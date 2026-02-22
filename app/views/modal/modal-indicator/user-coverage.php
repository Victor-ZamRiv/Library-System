<div class="modal fade" id="modalDetalleCobertura" tabindex="-1" role="dialog" aria-labelledby="modalDetalleCoberturaLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2e6da4; color: white;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalDetalleCoberturaLabel">
                    <i class="fa-solid fa-chart-line"></i> Análisis de Cobertura de Usuarios
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Impacto en la Comunidad</h4>
                        <p>Mide el porcentaje de ciudadanos registrados en la biblioteca respecto al total de habitantes del área de influencia.</p>
                        <div class="well well-sm">
                            <strong>Población Objetivo:</strong> 50,000 Hab.<br>
                            <strong>Usuarios Registrados:</strong> 7,500<br>
                            <i class="fa-solid fa-circle-info text-info"></i> La meta ideal para el presente año es alcanzar el 20%.
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div style="padding: 20px; border: 2px dashed #2e6da4; border-radius: 10px; background-color: #f0f7fd;">
                            <h2 style="color: #2e6da4; margin-top: 0;">15%</h2>
                            <p class="text-muted">Cobertura Poblacional Actual</p>
                            <div class="progress" style="margin-bottom: 0;">
                                <div class="progress-bar progress-bar-info" style="width: 15%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <h4>Crecimiento por Segmento</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="active">
                                <th>Segmento</th>
                                <th>Total Registrados</th>
                                <th>Nuevos (Mes Actual)</th>
                                <th>Tendencia</th>
                            </tr>
                        </thead>
                        <tbody id="tablaCoberturaCuerpo">
                            <tr>
                                <td><strong>Infantil (0-12 años)</strong></td>
                                <td>1,200</td>
                                <td>45</td>
                                <td><i class="fa-solid fa-arrow-trend-up text-success"></i> Alta</td>
                            </tr>
                            <tr>
                                <td><strong>Juvenil (13-18 años)</strong></td>
                                <td>2,300</td>
                                <td>12</td>
                                <td><i class="fa-solid fa-arrow-trend-down text-danger"></i> Baja</td>
                            </tr>
                            <tr>
                                <td><strong>Adultos</strong></td>
                                <td>3,000</td>
                                <td>28</td>
                                <td><i class="fa-solid fa-minus text-muted"></i> Estable</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="descargarPDF('Cobertura')">
                    <i class="fa-solid fa-file-pdf"></i> Exportar Datos
                </button>
            </div>
        </div>
    </div>
</div>