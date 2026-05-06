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
                    <form action="../controller/update_indicators.php" method="POST" id="formIndicadores">
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
                                                            <input type="checkbox" name="ind_cobertura" checked data-indicador="Cobertura de Usuarios"> Habilitar
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
                                                            <input type="checkbox" name="ind_referencia" checked data-indicador="Consultas de Referencia"> Habilitar
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
                                                            <input type="checkbox" name="ind_grafico_consultas" checked data-indicador="Promedio de Consultas (Gráfico)"> Habilitar
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
                                                            <input type="checkbox" name="ind_cumplimiento" checked data-indicador="Tasa de Cumplimiento"> Habilitar
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
                                                            <input type="checkbox" name="ind_ocupacion" checked data-indicador="Ocupación por Salas"> Habilitar
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
                                                            <input type="checkbox" name="ind_rotacion" data-indicador="Índice de Rotación"> Habilitar
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
                                                            <input type="checkbox" name="ind_estado_fisico" checked data-indicador="Estado Físico de Colección"> Habilitar
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
                                                            <input type="checkbox" name="ind_asistencia_estatal" checked data-indicador="Asistencia: Sala Estatal"> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="panel-footer text-right">
                                <button type="button" class="btn btn-primary btn-raised" id="btnGuardarIndicadores">
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
    <?php include VIEW_PATH . "/modal/save-config-indicator.php"; ?>

    <script>
        $(document).ready(function() {
            // Función para actualizar resumen del modal
            function actualizarResumenModal() {
                // VISIBLES
                let visiblesHTML = '';
                let totalVisibles = 0;
                $('input[type="checkbox"]:checked').each(function() {
                    let nombre = $(this).data('indicador');
                    visiblesHTML += '<span class="badge badge-success mr-1 mb-1">' + nombre + '</span>';
                    totalVisibles++;
                });
                $('#indicadoresVisibles').html(visiblesHTML || '<em class="text-muted">Ninguno</em>');
                $('#contadorVisibles').text(totalVisibles);

                // OCULTOS
                let ocultosHTML = '';
                let totalOcultos = 0;
                $('input[type="checkbox"]:not(:checked)').each(function() {
                    let nombre = $(this).data('indicador');
                    ocultosHTML += '<span class="badge badge-danger mr-1 mb-1">' + nombre + '</span>';
                    totalOcultos++;
                });
                $('#indicadoresOcultos').html(ocultosHTML || '<em class="text-muted">Ninguno</em>');
                $('#contadorOcultos').text(totalOcultos);
            }

            // Actualizar en tiempo real al cambiar checkboxes
            $('input[type="checkbox"]').on('change', function() {
                if ($('#confirmSaveIndicadoresModal').hasClass('show')) {
                    actualizarResumenModal();
                }
            });

            // Abrir modal al hacer clic en Guardar
            $('#btnGuardarIndicadores').on('click', function() {
                actualizarResumenModal();
                $('#confirmSaveIndicadoresModal').modal('show');
            });
        });
    </script>

</body>

</html>