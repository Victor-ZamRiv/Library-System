<?php
namespace App\Controllers;

use App\Contracts\IAdministradorRepository;
use App\Contracts\IAutorRepository;
use App\Contracts\IEditorialRepository;
use App\Contracts\IAuditRepository;
use App\Core\BaseController;

class HistorialController extends BaseController
{
    private IAuditRepository $auditRepo;
    private IAdministradorRepository $adminRepo;
    private IEditorialRepository $editorialRepo;
    private IAutorRepository $autorRepo;
    private array $modulos = [
        'actividad' => 'historial_actividad',
        'libro' => 'historial_libro',
        'prestamo' => 'historial_prestamo',
        'multa' => 'historial_multa',
        'lector' => 'historial_lector',
        // añade otros según tu BD
    ];

    public function __construct(
        IAuditRepository $auditRepo,
        IAdministradorRepository $adminRepo,
        IEditorialRepository $editorialRepo,
        IAutorRepository $autorRepo
    ) {
        $this->auditRepo = $auditRepo;
        $this->adminRepo = $adminRepo;
        $this->editorialRepo = $editorialRepo;
        $this->autorRepo = $autorRepo;
        $this->authenticate();
        // Opcional: middleware de rol (solo directores o administradores)
        $this->middlewareRol(['Director'], 'historial');
    }

    /**
     * Muestra la lista de registros de auditoría con filtros.
     */
    public function index(): string
    {
        // Filtros (con valores por defecto)
        $filtros = [
            'usuario' => $this->input('filtro-usuario', ''),
            'accion'  => $this->input('filtro-accion', ''),
            'modulo'  => $this->input('filtro-modulo', ''),
            'desde'   => $this->input('filtro-desde', ''),
            'hasta'   => $this->input('filtro-hasta', '')
        ];
        
        $pagina = (int) $this->input('page', 1);
        $porPagina = 10;
        
        // Módulos disponibles
        $modulos = [
            'actividad' => 'historial_actividad',
            'libro'     => 'historial_libro',
            'prestamo'  => 'historial_prestamo',
            'multa'     => 'historial_multa',
            'lector'    => 'historial_lector'
        ];
        
        $registros = [];
        $paginacion = null;
        
        if (!empty($filtros['modulo']) && isset($modulos[$filtros['modulo']])) {
            $tablaHistorial = $modulos[$filtros['modulo']];
            $resultado = $this->auditRepo->getHistorialPaginado(
                $tablaHistorial,
                $pagina,
                $porPagina,
                $filtros['usuario'] ?: null,
                $filtros['accion'] ?: null,
                $filtros['desde'] ?: null,
                $filtros['hasta'] ?: null
            );
            
            $registros = $resultado['datos'];
            $paginacion = [
                'actual' => $resultado['pagina'],
                'porPagina' => $resultado['porPagina'],
                'total' => $resultado['total'],
                'ultima' => $resultado['ultimaPagina']
            ];
            
            // Enriquecer registros
            foreach ($registros as &$r) {
                $admin = $this->adminRepo->find($r['ID_Admin']);
                $nombreAdmin = 'Desconocido';
                if ($admin && $admin->getPersona()) {
                    $nombreAdmin = $admin->getPersona()->getNombre() . ' ' . $admin->getPersona()->getApellido();
                }
                $r['usuario'] = $nombreAdmin;
                $r['modulo'] = ucfirst($filtros['modulo']);
                $r['accion'] = $r['Tipo_Cambio'];
                $r['fecha'] = $r['Fecha_Cambio'];
                $r['descripcion'] = $this->generarDescripcion($filtros['modulo'], $r);
                $pk = $this->auditRepo->getPrimaryKey($tablaHistorial);
                $r['id'] = $r[$pk];
            }
        }
        
        // Obtener usuarios para el filtro
        $usuarios = [];
        $admins = $this->adminRepo->all();
        foreach ($admins as $admin) {
            $persona = $admin->getPersona();
            if ($persona) {
                $usuarios[] = [
                    'id' => $admin->getIdAdministrador(),
                    'nombre' => $persona->getNombre() . ' ' . $persona->getApellido() . ' (' . $admin->getNombreUsuario() . ')'
                ];
            }
        }
        
        return $this->render('history/history', [
            'registros' => $registros,
            'usuarios' => $usuarios,
            'modulos' => $modulos,
            'filtros' => $filtros,
            'paginacion' => $paginacion
        ]);
    }

    public function show(): string
    {
        $modulo = $this->input('modulo');
        $id = (int) $this->input('id');

        // Mapear nombre del módulo a tabla de historial
        $mapaTablas = [
            'actividad' => 'historial_actividad',
            'libro' => 'historial_libro',
            'prestamo' => 'historial_prestamo',
            'multa' => 'historial_multa',
            'lector' => 'historial_lector',
            // añade otros según necesites
        ];

        if (!isset($mapaTablas[$modulo])) {
            http_response_code(400);
            return "Módulo no válido";
        }

        $tablaHistorial = $mapaTablas[$modulo];
        $registro = $this->auditRepo->getRegistro($tablaHistorial, $id);
        $admin = $this->adminRepo->find($registro['ID_Admin']);
        $nombreAdmin = $admin ? $admin->getNombreUsuario() : 'Desconocido';

        if (!$registro) {
            http_response_code(404);
            return "Registro no encontrado";
        }

        // Decodificar JSON
        $old = json_decode($registro['Viejo_Valor'], true) ?: [];
        $new = json_decode($registro['Nuevo_Valor'], true) ?: [];

        // Enriquecer datos según el módulo
        if ($modulo === 'libro') {
            $old = $this->enriquecerDatosLibro($old);
            $new = $this->enriquecerDatosLibro($new);
        } elseif ($modulo === 'actividad') {
            // posiblemente no requiera transformación especial
        }

        return $this->render('history/info-history', [
            'modulo' => $modulo,
            'registro' => $registro,
            'old_data' => $old,
            'new' => $new,
            'usuario' => $nombreAdmin
        ]);
    }

