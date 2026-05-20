<!DOCTYPE html>
<html lang="es">

<head>
    <title>Historial del Sistema</title>
    <?php include VIEW_PATH . "/component/heat.php" ?>
    <style>
    @media print {
        /* Ocultar elementos de la interfaz */
        .sidebar-wrapper, .dashboard-sideBar, .dashboard-contentPage > .navbar, 
        .form-horizontal, .panel-body form, .btn, .zmdi {
            display: none !important;
        }

        /* Ajustar el contenedor principal */
        section, .container-fluid, .panel, .panel-body {
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            box-shadow: none !important;
        }

        /* OCULTAR LA COLUMNA DE OPCIONES (Última columna de la tabla) */
        table th:last-child, 
        table td:last-child {
            display: none !important;
        }

        /* Hacer que la tabla ocupe todo el ancho */
        .table {
            width: 100% !important;
            border-collapse: collapse;
        }

        .page-header::after {
            content: " Reporte de Historial Generado el <?= date('d/m/Y') ?>";
            font-size: 14px;
        }

        .label {
            border: 1px solid #333;
            color: #000 !important;
            background: none !important;
        }
    }
</style>
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
                        <!-- Filtro Usuario -->
                        <div class="col-xs-12 col-sm-3">
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

                        <!-- Filtro Acción -->
                        <div class="col-xs-12 col-sm-3">
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

                        <!-- NUEVO: Filtro por Módulo -->
                        <div class="col-xs-12 col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Módulo del Sistema</label>
                                <select class="form-control" name="filtro-modulo">
                                    <option value="">Todos los módulos</option>
                                    <option value="lectores">Lectores</option>
                                    <option value="libros">Libros</option>
                                    <option value="prestamos">Préstamos</option>
                                    <option value="visitas">Visitas</option>
                                    <option value="eventos">Eventos</option>
                                </select>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="col-xs-12 col-sm-3 text-center" style="margin-top: 25px;">
                            <button type="submit" class="btn btn-primary btn-raised btn-sm">
                                <i class="zmdi zmdi-search"></i> &nbsp; BUSCAR
                            </button>
                            <button type="button" class="btn btn-danger btn-raised btn-sm" onclick="window.print();">
                                <i class="zmdi zmdi-print"></i> &nbsp; PDF
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
                                    <th class="text-center">MÓDULO</th> <!-- Columna Modificada -->
                                    <th class="text-center">FECHA / HORA</th>
                                    <th class="text-center">ACCIÓN</th>
                                    <th class="text-center">DESCRIPCIÓN</th>
                                    <th class="text-center">OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>admin_jose</strong></td>
                                    <td><span class="label label-default">Lectores</span></td> <!-- Celda Modificada -->
                                    <td>23/01/2026 - 10:15 AM</td>
                                    <td><span class="label label-success">CREACIÓN</span></td>
                                    <td>Se registró un nuevo usuario en el sistema.</td>
                                    <td>
                                        <!-- Botón Más Info -->
                                        <a href="detalle_log.php?id=1" class="btn btn-info btn-raised btn-xs" title="Más Información">
                                            <i class="zmdi zmdi-info-outline"></i> &nbsp; Más info
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>operador_01</strong></td>
                                    <td><span class="label label-default">Libros</span></td> <!-- Celda Modificada -->
                                    <td>23/01/2026 - 09:40 AM</td>
                                    <td><span class="label label-info">ACTUALIZACIÓN</span></td>
                                    <td>Se modificaron los datos de un cliente existente.</td>
                                    <td>
                                        <!-- Botón Más Info -->
                                        <a href="detalle_log.php?id=2" class="btn btn-info btn-raised btn-xs" title="Más Información">
                                            <i class="zmdi zmdi-info-outline"></i> &nbsp; Más info
                                        </a>
                                    </td>
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