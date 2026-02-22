<!DOCTYPE html>
<html lang="es">

<head>
    <title>Historial del Sistema</title>
    <?php include VIEW_PATH . "/component/heat.php" ?>
</head>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php" ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php" ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"> Configuración <small>Historial</small></h1>
            </div>
        </div>

        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="" method="GET" class="row">
                        <div class="col-xs-12 col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Seleccionar Usuario</label>
                                <select class="form-control" name="filtro-usuario">
                                    <option value="">Todos los usuarios</option>
                                    <option value="1">admin_jose</option>
                                    <option value="2">operador_01</option>
                                    <option value="3">vendedor_caracas</option>
                                </select>
                            </div>
                        </div>

                        

                        <div class="col-xs-12 col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Tipo de Acción</label>
                                <select class="form-control" name="filtro-accion">
                                    <option value="">Todas las acciones</option>
                                    <option value="creacion">Creación</option>
                                    <option value="actualizacion">Actualización</option>
                                    <option value="eliminacion">Eliminación</option>
                                    <option value="login">Inicio de Sesión</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-3 text-center" style="margin-top: 25px;">
                            <button type="submit" class="btn btn-primary btn-raised btn-sm">
                                <i class="zmdi zmdi-search"></i> &nbsp; BUSCAR
                            </button>
                            <button type="button" class="btn btn-danger btn-raised btn-sm" onclick="window.print();">
                                <i class="zmdi zmdi-print"></i> &nbsp; PDF / IMPRIMIR
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="zmdi zmdi-time-restore"></i> &nbsp; LOGS DE ACTIVIDAD</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">USUARIO</th>
                                    <th class="text-center">FECHA / HORA</th>
                                    <th class="text-center">ACCIÓN</th>
                                    <th class="text-center">DESCRIPCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>admin_jose</strong></td>
                                    <td>23/01/2026 - 10:15 AM</td>
                                    <td><span class="label label-success">CREACIÓN</span></td>
                                    <td>Se registró un nuevo usuario en el sistema.</td>
                                </tr>
                                <tr>
                                    <td><strong>operador_01</strong></td>
                                    <td>23/01/2026 - 09:40 AM</td>
                                    <td><span class="label label-info">ACTUALIZACIÓN</span></td>
                                    <td>Se modificaron los datos de un cliente existente.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/component/scripts.php" ?>
</body>
</html>