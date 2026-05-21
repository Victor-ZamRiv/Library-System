<?php
// ==========================================
//   CONTROL DE VISIBILIDAD (10 INDICADORES)
// ==========================================
// Cambia a true para mostrar o false para ocultar en tus pruebas:

// Bloque Superior (Área de Usuarios)
$mostrarCobertura = true;        // 1
$mostrarReferencia = true;       // 2
$mostrarGraficoConsultas = true; // 3

// Bloque Medio (Procesos e Indicadores de Configuración)
$mostrarCumplimiento = true;     // 4
$mostrarOcupacion = true;        // 5
$mostrarRotacion = true;         // 6
$mostrarFisico = true;           // 7
$mostrarAsistencia = true;       // 8
$mostrarColeccion = true;        // 9

// Bloque Inferior
$mostrarActividades = true;      // 10


// ==========================================
//   VALORES PARA MODIFICAR EN TUS PRUEBAS
// ==========================================
$valRotacion = 20;
$valFisico = 10;
$valAsistencia = 50;
$valColeccion = 50;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Inicio</title>
    <?php include VIEW_PATH . "/component/heat.php"; ?>
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/css/style-indicator.css">
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jsPDF.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jspdf-autotable.js"></script>

    <style>
        /* Contenedor de paneles superiores izquierdo */
        .contenedor-paneles-superiores {
            display: flex;
            flex-direction: column;
            gap: 10px;
            height: 100%;
            justify-content: space-between;
        }

        .contenedor-paneles-superiores .well {
            flex: 1 1 auto;
            margin-bottom: 0 !important;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Fila de gráficos medios */
        .fila-procesos-medios {
            display: flex;
            flex-wrap: wrap;
            gap: 0;
        }

        .grafico-adaptable {
            flex: 1 1 auto;
            transition: all 0.3s ease;
        }

        /* Contenedor lateral derecho de indicadores con semáforo */
        .contenedor-flex-lateral {
            display: flex;
            flex-direction: column;
            gap: 10px;
            height: 100%;
            min-height: 350px;
        }

        .contenedor-flex-lateral .col-xs-12 {
            float: none !important;
            width: 100% !important;
            flex: 1 1 auto;
            display: flex;
        }

        .contenedor-flex-lateral .status-card {
            width: 100%;
            margin-bottom: 0 !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contenedor-flex-lateral .panel-body {
            width: 100%;
            padding: 8px !important;
        }
    </style>
</head>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>

        <div class="container-fluid" style="padding-top: 20px;">
            <div class="page-header text-center">
                <h2 class="text-titles">
                    <i class="fa-solid fa-landmark"></i> Gestión de la Biblioteca "Armando Zuloaga Blanco"
                </h2>
            </div>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa-solid fa-users"></i></h3>
                </div>
                <div class="panel-body">
                    <div class="row" style="display: flex; flex-wrap: wrap;">

                        <?php if ($mostrarCobertura || $mostrarReferencia): ?>
                            <div class="col-xs-12 col-sm-4" style="display: flex; flex-direction: column;">
                                <div class="contenedor-paneles-superiores">

                                    <?php if ($mostrarCobertura): ?>
                                        <div class="well well-sm text-center" id="panel-cobertura-usuarios" style="position: relative;">
                                            <button class="btn btn-xs"
                                                style="position: absolute; top: 5px; right: 5px; border: 1px solid #2e6da4; color: #2e6da4; background: #fff;"
                                                data-toggle="modal" data-target="#modalDetalleCobertura">
                                                <i class="fa-solid fa-plus"></i>
                                            </button><br>
                                            <h5 class="text-uppercase text-titles">Cobertura de Usuarios</h5>
                                            <h3 class="text-info" style="margin-top: 10px;">15%</h3>
                                            <small class="text-muted">Meta: Ascendente</small>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($mostrarReferencia): ?>
                                        <div class="well well-sm text-center" id="panel-consultas-referencia" style="position: relative;">
                                            <button class="btn btn-xs"
                                                style="position: absolute; top: 5px; right: 5px; border: 1px solid #2e6da4; color: #2e6da4; background: #fff;"
                                                data-toggle="modal" data-target="#modalDetalleReferencia">
                                                <i class="fa-solid fa-plus"></i>
                                            </button><br>
                                            <h5 class="text-uppercase text-titles">Consultas de Referencia</h5>
                                            <h3 class="text-info" style="margin-top: 10px;">2.4</h3>
                                            <small class="text-muted">Razón por usuario activo</small>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($mostrarGraficoConsultas): ?>
                            <div class="grafico-adaptable <?= ($mostrarCobertura || $mostrarReferencia) ? 'col-xs-12 col-sm-8' : 'col-xs-12' ?>" id="panel-grafico-consultas">
                                <div class="thumbnail" style="padding: 15px; height: 350px; position: relative; border: 1px solid #ddd; overflow: hidden; margin-bottom: 0;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px; margin-bottom: 10px;">
                                        <h5 class="text-titles" style="margin: 0;">Promedio de Consultas</h5>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-xs btn-default" onclick="actualizarTodo('semana')">Semana</button>
                                            <button type="button" class="btn btn-xs btn-default" onclick="actualizarTodo('mes')">Mes</button>
                                            <button type="button" class="btn btn-xs btn-default" onclick="actualizarTodo('trimestre')">Trimestre</button>
                                        </div>
                                    </div>
                                    <div id="chartConsultas"></div>
                                    <button class="btn btn-xs"
                                        style="position: absolute; top: 5px; right: 5px; border: 1px solid #2e6da4; color: #2e6da4; background: #fff;"
                                        data-toggle="modal" data-target="#modalDetalleConsultasGrafico">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa-solid fa-gears"></i></h3>
                </div>
                <div class="panel-body">
                    <div class="row fila-procesos-medios">

                        <?php if ($mostrarCumplimiento): ?>
                            <div class="grafico-adaptable col-xs-12 <?= ($mostrarOcupacion && ($mostrarRotacion || $mostrarFisico || $mostrarAsistencia || $mostrarColeccion)) ? 'col-md-4' : 'col-md-6' ?>">
                                <div class="thumbnail" style="padding: 15px; height: 350px; position: relative; border: 1px solid #ddd; overflow: hidden; margin-bottom: 0;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; margin-bottom: 10px;">
                                        <h5 class="text-titles" style="margin: 0; font-size: 13px;">Cumplimiento</h5>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-xs btn-default" onclick="actualizarCumplimiento('semana')">Semana</button>
                                            <button type="button" class="btn btn-xs btn-default" onclick="actualizarCumplimiento('mes')">Mes</button>
                                            <button type="button" class="btn btn-xs btn-default" onclick="actualizarCumplimiento('trimestre')">Trimestre</button>
                                        </div>
                                    </div>
                                    <div id="chartPlazos"></div>
                                    <button class="btn btn-xs" style="position: absolute; top: 5px; right: 5px; border: 1px solid #2e6da4; color: #2e6da4; background:#fff;" data-toggle="modal" data-target="#modalDetalleCumplimiento">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($mostrarOcupacion): ?>
                            <div class="grafico-adaptable col-xs-12 <?= ($mostrarCumplimiento && ($mostrarRotacion || $mostrarFisico || $mostrarAsistencia || $mostrarColeccion)) ? 'col-md-5' : 'col-md-6' ?>">
                                <div class="thumbnail" style="padding: 15px; height: 350px; position: relative; border: 1px solid #ddd; overflow: hidden; margin-bottom: 0;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; margin-bottom: 10px;">
                                        <h5 class="text-titles" style="margin: 0; font-size: 13px;">Ocupación Salas (%)</h5>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-xs btn-default" onclick="actualizarOcupacion('semana')">Semana</button>
                                            <button type="button" class="btn btn-xs btn-default" onclick="actualizarOcupacion('mes')">Mes</button>
                                            <button type="button" class="btn btn-xs btn-default" onclick="actualizarOcupacion('trimestre')">trimestre</button>
                                        </div>
                                    </div>
                                    <div id="chartOcupacion"></div>
                                    <button class="btn btn-xs" style="position: absolute; top: 5px; right: 5px; border: 1px solid #2e6da4; color: #2e6da4; background:#fff;" data-toggle="modal" data-target="#modalDetalleOcupacion">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($mostrarRotacion || $mostrarFisico || $mostrarAsistencia || $mostrarColeccion): ?>
                            <div class="col-xs-12 col-md-3">
                                <div class="contenedor-flex-lateral">

                                    <?php if ($mostrarRotacion): ?>
                                        <div class="col-xs-12" id="contenedor-indicador-rotacion">
                                            <div class="panel panel-default indicator-item btn-detalle-rotacion status-card"
                                                id="indicador-rotacion"
                                                style="cursor: pointer;"
                                                data-toggle="popover"
                                                data-target-modal="#modalRotacion"
                                                title="&lt;i class='fa-solid fa-rotate'&gt;&lt;/i&gt; Índice de Rotación"
                                                data-content="La circulación de libros es muy baja respecto al inventario.&lt;br&gt;&lt;strong&gt;Estado:&lt;/strong&gt; Crítico&lt;br&gt;&lt;div class='progress'&gt;&lt;div class='progress-bar progress-bar-danger' style='width:<?= $valRotacion ?>%'&gt;&lt;/div&gt;&lt;/div&gt;&lt;small&gt;Meta: &gt; 50%&lt;/small&gt;">
                                                <div class="panel-body text-center">
                                                    <i class="fa-solid fa-rotate status-icon" style="font-size: 20px;"></i>
                                                    <div style="font-size: 10px; font-weight: bold; color: #555; margin: 5px 0;">ROTACIÓN</div>
                                                    <span class="label status-label" style="font-size: 12px;"><?= $valRotacion ?>%</span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($mostrarFisico): ?>
                                        <div class="col-xs-12" id="contenedor-indicador-fisico">
                                            <div class="panel panel-default indicator-item status-card"
                                                id="indicador-fisico"
                                                style="cursor: pointer;"
                                                data-toggle="popover"
                                                data-target-modal="#modalEstadoFisico"
                                                title="&lt;i class='fa-solid fa-book-medical'&gt;&lt;/i&gt; Estado Físico"
                                                data-content="La mayoría de la colección se encuentra en óptimas condiciones.&lt;br&gt;&lt;strong&gt;Estado:&lt;/strong&gt; Excelente&lt;br&gt;&lt;div class='progress'&gt;&lt;div class='progress-bar progress-bar-success' style='width:<?= $valFisico ?>%'&gt;&lt;/div&gt;&lt;/div&gt;&lt;small&gt;Mantenimiento al día&lt;/small&gt;">
                                                <div class="panel-body text-center">
                                                    <i class="fa-solid fa-book-medical status-icon" style="font-size: 20px;"></i>
                                                    <div style="font-size: 10px; font-weight: bold; color: #555; margin: 5px 0;">ESTADO FÍSICO</div>
                                                    <span class="label status-label" style="font-size: 12px;"><?= $valFisico ?>%</span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($mostrarAsistencia): ?>
                                        <div class="col-xs-12" id="contenedor-indicador-asistencia">
                                            <div class="panel panel-default indicator-item status-card"
                                                id="indicador-asistencia"
                                                style="cursor: pointer;"
                                                data-toggle="popover"
                                                data-target-modal="#modalAsistenciaEstatal"
                                                title="&lt;i class='fa-solid fa-users-viewfinder'&gt;&lt;/i&gt; Asistencia: Sala Estatal"
                                                data-content="El flujo de visitantes en la Sala Estatal está por debajo de la meta mensual.&lt;br&gt;&lt;strong&gt;Estado:&lt;/strong&gt; Regular&lt;br&gt;&lt;div class='progress'&gt;&lt;div class='progress-bar progress-bar-warning' style='width:<?= $valAsistencia ?>%'&gt;&lt;/div&gt;&lt;/div&gt;&lt;small&gt;Meta: 500 usuarios/mes&lt;/small&gt;">
                                                <div class="panel-body text-center">
                                                    <i class="fa-solid fa-users-viewfinder status-icon" style="font-size: 20px;"></i>
                                                    <div style="font-size: 10px; font-weight: bold; color: #555; margin: 5px 0;">ASIST. SALA ESTATAL</div>
                                                    <span class="label status-label" style="font-size: 12px;"><?= $valAsistencia ?>%</span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($mostrarColeccion): ?>
                                        <div class="col-xs-12" id="contenedor-indicador-coleccion">
                                            <div class="panel panel-default indicator-item status-card"
                                                id="indicador-coleccion"
                                                style="cursor: pointer;"
                                                data-toggle="popover"
                                                data-target-modal="#modalColeccion"
                                                title="&lt;i class='fa-solid fa-archive'&gt;&lt;/i&gt; Colección"
                                                data-content="Nivel de actualización de títulos insuficiente este mes.&lt;br&gt;&lt;strong&gt;Estado:&lt;/strong&gt; Bajo&lt;br&gt;&lt;div class='progress'&gt;&lt;div class='progress-bar progress-bar-danger' style='width:<?= $valColeccion ?>%'&gt;&lt;/div&gt;&lt;/div&gt;&lt;small&gt;Requiere compra de títulos&lt;/small&gt;">
                                                <div class="panel-body text-center">
                                                    <i class="fa-solid fa-archive status-icon" style="font-size: 20px;"></i>
                                                    <div style="font-size: 10px; font-weight: bold; color: #555; margin: 5px 0;">COLECCIÓN</div>
                                                    <span class="label status-label" style="font-size: 12px;"><?= $valColeccion ?>%</span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <?php if ($mostrarActividades): ?>
                <div class="panel panel-info" id="panel-participacion-actividades">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa-solid fa-graduation-cap"></i></h3>
                    </div>
                    <div class="panel-body text-center">
                        <p class="lead text-titles">Participación en Actividades y Talleres</p>
                        <div class="progress" style="height: 30px;">
                            <div class="progress-bar progress-bar-info progress-bar-striped active" style="width: 25%; line-height: 30px; font-size: 16px;">
                                25% de Usuarios Registrados
                            </div>
                        </div>
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
      
</body>

</html>