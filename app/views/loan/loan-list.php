<!DOCTYPE html>
<html lang="es">

<?php
include "../component/heat.php";
?>

<body>

    <?php
    include "../component/sidebar.php";
    ?>
    <section class="full-box dashboard-contentPage">
        <?php
        include "../component/navbar.php";
        ?>
        <div class="container-fluid ">
            <div class="page-header">
                <h1 class="text-titles"> </h1>
                <h1 class="text-titles"><i class="fa-solid fa-bookmark"></i> Préstamo <small>Lista de Préstamos</small></h1>
            </div>
        </div>

        <div class="container-fluid text-center" style="max-width: 600px;">
            <div class="d-inline-block" style=" width: 100%;">
                <div class="card shadow-lg p-3 mb-4 bg-white rounded">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-center align-items-center p-0 gap-0">

                            <div class="flex-grow-1">
                                <input type="text" class="form-control" placeholder="Buscar préstamo">
                            </div>

                            <div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 50px 0 0 50px; min-width: 100px;">
                                    Criterio <i class="fa-solid fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#!">ID Préstamo</a></li>
                                    <li><a href="#!">Carnet</a></li>
                                    <li><a href="#!">Cota</a></li>
                                </ul>
                            </div>

                            <a class="btn btn-success" type="button" style="border-radius: 0 50px 50px 0; min-width: 80px;">
                                Filtrar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>

        <div class="container-fluid">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"> &nbsp; LISTA DE PRÉSTAMOS</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>

                                    
                                    <th class="text-center">Carnet de usuario</th>
                                    <th class="text-center">Responsable</th>
                                    <th class="text-center">Cota</th>
                                    <th class="text-center">Emisión</th>
                                    <th class="text-center">Devolución</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Ver más</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    
                                    <td>123456/23</td>
                                    <td>admin</td>
                                    <td>001.8 A567</td>
                                    <td>20-03-2025</td>
                                    <td>20-04-2025</td>
                                    <td>Entregado</td>
                                    <td>
                                        <a href="loan-details.php?id=32" class="btn btn-success btn-raised btn-xs" title="Ver más">
                                            <i class="fa-solid fa-info"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    
                                    <td>123456/23</td>
                                    <td>admin</td>
                                    <td>N.EJ43 N454</td>
                                    <td>18-04-2025</td>
                                    <td>18-07-2025</td>
                                    <td>Entregado tarde</td>
                                    <td>
                                        <a href="loan-details.php?id=30" class="btn btn-success btn-raised btn-xs" title="Ver más">
                                            <i class="fa-solid fa-info"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    
                                    <td>123456/23</td>
                                    <td>admin</td>
                                    <td>N H454</td>
                                    <td>27-05-2025</td>
                                    <td>27-09-2025</td>
                                    <td>Entregado</td>
                                    <td>
                                        <a href="loan-details.php?id=28" class="btn btn-success btn-raised btn-xs" title="Ver más">
                                            <i class="fa-solid fa-info"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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


    </section>

    <?php
    include "../component/scripts.php";
    ?>
</body>

</html>