<!DOCTYPE html>
<html lang="es">

<title>Gestión de Visitas</title>

<?php include VIEW_PATH . "/component/heat.php"; ?>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-users"></i> Visitas <small> Gestión de Visitas</small></h1>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                    <div class="panel panel-info text-center">
                        <div class="panel-heading">Niños</div>
                        <div class="panel-body">
                            <h4><strong>45</strong></h4>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-primary text-center">
                        <div class="panel-heading">Adolescentes</div>
                        <div class="panel-body">
                            <h4><strong>32</strong></h4>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-success text-center">
                        <div class="panel-heading">Adultos</div>
                        <div class="panel-body">
                            <h4><strong>128</strong></h4>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-danger text-center">
                        <div class="panel-heading">Total Obras</div>
                        <div class="panel-body">
                            <h4><strong>210</strong></h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body" style="position: relative;">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="fa-solid fa-chart-line"></i> Flujo de Consultas
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12">
                                        <div class="thumbnail" style="padding: 15px; position: relative; border-radius: 4px;">
                                            <button class="btn btn-xs"
                                                style="position: absolute; top: 10px; right: 10px; z-index: 10; border: 1px solid #2e6da4; color: #2e6da4; background: #fff; font-weight: bold;"
                                                data-toggle="modal" data-target="#modalDetalleConsultasGrafico">
                                                <i class="fa-solid fa-circle-plus"></i> MÁS DETALLES
                                            </button><br>

                                            <div class="row">
                                                <div class="col-xs-12 col-md-6">
                                                    <h5 class="text-titles" style="font-weight: bold;">Flujo de Consultas (Obras)</h5>
                                                </div>
                                                <div class="col-xs-12 col-md-6 text-right" style="margin-top: 10px;">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-xs btn-default" onclick="actualizarConsultas('semana')">Semana</button>
                                                        <button type="button" class="btn btn-xs btn-default" onclick="actualizarConsultas('mes')">Mes</button>
                                                        <button type="button" class="btn btn-xs btn-default" onclick="actualizarConsultas('trimestre')">Trimestre</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="chartConsultasVisitor"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6">
                                    <h3 class="panel-title">Listado de Registros</h3>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <button class="btn btn-xs btn-default"><i class="fa-solid fa-print"></i> Imprimir</button>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Turno</th>
                                            <th>Distribución (N/A/A)</th>
                                            <th>Sala</th>
                                            <th>Total</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>2026-01-10</td>
                                            <td><span class="label label-info">Mañana</span></td>
                                            <td>10 / 5 / 15</td>
                                            <td>General</td>
                                            <td><strong>30</strong></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="visitor-info.php" class="btn btn-info btn-raised btn-xs"><i class="fa-solid fa-eye"></i></a>
                                                    <button class="btn btn-danger btn-raised btn-xs"
                                                        data-toggle="modal"
                                                        data-target="#modalEliminarVisitante"
                                                        data-id="ID_AQUI"
                                                        data-fecha="2026-01-10"
                                                        data-turno="Mañana">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/modal/modal-indicator/visitor-graph.php"; ?>
    <?php include VIEW_PATH . "/modal/confirmation-delete-visitor.php"; ?>
    <?php include VIEW_PATH . "/component/scripts.php"; ?>
    <?php include VIEW_PATH . "/component/chart-graph.php"; ?>
    
</body>
</html>