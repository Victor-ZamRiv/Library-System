<div class="modal fade" id="modalDetalleConsultasGrafico" tabindex="-1" role="dialog" aria-labelledby="modalDetalleConsultasGraficoLabel">
    <div class="modal-dialog modal-lg" role="document" style="margin-top: 10px;"> <div class="modal-content">
            <div class="modal-header" style="background-color: #2c3e50; color: white; padding: 10px 15px;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalDetalleConsultasGraficoLabel" style="font-size: 16px;">
                    <i class="fa-solid fa-chart-area"></i> Estadística Histórica de Consultas
                </h4>
            </div>

            <div class="modal-body" style="padding: 15px;">
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-xs-12 text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-xs btn-primary" onclick="actualizarTodo('semana')">Semana</button>
                            <button type="button" class="btn btn-xs btn-info" onclick="actualizarTodo('mes')">Mes</button>
                            <button type="button" class="btn btn-xs btn-warning" onclick="actualizarTodo('trimestre')">Trimestre</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div id="chartModalConsultas" style="background: #f9f9f9; border-radius: 5px; padding: 5px; margin-bottom: 10px; border: 1px solid #ddd; min-height: 200px; max-height: 250px;"></div>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-xs-4 text-center">
                        <div class="well well-sm" style="margin-bottom: 0; padding: 5px;">
                            <h4 id="reporteTotal" style="margin:0; font-weight: bold;">1,240</h4>
                            <small id="reporteLabelTotal" style="font-size: 10px;">Total</small>
                        </div>
                    </div>
                    <div class="col-xs-4 text-center">
                        <div class="well well-sm" style="margin-bottom: 0; padding: 5px;">
                            <h4 id="reporteCrecimiento" class="text-success" style="margin:0; font-weight: bold;">+12%</h4>
                            <small style="font-size: 10px;">Rendimiento</small>
                        </div>
                    </div>
                    <div class="col-xs-4 text-center">
                        <div class="well well-sm" style="margin-bottom: 0; padding: 5px;">
                            <h4 id="reportePico" class="text-primary" style="margin:0; font-weight: bold; font-size: 14px;">Martes</h4>
                            <small style="font-size: 10px;">Pico</small>
                        </div>
                    </div>
                </div>

                <h5 style="margin-top: 0; margin-bottom: 5px; font-weight: bold;">Desglose de Datos</h5>
                <div class="table-responsive" style="max-height: 150px; overflow-y: auto; border: 1px solid #eee;">
                    <table class="table table-striped table-bordered table-condensed" style="margin-bottom: 0; font-size: 12px;">
                        <thead style="position: sticky; top: 0; background: white; z-index: 1;">
                            <tr class="info">
                                <th>Periodo / Turno</th>
                                <th>Consultas</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody id="tablaReporteCuerpo">
                            </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer" style="padding: 10px;">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-sm btn-dark" style="background-color:#2c3e50; color:white;" onclick="descargarPDF('Consultas')">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Reporte
                </button>
            </div>
        </div>
    </div>
</div>