<!DOCTYPE html>
<html lang="es">

<head>
    <title>Inicio</title>
    <?php include  VIEW_PATH . "/component/heat.php"; ?>
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/css/style-indicator.css">
    <script src=" <?= PUBLIC_PATH ?> /js/pdf/jsPDF.js"></script>
    <script src=" <?= PUBLIC_PATH ?> /js/pdf/jspdf-autotable.js"></script>

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
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <div class="well well-sm text-center" style="position: relative;">
                                <button class="btn btn-xs"
                                    style="position: absolute; top: 5px; right: 5px; border: 1px solid #2e6da4; color: #2e6da4; background: #fff;"
                                    data-toggle="modal" data-target="#modalDetalleCobertura">
                                    <i class="fa-solid fa-plus"></i>
                                </button><br>
                                <h5 class="text-uppercase text-titles">Cobertura de Usuarios</h5>
                                <h3 class="text-info" style="margin-top: 10px;">15%</h3>
                                <small class="text-muted">Meta: Ascendente</small>
                            </div>

                            <div class="well well-sm text-center" style="margin-bottom:0; position: relative;">
                                <button class="btn btn-xs"
                                    style="position: absolute; top: 5px; right: 5px; border: 1px solid #2e6da4; color: #2e6da4; background: #fff;"
                                    data-toggle="modal" data-target="#modalDetalleReferencia">
                                    <i class="fa-solid fa-plus"></i>
                                </button><br>
                                <h5 class="text-uppercase text-titles">Consultas de Referencia</h5>
                                <h3 class="text-info" style="margin-top: 10px;">2.4</h3>
                                <small class="text-muted">Razón por usuario activo</small>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-8">
                            <div class="thumbnail" style="padding: 15px; height: 350px; position: relative; border: 1px solid #ddd; overflow: hidden;">
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
                    </div>
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa-solid fa-gears"></i></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            <div class="thumbnail" style="padding: 15px; height: 350px; position: relative; border: 1px solid #ddd; overflow: hidden;">
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

                        <div class="col-xs-12 col-md-5">
                            <div class="thumbnail" style="padding: 15px; height: 350px; position: relative; border: 1px solid #ddd; overflow: hidden;">
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

                        <div class="col-xs-12 col-md-3">
                            <div class="row">

                                <div class="col-xs-12">
                                    <div class="panel panel-default indicator-item btn-detalle-rotacion"
                                        style="border-left: 5px solid #d9534f; margin-bottom: 10px; cursor: pointer;"
                                        data-toggle="popover"
                                        data-target-modal="#modalRotacion"
                                        data-status="danger"
                                        title="<i class='fa-solid fa-rotate'></i> Índice de Rotación"
                                        data-content="La circulación de libros es muy baja respecto al inventario.<br><strong>Estado:</strong> Crítico<br><div class='progress'><div class='progress-bar progress-bar-danger' style='width:24%'></div></div><small>Meta: > 50%</small>">
                                        <div class="panel-body text-center">
                                            <i class="fa-solid fa-rotate text-danger" style="font-size: 20px;"></i>
                                            <div style="font-size: 10px; font-weight: bold; color: #555; margin: 5px 0;">ROTACIÓN</div>
                                            <span class="label label-danger" style="font-size: 12px;">24%</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="panel panel-default indicator-item"
                                        style="border-left: 5px solid #5cb85c; margin-bottom: 10px; cursor: pointer;"
                                        data-toggle="popover"
                                        data-status="success"
                                        data-target-modal="#modalEstadoFisico"
                                        title="<i class='fa-solid fa-book-medical'></i> Estado Físico"
                                        data-content="La mayoría de la colección se encuentra en óptimas condiciones.<br><strong>Estado:</strong> Excelente<br><div class='progress'><div class='progress-bar progress-bar-success' style='width:92%'></div></div><small>Mantenimiento al día</small>">
                                        <div class="panel-body text-center">
                                            <i class="fa-solid fa-book-medical text-success" style="font-size: 20px;"></i>
                                            <div style="font-size: 10px; font-weight: bold; color: #555; margin: 5px 0;">ESTADO FÍSICO</div>
                                            <span class="label label-success" style="font-size: 12px;">92%</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="panel panel-default indicator-item"
                                        style="border-left: 5px solid #f0ad4e; margin-bottom: 10px; cursor: pointer;"
                                        data-toggle="popover"
                                        data-status="warning"
                                        data-target-modal="#modalAsistenciaEstatal"
                                        title="<i class='fa-solid fa-users-viewfinder'></i> Asistencia: Sala Estatal"
                                        data-content="El flujo de visitantes en la Sala Estatal está por debajo de la meta mensual.<br><strong>Estado:</strong> Regular<br><div class='progress'><div class='progress-bar progress-bar-warning' style='width:68%'></div></div><small>Meta: 500 usuarios/mes</small>">
                                        <div class="panel-body text-center">
                                            <i class="fa-solid fa-users-viewfinder text-warning" style="font-size: 20px;"></i>
                                            <div style="font-size: 10px; font-weight: bold; color: #555; margin: 5px 0;">ASIST. SALA ESTATAL</div>
                                            <span class="label label-warning" style="font-size: 12px;">68%</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                    <div class="panel panel-default indicator-item"
                                        style="border-left: 5px solid #d9534f; margin-bottom: 0; cursor: pointer;"
                                        data-toggle="popover"
                                        data-status="danger"
                                        data-target-modal="#modalColeccion"
                                        title="<i class='fa-solid fa-archive'></i> Colección"
                                        data-content="Nivel de actualización de títulos insuficiente este mes.<br><strong>Estado:</strong> Bajo<br><div class='progress'><div class='progress-bar progress-bar-danger' style='width:35%'></div></div><small>Requiere compra de títulos</small>">
                                        <div class="panel-body text-center">
                                            <i class="fa-solid fa-archive text-danger" style="font-size: 20px;"></i>
                                            <div style="font-size: 10px; font-weight: bold; color: #555; margin: 5px 0;">COLECCIÓN</div>
                                            <span class="label label-danger" style="font-size: 12px;">35%</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-info">
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
        </div>



        <div class="container-fluid">
            <?php include VIEW_PATH . "/component/notification.php"; ?>
        </div>
    </section>



    <?php include  VIEW_PATH . "/modal/modal-indicator/user-coverage.php" ?>
    <?php include  VIEW_PATH . "/modal/modal-indicator/consult-reference.php" ?>
    <?php include  VIEW_PATH . "/modal/modal-indicator/query-graph.php" ?>


    <?php include  VIEW_PATH . "/modal/modal-indicator/compliance.php" ?>
    <?php include  VIEW_PATH . "/modal/modal-indicator/occupation.php" ?>
    <?php include  VIEW_PATH . "/modal/modal-indicator/rotation.php" ?>
    <?php include  VIEW_PATH . "/modal/modal-indicator/physical-state.php" ?>
    <?php include  VIEW_PATH . "/modal/modal-indicator/state-assistance.php" ?>
    <?php include  VIEW_PATH . "/modal/modal-indicator/colection.php" ?>

    <?php include  VIEW_PATH . "/component/scripts.php"; ?>
    <?php include VIEW_PATH . "/component/chart-graph.php"; ?>



</body>

</html>