<?php
namespace App\Models\Services;

use PDO;

class VisitanteEstadisticaService
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Obtiene los totales de niños, adolescentes y adultos en un rango de fechas.
     */
    public function getTotalesGrupos(string $fechaInicio, string $fechaFin): array
    {
        $sql = "SELECT 
                    SUM(Niños_Hombres + Niños_Mujeres) as ninos,
                    SUM(Adolescentes_Hombres + Adolescentes_Mujeres) as adolescentes,
                    SUM(Adultos_Hombres + Adultos_Mujeres) as adultos
                FROM conteo_diario_visitantes
                WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':inicio' => $fechaInicio, ':fin' => $fechaFin]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return [
            'ninos' => (int)($row['ninos'] ?? 0),
            'adolescentes' => (int)($row['adolescentes'] ?? 0),
            'adultos' => (int)($row['adultos'] ?? 0)
        ];
    }

    /**
     * Total de obras consultadas en el rango de fechas.
     */
    public function getTotalObrasConsultadas(string $fechaInicio, string $fechaFin): int
    {
        $sql = "SELECT SUM(Cantidad_Consultada) as total
                FROM consultas_area_diarias
                WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':inicio' => $fechaInicio, ':fin' => $fechaFin]);
        return (int)($stmt->fetchColumn() ?? 0);
    }

    /**
     * Datos para el gráfico de consultas por área (clasificación).
     * @param string $periodo 'semana', 'mes', 'trimestre'
     * @return array ['labels' => ['000','100',...], 'data' => [10,20,...]]
     */
    public function getDatosGrafico(string $periodo): array
    {
        $fechas = $this->calcularRangoFechas($periodo);
        $sql = "SELECT ID_Area, SUM(Cantidad_Consultada) as total
                FROM consultas_area_diarias
                WHERE Fecha BETWEEN :inicio AND :fin AND Activo = 1
                GROUP BY ID_Area
                ORDER BY ID_Area";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':inicio' => $fechas['inicio'], ':fin' => $fechas['fin']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Definir todas las áreas posibles (incluyendo Biog)
        $areas = ['000','100','200','300','400','500','600','700','800','900','N','NV','Biog'];
        $data = [];
        foreach ($areas as $area) {
            $encontrado = false;
            foreach ($rows as $row) {
                if ($row['ID_Area'] == $area) {
                    $data[] = (int)$row['total'];
                    $encontrado = true;
                    break;
                }
            }
            if (!$encontrado) $data[] = 0;
        }
        return ['labels' => $areas, 'data' => $data];
    }

    /**
     * Listado paginado de registros de visitantes.
     * @param int $pagina
     * @param int $porPagina
     * @param string|null $fechaDesde
     * @param string|null $fechaHasta
     * @return array ['datos' => [...], 'total' => int, 'pagina' => int, 'ultimaPagina' => int]
     */
    public function listarRegistros(int $pagina = 1, int $porPagina = 10, ?string $fechaDesde = null, ?string $fechaHasta = null): array
    {
        $offset = ($pagina - 1) * $porPagina;
        $where = "WHERE Activo = 1";
        $params = [];
        if ($fechaDesde && $fechaHasta) {
            $where .= " AND Fecha BETWEEN :desde AND :hasta";
            $params[':desde'] = $fechaDesde;
            $params[':hasta'] = $fechaHasta;
        }
        // Consulta total
        $countSql = "SELECT COUNT(*) FROM conteo_diario_visitantes $where";
        $stmtCount = $this->pdo->prepare($countSql);
        $stmtCount->execute($params);
        $total = (int) $stmtCount->fetchColumn();

        // Consulta datos
        $sql = "SELECT ID_Conteo, ID_Sala, Fecha, Turno,
                       Niños_Hombres, Niños_Mujeres,
                       Adolescentes_Hombres, Adolescentes_Mujeres,
                       Adultos_Hombres, Adultos_Mujeres
                FROM conteo_diario_visitantes $where
                ORDER BY Fecha DESC, Turno DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        // Unir parámetros de búsqueda y paginación
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->bindValue(':limit', $porPagina, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $datos = [];
        foreach ($rows as $row) {
            $totalVisitantes = $row['Niños_Hombres'] + $row['Niños_Mujeres'] +
                               $row['Adolescentes_Hombres'] + $row['Adolescentes_Mujeres'] +
                               $row['Adultos_Hombres'] + $row['Adultos_Mujeres'];
            $datos[] = [
                'id' => $row['ID_Conteo'],
                'fecha' => $row['Fecha'],
                'turno' => $row['Turno'],
                'sala' => $this->nombreSala($row['ID_Sala']),
                'distribucion' => ($row['Niños_Hombres']+$row['Niños_Mujeres']) . " / " .
                                  ($row['Adolescentes_Hombres']+$row['Adolescentes_Mujeres']) . " / " .
                                  ($row['Adultos_Hombres']+$row['Adultos_Mujeres']),
                'total' => $totalVisitantes
            ];
        }
        return [
            'datos' => $datos,
            'total' => $total,
            'pagina' => $pagina,
            'porPagina' => $porPagina,
            'ultimaPagina' => ceil($total / $porPagina)
        ];
    }

    // app/Models/Services/VisitanteEstadisticaService.php

    public function calcularRangoFechas(string $periodo): array
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

    private function nombreSala(string $idSala): string
    {
        $map = ['G' => 'Sala General', 'R' => 'Sala Referencia', 'SE' => 'Sala Estatal', 'X' => 'Sala Infantil'];
        return $map[$idSala] ?? $idSala;
    }

    /**
     * Obtiene todos los datos necesarios para el modal de detalle
     * @param string $periodo 'semana', 'mes', 'trimestre'
     * @return array
     */
    public function getDatosModal(string $periodo): array
    {
        $rango = $this->calcularRangoFechas($periodo);
        $fechaDesde = $rango['inicio'];
        $fechaHasta = $rango['fin'];

        // Total obras en el período
        $totalObras = $this->getTotalObrasConsultadas($fechaDesde, $fechaHasta);
        
        // Día de la semana con más consultas
        $diaMasConcurrido = $this->getDiaMasConcurrido($fechaDesde, $fechaHasta);
        
        // Tendencia (vs período anterior igual)
        $tendencia = $this->calcularTendencia($fechaDesde, $fechaHasta);
        
        // Tabla de consultas por día de semana
        $tabla = $this->getConsultasPorDiaSemana($fechaDesde, $fechaHasta);
        
        // Total acumulado (suma de obras de la tabla)
        $totalAcumulado = array_sum(array_column($tabla, 'total'));
        
        return [
            'totalPeriodo' => $totalObras,
            'diaMasConcurrido' => $diaMasConcurrido,
            'tendencia' => $tendencia,
            'tabla' => $tabla,
            'totalAcumulado' => $totalAcumulado
        ];
    }

    /**
     * Devuelve el día de la semana con mayor cantidad de consultas
     */
    private function getDiaMasConcurrido(string $fechaDesde, string $fechaHasta): string
    {
        $sql = "SELECT DAYOFWEEK(Fecha) as dia_semana, SUM(Cantidad_Consultada) as total
                FROM consultas_area_diarias
                WHERE Fecha BETWEEN :desde AND :hasta AND Activo = 1
                GROUP BY dia_semana
                ORDER BY total DESC LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':desde' => $fechaDesde, ':hasta' => $fechaHasta]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return 'Sin datos';
        }
        return $this->nombreDia((int)$row['dia_semana']);
    }

    /**
     * Calcula la tendencia porcentual respecto al período anterior de igual duración
     */
    private function calcularTendencia(string $fechaDesde, string $fechaHasta): string
    {
        $duracion = strtotime($fechaHasta) - strtotime($fechaDesde);
        $anteriorDesde = date('Y-m-d', strtotime($fechaDesde . " - $duracion seconds"));
        $anteriorHasta = date('Y-m-d', strtotime($fechaDesde . " - 1 day"));
        $totalActual = $this->getTotalObrasConsultadas($fechaDesde, $fechaHasta);
        $totalAnterior = $this->getTotalObrasConsultadas($anteriorDesde, $anteriorHasta);
        if ($totalAnterior == 0) {
            return $totalActual > 0 ? '+100%' : '0%';
        }
        $porcentaje = round(($totalActual - $totalAnterior) / $totalAnterior * 100);
        return ($porcentaje >= 0 ? '+' : '') . $porcentaje . '%';
    }

    /**
     * Obtiene las consultas agrupadas por día de la semana
     */
    private function getConsultasPorDiaSemana(string $fechaDesde, string $fechaHasta): array
    {
        $sql = "SELECT DAYOFWEEK(Fecha) as dia_semana, SUM(Cantidad_Consultada) as total
                FROM consultas_area_diarias
                WHERE Fecha BETWEEN :desde AND :hasta AND Activo = 1
                GROUP BY dia_semana
                ORDER BY dia_semana";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':desde' => $fechaDesde, ':hasta' => $fechaHasta]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $resultados = [];
        foreach ($rows as $row) {
            $resultados[] = [
                'dia' => $this->nombreDia((int)$row['dia_semana']),
                'total' => (int)$row['total']
            ];
        }
        return $resultados;
    }

    /**
     * Convierte DAYOFWEEK (1=domingo, ..., 7=sábado) a nombre en español
     */
    private function nombreDia(int $dayOfWeek): string
    {
        $dias = [1 => 'Domingo', 2 => 'Lunes', 3 => 'Martes', 4 => 'Miércoles', 5 => 'Jueves', 6 => 'Viernes', 7 => 'Sábado'];
        return $dias[$dayOfWeek] ?? '';
    }
}