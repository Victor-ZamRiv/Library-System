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
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group label-floating">
                                <label class="control-label">¿A quién buscas?</label>
                                <input type="text" class="form-control" id="inputSearch">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 text-right">
                            <br>
                            <button class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-search"></i> Buscar</button>
                        </div>
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
                                <tr>
                                    <td>00000010/26</td>
                                    <td>25.444.333</td>
                                    <td>Juan Pérez</td>
                                    <td>04241234567</td>
                                    <td>Ingeniero</td>
                                    <td>
                                        <a href="#!" class="btn btn-success btn-raised btn-xs" title="Editar">

                                        </a>
                                        <a href="#!" class="btn btn-info btn-raised btn-xs" title="Ver Detalles">

                                        </a>
                                        <form action="" method="POST" style="display: inline-block;">
                                            <button type="submit" class="btn btn-danger btn-raised btn-xs" title="Eliminar">

                                            </button>
                                        </form>
                                    </td>
                                </tr>
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

    <?php include VIEW_PATH . "/component/scripts.php" ?>
</body>

</html>