    /**
     * Transforma los datos del libro (desde JSON de auditoría) para que sean legibles en la vista.
     * Convierte IDs en nombres, arrays en strings, y elimina claves problemáticas.
     */
    private function enriquecerDatosLibro(array $data): array
    {
        // 1. Editorial (desde idEditorial)
        if (isset($data['idEditorial']) && is_numeric($data['idEditorial'])) {
            $editorial = $this->editorialRepo->find($data['idEditorial']);
            $data['editorial_nombre'] = $editorial ? $editorial->getNombre() : 'Desconocido';
            unset($data['idEditorial']);
        }
        // Si llegara como objeto editorial
        if (isset($data['editorial']) && is_array($data['editorial']) && isset($data['editorial']['nombre'])) {
            $data['editorial_nombre'] = $data['editorial']['nombre'];
            unset($data['editorial']);
        }

        // 2. Sala
        if (isset($data['idSala'])) {
            $mapaSala = ['G'=>'Sala General','R'=>'Sala Referencia','SE'=>'Sala Estatal','X'=>'Sala Infantil'];
            $data['sala_nombre'] = $mapaSala[$data['idSala']] ?? $data['idSala'];
            unset($data['idSala']);
        }

        // 3. Autores
        if (isset($data['autores']) && is_array($data['autores'])) {
            $nombres = [];
            foreach ($data['autores'] as $autor) {
                if (is_array($autor) && isset($autor['nombre'])) {
                    $nombres[] = $autor['nombre'];
                } elseif (is_object($autor) && method_exists($autor, 'getNombre')) {
                    $nombres[] = $autor->getNombre();
                }
            }
            $data['autores_nombres'] = !empty($nombres) ? implode(', ', $nombres) : 'No disponible';
            unset($data['autores']);
        } else {
            $data['autores_nombres'] = 'No disponible';
        }

        // 4. Ejemplares
        if (isset($data['ejemplares']) && is_array($data['ejemplares'])) {
            $numeros = [];
            foreach ($data['ejemplares'] as $ej) {
                if (is_array($ej) && isset($ej['numeroEjemplar'])) {
                    $numeros[] = $ej['numeroEjemplar'];
                } elseif (is_object($ej) && method_exists($ej, 'getNumeroEjemplar')) {
                    $numeros[] = $ej->getNumeroEjemplar();
                }
            }
            $data['ejemplares_resumen'] = !empty($numeros) ? implode(', ', $numeros) : 'Sin ejemplares';
            unset($data['ejemplares']);
        } else {
            $data['ejemplares_resumen'] = 'Sin datos';
        }

        // 5. Activo
        if (isset($data['activo'])) {
            $data['activo_texto'] = $data['activo'] ? 'Sí' : 'No';
            unset($data['activo']);
        }

        // Eliminar cualquier otra clave que sea array (por si acaso)
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * Enriquece los registros de auditoría con datos legibles (usuario, módulo, descripción).
     */
    private function enriquecerRegistros(array $registros, string $modulo): array
    {
        // Mapeo de acciones a textos
        $accionesTexto = [
            'INSERT' => 'Creación',
            'UPDATE' => 'Actualización',
            'DELETE' => 'Eliminación'
        ];

        $resultado = [];
        foreach ($registros as $r) {
            // Obtener nombre del administrador
            $admin = $this->adminRepo->find($r['ID_Admin']);
            $nombreAdmin = 'Desconocido';
            if ($admin && $admin->getPersona()) {
                $nombreAdmin = $admin->getPersona()->getNombre() . ' ' . $admin->getPersona()->getApellido();
            }

            // Generar una breve descripción del cambio (puedes personalizarla según el módulo)
            $descripcion = $this->generarDescripcion($modulo, $r);

            $resultado[] = [
                'id' => $r[$this->auditRepo->getPrimaryKey($this->modulos[$modulo])],
                'usuario' => $nombreAdmin,
                'modulo' => ucfirst($modulo),
                'fecha' => $r['Fecha_Cambio'],
                'accion' => $r['Tipo_Cambio'],
                'descripcion' => $descripcion
            ];
        }
        return $resultado;
    }

    private function generarDescripcion(string $modulo, array $registro): string
    {
        $accion = $registro['Tipo_Cambio'];
        $idRegistro = $registro['ID_' . ucfirst($modulo)] ?? 'N/A';
        switch ($accion) {
            case 'INSERT':
                return "Se creó un nuevo registro en $modulo (ID: $idRegistro).";
            case 'UPDATE':
                return "Se actualizó el registro de $modulo (ID: $idRegistro).";
            case 'DELETE':
                return "Se eliminó/desactivó el registro de $modulo (ID: $idRegistro).";
            default:
                return "Cambio en $modulo (ID: $idRegistro).";
        }
    }
}

