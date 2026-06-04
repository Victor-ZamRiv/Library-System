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
                    <i class="fa-solid fa-calendar"></i> Listado de Eventos
                </h1>
            </div>
        </div>

        <div class="container-fluid text-left mb-4" style="margin-bottom: 20px;">
            <button type="button" class="btn btn-primary btn-raised btn-lg" data-toggle="modal" data-target="#modalLogros">
                <i class="fa-solid fa-trophy"></i> Logros
            </button>
        </div>

        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">
                            <h3 class="panel-title" style="line-height: 30px;">
                                <i class="fa-solid fa-list-check"></i> &nbsp; LISTA DE ACTIVIDADES
                            </h3>
                        </div>
                        <div class="col-xs-6 text-right">
                            <button type="button" onclick="descargarPDF('TablaActividades')" class="btn btn-sm btn-raised btn-primary">
                                <i class="fa-solid fa-print"></i> IMPRIMIR REPORTE
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="tabla-actividades" class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">FECHA</th>
                                    <th class="text-center">CATEGORÍA</th>
                                    <th class="text-center">ESTADO</th>
                                    <th class="text-center">DESCRIPCIÓN</th>
                                    <th class="text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($actividades as $actividad): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($actividad->getFecha()) ?></td>
                                        <td><?= htmlspecialchars($actividad->getCategoria()) ?></td>
                                        <td>
                                            <span class="label label-success">
                                                <?= htmlspecialchars($actividad->getEstado()) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($actividad->getDescripcion()) ?></td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="Library_System/actividad/edit?id=<?= htmlspecialchars($actividad->getIdActividad()) ?>" class="btn btn-success btn-raised btn-xs" title="Editar">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>

                                                <button type="button" class="btn btn-danger btn-raised btn-xs"
                                                    title="Eliminar"
                                                    data-toggle="modal"
                                                    data-target="#confirmDeleteModalActividad"
                                                    data-descripcion="<?= htmlspecialchars($actividad->getDescripcion()) ?>">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <nav class="text-center">
                        <ul class="pagination pagination-sm">
                            <li class="disabled"><a href="javascript:void(0)">«</a></li>
                            <li class="active"><a href="javascript:void(0)">1</a></li>
                            <li><a href="javascript:void(0)">»</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/component/scripts.php"; ?>
    <?php include VIEW_PATH . "/modal/confirmation-delete-actividad.php"; ?>
    <?php include VIEW_PATH . "/modal/view-achievement.php"; ?>
    
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jsPDF.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jspdf-autotable.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/html2canvas.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf-generator.js"></script>
</body>

</html>