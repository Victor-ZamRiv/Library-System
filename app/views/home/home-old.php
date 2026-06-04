<?php
// ==========================================
//   CONTROL DE VISIBILIDAD (10 INDICADORES)
// ==========================================
$mostrarCobertura = $dashboardConfig->getMostrarCobertura();
$mostrarReferencia = $dashboardConfig->getMostrarReferencia();
$mostrarGraficoConsultas = $dashboardConfig->getMostrarGraficoConsultas();
$mostrarCumplimiento = $dashboardConfig->getMostrarCumplimiento();
$mostrarOcupacion = $dashboardConfig->getMostrarOcupacion();
$mostrarRotacion = $dashboardConfig->getMostrarRotacion();
$mostrarFisico = $dashboardConfig->getMostrarEstadoFisico();
$mostrarAsistencia = $dashboardConfig->getMostrarAsistenciaEstatal();
$mostrarColeccion = $dashboardConfig->getMostrarColeccion();
$mostrarActividades = $dashboardConfig->getMostrarActividades();

// Agrupaciones lógicas por sección para evaluar estados vacíos
$seccionUsuariosVacia = (!$mostrarCobertura && !$mostrarReferencia && !$mostrarGraficoConsultas);
$seccionProcesosVacia = (!$mostrarCumplimiento && !$mostrarOcupacion && !$mostrarRotacion && !$mostrarFisico && !$mostrarAsistencia && !$mostrarColeccion);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Inicio</title>
    <?php include VIEW_PATH . "/component/heat.php"; ?>
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/css/style-indicator.css">
    <script>
        var BASE_URL = '<?= BASE_URL ?>';
    </script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jsPDF.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jspdf-autotable.js"></script>
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/css/dashboard.css">
</head>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>

        <div class="container-fluid" style="padding-top: 20px;">
            <div class="page-header text-center">
                <div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
        <h2 class="text-titles" style="margin: 0; text-align: left;">
            <i class="fa-solid fa-landmark"></i> Gestión de la Biblioteca "Armando Zuloaga Blanco"
        </h2>

        <div style="display: flex; gap: 10px;">
            <button type="button" class="btn btn-primary btn-raised btn-lg" onclick="descargarPDF('dashboard')" style="margin: 0;">
                <i class="fa-solid fa-file-pdf"></i> Descargar Resumen
            </button>
            <button type="button" class="btn btn-primary btn-raised btn-lg" onclick="descargarPDF('macro')" style="margin: 0;">
                <i class="fa-solid fa-file-pdf"></i> Reporte General
            </button>
        </div>
    </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa-solid fa-users"></i> Indicadores de Usuarios y Consultas</h3>
                    </div>
                    <div class="panel-body">
                        <?php if ($seccionUsuariosVacia): ?>
                            <div class="empty-state-container">
                                <i class="fa-solid fa-eye-slash empty-state-icon"></i>
                                <p class="empty-state-text">
                                    Los indicadores y gráficos de esta sección se encuentran deshabilitados debido a la configuración actual del sistema.
                                </p>
                                <a href="<?= BASE_URL ?>/configuracion/indicator" class="btn btn-primary btn-raised btn-sm">
                                    <i class="fa-solid fa-gear"></i> Configurar Indicadores
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="row" style="display: flex; flex-wrap: wrap;">
                                <?php if ($mostrarCobertura || $mostrarReferencia): ?>
                                    <div class="col-xs-12 col-sm-4" style="display: flex; flex-direction: column;">
                                        <div class="contenedor-paneles-superiores">

                                            <?php if ($mostrarCobertura):
                                                if ($cobertura < 40) {
                                                    $colorDinamicoCobertura = '#d9534f';
                                                    $textoEstadoCobertura = 'CRÍTICO';
                                                    $claseFondo = 'fondo-card-critico';
                                                } elseif ($cobertura < 70) {
                                                    $colorDinamicoCobertura = '#f0ad4e';
                                                    $textoEstadoCobertura = 'TOLERABLE';
                                                    $claseFondo = 'fondo-card-tolerable';
                                                } else {
                                                    $colorDinamicoCobertura = '#5cb85c';
                                                    $textoEstadoCobertura = 'ÓPTIMO';
                                                    $claseFondo = 'fondo-card-optimo';
                                                }
                                            ?>
                                                <div class="well well-sm text-center <?= $claseFondo ?>" id="panel-cobertura-usuarios"
                                                    style="position: relative; cursor: pointer; padding: 15px;"
                                                    data-toggle="modal" data-target="#modalDetalleCobertura">
                                                    <h5 class="text-uppercase text-titles" style="margin: 5px 0 0 0; font-weight: bold; color: #555; font-size: 11px; letter-spacing: 0.5px;">Cobertura de Usuarios</h5>
                                                    <h3 id="cobertura-valor" style="margin: 8px 0; font-weight: bold; color: <?= $colorDinamicoCobertura ?> !important; font-size: 22px;"><?= $cobertura ?>%</h3>
                                                    <div style="margin-top: 10px;">
                                                        <span class="label" style="display: inline-block; padding: 6px 20px; font-size: 13px; font-weight: bold; border-radius: 14px; text-transform: uppercase; background-color: <?= $colorDinamicoCobertura ?>; color: white; letter-spacing: 0.5px;">
                                                            <?= $textoEstadoCobertura ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($mostrarReferencia):
                                                if ($razonReferencia <= 1.0) {
                                                    $colorDinamicoReferencia = '#d9534f';
                                                    $textoEstadoReferencia = 'CRÍTICO';
                                                    $claseFondo = 'fondo-card-critico';
                                                } elseif ($razonReferencia < 2.0) {
                                                    $colorDinamicoReferencia = '#f0ad4e';
                                                    $textoEstadoReferencia = 'TOLERABLE';
                                                    $claseFondo = 'fondo-card-tolerable';
                                                } else {
                                                    $colorDinamicoReferencia = '#5cb85c';
                                                    $textoEstadoReferencia = 'ÓPTIMO';
                                                    $claseFondo = 'fondo-card-optimo';
                                                }
                                            ?>
                                                <div class="well well-sm text-center <?= $claseFondo ?>" id="panel-consultas-referencia"
                                                    style="position: relative; cursor: pointer; padding: 15px;"
                                                    data-toggle="modal" data-target="#modalDetalleReferencia">
                                                    <h5 class="text-uppercase text-titles" style="margin: 5px 0 0 0; font-weight: bold; color: #555; font-size: 11px; letter-spacing: 0.5px;">Consultas de Referencia</h5>
                                                    <h3 id="referencia-valor" style="margin: 6px 0 2px 0; font-weight: bold; color: <?= $colorDinamicoReferencia ?> !important; font-size: 22px;"><?= $razonReferencia ?></h3>
                                                    <small class="text-muted" style="font-size: 20px; display: block; margin-bottom: 8px;">Por usuario activo</small>
                                                    <div style="margin-top: 10px;">
                                                        <span class="label" style="display: inline-block; padding: 6px 20px; font-size: 13px; font-weight: bold; border-radius: 14px; text-transform: uppercase; background-color: <?= $colorDinamicoReferencia ?>; color: white; letter-spacing: 0.5px;">
                                                            <?= $textoEstadoReferencia ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($mostrarGraficoConsultas):
                                    $rendimientoConsultas = $rendimientoConsultas ?? 8;
                                    if ($rendimientoConsultas < 70) {
                                        $colorDinamicoGrafico = '#d9534f';
                                        $textoEstadoGrafico = 'CRÍTICO';
                                    } elseif ($rendimientoConsultas <= 90) {
                                        $colorDinamicoGrafico = '#f0ad4e';
                                        $textoEstadoGrafico = 'TOLERABLE';
                                    } else {
                                        $colorDinamicoGrafico = '#5cb85c';
                                        $textoEstadoGrafico = 'ÓPTIMO';
                                    }
                                ?>
                                    <div class="grafico-adaptable <?= ($mostrarCobertura || $mostrarReferencia) ? 'col-xs-12 col-sm-8' : 'col-xs-12' ?>"
                                        id="panel-grafico-consultas"
                                        style="cursor: pointer; margin-bottom: 15px;"
                                        data-toggle="modal" data-target="#modalDetalleConsultasGrafico">

                                        <div class="thumbnail" style="background: #fff; border: 1px solid #e3e3e3; border-radius: 10px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 0;">

                                            <div style="display: flex; justify-content: space-between; align-items: start; padding: 0 5px; margin-bottom: 10px;">
                                                <div>
                                                    <br>
                                                    <h4 class="text-uppercase text-titles" style="margin: 0 0 2px 0; font-weight: bold; color: #555; font-size: 11px; letter-spacing: 0.5px;">
                                                        Promedio de Consultas
                                                    </h4>
                                                    <small style="font-size: 13px; color: #888; display: block; line-height: 1.1;">
                                                        Mide el volumen de consultas procesadas en función del tiempo operativo.
                                                    </small>
                                                </div>

                                                <div class="btn-group" onclick="event.stopPropagation();" style="box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                                    <button type="button" id="btnConsultasDashsemana" class="btn btn-xs btn-default" style="font-weight: 600; padding: 2px 8px;" onclick="actualizarTodo('semana')">Semana</button>
                                                    <button type="button" id="btnConsultasDashmes" class="btn btn-xs btn-default active" style="font-weight: 600; padding: 2px 8px;" onclick="actualizarTodo('mes')">Mes</button>
                                                    <button type="button" id="btnConsultasDashtrimestre" class="btn btn-xs btn-default" style="font-weight: 600; padding: 2px 8px;" onclick="actualizarTodo('trimestre')">Trimestre</button>
                                                </div>
                                            </div>

                                            <div id="chartConsultas" style="padding: 0 5px; min-height: 160px;"></div>

                                            <div class="text-center" style="margin-top: 12px; border-top: 1px solid #f5f5f5; padding-top: 10px;">
                                                <span id="badgeConsultasEstado" class="label" style="display: inline-block; padding: 6px 20px; font-size: 12px; font-weight: bold; border-radius: 14px; text-transform: uppercase; background-color: <?= $colorDinamicoGrafico ?>; color: white; letter-spacing: 0.5px; transition: background-color 0.3s ease;">
                                                    <?= $textoEstadoGrafico ?> (<?= $rendimientoConsultas ?>%)
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa-solid fa-gears"></i> Procesos Internos y Gestión de Colecciones</h3>
                    </div>
                    <div class="panel-body">
                        <?php if ($seccionProcesosVacia): ?>
                            <div class="empty-state-container">
                                <i class="fa-solid fa-folder-open empty-state-icon"></i>
                                <p class="empty-state-text">
                                    Los indicadores y gráficos de esta sección se encuentran deshabilitados debido a la configuración actual del sistema.
                                </p>
                                <a href="<?= BASE_URL ?>/configuracion/indicator" class="btn btn-success btn-raised btn-sm">
                                    <i class="fa-solid fa-gear"></i> Configurar Indicadores
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="row fila-procesos-medios">
                                <?php if ($mostrarCumplimiento): ?>
                                    <div class="grafico-adaptable col-xs-12 <?= ($mostrarOcupacion && ($mostrarRotacion || $mostrarFisico || $mostrarAsistencia || $mostrarColeccion)) ? 'col-md-4' : 'col-md-6' ?>"
                                        style="cursor: pointer; margin-bottom: 15px;"
                                        data-toggle="modal" data-target="#modalDetalleCumplimiento">

                                        <div class="thumbnail" style="background: #fff; border: 1px solid #e3e3e3; border-radius: 10px; padding: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 0;">

                                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0 5px; margin-bottom: 10px;">
                                                <h5 class="text-uppercase text-titles" style="margin: 0; font-size: 11px; font-weight: bold; color: #555; letter-spacing: 0.5px;">Cumplimiento</h5>
                                                <div class="btn-group" onclick="event.stopPropagation();">
                                                    <button type="button" class="btn btn-xs btn-default" onclick="actualizarCumplimiento('semana')">Semana</button>
                                                    <button type="button" class="btn btn-xs btn-default" onclick="actualizarCumplimiento('mes')">Mes</button>
                                                    <button type="button" class="btn btn-xs btn-default" onclick="actualizarCumplimiento('trimestre')">Trimestre</button>
                                                </div>
                                            </div>

                                            <div id="chartPlazos" style="padding: 0 10px; min-height: 160px;"></div>

                                            <div class="text-center" style="margin-top: 12px; border-top: 1px solid #f5f5f5; padding-top: 10px;">
                                                <span id="badgeEstadoCumplimiento" class="label" style="display: inline-block; padding: 6px 20px; font-size: 13px; font-weight: bold; border-radius: 14px; text-transform: uppercase; color: white; letter-spacing: 0.5px; background-color: #777777; transition: all 0.3s ease;">
                                                    Estado: Cargando...
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($mostrarOcupacion): ?>
                                    <div class="grafico-adaptable col-xs-12 <?= ($mostrarCumplimiento && ($mostrarRotacion || $mostrarFisico || $mostrarAsistencia || $mostrarColeccion)) ? 'col-md-5' : 'col-md-6' ?>"
                                        style="cursor: pointer;"
                                        data-toggle="modal" data-target="#modalDetalleOcupacion">
                                        <div class="thumbnail" style="border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding-bottom: 15px;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 15px 5px 15px;">
                                                <h5 class="text-titles" style="margin: 0; font-size: 13px; font-weight: bold; color: #555;">OCUPACIÓN POR SALA (%)</h5>
                                                <div class="btn-group" onclick="event.stopPropagation();">
                                                    <button type="button" class="btn btn-xs btn-default" onclick="actualizarOcupacion('semana')">Semana</button>
                                                    <button type="button" class="btn btn-xs btn-default" onclick="actualizarOcupacion('mes')">Mes</button>
                                                    <button type="button" class="btn btn-xs btn-default" onclick="actualizarOcupacion('trimestre')">Trimestre</button>
                                                </div>
                                            </div>
                                            <div id="chartOcupacion" style="padding: 0 10px; min-height: 150px;"></div>
                                            <div style="text-align: center; margin-top: 5px;">
                                                <span id="badgeOcupacionEstado" class="label" style="background-color: #f0ad4e; color: white; padding: 6px 25px; font-size: 12px; font-weight: bold; border-radius: 12px; display: inline-block; letter-spacing: 0.5px; text-transform: uppercase; box-shadow: 0 2px 4px rgba(0,0,0,0.08);">
                                                    EVALUANDO...
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($mostrarRotacion || $mostrarFisico || $mostrarAsistencia || $mostrarColeccion): ?>
                                    <div class="col-xs-12 col-md-3">
                                        <div class="contenedor-flex-lateral">
                                            <?php if ($mostrarRotacion):
                                                if ($rotacion < 5) {
                                                    $claseFondoRotacion = 'fondo-card-critico';
                                                    $badgeRotacion = 'badge-critico';
                                                    $colorHexRotacion = '#d9534f';
                                                    $textoEstadoRotacion = 'Crítico';
                                                } elseif ($rotacion <= 15) {
                                                    $claseFondoRotacion = 'fondo-card-tolerable';
                                                    $badgeRotacion = 'badge-tolerable';
                                                    $colorHexRotacion = '#f0ad4e';
                                                    $textoEstadoRotacion = 'Tolerable';
                                                } else {
                                                    $claseFondoRotacion = 'fondo-card-optimo';
                                                    $badgeRotacion = 'badge-optimo';
                                                    $colorHexRotacion = '#5cb85c';
                                                    $textoEstadoRotacion = 'Óptimo';
                                                }
                                            ?>
                                                <div class="col-xs-12">
                                                    <div class="panel panel-default status-card <?= $claseFondoRotacion ?>"
                                                        id="indicador-rotacion" style="cursor: pointer;"
                                                        data-toggle="modal" data-target="#modalRotacion">
                                                        <div class="text-center" style="padding: 18px 5px 15px 5px;">
                                                            <i class="fa-solid fa-rotate status-icon" style="font-size: 16px; color: <?= $colorHexRotacion ?> !important;"></i>
                                                            <div style="font-size: 9px; font-weight: bold; color: #555; margin: 2px 0 6px 0; text-transform: uppercase; letter-spacing: 0.5px;">Rotación de colección</div>
                                                            <span class="label status-label" style="font-size: 13px; font-weight: bold; display: inline-block; margin-bottom: 6px; padding: 2px 6px; color: white !important; background-color: <?= $colorHexRotacion ?> !important; border-radius: 3px;"><?= $rotacion ?>%</span>
                                                            <div style="margin-top: 4px;">
                                                                <span class="badge <?= $badgeRotacion ?>" id="rotacion-estado-badge"
                                                                    style="font-size: 11px; font-weight: bold; padding: 4px 10px; text-transform: uppercase; border-radius: 12px; letter-spacing: 0.5px;">
                                                                    <?= $textoEstadoRotacion ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($mostrarFisico):
                                                if ($estadoFisico <= 30) {
                                                    $claseFondoFisico = 'fondo-card-critico';
                                                    $badgeFisico = 'badge-critico';
                                                    $colorHexFisico = '#d9534f';
                                                    $textoEstadoFisico = 'Crítico';
                                                } elseif ($estadoFisico < 70) {
                                                    $claseFondoFisico = 'fondo-card-tolerable';
                                                    $badgeFisico = 'badge-tolerable';
                                                    $colorHexFisico = '#f0ad4e';
                                                    $textoEstadoFisico = 'Tolerable';
                                                } else {
                                                    $claseFondoFisico = 'fondo-card-optimo';
                                                    $badgeFisico = 'badge-optimo';
                                                    $colorHexFisico = '#5cb85c';
                                                    $textoEstadoFisico = 'Óptimo';
                                                }
                                            ?>
                                                <div class="col-xs-12">
                                                    <div class="panel panel-default status-card <?= $claseFondoFisico ?>"
                                                        id="indicador-fisico" style="cursor: pointer;"
                                                        data-toggle="modal" data-target="#modalEstadoFisico">
                                                        <div class="text-center" style="padding: 18px 5px 15px 5px;">
                                                            <i class="fa-solid fa-book-medical status-icon" style="font-size: 16px; color: <?= $colorHexFisico ?> !important;"></i>
                                                            <div style="font-size: 9px; font-weight: bold; color: #555; margin: 2px 0 6px 0; text-transform: uppercase; letter-spacing: 0.5px;">Estado Físico</div>
                                                            <span class="label status-label" style="font-size: 13px; font-weight: bold; display: inline-block; margin-bottom: 6px; padding: 2px 6px; color: white !important; background-color: <?= $colorHexFisico ?> !important; border-radius: 3px;"><?= $estadoFisico ?>%</span>
                                                            <div style="margin-top: 4px;">
                                                                <span class="badge <?= $badgeFisico ?>" id="fisico-estado-badge"
                                                                    style="font-size: 11px; font-weight: bold; padding: 4px 10px; text-transform: uppercase; border-radius: 12px; letter-spacing: 0.5px;">
                                                                    <?= $textoEstadoFisico ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($mostrarAsistencia):
                                                if ($asistenciaEstatal <= 30) {
                                                    $claseFondoAsistencia = 'fondo-card-critico';
                                                    $badgeAsistencia = 'badge-critico';
                                                    $colorHexAsistencia = '#d9534f';
                                                    $textoEstadoAsistencia = 'Crítico';
                                                } elseif ($asistenciaEstatal < 70) {
                                                    $claseFondoAsistencia = 'fondo-card-tolerable';
                                                    $badgeAsistencia = 'badge-tolerable';
                                                    $colorHexAsistencia = '#f0ad4e';
                                                    $textoEstadoAsistencia = 'Tolerable';
                                                } else {
                                                    $claseFondoAsistencia = 'fondo-card-optimo';
                                                    $badgeAsistencia = 'badge-optimo';
                                                    $colorHexAsistencia = '#5cb85c';
                                                    $textoEstadoAsistencia = 'Óptimo';
                                                }
                                            ?>
                                                <div class="col-xs-12">
                                                    <div class="panel panel-default status-card <?= $claseFondoAsistencia ?>"
                                                        id="indicador-asistencia" style="cursor: pointer;"
                                                        data-toggle="modal" data-target="#modalAsistenciaEstatal">
                                                        <div class="text-center" style="padding: 18px 5px 15px 5px;">
                                                            <i class="fa-solid fa-users-viewfinder status-icon" style="font-size: 16px; color: <?= $colorHexAsistencia ?> !important;"></i>
                                                            <div style="font-size: 9px; font-weight: bold; color: #555; margin: 2px 0 6px 0; text-transform: uppercase; letter-spacing: 0.5px;">ASIST. SALA ESTATAL</div>
                                                            <span class="label status-label" style="font-size: 13px; font-weight: bold; display: inline-block; margin-bottom: 6px; padding: 2px 6px; color: white !important; background-color: <?= $colorHexAsistencia ?> !important; border-radius: 3px;"><?= $asistenciaEstatal ?>%</span>
                                                            <div style="margin-top: 4px;">
                                                                <span class="badge <?= $badgeAsistencia ?>" id="asistencia-estado-badge"
                                                                    style="font-size: 11px; font-weight: bold; padding: 4px 10px; text-transform: uppercase; border-radius: 12px; letter-spacing: 0.5px;">
                                                                    <?= $textoEstadoAsistencia ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ($mostrarColeccion):
                                                if ($coleccionEstatal <= 30) {
                                                    $claseFondoColeccion = 'fondo-card-critico';
                                                    $badgeColeccion = 'badge-critico';
                                                    $colorHexColeccion = '#d9534f';
                                                    $textoEstadoColeccion = 'Crítico';
                                                } elseif ($coleccionEstatal < 70) {
                                                    $claseFondoColeccion = 'fondo-card-tolerable';
                                                    $badgeColeccion = 'badge-tolerable';
                                                    $colorHexColeccion = '#f0ad4e';
                                                    $textoEstadoColeccion = 'Tolerable';
                                                } else {
                                                    $claseFondoColeccion = 'fondo-card-optimo';
                                                    $badgeColeccion = 'badge-optimo';
                                                    $colorHexColeccion = '#5cb85c';
                                                    $textoEstadoColeccion = 'Óptimo';
                                                }
                                            ?>
                                                <div class="col-xs-12">
                                                    <div class="panel panel-default status-card <?= $claseFondoColeccion ?>"
                                                        id="indicador-coleccion" style="cursor: pointer;"
                                                        data-toggle="modal" data-target="#modalColeccion">
                                                        <div class="text-center" style="padding: 18px 5px 15px 5px;">
                                                            <i class="fa-solid fa-archive status-icon" style="font-size: 16px; color: <?= $colorHexColeccion ?> !important;"></i>
                                                            <div style="font-size: 9px; font-weight: bold; color: #555; margin: 2px 0 6px 0; text-transform: uppercase; letter-spacing: 0.5px;">COLECCIÓN ESTATAL</div>
                                                            <span class="label status-label" style="font-size: 13px; font-weight: bold; display: inline-block; margin-bottom: 6px; padding: 2px 6px; color: white !important; background-color: <?= $colorHexColeccion ?> !important; border-radius: 3px;"><?= $coleccionEstatal ?>%</span>
                                                            <div style="margin-top: 4px;">
                                                                <span class="badge <?= $badgeColeccion ?>" id="coleccion-estado-badge"
                                                                    style="font-size: 11px; font-weight: bold; padding: 4px 10px; text-transform: uppercase; border-radius: 12px; letter-spacing: 0.5px;">
                                                                    <?= $textoEstadoColeccion ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($mostrarActividades):
                    $claseFondo = 'fondo-card-optimo';
                    if ($participacionActividades <= 30) {
                        $claseFondo = 'fondo-card-critico';
                    } elseif ($participacionActividades < 70) {
                        $claseFondo = 'fondo-card-tolerable';
                    }
                ?>
                    <div class="panel panel-info" id="panel-participacion-actividades"
                        style="cursor: pointer; transition: transform 0.2s; overflow: hidden; border: 1px solid #bce8f1;">
                        <div class="cintillo-estados">
                            <div class="cintillo-bloque cintillo-critico" style="padding: 6px;">Crítico <span>&le; 30%</span></div>
                            <div class="cintillo-bloque cintillo-tolerable" style="padding: 6px;">Tolerable <span>40% - 70%</span></div>
                            <div class="cintillo-bloque cintillo-optimo" style="padding: 6px;">Óptimo <span>&ge; 70%</span></div>
                        </div>
                        <div class="panel-body text-center <?= $claseFondo ?>" style="padding-top: 15px; padding-bottom: 15px;">
                            <p class="lead text-titles" style="margin-bottom: 10px; font-weight: bold; color: #555;">Participación en Actividades y Talleres</p>
                            <div class="progress" style="height: 26px; margin-bottom: 0; border-radius: 4px; box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);">
                                <div class="progress-bar progress-bar-info progress-bar-striped active" style="width: <?= $participacionActividades ?>%; line-height: 26px; font-size: 15px; font-weight: bold;">
                                    <?= $participacionActividades ?>% de Usuarios Registrados
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="panel panel-info" style="border: 1px dashed #bce8f1;">
                        <div class="panel-body text-center" style="padding: 20px;">
                            <i class="fa-solid fa-chart-bar" style="font-size: 28px; color: #bce8f1; margin-bottom: 10px;"></i>
                            <p style="color: #666; margin-bottom: 12px;">El indicador de participación en actividades grupales está oculto.</p>
                            <a href="<?= BASE_URL ?>/configuracion" class="btn btn-info btn-raised btn-xs">
                                <i class="fa-solid fa-gear"></i> Habilitar
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="container-fluid">
                <?php include VIEW_PATH . "/component/notification.php"; ?>
            </div>
    </section>

    <?php include VIEW_PATH . "/modal/modal-indicator/user-coverage.php" ?>
    <?php include VIEW_PATH . "/modal/modal-indicator/consult-reference.php" ?>
    <?php include VIEW_PATH . "/modal/modal-indicator/query-graph.php" ?>
    <?php include VIEW_PATH . "/modal/modal-indicator/compliance.php" ?>
    <?php include VIEW_PATH . "/modal/modal-indicator/occupation.php" ?>
    <?php include VIEW_PATH . "/modal/modal-indicator/rotation.php" ?>
    <?php include VIEW_PATH . "/modal/modal-indicator/physical-state.php" ?>
    <?php include VIEW_PATH . "/modal/modal-indicator/state-assistance.php" ?>
    <?php include VIEW_PATH . "/modal/modal-indicator/colection.php" ?>

    <?php include VIEW_PATH . "/component/scripts.php"; ?>
    <?php include VIEW_PATH . "/component/chart-graph.php"; ?>

    <script src="<?= PUBLIC_PATH ?>/js/dashboard.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/html2canvas.js"></script>
</body>

</html>