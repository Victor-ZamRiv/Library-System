<div class="modal fade" id="modalColeccion" tabindex="-1" role="dialog" aria-labelledby="modalColeccionLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- ID para reescribir dinámicamente el color de fondo del encabezado -->
            <div class="modal-header" id="modalColeccionHeader" style="color: white;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalColeccionLabel">
                    <i class="fa-solid fa-archive"></i> Estado de Actualización de la Colección
                </h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Déficit de Actualización</h4>
                        <p>Este indicador mide el porcentaje de títulos nuevos adquiridos en el último año frente a la meta de renovación bibliográfica anual.</p>
                        <!-- ID para cambiar dinámicamente el color del borde izquierdo y adaptar la alerta -->
                        <div class="well well-sm">
                            <strong>Fórmula:</strong> <br>
                            (Ejemplares registrados en Sala Estatal / Total de ejemplares) x 100
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <!-- ID para alterar el color de los bordes y el fondo de la caja del indicador -->
                        <div id="modalColeccionContenedorPorcentaje" style="padding: 20px; border: 2px dashed #ddd; border-radius: 10px;">
                            <!-- ID para renderizar el porcentaje real -->
                            <h2 id="modalColeccionPorcentaje" style="margin-top: 0; font-weight: bold;">--%</h2>
                            <p class="text-muted" style="margin-bottom: 5px;">Nivel de Renovación Actual (<span id="modalColeccionEstadoText">--</span>)</p>
                            <div class="progress" style="margin-bottom: 0;">
                                <!-- ID para empujar la barra con el porcentaje real y aplicar la clase Bootstrap correspondiente -->
                                <div id="modalColeccionBarra" class="progress-bar" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <h4>Necesidades por Sala</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="active">
                                <th>Sala</th>
                                <th>Títulos Totales</th>
                                <th>Novedades (Recientes)</th>
                                <th>Estado</th>
                                <th>Acción Requerida</th>
                            </tr>
                        </thead>
                        <tbody id="tablaColeccionCuerpo">
                            <tr>
                                <td><strong>General</strong></td>
                                <td>8,500</td>
                                <td>120</td>
                                <td><span class="label label-danger">Crítico</span></td>
                                <td class="text-danger">Compra urgente</td>
                            </tr>
                            <tr>
                                <td><strong>Referencia</strong></td>
                                <td>1,200</td>
                                <td>45</td>
                                <td><span class="label label-warning">Bajo</span></td>
                                <td class="text-warning">Actualizar enciclopedias</td>
                            </tr>
                            <tr>
                                <td><strong>Estatal</strong></td>
                                <td>3,400</td>
                                <td>210</td>
                                <td><span class="label label-success">Aceptable</span></td>
                                <td class="text-success">Donaciones recibidas</td>
                            </tr>
                            <tr>
                                <td><strong>Infantil</strong></td>
                                <td>2,100</td>
                                <td>30</td>
                                <td><span class="label label-danger">Muy Crítico</span></td>
                                <td class="text-danger">Renovación total</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" onclick="descargarPDF('Coleccion')">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Informe
                </button>
            </div>
        </div>
    </div>
</div>