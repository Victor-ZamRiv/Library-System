<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Services\HistorialService;

class HistorialController extends BaseController
{
    private HistorialService $historialService;

    public function __construct(HistorialService $historialService)
    {
        $this->historialService = $historialService;
    }

    public function index()
    {
        $this->authenticate();

        $fUsuario = $this->input('filtro-usuario');
        $fAccion = $this->input('filtro-accion');
        $fModulo = $this->input('filtro-modulo');
        $desde = $this->input('desde');
        $hasta = $this->input('hasta');

        $idAdmin = $fUsuario ? (int)$fUsuario : null;
        $accion = $fAccion ?: null;

        $registros = $this->historialService->listar(
            $fModulo ?: null,
            $idAdmin,
            $accion,
            $desde ?: null,
            $hasta ?: null
        );

        return $this->render('history/history', [
            'registros' => $registros,
            'modulos' => $this->historialService->getModulos(),
            'filtros' => [
                'usuario' => $fUsuario,
                'accion' => $fAccion,
                'modulo' => $fModulo,
                'desde' => $desde,
                'hasta' => $hasta,
            ],
        ]);
    }

    public function show()
    {
        $this->authenticate();

        $modulo = $this->input('modulo');
        $id = (int)$this->input('id');

        $detalle = $this->historialService->detalle($modulo, $id);
        if (!$detalle) {
            die('Registro de historial no encontrado');
        }

        return $this->render('history/info-history', $detalle);
    }
}

