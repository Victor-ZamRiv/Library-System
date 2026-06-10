<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Lectores</title>
    <?php include VIEW_PATH . "/component/heat.php" ?>
</head>
<body>
    <?php include VIEW_PATH . "/component/sidebar.php" ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php" ?>
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"> <i class="fa-solid fa-book-open-reader"></i> Lista de Lectores</h1>
            </div>
        </div>
        <?php include VIEW_PATH . "/component/readerbar.php" ?>

        <div class="container-fluid">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE LECTORES</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form action="<?= BASE_URL ?>/lectores" method="GET">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">¿A quién buscas?</label>
                                    <input type="text" class="form-control" name="buscar" value="<?= htmlspecialchars($search ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 text-right">
                                <br>
                                <button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-search"></i> Buscar</button>
                                <button type="button" class="btn btn-warning btn-raised btn-sm" data-toggle="modal" data-target="#disabledReadersModal">
                                    <i class="fa-solid fa-ban"></i> Suspendidos <?= ($totalInactivos ?? 0) > 0 ? '(' . ($totalInactivos ?? 0) . ')' : '' ?>
                                </button>
                                <button type="button" onclick="descargarPDF('Lectores');" class="btn btn-success btn-raised btn-sm">
                                    <i class="fa-solid fa-file-pdf"></i> IMPRIMIR HABILITADOS
                                </button>
                            </div>
                        </form>
                    </div>

                    <hr>

                    <div class="table-responsive">
                        <table id="tabla-lectores-imprimir" class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">N° CARNET</th>
                                    <th class="text-center">CÉDULA</th>
                                    <th class="text-center">NOMBRE COMPLETO</th>
                                    <th class="text-center">TELÉFONO</th>
                                    <th class="text-center">PROFESIÓN</th>
                                    <th class="text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-lectores-cuerpo">
                                <?php if (empty($lectores)): ?>
                                    <tr><td colspan="6" class="text-center">No hay lectores activos registrados.<?php else: ?>
                                    <?php foreach ($lectores as $lector): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($lector->getCarnet()) ?></td>
                                            <td><?= htmlspecialchars($lector->getPersona()->getCedula()) ?></td>
                                            <td><?= htmlspecialchars($lector->getPersona()->getNombre() . ' ' . $lector->getPersona()->getApellido()) ?></td>
                                            <td><?= htmlspecialchars($lector->getPersona()->getTelefono()) ?></td>
                                            <td><?= htmlspecialchars($lector->getProfesion()) ?></td>
                                            <td>
                                                <a href="<?= BASE_URL ?>/lectores/edit?id=<?= $lector->getIdLector() ?>" class="btn btn-success btn-raised btn-xs" title="Editar">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a href="<?= BASE_URL ?>/lectores/show?id=<?= $lector->getIdLector() ?>" class="btn btn-info btn-raised btn-xs" title="Ver Detalles">
                                                    <i class="fa-solid fa-info"></i>
                                                </a>
                                                <form action="<?= BASE_URL ?>/lectores/delete?id=<?= $lector->getIdLector() ?>" method="POST" style="display: inline-block;">
                                                    <button type="button"
                                                        class="btn btn-danger btn-raised btn-xs"
                                                        title="Eliminar"
                                                        data-toggle="modal"
                                                        data-target="#confirmDeleteModal"
                                                        data-id="<?= $lector->getIdLector() ?>"
                                                        data-nombre="<?= htmlspecialchars($lector->getPersona()->getNombre() . ' ' . $lector->getPersona()->getApellido()) ?>">
                                                        <i class="fa-solid fa-ban"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if (isset($paginacion) && $paginacion['ultima'] > 1): ?>
                    <nav class="text-center">
                        <ul class="pagination pagination-sm">
                            <?php if ($paginacion['actual'] > 1): ?>
                                <li><a href="?page=1&buscar=<?= urlencode($search ?? '') ?>">«</a></li>
                                <li><a href="?page=<?= $paginacion['actual']-1 ?>&buscar=<?= urlencode($search ?? '') ?>">‹</a></li>
                            <?php else: ?>
                                <li class="disabled"><a href="#">«</a></li>
                            <?php endif; ?>
                            
                            <li class="active"><a href="#"><?= $paginacion['actual'] ?></a></li>
                            
                            <?php if ($paginacion['actual'] < $paginacion['ultima']): ?>
                                <li><a href="?page=<?= $paginacion['actual']+1 ?>&buscar=<?= urlencode($search ?? '') ?>">›</a></li>
                                <li><a href="?page=<?= $paginacion['ultima'] ?>&buscar=<?= urlencode($search ?? '') ?>">»</a></li>
                            <?php else: ?>
                                <li class="disabled"><a href="#">›</a></li>
                                <li class="disabled"><a href="#">»</a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/modal/enable-reader.php" ?>
    <?php include VIEW_PATH . "/modal/confirmation-delete-reader.php" ?>

    <?php include VIEW_PATH . "/component/scripts.php" ?>
    <script src="<?= PUBLIC_PATH ?>/js/pdf-generator.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/html2canvas.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jsPDF.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jspdf-autotable.js"></script>

    <script>
        $(document).ready(function() {
            $('#confirmDeleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var idLector = button.data('id');
                var nombre = button.data('nombre');
                var modal = $(this);
                modal.find('#nombreLectorModal').text(nombre);
                var urlEliminar = '<?= BASE_URL ?>/lectores/delete?id=' + idLector;
                modal.find('#btnConfirmarEliminar').attr('href', urlEliminar);
            });
        });
    </script>
</body>
</html>