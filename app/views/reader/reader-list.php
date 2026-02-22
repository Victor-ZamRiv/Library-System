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
                <h1 class="text-titles"> <i class="fa-solid fa-book-open-reader"></i> Lectores <small> Lista de Lectores</small></h1>
            </div>
        </div>
        <?php include VIEW_PATH . "/component/readerbar.php" ?>

        <div class="container-fluid">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE LECTORES </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form action="<?= BASE_URL ?>/lectores/search">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">¿A quién buscas?</label>
                                    <input type="text" class="form-control" id="inputSearch" name="buscar">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 text-right">
                                <br>
                                <button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-search"></i> Buscar</button>
                            </div>
                        </form>
                    </div>

                    <hr>

                    <div class="table-responsive">
                        <table class="table table-hover text-center">
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
                            <tbody>
                                <?php foreach ($lectores as $lector): ?>
                                    <tr>
                                        <td><?= $lector->getCarnet() ?></td>
                                        <td><?= $lector->getPersona()->getCedula() ?></td>
                                        <td><?= $lector->getPersona()->getNombre() . " " . $lector->getPersona()->getApellido() ?></td>
                                        <td><?= $lector->getPersona()->getTelefono() ?></td>
                                        <td><?= $lector->getProfesion() ?></td>
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
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
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
                            <li><a href="javascript:void(0)">2</a></li>
                            <li><a href="javascript:void(0)">3</a></li>
                            <li><a href="javascript:void(0)">»</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    

    <?php include VIEW_PATH . "/modal/confirmation-delete-reader.php" ?>

    <?php include VIEW_PATH . "/component/scripts.php" ?>
    <script>
        $(document).ready(function() {
            $('#confirmDeleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Botón que abrió el modal
                var idLector = button.data('id'); // Extraer ID
                var nombre = button.data('nombre'); // Extraer Nombre

                var modal = $(this);
                modal.find('#nombreLectorModal').text(nombre);

                // Construye la URL de eliminación (ajustada a tu ruta de lectores)
                var urlEliminar = '<?= BASE_URL ?>/lectores/delete?id=' + idLector;
                modal.find('#btnConfirmarEliminar').attr('href', urlEliminar);
            });
        });
    </script>
</body>

</html>