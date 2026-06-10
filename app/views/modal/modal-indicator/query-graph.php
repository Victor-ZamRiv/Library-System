<div class="modal fade" id="modalDetalleConsultasGrafico" tabindex="-1" role="dialog" aria-labelledby="modalDetalleConsultasGraficoLabel">
    <div class="modal-dialog modal-lg" role="document" style="margin-top: 10px;">
        <div class="modal-content" style="border-radius: 6px; overflow: hidden; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
            
            <div class="modal-header" id="modalConsultasHeader" style="background-color: #2c3e50 !important; color: white; padding: 12px 20px; border-bottom: none; transition: background-color 0.3s ease;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1; font-size: 22px; margin-top: -2px;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalDetalleConsultasGraficoLabel" style="font-size: 16px; font-weight: bold; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-chart-area"></i> ESTADÍSTICA HISTÓRICA DE CONSULTAS - <span id="modalConsultasEstadoText">EVALUANDO...</span>
                </h4>
            </div>

            <div class="modal-body" style="padding: 20px;">
                
                <div class="row">
                    <div class="col-xs-12">
                        <div style="display: flex; width: 100%; border-radius: 6px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; font-family: sans-serif;">

                            <div id="cintilloConsultasCritico" style="flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #f9dbdb; font-size: 14px; opacity: 0.75;">
                                Crítico <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&lt; 10</span>
                            </div>

                            <div id="cintilloConsultasTolerable" style="flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #fef0de; font-size: 14px; opacity: 0.75;">
                                Tolerable <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">10 - 20</span>
                            </div>

                            <div id="cintilloConsultasOptimo" style="flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #e2f3e2; font-size: 14px; opacity: 0.75;">
                                Óptimo <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&gt; 20</span>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-xs-12 text-center">
                        <div class="btn-group" style="box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <button type="button" id="btnConsultassemana" class="btn btn-sm btn-default" style="padding: 4px 16px; font-weight: 600;" onclick="actualizarTodo('semana')">SEMANA</button>
                            <button type="button" id="btnConsultasmes" class="btn btn-sm btn-default active" style="padding: 4px 16px; font-weight: 600;" onclick="actualizarTodo('mes')">MES</button>
                            <button type="button" id="btnConsultastrimestre" class="btn btn-sm btn-default" style="padding: 4px 16px; font-weight: 600;" onclick="actualizarTodo('trimestre')">TRIMESTRE</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div style="background: #ffffff; border: 1px solid #e3e3e3; padding: 10px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); margin-bottom: 20px;">
                            <div id="chartModalConsultas" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-xs-4 style-card" style="padding: 0 7px;">
                        <div style="background: #fdfdfd; border: 1px solid #e3e3e3; border-radius: 4px; padding: 10px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                            <h4 id="reporteTotal" style="margin: 0; font-weight: bold; color: #333; font-size: 20px;">--</h4>
                            <small style="font-size: 11px; color: #777; font-weight: 600; text-transform: uppercase; margin-top: 4px; display: block;">Total Consultas</small>
                        </div>
                    </div>
                    <div class="col-xs-4 style-card" style="padding: 0 7px;">
                        <div id="cardRendimiento" style="background: #fdfdfd; border: 1px solid #e3e3e3; border-radius: 4px; padding: 10px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.02); border-left: 4px solid #2c3e50; transition: border-color 0.3s ease;">
                            <h4 id="reporteCrecimiento" style="margin: 0; font-weight: bold; font-size: 20px;">--</h4>
                            <small style="font-size: 11px; color: #777; font-weight: 600; text-transform: uppercase; margin-top: 4px; display: block;">Rendimiento Global</small>
                        </div>
                    </div>
                    <div class="col-xs-4 style-card" style="padding: 0 7px;">
                        <div style="background: #fdfdfd; border: 1px solid #e3e3e3; border-radius: 4px; padding: 10px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                            <h4 id="reportePico" class="text-primary" style="margin: 0; font-weight: bold; font-size: 20px;">--</h4>
                            <small style="font-size: 11px; color: #777; font-weight: 600; text-transform: uppercase; margin-top: 4px; display: block;">Pico Más Alto</small>
                        </div>
                    </div>
                </div>

                <h5 style="margin: 15px 0 8px 0; font-weight: bold; color: #444; font-size: 12px; letter-spacing: 0.3px; text-transform: uppercase;">
                    <i class="fa-solid fa-table-columns" style="color: #2e6da4;"></i> Desglose Detallado de Registros
                </h5>
                
                <div class="table-responsive" style="max-height: 150px; overflow-y: auto; border: 1px solid #e3e3e3; border-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
                    <table class="table table-striped table-hover table-condensed" style="margin-bottom: 0; font-size: 11.5px;">
                        <thead style="position: sticky; top: 0; background: #f5f5f5; z-index: 2; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                            <tr style="color: #555;">
                                <th style="padding: 8px;">Periodo / Línea Temporal</th>
                                <th style="padding: 8px;" class="text-center">Volumen de Consultas</th>
                            </tr>
                        </thead>
                        <tbody id="tablaReporteCuerpo">
                            <tr>
                                <td colspan="2" class="text-center text-muted" style="padding: 20px;">
                                    <i class="fa-solid fa-spinner fa-spin"></i> Cargando tabla de flujo temporal...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer" style="padding: 10px 20px; background-color: #fafafa; border-top: 1px solid #eee;">
                <button type="button" class="btn btn-sm btn-default" style="font-weight: 600; padding: 5px 14px;" data-dismiss="modal">CERRAR</button>
                <button type="button" class="btn btn-sm btn-info" style="font-weight: bold;" onclick="descargarPDF('Consultas')">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Reporte
                </button>
            </div>
        </div>
    </div>
</div>