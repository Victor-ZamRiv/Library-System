<?php
namespace App\Models\Services;

use PDO;

class IndicadorService
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // ================= INDICADORES GLOBALES (estáticos) =================

    /**
     * Cobertura de usuarios registrados
     */
    public function getCoberturaUsuarios(): float
    {
        // Usuarios que han tomado préstamos alguna vez (lectores activos con préstamos)
        $stmt = $this->pdo->query("SELECT COUNT(DISTINCT l.ID_Lector) 
                                   FROM lectores l 
                                   JOIN prestamos p ON l.ID_Lector = p.ID_Lector
                                   WHERE l.Estado = 'Activo' AND p.Activo = 1");
        $usuarios = (int) $stmt->fetchColumn();

        // Población objetivo desde configuración
        $stmt = $this->pdo->prepare("SELECT poblacion_objetivo FROM configuraciones_sistema WHERE ID_Configuracion = 1");
        $stmt->execute();
        $poblacion = (int) $stmt->fetchColumn() ?: 500;
        return round(($usuarios / $poblacion) * 100, 2);
    }

    /**
     * Promedio de consultas mensuales (último mes completo)
     */
    public function getPromedioConsultasMensuales(): float
    {
        $year = date('Y');
        $month = date('n');
        $fechaInicio = "$year-$month-01";
        $fechaFin = date('Y-m-t', strtotime($fechaInicio));

        $stmt = $this->pdo->prepare("SELECT SUM(Cantidad_Consultada) 
                                     FROM consultas_area_diarias 
                                     WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1");
        $stmt->execute([':inicio' => $fechaInicio, ':fin' => $fechaFin]);
        $total = (int) $stmt->fetchColumn();

        $diasHabiles = $this->diasHabilesEnMes($year, $month);
        return $diasHabiles > 0 ? round($total / $diasHabiles, 2) : 0;
    }

    /**
     * Tasa de cumplimiento de plazos de devolución
     */
    public function getTasaCumplimientoPlazos(): float
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM prestamos WHERE Estado_Entrega = 'Devuelto' AND Activo = 1");
        $aTiempo = (int) $stmt->fetchColumn();
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM prestamos WHERE Estado_Entrega IN ('Devuelto','Vencido') AND Activo = 1");
        $total = (int) $stmt->fetchColumn();
        return $total > 0 ? round(($aTiempo / $total) * 100, 2) : 0;
    }

    /**
     * Rotación de la colección (anual)
     */
    public function getRotacionColeccion(): float
    {
        $year = date('Y');
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM prestamos WHERE YEAR(Fecha_Recepcion_Real) = :year AND Activo = 1");
        $stmt->execute([':year' => $year]);
        $prestamos = (int) $stmt->fetchColumn();
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM ejemplares WHERE Activo = 1");
        $total = (int) $stmt->fetchColumn();
        return $total > 0 ? round(($prestamos / $total) * 100, 2) : 0;
    }

    /**
     * Porcentaje de ocupación diaria de salas (promedio últimos 30 días)
     */
    public function getPorcentajeOcupacionSalas(): float
    {
        $fin = date('Y-m-d');
        $inicio = date('Y-m-d', strtotime('-30 days'));
        $sql = "SELECT SUM(v.Niños_Hombres+v.Niños_Mujeres+v.Adolescentes_Hombres+v.Adolescentes_Mujeres+v.Adultos_Hombres+v.Adultos_Mujeres) as asistentes,
                       SUM(s.Capacidad) as capacidad
                FROM conteo_diario_visitantes v
                JOIN salas s ON v.ID_Sala = s.ID_Sala
                WHERE v.Fecha BETWEEN :inicio AND :fin AND v.Activo = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':inicio' => $inicio, ':fin' => $fin]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $asistentes = (int) $row['asistentes'];
        $capacidad = (int) $row['capacidad'];
        return $capacidad > 0 ? round(($asistentes / $capacidad) * 100, 2) : 0;
    }

    /**
     * Porcentaje de ejemplares en buen estado
     */
    public function getPorcentajeEjemplaresBuenEstado(): float
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM ejemplares WHERE Estado IN ('Disponible','Prestado') AND Activo = 1");
        $buenos = (int) $stmt->fetchColumn();
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM ejemplares WHERE Activo = 1");
        $total = (int) $stmt->fetchColumn();
        return $total > 0 ? round(($buenos / $total) * 100, 2) : 0;
    }

    /**
     * Porcentaje de asistentes a la sala Estatal (sobre total asistentes)
     */
    public function getPorcentajeAsistentesSalaEstatal(): float {
        $fin = date('Y-m-d');
        $inicio = date('Y-m-d', strtotime('-30 days'));
        $sql = "SELECT SUM(Niños_Hombres+Niños_Mujeres+Adolescentes_Hombres+Adolescentes_Mujeres+Adultos_Hombres+Adultos_Mujeres) as total
                FROM conteo_diario_visitantes WHERE ID_Sala = 'SE' AND Fecha BETWEEN :inicio AND :fin AND Activo = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':inicio' => $inicio, ':fin' => $fin]);
        $estatal = (int) $stmt->fetchColumn();
        $sqlTotal = "SELECT SUM(Niños_Hombres+Niños_Mujeres+Adolescentes_Hombres+Adolescentes_Mujeres+Adultos_Hombres+Adultos_Mujeres) as total
                     FROM conteo_diario_visitantes WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1";
        $stmtTotal = $this->pdo->prepare($sqlTotal);
        $stmtTotal->execute([':inicio' => $inicio, ':fin' => $fin]);
        $total = (int) $stmtTotal->fetchColumn();
        return $total > 0 ? round(($estatal / $total) * 100, 2) : 0;
    }

    /**
     * Porcentaje de colección Estatal
     */
    public function getPorcentajeColeccionEstatal(): float {
        $stmt = $this->pdo->query("SELECT COUNT(e.ID_Ejemplar) FROM ejemplares e
                                   JOIN libros l ON e.ID_Libro = l.ID_Libro
                                   WHERE l.ID_Sala = 'SE' AND e.Activo = 1");
        $estatal = (int) $stmt->fetchColumn();
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM ejemplares WHERE Activo = 1");
        $total = (int) $stmt->fetchColumn();
        return $total > 0 ? round(($estatal / $total) * 100, 2) : 0;
    }

    /**
     * Razón de consultas de materiales de referencia por usuario activo
     */
    public function getRazonConsultasReferencia(): float {
        $stmt = $this->pdo->query("SELECT SUM(Cantidad_Consultada) FROM consultas_area_diarias WHERE Activo = 1");
        $totalConsultas = (int) $stmt->fetchColumn();
        $stmt = $this->pdo->query("SELECT COUNT(DISTINCT l.ID_Lector) FROM lectores l
                                   JOIN prestamos p ON l.ID_Lector = p.ID_Lector
                                   WHERE l.Estado = 'Activo' AND p.Activo = 1");
        $usuariosActivos = (int) $stmt->fetchColumn();
        return $usuariosActivos > 0 ? round($totalConsultas / $usuariosActivos, 2) : 0;
    }

    /**
     * Porcentaje de usuarios registrados que participan en actividades
     * (Suma de asistentes a actividades / Total lectores activos) × 100
     */
<<<<<<< HEAD
    public function getPorcentajeParticipacionActividades(): float
    {
        $primerDia = date('Y-m-01');
        $ultimoDia = date('Y-m-t');

        $stmt = $this->pdo->prepare("SELECT SUM(Asistentes) FROM actividades WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1");
        $stmt->execute([':inicio' => $primerDia, ':fin' => $ultimoDia]);
=======
    public function getPorcentajeParticipacionActividades(): float {
        $stmt = $this->pdo->query("SELECT SUM(Asistentes) FROM actividades WHERE Activo = 1");
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
        $totalAsistentes = (int) $stmt->fetchColumn();

        $stmt = $this->pdo->query("SELECT COUNT(*) FROM lectores WHERE Estado = 'Activo'");
        $totalLectores = (int) $stmt->fetchColumn();

        return $totalLectores > 0 ? round(($totalAsistentes / $totalLectores) * 100, 2) : 0;
    }

    /**
     * Índice de Intensidad de Uso de Recursos (IIUR)
     * Agrupa áreas Dewey por su centena (ej. 810, 820 → 800). Áreas no numéricas se mantienen.
     */
    public function getIndiceIntensidadUsoRecursos(): array {
        $primerDia = date('Y-m-01');
        $ultimoDia = date('Y-m-t');

        $sqlAreas = "SELECT ID_Area, Nombre_Area FROM areas_de_conocimiento";
        $stmtAreas = $this->pdo->query($sqlAreas);
        $areas = $stmtAreas->fetchAll(PDO::FETCH_ASSOC);

        $sqlEjemplares = "SELECT l.ID_Area, COUNT(e.ID_Ejemplar) as total_ejemplares
                        FROM ejemplares e
                        JOIN libros l ON e.ID_Libro = l.ID_Libro
                        WHERE e.Activo = 1 AND l.Activo = 1
                        GROUP BY l.ID_Area";
        $stmt = $this->pdo->query($sqlEjemplares);
        $ejemplaresRaw = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ejemplaresRaw[$row['ID_Area']] = (int) $row['total_ejemplares'];
        }

        $sqlConsultas = "SELECT ID_Area, SUM(Cantidad_Consultada) as total_consultas
                        FROM consultas_area_diarias
                        WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1
                        GROUP BY ID_Area";
        $stmt = $this->pdo->prepare($sqlConsultas);
        $stmt->execute([':inicio' => $primerDia, ':fin' => $ultimoDia]);
        $consultasRaw = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $consultasRaw[$row['ID_Area']] = (int) $row['total_consultas'];
        }

        $grupos = [];
        foreach ($areas as $area) {
            $id = $area['ID_Area'];
            $base = $this->getDeweyCentena($id);
            if (!isset($grupos[$base])) {
                $grupos[$base] = [
                    'nombre' => $this->getNombreGrupo($base, $area['Nombre_Area'], $id),
                    'ejemplares' => 0,
                    'consultas' => 0
                ];
            }
            $grupos[$base]['ejemplares'] += $ejemplaresRaw[$id] ?? 0;
            $grupos[$base]['consultas'] += $consultasRaw[$id] ?? 0;
        }

        $desglose = [];
        $totalConsultasGlobal = 0;
        $totalEjemplaresGlobal = 0;
        foreach ($grupos as $base => $data) {
            $ejemplares = $data['ejemplares'];
            $consultas = $data['consultas'];
            $iiur = $ejemplares > 0 ? round($consultas / $ejemplares, 2) : 0;
            $estado = $this->getEstadoIIUR($iiur);
            $desglose[] = [
                'area' => $data['nombre'],
                'ejemplares' => $ejemplares,
                'consultas' => $consultas,
                'iiur' => $iiur,
                'clase' => $estado['clase'],
                'texto' => $estado['texto']
            ];
            $totalConsultasGlobal += $consultas;
            $totalEjemplaresGlobal += $ejemplares;
        }

        $iiurGlobal = $totalEjemplaresGlobal > 0 ? round($totalConsultasGlobal / $totalEjemplaresGlobal, 2) : 0;
        $estadoGlobal = $this->getEstadoIIUR($iiurGlobal);

        return [
            'valor' => $iiurGlobal,
            'clase' => $estadoGlobal['clase'],
            'texto' => $estadoGlobal['texto'],
            'desglose' => $desglose
        ];
    }

    /*
    * Índice de Deterioro de Alta Rotación (IDCAR)
    * Fórmula: (Ejemplares dañados / Total ejemplares de alta rotación) x 100
    * Se consideran "alta rotación" aquellos ejemplares que han sido prestados al menos 3 veces en el último año.
    */

    public function getIndiceDeterioroAltaRotacion(int $year = null, int $minPrestamos = 3): array
    {
        $year = $year ?? date('Y');

        $sql = "SELECT ep.ID_Ejemplar, COUNT(ep.ID_Prestamo) as total_prestamos
                FROM ejemplar_prestamo ep
                JOIN prestamos p ON ep.ID_Prestamo = p.ID_Prestamo
                WHERE YEAR(p.Fecha_Recepcion_Real) = :year AND p.Activo = 1
                GROUP BY ep.ID_Ejemplar
                HAVING total_prestamos >= :min_prestamos";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':year' => $year, ':min_prestamos' => $minPrestamos]);
        $idsAltaRotacion = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $totalAltaRotacion = count($idsAltaRotacion);

        if ($totalAltaRotacion == 0) {
            return ['valor' => 0, 'total_alta_rotacion' => 0, 'danados' => 0];
        }

        $placeholders = implode(',', array_fill(0, $totalAltaRotacion, '?'));
        $sqlDanados = "SELECT COUNT(*) FROM ejemplares 
                    WHERE ID_Ejemplar IN ($placeholders) 
                    AND Estado IN ('Dañado', 'En Reparación')";
        $stmt = $this->pdo->prepare($sqlDanados);
        $stmt->execute($idsAltaRotacion);
        $danados = (int) $stmt->fetchColumn();

        $idcar = round(($danados / $totalAltaRotacion) * 100, 1);
        return [
            'valor' => $idcar,
            'total_alta_rotacion' => $totalAltaRotacion,
            'danados' => $danados
        ];
    }

    /*
    * Tasa de Productividad de Eventos (IPE)
    * Fórmula: Total asistentes a eventos / Total eventos realizados
    */

    public function getTasaProductividadEventos(?string $fechaInicio = null, ?string $fechaFin = null): array
    {
        if (!$fechaInicio) $fechaInicio = date('Y-m-01');
        if (!$fechaFin) $fechaFin = date('Y-m-t');

        $sql = "SELECT SUM(Asistentes) as total_asistentes, COUNT(*) as total_eventos
                FROM actividades
                WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':inicio' => $fechaInicio, ':fin' => $fechaFin]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $totalAsistentes = (int) $row['total_asistentes'];
        $totalEventos = (int) $row['total_eventos'];
        $ipe = $totalEventos > 0 ? round($totalAsistentes / $totalEventos, 1) : 0;

        return [
            'valor' => $ipe,
            'total_asistentes' => $totalAsistentes,
            'total_eventos' => $totalEventos
        ];
    }

    // ================= DATOS DESGLOSADOS PARA MODALES =================

    /**
     * Rotación por categorías (áreas de conocimiento)
     */
    public function getRotacionPorCategorias(): array
    {
        $year = date('Y');
        $sql = "SELECT 
                    a.Nombre_Area as categoria,
                    COUNT(DISTINCT e.ID_Ejemplar) as inventario,
                    COUNT(p.ID_Prestamo) as prestamos
                FROM areas_de_conocimiento a
                LEFT JOIN libros l ON a.ID_Area = l.ID_Area AND l.Activo = 1
                LEFT JOIN ejemplares e ON l.ID_Libro = e.ID_Libro AND e.Activo = 1
                LEFT JOIN ejemplar_prestamo ep ON e.ID_Ejemplar = ep.ID_Ejemplar
                LEFT JOIN prestamos p ON ep.ID_Prestamo = p.ID_Prestamo AND YEAR(p.Fecha_Recepcion_Real) = :year AND p.Activo = 1
                GROUP BY a.ID_Area
                ORDER BY a.Nombre_Area";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':year' => $year]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $inventario = (int) $row['inventario'];
            $prestamos = (int) $row['prestamos'];
            $rotacion = $inventario > 0 ? round(($prestamos / $inventario) * 100, 2) : 0;
            $clase = 'danger';
            if ($rotacion >= 15) $clase = 'success';
            elseif ($rotacion >= 5) $clase = 'warning';
            $result[] = [
                'categoria' => $row['categoria'],
                'inventario' => $inventario,
                'prestamos' => $prestamos,
                'rotacion' => $rotacion,
                'clase' => $clase
            ];
        }
        return $result;
    }

    /**
     * Estado físico por sala
     */
    public function getEstadoFisicoPorSalas(): array
    {
        $sql = "SELECT 
                    s.Nombre as sala,
                    COUNT(e.ID_Ejemplar) as total,
                    SUM(CASE WHEN e.Estado IN ('Disponible','Prestado') THEN 1 ELSE 0 END) as buenos
                FROM salas s
                LEFT JOIN libros l ON s.ID_Sala = l.ID_Sala
                LEFT JOIN ejemplares e ON l.ID_Libro = e.ID_Libro AND e.Activo = 1
                WHERE s.Disponible = 1
                GROUP BY s.ID_Sala
                ORDER BY s.Nombre";
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $total = (int) $row['total'];
            $buenos = (int) $row['buenos'];
            $porcentaje = $total > 0 ? round(($buenos / $total) * 100, 2) : 0;
            $clase = $porcentaje >= 90 ? 'success' : ($porcentaje >= 70 ? 'warning' : 'danger');
            $result[] = [
                'sala' => $row['sala'],
                'total' => $total,
                'buenos' => $buenos,
                'en_reparacion' => $total - $buenos,
                'porcentaje' => $porcentaje,
                'clase' => $clase,
                'label' => $porcentaje . '%'
            ];
        }
        return $result;
    }

    /**
     * Asistencia a sala Estatal por tipo de usuario
     */
    public function getAsistenciaEstatalPorTipo(): array
    {
        $sql = "SELECT 
                    SUM(Niños_Hombres + Niños_Mujeres) as ninos,
                    SUM(Adolescentes_Hombres + Adolescentes_Mujeres) as adolescentes,
                    SUM(Adultos_Hombres + Adultos_Mujeres) as adultos
                FROM conteo_diario_visitantes
                WHERE ID_Sala = 'SE' AND Activo = 1";
        $stmt = $this->pdo->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return [
            ['tipo' => 'Niños (0-12 años)', 'visitas' => (int) $row['ninos'], 'permanencia' => 45, 'tendencia' => 'alta'],
            ['tipo' => 'Adolescentes (13-18 años)', 'visitas' => (int) $row['adolescentes'], 'permanencia' => 60, 'tendencia' => 'estable'],
            ['tipo' => 'Adultos', 'visitas' => (int) $row['adultos'], 'permanencia' => 90, 'tendencia' => 'baja'],
        ];
    }

    /**
     * Necesidades de colección por sala (porcentaje de novedades)
     */
    public function getNecesidadesColeccionPorSalas(): array
    {
        $sql = "SELECT 
                    s.Nombre as sala,
                    COUNT(DISTINCT l.ID_Libro) as titulos_totales,
                    SUM(CASE WHEN l.Anio_Publicacion >= 2023 THEN 1 ELSE 0 END) as novedades
                FROM salas s
                LEFT JOIN libros l ON s.ID_Sala = l.ID_Sala AND l.Activo = 1
                WHERE s.Disponible = 1
                GROUP BY s.ID_Sala
                ORDER BY s.Nombre";
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $total = (int) $row['titulos_totales'];
            $novedades = (int) $row['novedades'];
            $porcentaje = $total > 0 ? round(($novedades / $total) * 100, 2) : 0;
            $clase = $porcentaje >= 25 ? 'success' : ($porcentaje >= 10 ? 'warning' : 'danger');
            $result[] = [
                'sala' => $row['sala'],
                'titulos_totales' => $total,
                'novedades' => $novedades,
                'porcentaje' => $porcentaje,
                'clase' => $clase,
                'accion' => $porcentaje < 10 ? 'Compra urgente' : ($porcentaje < 25 ? 'Actualización necesaria' : 'Aceptable')
            ];
        }
        return $result;
    }

    /**
     * Obtiene detalle de libros con ejemplares de alta rotación (≥ $minPrestamos préstamos en el año).
     * @param int $year Año de análisis (por defecto año actual)
     * @param int $minPrestamos Mínimo de préstamos para considerar alta rotación (por defecto 3)
     * @return array
     */
    public function getDetalleLibrosAltaRotacion(int $year = null, int $minPrestamos = 3): array
    {
        $year = $year ?? date('Y');

        $sql = "SELECT 
                    l.Cota,
                    l.Titulo,
                    COUNT(e.ID_Ejemplar) AS total_ejemplares,
                    SUM(CASE WHEN e.Estado IN ('Dañado', 'En Reparación') THEN 1 ELSE 0 END) AS danados
                FROM ejemplares e
                JOIN libros l ON e.ID_Libro = l.ID_Libro
                WHERE e.Activo = 1
                    AND l.Activo = 1
                    AND e.ID_Ejemplar IN (
                        SELECT ep.ID_Ejemplar
                        FROM ejemplar_prestamo ep
                        JOIN prestamos p ON ep.ID_Prestamo = p.ID_Prestamo
                        WHERE YEAR(p.Fecha_Recepcion_Real) = :year
                            AND p.Activo = 1
                        GROUP BY ep.ID_Ejemplar
                        HAVING COUNT(ep.ID_Prestamo) >= :min_prestamos
                    )
                GROUP BY l.ID_Libro
                ORDER BY l.Cota";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':year' => $year, ':min_prestamos' => $minPrestamos]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function($row) {
            return [
                'cota' => $row['Cota'],
                'titulo' => $row['Titulo'],
                'total_ejemplares' => (int) $row['total_ejemplares'],
                'danados' => (int) $row['danados']
            ];
        }, $rows);
    }

