<div class="modal fade" id="modalColeccion" tabindex="-1" role="dialog" aria-labelledby="modalColeccionLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #d9534f; color: white;">
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
                        <div class="well well-sm" style="border-left: 5px solid #d9534f;">
                            <i class="fa-solid fa-circle-exclamation text-danger"></i> <strong>Alerta:</strong> El 65% de la colección tiene más de 10 años sin actualización en áreas críticas.
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div style="padding: 20px; border: 2px dashed #d9534f; border-radius: 10px; background-color: #fdf7f7;">
                            <h2 style="color: #d9534f; margin-top: 0;">35%</h2>
                            <p class="text-muted">Nivel de Renovación Actual</p>
                            <div class="progress" style="margin-bottom: 0;">
                                <div class="progress-bar progress-bar-danger" style="width: 35%"></div>
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
                                <th>Novedades (2024-25)</th>
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