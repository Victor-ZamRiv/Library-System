<!DOCTYPE html>
<html lang="es">

<head>
    <title>Gestión de Multas - Listado</title>
    <?php include "../component/heat.php" ?>
</head>

<body>
    <?php include "../component/sidebar.php" ?>

    <section class="full-box dashboard-contentPage">
        <?php include "../component/navbar.php" ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-bookmark"></i> Multas <small>Listado de Multas</small></h1>
            </div>
        </div>

        <?php include "../component/finebar.php" ?>

        <div class="container-fluid">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE MULTAS</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                  
                                    <th class="text-center">N° PRÉSTAMO</th>
                                    <th class="text-center">CONCEPTO</th>
                                    <th class="text-center">MONTO</th>
                                    <th class="text-center">ESTADO</th>
                                    <th class="text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    
                                    <td>002154</td>
                                    <td>Entrega fuera de fecha</td>
                                    <td>$15.25</td>
                                    <td><span class="label label-danger">Pendiente</span></td>
                                    <td>
                                        <a href="#!" class="btn btn-success btn-raised btn-xs" title="Pagar">
                                            <i class="zmdi zmdi-money-box"></i>
                                        </a>
                                        <a href="#!" class="btn btn-info btn-raised btn-xs" title="Editar">
                                            <i class="zmdi zmdi-edit"></i>
                                        </a>
                                        <form action="" method="POST" style="display: inline-block;">
                                            <button type="submit" class="btn btn-danger btn-raised btn-xs" title="Eliminar">
                                                <i class="zmdi zmdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                
                                <tr>
                                    
                                    <td>002188</td>
                                    <td>Libro dañado (hojas sueltas)</td>
                                    <td>$5.00</td>
                                    <td><span class="label label-success">Pagado</span></td>
                                    <td>
                                        <button class="btn btn-secondary btn-raised btn-xs" disabled>
                                            <i class="zmdi zmdi-check-all"></i>
                                        </button>
                                        <a href="#!" class="btn btn-info btn-raised btn-xs" title="Editar">
                                            <i class="zmdi zmdi-edit"></i>
                                        </a>
                                        <form action="" method="POST" style="display: inline-block;">
                                            <button type="submit" class="btn btn-danger btn-raised btn-xs" title="Eliminar">
                                                <i class="zmdi zmdi-delete"></i>
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

    <?php include "../component/scripts.php" ?>
    </body>

</html>