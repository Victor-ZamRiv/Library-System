<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Eventos</title>
    <?php include VIEW_PATH . "/component/heat.php"; ?>
</head>

<body>

    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles">
                    <i class="fa-solid fa-calendar"></i> Eventos
                    <small>Listado de Eventos</small>
                </h1>
            </div>
        </div>

        <div class="container-fluid text-center" style="margin-bottom: 20px;">
            <a href="#list-actividades" data-toggle="tab" class="btn btn-info btn-raised" style="margin-right: 5px;">
                <i class="fa-solid fa-list-check"></i> Lista de Actividades
            </a>
            <a href="#list-logros" data-toggle="tab" class="btn btn-primary btn-raised" style="margin-left: 5px;">
                <i class="fa-solid fa-trophy"></i> Lista de Logros
            </a>
        </div>

        <div class="container-fluid">
            <div class="tab-content">

                <div class="tab-pane fade active in" id="list-actividades">
                    <div class="card shadow p-3 mb-5 bg-white rounded">
                        <div class="table-responsive">
                            <table class="table table-hover text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Categoría</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Descripción</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($actividades as $actividad): ?>
                                    <tr>
                                        <td style="vertical-align: middle;"><?= htmlspecialchars($actividad->getFecha()) ?></td>
                                        <td style="vertical-align: middle;"><?= htmlspecialchars($actividad->getCategoria()) ?></td>
                                        <td style="vertical-align: middle;">
                                            <span class="label label-success"><?= htmlspecialchars($actividad->getEstado()) ?></span>
                                        </td>
                                        <td style="vertical-align: middle;"><?= htmlspecialchars($actividad->getDescripcion()) ?></td>
                                        <td style="vertical-align: middle;">
                                            <div class="d-flex justify-content-center">
                                                <a href="#!" class="btn btn-success btn-raised btn-sm" style="margin-right: 5px;">
                                                    <i class="fa-solid fa-pen-to-square"></i> EDITAR
                                                </a>
                                                <a href="#!" class="btn btn-danger btn-raised btn-sm">
                                                    <i class="fa-solid fa-trash"></i> ELIMINAR
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="list-logros">
                    <div class="card shadow p-3 mb-5 bg-white rounded">
                        <div class="table-responsive">
                            <table class="table table-hover text-center">
                                <thead>
                                    
                                    <tr>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Involucrados</th>
                                        <th class="text-center">Descripción</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($logros as $logro): ?>
                                    <tr>
                                        <td style="vertical-align: middle;"><?= htmlspecialchars($logro->getFecha()) ?></td>
                                        <td style="vertical-align: middle;"><?= htmlspecialchars($logro->getInvolucrados()) ?></td>
                                        <td style="vertical-align: middle;"><?= htmlspecialchars($logro->getDescripcion()) ?></td>
                                        <td style="vertical-align: middle;">
                                            <div class="d-flex justify-content-center">
                                                <a href="#!" class="btn btn-success btn-raised btn-sm" style="margin-right: 5px;">
                                                    <i class="fa-solid fa-pen-to-square"></i> EDITAR
                                                </a>
                                                <a href="#!" class="btn btn-danger btn-raised btn-sm">
                                                    <i class="fa-solid fa-trash"></i> ELIMINAR
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/component/scripts.php"; ?>
</body>

</html>