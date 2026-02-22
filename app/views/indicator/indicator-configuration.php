<!DOCTYPE html>
<html lang="es">
<head>
    <title>Configuración de Indicadores</title>
    <?php include VIEW_PATH . "/component/heat.php"; ?>
</head>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>

        <div class="container-fluid" style="padding-top: 20px;">
            <div class="page-header">
                <h2 class="text-titles text-center">
                    <i class="fa-solid fa-chart-line"></i> Configuración de Indicadores
                </h2>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <form action="../controller/update_indicators.php" method="POST">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa-solid fa-eye"></i> Visibilidad de Indicadores en Dashboard</h3>
                            </div>
                            <div class="panel-body">
                                <p class="text-muted">Seleccione los indicadores que desea visualizar en la página de inicio del sistema.</p>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover text-center">
                                        <thead>
                                            <tr>
                                                <th class="text-center">INDICADOR</th>
                                                <th class="text-center">CATEGORÍA</th>
                                                <th class="text-center">ESTADO</th>
                                                <th class="text-center">VISIBILIDAD</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Cobertura de Usuarios</td>
                                                <td><span class="text-muted small">Usuarios</span></td>
                                                <td><span class="label label-success">Activo</span></td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_cobertura" checked> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Consultas de Referencia</td>
                                                <td><span class="text-muted small">Usuarios</span></td>
                                                <td><span class="label label-success">Activo</span></td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_referencia" checked> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Promedio de Consultas (Gráfico)</td>
                                                <td><span class="text-muted small">Actividad</span></td>
                                                <td><span class="label label-success">Activo</span></td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_grafico_consultas" checked> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tasa de Cumplimiento</td>
                                                <td><span class="text-muted small">Gestión</span></td>
                                                <td><span class="label label-success">Activo</span></td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_cumplimiento" checked> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Ocupación por Salas</td>
                                                <td><span class="text-muted small">Infraestructura</span></td>
                                                <td><span class="label label-success">Activo</span></td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_ocupacion" checked> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Índice de Rotación</td>
                                                <td><span class="text-muted small">Colección</span></td>
                                                <td><span class="label label-danger">Inactivo</span></td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_rotacion"> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Estado Físico de Colección</td>
                                                <td><span class="text-muted small">Colección</span></td>
                                                <td><span class="label label-success">Activo</span></td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_estado_fisico" checked> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Asistencia: Sala Estatal</td>
                                                <td><span class="text-muted small">Salas</span></td>
                                                <td><span class="label label-success">Activo</span></td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_asistencia_estatal" checked> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="panel-footer text-right">
                                <button type="submit" class="btn btn-primary btn-raised">
                                    <i class="fa-solid fa-floppy-disk"></i> Guardar Configuración
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

       
    </section>

    <?php include VIEW_PATH . "/component/scripts.php"; ?>
</body>
</html>