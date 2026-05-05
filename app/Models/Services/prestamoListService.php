<?php

namespace App\Models\Services;

use PDO;

class PrestamoListService
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Obtiene préstamos paginados con los datos necesarios.
     *
     * @param int $pagina Número de página (1-indexed)
     * @param int $porPagina Cantidad de registros por página
     * @param string $busqueda (opcional) texto para buscar en carnet, nombre de lector, cota o título
     * @return array {
     *     'datos' => array de objetos (o arrays asociativos) con los campos,
     *     'total' => int, total de registros sin paginar,
     *     'pagina' => int,
     *     'porPagina' => int,
     *     'ultimaPagina' => int
     * }
     */
    public function listarPaginado(
        int $pagina = 1,
        int $porPagina = 10,
        string $criterio = '',
        string $termino = ''
    ): array {
        $offset = ($pagina - 1) * $porPagina;

        // Base de la consulta (sin WHERE aún)
        $baseSql = "
            FROM prestamos p
            JOIN lectores l ON p.ID_Lector = l.ID_Lector
            JOIN persona per ON l.ID_Persona = per.ID_Persona
            JOIN administradores a ON p.ID_Admin = a.ID_Admin
            JOIN persona per_admin ON a.ID_Persona = per_admin.ID_Persona
            LEFT JOIN ejemplar_prestamo ep ON p.ID_Prestamo = ep.ID_Prestamo
            LEFT JOIN ejemplares e ON ep.ID_Ejemplar = e.ID_Ejemplar
            LEFT JOIN libros lib ON e.ID_Libro = lib.ID_Libro
            WHERE 1=1
        ";

        $params = [];

        // Aplicar filtro según criterio
        if (!empty($termino)) {
            switch ($criterio) {
                case 'id':
                    $baseSql .= " AND p.ID_Prestamo = :termino";
                    $params[':termino'] = (int)$termino;
                    break;
                case 'carnet':
                    $baseSql .= " AND per.Cedula LIKE :termino";
                    $params[':termino'] = '%' . $termino . '%';
                    break;
                case 'cota':
                    $baseSql .= " AND lib.Cota LIKE :termino";
                    $params[':termino'] = '%' . $termino . '%';
                    break;
                default:
                    // Si no hay criterio válido, no filtrar
                    break;
            }
        }

        // Consulta para contar total
        $countSql = "SELECT COUNT(DISTINCT p.ID_Prestamo) " . $baseSql;
        $stmtCount = $this->pdo->prepare($countSql);
        $stmtCount->execute($params);
        $total = (int) $stmtCount->fetchColumn();

        // Consulta para obtener datos paginados
        $dataSql = "
            SELECT 
                p.ID_Prestamo as idPrestamo,
                p.Fecha_Entrega as fechaEntrega,
                p.Fecha_Recepcion_Estipulada as fechaDevolucion,
                p.Estado_Entrega as estado,
                per.Cedula as carnetLector,
                per.Nombre as nombreLector,
                per.Apellido as apellidoLector,
                per_admin.Nombre as nombreAdmin,
                per_admin.Apellido as apellidoAdmin,
                lib.Cota as cota,
                e.Numero_Ejemplar as numeroEjemplar,
                lib.Titulo as tituloLibro
            " . $baseSql . "
            ORDER BY p.Fecha_Entrega DESC
            LIMIT :limit OFFSET :offset
        ";

        $stmtData = $this->pdo->prepare($dataSql);
        // Bindear parámetros de búsqueda
        foreach ($params as $key => $value) {
            $stmtData->bindValue($key, $value);
        }
        $stmtData->bindValue(':limit', $porPagina, PDO::PARAM_INT);
        $stmtData->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmtData->execute();
        $rows = $stmtData->fetchAll(PDO::FETCH_ASSOC);

        $datos = [];
        foreach ($rows as $row) {
            $datos[] = [
                'idPrestamo' => $row['idPrestamo'],
                'fechaEmision' => $row['fechaEntrega'],
                'fechaDevolucion' => $row['fechaDevolucion'],
                'estado' => $row['estado'],
                'carnetLector' => $row['carnetLector'],
                'lector' => $row['nombreLector'] . ' ' . $row['apellidoLector'],
                'administrador' => $row['nombreAdmin'] . ' ' . $row['apellidoAdmin'],
                'cota' => $row['cota'],
                'numeroEjemplar' => $row['numeroEjemplar'],
                'titulo' => $row['tituloLibro']
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
}