<?php
namespace App\Models\Services;

use PDO;

class ReporteOperativoService
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Obtiene los totales principales para un período (consultas, préstamos, actividades, logros).
     * @param array $rango ['inicio' => 'Y-m-d', 'fin' => 'Y-m-d']
     * @return array ['consultas' => int, 'prestamos' => int, 'actividades' => int, 'logros' => int]
     */
    public function getTotalesPeriodo(array $rango): array
    {
        // Total consultas (suma de Cantidad_Consultada)
        $stmt = $this->pdo->prepare("SELECT SUM(Cantidad_Consultada) FROM consultas_area_diarias WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1");
        $stmt->execute($rango);
        $consultas = (int) $stmt->fetchColumn();

        // Total préstamos (número de transacciones, no ejemplares)
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM prestamos WHERE Fecha_Entrega BETWEEN :inicio AND :fin AND Activo = 1");
        $stmt->execute($rango);
        $prestamos = (int) $stmt->fetchColumn();

        // Total actividades (todas las categorías)
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM actividades WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1");
        $stmt->execute($rango);
        $actividades = (int) $stmt->fetchColumn();

        // Total logros
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM logros WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1");
        $stmt->execute($rango);
        $logros = (int) $stmt->fetchColumn();

        return compact('consultas', 'prestamos', 'actividades', 'logros');
    }

    /**
     * Obtiene el total de ejemplares prestados en el período (cada ejemplar prestado cuenta).
     * @param array $rango
     * @param string|null $salaId (opcional) - G, R, SE, X. Si null, se suman todas.
     * @return int
     */
    public function getTotalEjemplaresPrestados(array $rango, ?string $salaId = null): int
    {
        $sql = "SELECT COUNT(ep.ID_Prestamo_Ejemplar)
                FROM ejemplar_prestamo ep
                JOIN prestamos p ON ep.ID_Prestamo = p.ID_Prestamo
                JOIN ejemplares e ON ep.ID_Ejemplar = e.ID_Ejemplar
                JOIN libros l ON e.ID_Libro = l.ID_Libro
                WHERE p.Fecha_Entrega BETWEEN :inicio AND :fin AND p.Activo = 1 AND e.Activo = 1 AND l.Activo = 1";
        if ($salaId) {
            $sql .= " AND l.ID_Sala = :sala";
        }
        $stmt = $this->pdo->prepare($sql);
        $params = $rango;
        if ($salaId) {
            $params[':sala'] = $salaId;
        }
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Obtiene el total de consultas (obras) por sala (para la tabla de afluencia).
     * @param array $rango
     * @param string|null $salaId Si se especifica, retorna solo el total para esa sala.
     * @return array|int Si $salaId es null, retorna array [nombre_sala => total]; si no, retorna int.
     */
    public function getConsultasPorSala(array $rango, ?string $salaId = null): array|int
    {
        $sql = "SELECT v.ID_Sala, SUM(c.Cantidad_Consultada) as total
                FROM consultas_area_diarias c
                JOIN conteo_diario_visitantes v ON c.Fecha = v.Fecha AND c.ID_Sala = v.ID_Sala
                WHERE c.Fecha BETWEEN :inicio AND :fin AND c.Activo = 1 AND v.Activo = 1";
        if ($salaId) {
            $sql .= " AND v.ID_Sala = :sala";
            $stmt = $this->pdo->prepare($sql);
            $params = $rango;
            $params[':sala'] = $salaId;
            $stmt->execute($params);
            return (int) $stmt->fetchColumn();
        } else {
            $sql .= " GROUP BY v.ID_Sala";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($rango);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $mapa = ['G' => 'Sala General', 'R' => 'Sala de Referencia', 'SE' => 'Sala Estatal', 'X' => 'Sala Infantil'];
            $resultado = array_fill_keys(array_values($mapa), 0); // inicializa todas en 0
            foreach ($rows as $row) {
                $nombre = $mapa[$row['ID_Sala']] ?? $row['ID_Sala'];
                $resultado[$nombre] = (int) $row['total'];
            }
            return $resultado;
        }
    }

    /**
     * Obtiene el desglose de consultas (obras) por área de conocimiento.
     * @param array $rango
     * @param string|null $salaId Opcional: filtrar por sala.
     * @return array ['000'=>int, '100'=>int, ...] (todas las áreas incluidas con valor 0 si no hay datos)
     */
    public function getConsultasPorArea(array $rango, ?string $salaId = null): array
    {
        $sql = "SELECT c.ID_Area, SUM(c.Cantidad_Consultada) as total
                FROM consultas_area_diarias c
                WHERE c.Fecha BETWEEN :inicio AND :fin AND c.Activo = 1";
        if ($salaId) {
            $sql .= " AND c.ID_Sala = :sala";
        }
        $sql .= " GROUP BY c.ID_Area";
        $stmt = $this->pdo->prepare($sql);
        $params = $rango;
        if ($salaId) {
            $params[':sala'] = $salaId;
        }
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $areasReales = array_column($rows, 'total', 'ID_Area');
        // Lista completa de áreas que queremos mostrar (ajusta según tu sistema)
        $todasAreas = ['000','100','200','300','400','500','600','700','800','900','Biog','N','NV'];
        $resultado = [];
        foreach ($todasAreas as $area) {
            $resultado[$area] = $areasReales[$area] ?? 0;
        }
        return $resultado;
    }

    /**
     * Obtiene el desglose de préstamos (ejemplares prestados) por área de conocimiento.
     * @param array $rango
     * @param string|null $salaId Opcional: filtrar por sala.
     * @return array (misma estructura que getConsultasPorArea)
     */
    public function getPrestamosPorArea(array $rango, ?string $salaId = null): array
    {
        $sql = "SELECT l.ID_Area, COUNT(ep.ID_Prestamo_Ejemplar) as total
                FROM ejemplar_prestamo ep
                JOIN prestamos p ON ep.ID_Prestamo = p.ID_Prestamo
                JOIN ejemplares e ON ep.ID_Ejemplar = e.ID_Ejemplar
                JOIN libros l ON e.ID_Libro = l.ID_Libro
                WHERE p.Fecha_Entrega BETWEEN :inicio AND :fin AND p.Activo = 1 AND e.Activo = 1 AND l.Activo = 1";
        if ($salaId) {
            $sql .= " AND l.ID_Sala = :sala";
        }
        $sql .= " GROUP BY l.ID_Area";
        $stmt = $this->pdo->prepare($sql);
        $params = $rango;
        if ($salaId) {
            $params[':sala'] = $salaId;
        }
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $areasReales = array_column($rows, 'total', 'ID_Area');
        $todasAreas = ['000','100','200','300','400','500','600','700','800','900','Biog','N','NV'];
        $resultado = [];
        foreach ($todasAreas as $area) {
            $resultado[$area] = $areasReales[$area] ?? 0;
        }
        return $resultado;
    }

    /**
     * Obtiene estadísticas de actividades: total de actividades y subtotal por categoría (ej. Taller/Charlas)
     * @param array $rango
     * @return array ['total_actividades' => int, 'talleres_charlas' => int, 'categorias' => array (opcional)]
     */
    public function getEstadisticasActividades(array $rango): array
    {
        // Total actividades
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM actividades WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1");
        $stmt->execute($rango);
        $totalActividades = (int) $stmt->fetchColumn();

        // Actividades de categoría 'Taller' o 'Charlas' (puedes ajustar los nombres según tu BD)
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM actividades WHERE Categoria IN ('Taller', 'Charlas') AND Fecha BETWEEN :inicio AND :fin AND Activo = 1");
        $stmt->execute($rango);
        $talleresCharlas = (int) $stmt->fetchColumn();

        // Opcional: puedes obtener todas las categorías para mayor detalle
        $stmt = $this->pdo->prepare("SELECT Categoria, COUNT(*) as total FROM actividades WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1 GROUP BY Categoria");
        $stmt->execute($rango);
        $categorias = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // ['Educativo' => 5, 'Cultural' => 3, ...]

        return compact('totalActividades', 'talleresCharlas', 'categorias');
    }

    /**
     * Obtiene total de logros (sin meta).
     * @param array $rango
     * @return int
     */
    public function getTotalLogros(array $rango): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM logros WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1");
        $stmt->execute($rango);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Obtiene distribución demográfica (por género y grupo etario) para el período y sala opcional.
     * @param array $rango
     * @param string|null $salaId
     * @return array ['masculinos' => ['ninos'=>int, 'adolescentes'=>int, 'adultos'=>int], 'femeninos' => [...]]
     */
    public function getDistribucionDemografica(array $rango, ?string $salaId = null): array
    {
        $sql = "SELECT 
                    SUM(Niños_Hombres) as ninos_m,
                    SUM(Niños_Mujeres) as ninos_f,
                    SUM(Adolescentes_Hombres) as adol_m,
                    SUM(Adolescentes_Mujeres) as adol_f,
                    SUM(Adultos_Hombres) as adultos_m,
                    SUM(Adultos_Mujeres) as adultos_f
                FROM conteo_diario_visitantes
                WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1";
        if ($salaId) {
            $sql .= " AND ID_Sala = :sala";
        }
        $stmt = $this->pdo->prepare($sql);
        $params = $rango;
        if ($salaId) {
            $params[':sala'] = $salaId;
        }
        $stmt->execute($params);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return [
            'masculinos' => [
                'ninos' => (int) $row['ninos_m'],
                'adolescentes' => (int) $row['adol_m'],
                'adultos' => (int) $row['adultos_m']
            ],
            'femeninos' => [
                'ninos' => (int) $row['ninos_f'],
                'adolescentes' => (int) $row['adol_f'],
                'adultos' => (int) $row['adultos_f']
            ]
        ];
    }

    /**
     * Calcula el rango de fechas según período (semana, mes, trimestre) y devuelve array con 'inicio' y 'fin'.
     * @param string $periodo 'semana', 'mes', 'trimestre'
     * @return array
     */
    public function calcularRango(string $periodo): array
    {
        $fin = date('Y-m-d');
        switch ($periodo) {
            case 'semana':
                $inicio = date('Y-m-d', strtotime('-7 days'));
                break;
            case 'mes':
                $inicio = date('Y-m-d', strtotime('-30 days'));
                break;
            case 'trimestre':
                $inicio = date('Y-m-d', strtotime('-90 days'));
                break;
            default:
                $inicio = date('Y-m-d', strtotime('-30 days'));
        }
        return ['inicio' => $inicio, 'fin' => $fin];
    }
}