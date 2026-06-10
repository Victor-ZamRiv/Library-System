<div class="modal fade" id="modalDetalleCumplimiento" tabindex="-1" role="dialog" aria-labelledby="modalDetalleCumplimientoLabel">
    <div class="modal-dialog modal-lg" role="document" style="margin-top: 10px;">
        <div class="modal-content">

            <div id="modalCumplimientoHeader" class="modal-header" style="background-color: #777777 !important; color: white; padding: 12px 15px; border-top-left-radius: 5px; border-top-right-radius: 5px; transition: background-color 0.3s ease;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white; opacity:1;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalDetalleCumplimientoLabel" style="font-weight: bold; font-size: 15px;">
                    <i class="fa-solid fa-chart-pie"></i> Análisis de Cumplimiento - <span id="modalCumplimientoEstadoText">EVALUANDO...</span>
                </h4>
            </div>

            <div class="modal-body" style="padding: 15px; padding-top: 15px;">

                <div class="row">
                    <div class="col-xs-12">
                        <div style="display: flex; width: 100%; border-radius: 6px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; font-family: sans-serif;">

                            <div id="cintilloCritico" style="flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #f9dbdb; font-size: 14px; opacity: 0.75;">
                                Crítico <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&le; 70%</span>
                            </div>

                            <div id="cintilloTolerable" style="flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #fef0de; font-size: 14px; opacity: 0.75;">
                                Tolerable <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">70% - 90%</span>
                            </div>

                            <div id="cintilloOptimo" style="flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #e2f3e2; font-size: 14px; opacity: 0.75;">
                                Óptimo <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&ge; 90%</span>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-xs-12 text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-xs btn-default" style="padding: 4px 12px;" onclick="actualizarCumplimiento('semana')">Semana</button>
                            <button type="button" class="btn btn-xs btn-default" style="padding: 4px 12px;" onclick="actualizarCumplimiento('mes')">Mes</button>
                            <button type="button" class="btn btn-xs btn-default" style="padding: 4px 12px;" onclick="actualizarCumplimiento('trimestre')">Trimestre</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <div id="chartModalPlazos" style="background: #fafafa; border: 1px solid #e3e3e3; border-radius: 10px; padding: 5px; margin-bottom: 15px; min-height: 180px;"></div>
                    </div>

                    <div class="col-md-7">
                        <div class="row" style="margin-bottom: 12px;">
                            <div class="col-xs-6" style="padding: 4px;">
                                <div class="well well-sm text-center" style="margin-bottom: 0; padding: 10px; border-radius: 6px; border: 1px solid #e3e3e3; background: #fff;">
                                    <h4 id="totalPrestamos" style="margin: 0; font-weight: bold; color: #333;">--</h4>
                                    <small style="font-size: 10px; display: block; margin-top: 4px; color: #777; font-weight: bold; text-transform: uppercase;">Total Préstamos</small>
                                </div>
                            </div>
                            <div class="col-xs-6" style="padding: 4px;">
                                <div class="well well-sm text-center" style="margin-bottom: 0; padding: 10px; border-radius: 6px; border: 1px solid #e3e3e3; background: #fff; border-left: 3px solid #5cb85c;">
                                    <h4 id="prestamosDevueltos" style="margin: 0; font-weight: bold;">--</h4>
                                    <small style="font-size: 10px; display: block; margin-top: 4px; color: #777; font-weight: bold; text-transform: uppercase;">Devueltos</small>
                                </div>
                            </div>
                            <div class="col-xs-6" style="padding: 4px;">
                                <div class="well well-sm text-center" style="margin-bottom: 0; padding: 10px; border-radius: 6px; border: 1px solid #e3e3e3; background: #fff; border-left: 3px solid #d9534f;">
                                    <h4 id="prestamosVencidos" style="margin: 0; font-weight: bold;">--</h4>
                                    <small style="font-size: 10px; display: block; margin-top: 4px; color: #777; font-weight: bold; text-transform: uppercase;">Vencidos</small>
                                </div>
                            </div>
                            <div class="col-xs-6" style="padding: 4px;">
                                <div class="well well-sm text-center" style="margin-bottom: 0; padding: 10px; border-radius: 6px; border: 1px solid #e3e3e3; background: #fff; border-left: 3px solid #f0ad4e;">
                                    <h4 id="totalRenovaciones" style="margin: 0; font-weight: bold;">--</h4>
                                    <small style="font-size: 10px; display: block; margin-top: 4px; color: #777; font-weight: bold; text-transform: uppercase;">Renovaciones</small>
                                </div>
                            </div>
                        </div>

                        <h5 style="margin-top: 10px; margin-bottom: 8px; font-weight: bold; color: #444;" class="text-uppercase">Desglose por Categorías</h5>
                        <div class="table-responsive" style="max-height: 160px; overflow-y: auto; border: 1px solid #e3e3e3; border-radius: 6px;">
                            <table class="table table-striped table-hover table-condensed" id="tablaDetalleCumplimiento" style="margin-bottom: 0; font-size: 11px;">
                                <thead style="position: sticky; top: 0; background: #fff; z-index: 1; border-bottom: 2px solid #ddd;">
                                    <tr class="active">
                                        <th style="padding: 6px; font-weight: bold; color: #555;">Categoría</th>
                                        <th class="text-center" style="padding: 6px; font-weight: bold; color: #555;">Total</th>
                                        <th class="text-center" style="padding: 6px; font-weight: bold; color: #555;">A Tiempo</th>
                                        <th class="text-center" style="padding: 6px; font-weight: bold; color: #555;">M. Leve</th>
                                        <th class="text-center" style="padding: 6px; font-weight: bold; color: #555;">M. Grave</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyDetalleCumplimiento">
                                    <tr>
                                        <td colspan="5" class="text-center text-muted" style="padding: 12px; font-style: italic;">
                                            <i class="fa-solid fa-spinner fa-spin"></i> Cargando datos detallados...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal-footer" style="padding: 10px 15px; background-color: #fafafa; border-top: 1px solid #eee;">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-sm btn-info" style="font-weight: bold;" onclick="descargarPDF('Cumplimiento')">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Reporte
                </button>
            </div>
        </div>
    </div>
</div>