<<<<<<< HEAD
    /**
     * Obtiene desglose de actividades por categoría para el mes actual.
     * @return array
     */
    public function getDesgloseActividades(): array
    {
        $primerDia = date('Y-m-01');
        $ultimoDia = date('Y-m-t');

        $sql = "SELECT 
                    Categoria,
                    COUNT(*) as eventos_realizados,
                    SUM(Asistentes) as total_asistentes
                FROM actividades
                WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1
                GROUP BY Categoria
                ORDER BY eventos_realizados DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':inicio' => $primerDia, ':fin' => $ultimoDia]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Total general de asistentes (para calcular porcentajes)
        $totalAsistentesGeneral = array_sum(array_column($rows, 'total_asistentes'));

        $desglose = [];
        foreach ($rows as $row) {
            $porcentaje = $totalAsistentesGeneral > 0 ? round(($row['total_asistentes'] / $totalAsistentesGeneral) * 100, 2) : 0;
            $clase = 'success';
            if ($porcentaje < 30) $clase = 'danger';
            elseif ($porcentaje < 70) $clase = 'warning';
            $desglose[] = [
                'categoria' => $row['Categoria'],
                'eventos_realizados' => (int) $row['eventos_realizados'],
                'total_asistentes' => (int) $row['total_asistentes'],
                'porcentaje' => $porcentaje,
                'clase' => $clase,
                'estado' => ($porcentaje >= 70) ? 'Alta participación' : (($porcentaje >= 30) ? 'Participación moderada' : 'Baja participación')
            ];
        }

        return $desglose;
    }

