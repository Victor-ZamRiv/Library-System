<!DOCTYPE html>
<html lang="es">
<head>
    <title>Configuración de Indicadores</title>
    <?php include VIEW_PATH . "/component/heat.php"; ?>
    <style>
        /* Estilos rápidos para mejorar la alineación de la botonera superior */
        .acciones-tabla {
            margin-bottom: 15px;
            display: flex;
            justify-content: flex-start;
        }
    </style>
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
                    <form action="<?= BASE_URL ?>/configuracion/indicadores/guardar" method="POST" id="formIndicadores">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa-solid fa-eye"></i> Visibilidad de Indicadores en Dashboard</h3>
                            </div>
                            <div class="panel-body">
                                <p class="text-muted">Seleccione los indicadores que desea visualizar en la página de inicio del sistema.</p>

                                <div class="acciones-tabla">
                                    <button type="button" class="btn btn-default btn-raised btn-sm" id="btnToggleTodos">
                                        <i class="fa-solid fa-check-double"></i> <span id="txtToggleTodos">Seleccionar Todos</span>
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover text-center" id="tablaIndicadores">
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
                                                <td>
                                                    <span class="label status-badge <?= $config->getMostrarCobertura() ? 'label-success' : 'label-danger' ?>">
                                                        <?= $config->getMostrarCobertura() ? 'Activo' : 'Inactivo' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_cobertura" <?= $config->getMostrarCobertura() ? 'checked' : '' ?> data-indicador="Cobertura de Usuarios"> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Consultas de Referencia</td>
                                                <td><span class="text-muted small">Usuarios</span></td>
                                                <td>
                                                    <span class="label status-badge <?= $config->getMostrarReferencia() ? 'label-success' : 'label-danger' ?>">
                                                        <?= $config->getMostrarReferencia() ? 'Activo' : 'Inactivo' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_referencia" <?= $config->getMostrarReferencia() ? 'checked' : '' ?> data-indicador="Consultas de Referencia"> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Promedio de Consultas (Gráfico)</td>
                                                <td><span class="text-muted small">Actividad</span></td>
                                                <td>
                                                    <span class="label status-badge <?= $config->getMostrarGraficoConsultas() ? 'label-success' : 'label-danger' ?>">
                                                        <?= $config->getMostrarGraficoConsultas() ? 'Activo' : 'Inactivo' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_grafico_consultas" <?= $config->getMostrarGraficoConsultas() ? 'checked' : '' ?> data-indicador="Promedio de Consultas (Gráfico)"> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Tasa de Cumplimiento</td>
                                                <td><span class="text-muted small">Gestión</span></td>
                                                <td>
                                                    <span class="label status-badge <?= $config->getMostrarCumplimiento() ? 'label-success' : 'label-danger' ?>">
                                                        <?= $config->getMostrarCumplimiento() ? 'Activo' : 'Inactivo' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_cumplimiento" <?= $config->getMostrarCumplimiento() ? 'checked' : '' ?> data-indicador="Tasa de Cumplimiento"> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Ocupación por Salas</td>
                                                <td><span class="text-muted small">Infraestructura</span></td>
                                                <td>
                                                    <span class="label status-badge <?= $config->getMostrarOcupacion() ? 'label-success' : 'label-danger' ?>">
                                                        <?= $config->getMostrarOcupacion() ? 'Activo' : 'Inactivo' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_ocupacion" <?= $config->getMostrarOcupacion() ? 'checked' : '' ?> data-indicador="Ocupación por Salas"> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>

<<<<<<< HEAD
                                            <tr>
                                                <td>Intensidad de Uso (IIUR)</td>
                                                <td><span class="text-muted small">Gestión</span></td>
                                                <td>
                                                    <span class="label status-badge <?= $config->getMostrarIiur() ? 'label-success' : 'label-danger' ?>">
                                                        <?= $config->getMostrarIiur() ? 'Activo' : 'Inactivo' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_iiur" <?= $config->getMostrarIiur() ? 'checked' : '' ?> data-indicador="Intensidad de Uso (IIUR)"> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Deterioro por Alta Rotación (IDCAR)</td>
                                                <td><span class="text-muted small">Colección</span></td>
                                                <td>
                                                    <span class="label status-badge <?= $config->getMostrarIdcar() ? 'label-success' : 'label-danger' ?>">
                                                        <?= $config->getMostrarIdcar() ? 'Activo' : 'Inactivo' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_idcar" <?= $config->getMostrarIdcar() ? 'checked' : '' ?> data-indicador="Deterioro por Alta Rotación (IDCAR)"> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>

