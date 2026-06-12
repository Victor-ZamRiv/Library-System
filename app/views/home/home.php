<?php
// ==========================================
//   CONTROL DE VISIBILIDAD (13 INDICADORES)
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
$mostrarIiur = $dashboardConfig->getMostrarIiur();
$mostrarIdcar = $dashboardConfig->getMostrarIdcar();
$mostrarIpe = $dashboardConfig->getMostrarIpe();


// Agrupaciones lógicas por sección para evaluar estados vacíos
$seccionUsuariosVacia = (!$mostrarCobertura && !$mostrarReferencia && !$mostrarGraficoConsultas);
$seccionProcesosVacia = (!$mostrarCumplimiento && !$mostrarOcupacion && !$mostrarRotacion && !$mostrarFisico && !$mostrarAsistencia && !$mostrarColeccion && !$mostrarIiur && !$mostrarIdcar);
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
                                                        <h5 class="text-uppercase text-titles" style="margin: 5px 0 0 0; font-weight: bold; color: #555; font-size: 15px; letter-spacing: 0.5px;">Cobertura de Usuarios</h5>
                                                        <h3 id="cobertura-valor" style="margin: 8px 0; font-weight: bold; color: <?= $colorDinamicoCobertura ?> !important; font-size: 32px;"><?= $cobertura ?>%</h3>
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
                                                        <h5 class="text-uppercase text-titles" style="margin: 5px 0 0 0; font-weight: bold; color: #555; font-size: 15px; letter-spacing: 0.5px;">Consultas de Referencia</h5>
                                                        <h3 id="referencia-valor" style="margin: 6px 0 2px 0; font-weight: bold; color: <?= $colorDinamicoReferencia ?> !important; font-size: 32px;"><?= $razonReferencia ?></h3>
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
                                                        <h4 class="text-uppercase text-titles" style="margin: 0 0 2px 0; font-weight: bold; color: #555; font-size: 15px; letter-spacing: 0.5px;">
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
                                                    <span id="badgeConsultasEstado" class="label" style="display: inline-block; padding: 6px 20px; font-size: 15px; font-weight: bold; border-radius: 14px; text-transform: uppercase; background-color: <?= $colorDinamicoGrafico ?>; color: white; letter-spacing: 0.5px; transition: background-color 0.3s ease;">
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

                                    <div class="col-xs-12 <?= ($mostrarRotacion || $mostrarFisico || $mostrarAsistencia || $mostrarColeccion) ? 'col-md-9' : 'col-md-12' ?>" style="padding-left: 0; padding-right: 0;">

                                        <div class="row" style="margin: 0;">
                                            <?php if ($mostrarCumplimiento): ?>
                                                <div class="grafico-adaptable col-xs-12 <?= ($mostrarOcupacion) ? 'col-md-5' : 'col-md-12' ?>"
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
                                                <div class="grafico-adaptable col-xs-12 <?= ($mostrarCumplimiento) ? 'col-md-7' : 'col-md-12' ?>"
                                                    style="cursor: pointer; margin-bottom: 15px;"
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
                                        </div>

                                        <?php if ($mostrarIiur || $mostrarIdcar): ?>
                                    <div class="row" style="margin: 0 0 15px 0;">
                                        <?php if ($mostrarIiur): 
                                            $valorIiur = $iiur['valor'];
                                            $claseIiur = $iiur['clase'];
                                            $textoEstadoIiur = $iiur['texto'];
                                            $colorDinamicoIiur = ($claseIiur == 'success') ? '#5cb85c' : (($claseIiur == 'warning') ? '#f0ad4e' : '#d9534f');
                                        ?>
                                        <div class="col-xs-12 col-md-6" style="margin-bottom: 15px; padding: 0 10px;">
                                            <div class="thumbnail text-center" id="panel-iiur"
                                                style="background: #fff; border: 1px solid #e3e3e3; border-radius: 10px; position: relative; cursor: pointer; padding: 30px 15px; box-shadow: 0 6px 15px rgba(0,0,0,0.1); margin-bottom: 0; min-height: 160px; display: flex; flex-direction: column; justify-content: center; align-items: center; transition: transform 0.2s ease, box-shadow 0.2s ease;"
                                                data-toggle="modal" data-target="#modalDetalleIiur">
                                                <h5 class="text-uppercase text-titles" style="margin: 0 0 10px 0; font-weight: bold; color: #555; font-size: 12px; letter-spacing: 0.5px;">Intensidad de Uso</h5>
                                                <h3 id="iiur-valor" style="margin: 5px 0 12px 0; font-weight: bold; color: <?= $colorDinamicoIiur ?> !important; font-size: 32px;"><?= number_format($valorIiur, 2) ?></h3>
                                                <div>
                                                    <span class="label" style="display: inline-block; padding: 6px 20px; font-size: 13px; font-weight: bold; border-radius: 14px; text-transform: uppercase; background-color: <?= $colorDinamicoIiur ?>; color: white; letter-spacing: 0.5px;">
                                                        <?= $textoEstadoIiur ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>

                                        <?php if ($mostrarIdcar): 
                                            $valorIdcar = $idcar['valor'];
                                            // Determinar color según valor
                                            if ($valorIdcar > 25) {
                                                $colorDinamicoIdcar = '#d9534f';
                                                $textoEstadoIdcar = 'CRÍTICO';
                                            } elseif ($valorIdcar >= 11) {
                                                $colorDinamicoIdcar = '#f0ad4e';
                                                $textoEstadoIdcar = 'EN PROCESO';
                                            } else {
                                                $colorDinamicoIdcar = '#5cb85c';
                                                $textoEstadoIdcar = 'LOGRADO';
                                            }
                                        ?>
                                        <div class="col-xs-12 col-md-6" style="margin-bottom: 15px; padding: 0 10px;">
                                            <div class="thumbnail text-center" id="panel-idcar"
                                                style="background: #fff; border: 1px solid #e3e3e3; border-radius: 10px; position: relative; cursor: pointer; padding: 30px 15px; box-shadow: 0 6px 15px rgba(0,0,0,0.1); margin-bottom: 0; min-height: 160px; display: flex; flex-direction: column; justify-content: center; align-items: center; transition: transform 0.2s ease, box-shadow 0.2s ease;"
                                                data-toggle="modal" data-target="#modalDetalleIdcar">
                                                <h5 class="text-uppercase text-titles" style="margin: 0 0 10px 0; font-weight: bold; color: #555; font-size: 12px; letter-spacing: 0.5px;">Deterioro Alta Rotación</h5>
                                                <h3 id="idcar-valor" style="margin: 5px 0 12px 0; font-weight: bold; color: <?= $colorDinamicoIdcar ?> !important; font-size: 32px;"><?= number_format($valorIdcar, 1) ?>%</h3>
                                                <div>
                                                    <span class="label" style="display: inline-block; padding: 6px 20px; font-size: 13px; font-weight: bold; border-radius: 14px; text-transform: uppercase; background-color: <?= $colorDinamicoIdcar ?>; color: white; letter-spacing: 0.5px;">
                                                        <?= $textoEstadoIdcar ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                    </div>

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
                                                    <div class="col-xs-12" style="padding-left: 0; padding-right: 0;">
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
                                                    <div class="col-xs-12" style="padding-left: 0; padding-right: 0;">
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
                                                    <div class="col-xs-12" style="padding-left: 0; padding-right: 0;">
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
                                                    <div class="col-xs-12" style="padding-left: 0; padding-right: 0;">
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

                    <!-- Panel Aprendizaje y Crecimiento -->
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"> <i class="fa-solid fa-graduation-cap"></i> Aprendizaje y Crecimiento</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 col-md-6">
                                        <?php if ($mostrarActividades): 
                                            $participacionActividades = $participacionActividades ?? 0;
                                            $claseFondo = ($participacionActividades <= 30) ? 'fondo-card-critico' : (($participacionActividades < 70) ? 'fondo-card-tolerable' : 'fondo-card-optimo');
                                            $claseBarra = ($participacionActividades <= 30) ? 'progress-bar-danger' : (($participacionActividades < 70) ? 'progress-bar-warning' : 'progress-bar-success');
                                            $badgeEstado = ($participacionActividades <= 30) ? 'label-danger' : (($participacionActividades < 70) ? 'label-warning' : 'label-success');
                                            $textoEstado = ($participacionActividades <= 30) ? 'Crítico' : (($participacionActividades < 70) ? 'Tolerable' : 'Óptimo');
                                        ?>
                                            <div class="panel panel-info" id="panel-participacion-actividades" data-toggle="modal" data-target="#modalParticipacionActividades"
                                                style="cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; border-radius: 6px;">
                                                <div class="panel-body <?= $claseFondo ?>" style="padding: 20px 15px;">
                                                    <p class="text-titles text-center" style="margin-bottom: 12px; font-weight: bold; color: #444; text-transform: uppercase;">
                                                        <i class="fa-solid fa-chalkboard-user"></i> Participación Actividades
                                                    </p>
                                                    <div class="text-center" style="margin-bottom: 15px;">
                                                        <span style="font-size: 40px; font-weight: 900;"><?= $participacionActividades ?>%</span>
                                                        <span class="label <?= $badgeEstado ?>"><?= $textoEstado ?></span>
                                                    </div>
                                                    <div class="progress" style="height: 10px; border-radius: 10px;">
                                                        <div class="progress-bar <?= $claseBarra ?> active" style="width: <?= $participacionActividades ?>%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-xs-12 col-md-6">
                                        <?php if ($mostrarIpe): 
                                            $valorIpe = $ipe['valor'];
                                            if ($valorIpe <= 15) {
                                                $colorSolidoIpe = '#d9534f';
                                                $textoEstadoIpe = 'Crítico';
                                                $claseFondoIpe = 'fondo-card-critico';
                                                $badgeEstadoIpe = 'label-danger';
                                            } elseif ($valorIpe < 30) {
                                                $colorSolidoIpe = '#f0ad4e';
                                                $textoEstadoIpe = 'En proceso';
                                                $claseFondoIpe = 'fondo-card-tolerable';
                                                $badgeEstadoIpe = 'label-warning';
                                            } else {
                                                $colorSolidoIpe = '#5cb85c';
                                                $textoEstadoIpe = 'Logrado';
                                                $claseFondoIpe = 'fondo-card-optimo';
                                                $badgeEstadoIpe = 'label-success';
                                            }
                                        ?>
                                            <div class="panel panel-info" id="panel-ipe" data-toggle="modal" data-target="#modalDetalleIpe"
                                                style="cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; border-radius: 6px;">
                                                <div class="panel-body <?= $claseFondoIpe ?>" style="padding: 20px 15px;">
                                                    <p class="text-titles text-center" style="margin-bottom: 12px; font-weight: bold; color: #444; text-transform: uppercase;">
                                                        <i class="fa-solid fa-users-rectangle"></i> Productividad de Eventos
                                                    </p>
                                                    <div class="text-center" style="margin-bottom: 15px;">
                                                        <span style="font-size: 40px; font-weight: 900;"><?= number_format($valorIpe, 1) ?></span>
                                                        <span class="label <?= $badgeEstadoIpe ?>"><?= $textoEstadoIpe ?></span>
                                                    </div>
                                                    <div class="progress" style="height: 10px; border-radius: 10px;">
                                                        <div class="progress-bar <?= ($valorIpe >= 30) ? 'progress-bar-success' : (($valorIpe >= 15) ? 'progress-bar-warning' : 'progress-bar-danger') ?> active" style="width: <?= min($valorIpe * 2, 100) ?>%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    <?php include VIEW_PATH . "/modal/modal-indicator/activity-workshop.php" ?>
    <?php include VIEW_PATH . "/modal/modal-indicator/iiur.php" ?>
    <?php include VIEW_PATH . "/modal/modal-indicator/idcar.php" ?>
    <?php include VIEW_PATH . "/modal/modal-indicator/ipe.php" ?>


    <?php include VIEW_PATH . "/component/scripts.php"; ?>
    <?php include VIEW_PATH . "/component/chart-graph.php"; ?>

    <script src="<?= PUBLIC_PATH ?>/js/dashboard.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/html2canvas.js"></script>
</body>

</html>