=======
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
    // ================= SERIES PARA GRÁFICOS (ENDPOINTS AJAX) =================

    /**
     * Datos para gráfico de consultas (promedio de consultas por día/semana/mes)
     * @param string $periodo 'semana', 'mes', 'trimestre'
     * @return array ['series' => [...], 'categorias' => [...], 'total' => int, 'pico' => string, 'crecimiento' => string, 'tablaDatos' => array]
     */
    public function getSeriesConsultas(string $periodo): array
    {
        switch ($periodo) {
            case 'semana':
                // Últimos 7 días (etiquetas: Lun, Mar, Mie, Jue, Vie, Sab, Dom)
                $fechas = [];
                $categorias = [];
                for ($i = 6; $i >= 0; $i--) {
                    $fecha = date('Y-m-d', strtotime("-$i days"));
                    $fechas[] = $fecha;
                    $categorias[] = $this->nombreDia(date('N', strtotime($fecha)));
                }
                $series = [];
                foreach ($fechas as $fecha) {
                    $stmt = $this->pdo->prepare("SELECT SUM(Cantidad_Consultada) FROM consultas_area_diarias WHERE Fecha = :fecha AND Activo = 1");
                    $stmt->execute([':fecha' => $fecha]);
                    $series[] = (int) $stmt->fetchColumn();
                }
                $total = array_sum($series);
                $max = max($series);
                $picoIndex = array_search($max, $series);
                $pico = $categorias[$picoIndex] ?? 'N/A';
                // Crecimiento respecto a semana anterior
                $semanaAnterior = [];
                for ($i = 13; $i >= 7; $i--) {
                    $fechaAnt = date('Y-m-d', strtotime("-$i days"));
                    $stmt = $this->pdo->prepare("SELECT SUM(Cantidad_Consultada) FROM consultas_area_diarias WHERE Fecha = :fecha AND Activo = 1");
                    $stmt->execute([':fecha' => $fechaAnt]);
                    $semanaAnterior[] = (int) $stmt->fetchColumn();
                }
                $totalAnt = array_sum($semanaAnterior);
                $crecimiento = $totalAnt > 0 ? round((($total - $totalAnt) / $totalAnt) * 100, 2) : 0;

                // Datos para tabla (desglose por día, opcional)
                $tablaDatos = [];
                foreach ($categorias as $idx => $dia) {
                    $tablaDatos[] = [
                        'periodo' => $dia,
                        'consultas' => $series[$idx],
                        'estado' => $series[$idx] > 40 ? 'Alta' : ($series[$idx] > 20 ? 'Normal' : 'Baja')
                    ];
                }
                break;

            case 'mes':
                // Últimas 4 semanas (etiquetas: Sem 1, Sem 2, Sem 3, Sem 4)
                $categorias = ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'];
                $series = [];
                for ($i = 0; $i < 4; $i++) {
                    $inicio = date('Y-m-d', strtotime("-$i weeks -" . (date('N') - 1) . " days"));
                    $fin = date('Y-m-d', strtotime($inicio . ' +6 days'));
                    $stmt = $this->pdo->prepare("SELECT SUM(Cantidad_Consultada) FROM consultas_area_diarias WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1");
                    $stmt->execute([':inicio' => $inicio, ':fin' => $fin]);
                    $series[] = (int) $stmt->fetchColumn();
                }
                $total = array_sum($series);
                $max = max($series);
                $picoIndex = array_search($max, $series);
                $pico = $categorias[$picoIndex] ?? 'N/A';
                // Crecimiento respecto al mes anterior (4 semanas anteriores)
                $mesAnterior = [];
                for ($i = 4; $i < 8; $i++) {
                    $inicioAnt = date('Y-m-d', strtotime("-$i weeks -" . (date('N') - 1) . " days"));
                    $finAnt = date('Y-m-d', strtotime($inicioAnt . ' +6 days'));
                    $stmt = $this->pdo->prepare("SELECT SUM(Cantidad_Consultada) FROM consultas_area_diarias WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1");
                    $stmt->execute([':inicio' => $inicioAnt, ':fin' => $finAnt]);
                    $mesAnterior[] = (int) $stmt->fetchColumn();
                }
                $totalAnt = array_sum($mesAnterior);
                $crecimiento = $totalAnt > 0 ? round((($total - $totalAnt) / $totalAnt) * 100, 2) : 0;

                $tablaDatos = [];
                foreach ($categorias as $idx => $sem) {
                    $tablaDatos[] = [
                        'periodo' => $sem,
                        'consultas' => $series[$idx],
                        'estado' => $series[$idx] > 150 ? 'Alta' : ($series[$idx] > 80 ? 'Normal' : 'Baja')
                    ];
                }
                break;

            case 'trimestre':
                // Últimos 3 meses (etiquetas: nombres de meses)
                $categorias = [];
                $series = [];
                for ($i = 2; $i >= 0; $i--) {
                    $inicio = date('Y-m-01', strtotime("-$i months"));
                    $fin = date('Y-m-t', strtotime($inicio));
                    $categorias[] = date('M', strtotime($inicio)); // Ene, Feb, Mar...
                    $stmt = $this->pdo->prepare("SELECT SUM(Cantidad_Consultada) FROM consultas_area_diarias WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1");
                    $stmt->execute([':inicio' => $inicio, ':fin' => $fin]);
                    $series[] = (int) $stmt->fetchColumn();
                }
                $total = array_sum($series);
                $max = max($series);
                $picoIndex = array_search($max, $series);
                $pico = $categorias[$picoIndex] ?? 'N/A';
                // Crecimiento respecto al trimestre anterior
                $trimAnterior = [];
                for ($i = 5; $i >= 3; $i--) {
                    $inicioAnt = date('Y-m-01', strtotime("-$i months"));
                    $finAnt = date('Y-m-t', strtotime($inicioAnt));
                    $stmt = $this->pdo->prepare("SELECT SUM(Cantidad_Consultada) FROM consultas_area_diarias WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1");
                    $stmt->execute([':inicio' => $inicioAnt, ':fin' => $finAnt]);
                    $trimAnterior[] = (int) $stmt->fetchColumn();
                }
                $totalAnt = array_sum($trimAnterior);
                $crecimiento = $totalAnt > 0 ? round((($total - $totalAnt) / $totalAnt) * 100, 2) : 0;

                $tablaDatos = [];
                foreach ($categorias as $idx => $mes) {
                    $tablaDatos[] = [
                        'periodo' => $mes,
                        'consultas' => $series[$idx],
                        'estado' => $series[$idx] > 500 ? 'Alta' : ($series[$idx] > 300 ? 'Normal' : 'Baja')
                    ];
                }
                break;

            default:
                return [];
        }

        return [
            'series' => $series,
            'categorias' => $categorias,
            'total' => $total,
            'pico' => $pico,
            'crecimiento' => ($crecimiento >= 0 ? '+' : '') . $crecimiento . '%',
            'tablaDatos' => $tablaDatos
        ];
    }

    /**
     * Series para gráfico de cumplimiento
     */
    public function getSeriesCumplimiento(string $periodo): array
    {
        $rango = $this->getRangoFechas($periodo);
        $stmt = $this->pdo->prepare("SELECT 
                                        COUNT(CASE WHEN Estado_Entrega = 'Devuelto' THEN 1 END) as devueltos,
                                        COUNT(CASE WHEN Estado_Entrega = 'Vencido' THEN 1 END) as vencidos,
                                        SUM(Renovaciones) as renovaciones,
                                        COUNT(*) as total_prestamos
                                    FROM prestamos
                                    WHERE Fecha_Recepcion_Real BETWEEN :inicio AND :fin AND Activo = 1");
        $stmt->execute([':inicio' => $rango['inicio'], ':fin' => $rango['fin']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $devueltos = (int) $row['devueltos'];
        $vencidos = (int) $row['vencidos'];
        $renovaciones = (int) $row['renovaciones'];
        $total = (int) $row['total_prestamos'];

        $porcATiempo = $total > 0 ? round(($devueltos / $total) * 100, 2) : 0;
        $porcVencido = 100 - $porcATiempo;

        return [
            'series' => [$porcATiempo, $porcVencido],
            'total_prestamos' => $total,
            'devueltos' => $devueltos,
            'vencidos' => $vencidos,
            'renovaciones' => $renovaciones
        ];
    }

    /**
     * Series para gráfico de ocupación
     */
    public function getSeriesOcupacion(string $periodo): array
    {
        $rango = $this->getRangoFechas($periodo);
        
        // Definir las 4 salas fijas
        $salasFijas = [
            ['id' => 'G', 'nombre' => 'General'],
            ['id' => 'R', 'nombre' => 'Referencia'],
            ['id' => 'SE', 'nombre' => 'Estatal'],
            ['id' => 'X', 'nombre' => 'Infantil']
        ];
        
        // Obtener datos reales del período
        $sql = "SELECT v.ID_Sala, s.Nombre as sala, s.Capacidad,
                    SUM(v.Niños_Hombres+v.Niños_Mujeres+v.Adolescentes_Hombres+v.Adolescentes_Mujeres+v.Adultos_Hombres+v.Adultos_Mujeres) 
                    as total_asistentes
                FROM conteo_diario_visitantes v
                JOIN salas s ON v.ID_Sala = s.ID_Sala
                WHERE v.Fecha BETWEEN :inicio AND :fin AND v.Activo = 1
                GROUP BY v.ID_Sala";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':inicio' => $rango['inicio'], ':fin' => $rango['fin']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Mapear datos reales
        $datosReales = [];
        foreach ($rows as $row) {
            $datosReales[$row['ID_Sala']] = [
                'capacidad' => (int) $row['Capacidad'],
                'asistentes' => (int) $row['total_asistentes']
            ];
        }
        
        // Construir series y datos para tabla (enviar como arrays, no HTML)
        $series = [];
        $categorias = [];
        $tablaDatos = [];
        foreach ($salasFijas as $sala) {
            $id = $sala['id'];
            $nombre = $sala['nombre'];
            $categorias[] = $nombre;
            
            if (isset($datosReales[$id])) {
                $asistentes = $datosReales[$id]['asistentes'];
                $capacidad = $datosReales[$id]['capacidad'];
            } else {
                $asistentes = 0;
                $capacidad = 1;
            }
            
            $porcentaje = $capacidad > 0 ? round(($asistentes / $capacidad) * 100, 2) : 0;
            $series[] = $porcentaje;
            
            // Guardar datos para la tabla (sin HTML)
            $tablaDatos[] = [
                'sala' => $nombre,
                'capacidad' => $capacidad,
                'asistentes' => $asistentes,
                'porcentaje' => $porcentaje
            ];
        }
        
        return [
            'series' => $series,
            'categorias' => $categorias,
            'tablaDatos' => $tablaDatos  // <-- datos crudos para que JS construya la tabla
        ];
    }


        // ================= Extras para modales =================

    /**
     * Obtiene segmentos de cobertura por grupo etario (basado en visitantes)
     * Retorna array con: segmento, total_registrados, nuevos_mes, tendencia
     */
    public function getSegmentosCobertura(): array
    {
        $mesActual = date('Y-m');
        $primerDia = date('Y-m-01');
        $ultimoDia = date('Y-m-t');
        
        // Función auxiliar para obtener total y nuevos de un grupo
        $getData = function($campoH, $campoM) use ($primerDia, $ultimoDia, $mesActual) {
            // Total histórico
            $stmt = $this->pdo->prepare("SELECT SUM($campoH + $campoM) as total FROM conteo_diario_visitantes WHERE Activo = 1");
            $stmt->execute();
            $total = (int) $stmt->fetchColumn();
            
            // Nuevos en el mes actual
            $stmt = $this->pdo->prepare("SELECT SUM($campoH + $campoM) as nuevos FROM conteo_diario_visitantes WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1");
            $stmt->execute([':inicio' => $primerDia, ':fin' => $ultimoDia]);
            $nuevos = (int) $stmt->fetchColumn();
            
            return ['total' => $total, 'nuevos' => $nuevos];
        };
        
        $ninos = $getData('Niños_Hombres', 'Niños_Mujeres');
        $adolescentes = $getData('Adolescentes_Hombres', 'Adolescentes_Mujeres');
        $adultos = $getData('Adultos_Hombres', 'Adultos_Mujeres');
        
        $result = [];
        $result[] = [
            'segmento' => 'Niños (0-12)',
            'total_registrados' => $ninos['total'],
            'nuevos_mes' => $ninos['nuevos'],
            'tendencia' => $this->calcularTendencia($ninos['nuevos'], $ninos['total'])
        ];
        $result[] = [
            'segmento' => 'Adolescentes (13-18)',
            'total_registrados' => $adolescentes['total'],
            'nuevos_mes' => $adolescentes['nuevos'],
            'tendencia' => $this->calcularTendencia($adolescentes['nuevos'], $adolescentes['total'])
        ];
        $result[] = [
            'segmento' => 'Adultos (19+)',
            'total_registrados' => $adultos['total'],
            'nuevos_mes' => $adultos['nuevos'],
            'tendencia' => $this->calcularTendencia($adultos['nuevos'], $adultos['total'])
        ];
        
        return $result;
    }

    private function calcularTendencia($nuevos, $total): string
    {
        if ($total == 0) return 'Baja';
        $porcentaje = ($nuevos / $total) * 100;
        if ($porcentaje >= 10) return 'Alta';
        if ($porcentaje > 0) return 'Estable';
        return 'Baja';
    }

    /**
     * Obtiene datos detallados para el modal de Consultas de Referencia
     * @return array ['razon' => float, 'totalConsultasMes' => int, 'usuariosConsultaron' => int, 'topTematicas' => array]
     */
    public function getDetalleConsultasReferencia(): array
    {
        // Obtener el mes actual
        $primerDiaMes = date('Y-m-01');
        $ultimoDiaMes = date('Y-m-t');

        // Total de consultas en el mes
        $stmt = $this->pdo->prepare("SELECT SUM(Cantidad_Consultada) FROM consultas_area_diarias 
                                    WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1");
        $stmt->execute([':inicio' => $primerDiaMes, ':fin' => $ultimoDiaMes]);
        $totalConsultasMes = (int) $stmt->fetchColumn();

        // Usuarios que realizaron consultas (lectores con préstamos activos o que aparecen en visitas? 
        // Asumimos que son lectores que han tomado préstamos en el mes, como proxy)
        $stmt = $this->pdo->prepare("SELECT COUNT(DISTINCT l.ID_Lector) FROM lectores l
                                    JOIN prestamos p ON l.ID_Lector = p.ID_Lector
                                    WHERE p.Fecha_Recepcion_Real BETWEEN :inicio AND :fin AND p.Activo = 1 AND l.Estado = 'Activo'");
        $stmt->execute([':inicio' => $primerDiaMes, ':fin' => $ultimoDiaMes]);
        $usuariosConsultaron = (int) $stmt->fetchColumn();

        // Razón (consultas por usuario)
        $razon = $usuariosConsultaron > 0 ? round($totalConsultasMes / $usuariosConsultaron, 2) : 0;

        // Top temáticas consultadas (agrupar por área, sumar consultas, ordenar descendente)
        $sql = "SELECT a.Nombre_Area as area, SUM(c.Cantidad_Consultada) as consultas
                FROM consultas_area_diarias c
                JOIN areas_de_conocimiento a ON c.ID_Area = a.ID_Area
                WHERE c.Fecha BETWEEN :inicio AND :fin AND c.Activo = 1
                GROUP BY c.ID_Area
                ORDER BY consultas DESC
                LIMIT 5";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':inicio' => $primerDiaMes, ':fin' => $ultimoDiaMes]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $topTematicas = [];
        foreach ($rows as $row) {
            // Simular eficiencia de respuesta (puedes calcular con base en tiempo de respuesta real si lo tienes)
            $eficiencia = rand(80, 100); // placeholder, idealmente se calcularía con datos reales
            $topTematicas[] = [
                'area' => $row['area'],
                'consultas' => (int) $row['consultas'],
            ];
        }

        return [
            'razon' => $razon,
            'totalConsultasMes' => $totalConsultasMes,
            'usuariosConsultaron' => $usuariosConsultaron,
            'topTematicas' => $topTematicas
        ];
    }

    // ================= AUXILIARES =================

    /**
     * Total de asistentes a la Sala Estatal en el mes actual
     */
    public function getTotalVisitasSalaEstatal(): int
    {
        $primerDiaMes = date('Y-m-01');
        $ultimoDiaMes = date('Y-m-t');
        $sql = "SELECT SUM(Niños_Hombres+Niños_Mujeres+Adolescentes_Hombres+Adolescentes_Mujeres+Adultos_Hombres+Adultos_Mujeres) as total
                FROM conteo_diario_visitantes
                WHERE ID_Sala = 'SE' AND Fecha BETWEEN :inicio AND :fin AND Activo = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':inicio' => $primerDiaMes, ':fin' => $ultimoDiaMes]);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Tendencia de asistencia a Sala Estatal (comparación mes actual vs mes anterior)
     */
    public function getTendenciaAsistenciaEstatal(): string
    {
        $mesActual = date('Y-m');
        $mesAnterior = date('Y-m', strtotime('-1 month'));
        $primerDiaActual = date('Y-m-01');
        $ultimoDiaActual = date('Y-m-t');
        $primerDiaAnterior = date('Y-m-01', strtotime('-1 month'));
        $ultimoDiaAnterior = date('Y-m-t', strtotime('-1 month'));

        $sql = "SELECT SUM(Niños_Hombres+Niños_Mujeres+Adolescentes_Hombres+Adolescentes_Mujeres+Adultos_Hombres+Adultos_Mujeres) as total
                FROM conteo_diario_visitantes
                WHERE ID_Sala = 'SE' AND Fecha BETWEEN :inicio AND :fin AND Activo = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':inicio' => $primerDiaActual, ':fin' => $ultimoDiaActual]);
        $actual = (int) $stmt->fetchColumn();
        $stmt->execute([':inicio' => $primerDiaAnterior, ':fin' => $ultimoDiaAnterior]);
        $anterior = (int) $stmt->fetchColumn();
        if ($anterior == 0) return $actual > 0 ? '+100%' : '0%';
        $diff = round(($actual - $anterior) / $anterior * 100);
        return ($diff >= 0 ? '+' : '') . $diff . '%';
    }

    private function diasHabilesEnMes(int $year, int $month): int
    {
        $fecha = new \DateTime("$year-$month-01");
        $diasEnMes = (int) $fecha->format('t');
        $habiles = 0;
        for ($i = 1; $i <= $diasEnMes; $i++) {
            $fecha->setDate($year, $month, $i);
            if ((int) $fecha->format('N') < 6) $habiles++;
        }
        return $habiles;
    }

    /**
     * Estado del IIUR según rangos
     * @return array ['clase' => string, 'texto' => string]
     */
    private function getEstadoIIUR(float $valor): array
    {
        if ($valor >= 2.0) return ['clase' => 'success', 'texto' => 'Óptimo'];
        if ($valor >= 1.0) return ['clase' => 'warning', 'texto' => 'En proceso'];
        return ['clase' => 'danger', 'texto' => 'Crítico'];
    }

    /**
     * Calcula la centena Dewey para un código de área.
     */
    private function getDeweyCentena(string $areaId): string
    {
        if (is_numeric($areaId) && strlen($areaId) >= 3) {
            return substr($areaId, 0, 1) . '00';
        }
        return $areaId;
    }

    /**
     * Devuelve el nombre del grupo para mostrar en la tabla.
     */
    private function getNombreGrupo(string $base, string $nombreOriginal, string $idOriginal): string
    {
        if (is_numeric($base)) {
            $stmt = $this->pdo->prepare("SELECT Nombre_Area FROM areas_de_conocimiento WHERE ID_Area = :area");
            $stmt->execute([':area' => $base]);
            $nombre = $stmt->fetchColumn();
            if ($nombre) return $nombre . " ($base)";
            else return "Área $base";
        } else {
            return $nombreOriginal . " ($idOriginal)";
        }
    }

    private function getRangoFechas(string $periodo): array
    {
        $fin = date('Y-m-d');
        switch ($periodo) {
            case 'semana': $inicio = date('Y-m-d', strtotime('-7 days')); break;
            case 'mes': $inicio = date('Y-m-d', strtotime('-30 days')); break;
            case 'trimestre': $inicio = date('Y-m-d', strtotime('-90 days')); break;
            default: $inicio = date('Y-m-d', strtotime('-30 days'));
        }
        return ['inicio' => $inicio, 'fin' => $fin];
    }

    private function nombreDia(int $numeroDia): string
    {
        $dias = ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'];
        return $dias[$numeroDia - 1] ?? '';
    }
}