=======
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
                                            <tr>
                                                <td>Índice de Rotación</td>
                                                <td><span class="text-muted small">Colección</span></td>
                                                <td>
                                                    <span class="label status-badge <?= $config->getMostrarRotacion() ? 'label-success' : 'label-danger' ?>">
                                                        <?= $config->getMostrarRotacion() ? 'Activo' : 'Inactivo' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_rotacion" <?= $config->getMostrarRotacion() ? 'checked' : '' ?> data-indicador="Índice de Rotación"> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Estado Físico de Colección</td>
                                                <td><span class="text-muted small">Colección</span></td>
                                                <td>
                                                    <span class="label status-badge <?= $config->getMostrarEstadoFisico() ? 'label-success' : 'label-danger' ?>">
                                                        <?= $config->getMostrarEstadoFisico() ? 'Activo' : 'Inactivo' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_estado_fisico" <?= $config->getMostrarEstadoFisico() ? 'checked' : '' ?> data-indicador="Estado Físico de Colección"> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Asistencia: Sala Estatal</td>
                                                <td><span class="text-muted small">Salas</span></td>
                                                <td>
                                                    <span class="label status-badge <?= $config->getMostrarAsistenciaEstatal() ? 'label-success' : 'label-danger' ?>">
                                                        <?= $config->getMostrarAsistenciaEstatal() ? 'Activo' : 'Inactivo' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_asistencia_estatal" <?= $config->getMostrarAsistenciaEstatal() ? 'checked' : '' ?> data-indicador="Asistencia: Sala Estatal"> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Estado de Colección (Sala Estatal)</td>
                                                <td><span class="text-muted small">Colección</span></td>
                                                <td>
                                                    <span class="label status-badge <?= $config->getMostrarColeccion() ? 'label-success' : 'label-danger' ?>">
                                                        <?= $config->getMostrarColeccion() ? 'Activo' : 'Inactivo' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_coleccion" <?= $config->getMostrarColeccion() ? 'checked' : '' ?> data-indicador="Estado de Colección (Sala Estatal)"> Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Participación en Actividades y Talleres</td>
                                                <td><span class="text-muted small">Formación</span></td>
                                                <td>
                                                    <span class="label status-badge <?= $config->getMostrarActividades() ? 'label-success' : 'label-danger' ?>">
                                                        <?= $config->getMostrarActividades() ? 'Activo' : 'Inactivo' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_actividades" <?= $config->getMostrarActividades() ? 'checked' : '' ?> data-indicador="Participación en Actividades y Talleres"> Habilitar
<<<<<<< HEAD
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Productividad de Eventos (IPE)</td>
                                                <td><span class="text-muted small">Formación</span></td>
                                                <td>
                                                    <span class="label status-badge <?= $config->getMostrarIpe() ? 'label-success' : 'label-danger' ?>">
                                                        <?= $config->getMostrarIpe() ? 'Activo' : 'Inactivo' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="ind_ipe" <?= $config->getMostrarIpe() ? 'checked' : '' ?> data-indicador="Productividad de Eventos (IPE)"> Habilitar
=======
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
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
            // Función para actualizar los badges de la tabla en tiempo real al interactuar
            function actualizarBadgeFila(checkbox) {
                let fila = $(checkbox).closest('tr');
                let badge = fila.find('.status-badge');
                if ($(checkbox).is(':checked')) {
                    badge.removeClass('label-danger').addClass('label-success').text('Activo');
                } else {
                    badge.removeClass('label-success').addClass('label-danger').text('Inactivo');
                }
            }

            // Actualizar estado del botón maestro de selección según los checkboxes individuales
            function verificarEstadoBotonMaestro() {
                let total = $('input[type="checkbox"]').length;
                let marcados = $('input[type="checkbox"]:checked').length;

                if (marcados === total) {
                    $('#txtToggleTodos').text('Desmarcar Todos');
                    $('#btnToggleTodos').data('accion', 'desmarcar');
                } else {
                    $('#txtToggleTodos').text('Seleccionar Todos');
                    $('#btnToggleTodos').data('accion', 'marcar');
                }
            }

            // Evento al cambiar un checkbox individual
            $('input[type="checkbox"]').on('change', function() {
                actualizarBadgeFila(this);
                verificarEstadoBotonMaestro();
                if ($('#confirmSaveIndicadoresModal').hasClass('show')) {
                    actualizarResumenModal();
                }
            });

            // Lógica del botón de selección/deselección masiva
            $('#btnToggleTodos').on('click', function() {
                let accion = $(this).data('accion') || 'marcar';
                let deberiaMarcar = (accion === 'marcar');

                $('input[type="checkbox"]').each(function() {
                    $(this).prop('checked', deberiaMarcar);
                    actualizarBadgeFila(this);
                });

                verificarEstadoBotonMaestro();
            });

            // Inicializar el estado del botón maestro al cargar la página
            verificarEstadoBotonMaestro();

            // Función para poblar el modal de confirmación antes de guardar
            function actualizarResumenModal() {
                let visiblesHTML = '';
                let totalVisibles = 0;
                $('input[type="checkbox"]:checked').each(function() {
                    let nombre = $(this).data('indicador');
                    visiblesHTML += '<span class="badge badge-success mr-1 mb-1" style="margin-right:5px; margin-bottom:5px; background-color:#66bb6a;">' + nombre + '</span>';
                    totalVisibles++;
                });
                $('#indicadoresVisibles').html(visiblesHTML || '<em class="text-muted">Ninguno</em>');
                $('#contadorVisibles').text(totalVisibles);

                let ocultosHTML = '';
                let totalOcultos = 0;
                $('input[type="checkbox"]:not(:checked)').each(function() {
                    let nombre = $(this).data('indicador');
                    ocultosHTML += '<span class="badge badge-danger mr-1 mb-1" style="margin-right:5px; margin-bottom:5px; background-color:#e57373;">' + nombre + '</span>';
                    totalOcultos++;
                });
                $('#indicadoresOcultos').html(ocultosHTML || '<em class="text-muted">Ninguno</em>');
                $('#contadorOcultos').text(totalOcultos);
            }

            $('#btnGuardarIndicadores').on('click', function() {
                actualizarResumenModal();
                $('#confirmSaveIndicadoresModal').modal('show');
            });
        });
    </script>
</body>
</html>