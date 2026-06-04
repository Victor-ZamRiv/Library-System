<div class="modal fade" id="modalDetalleOcupacion" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" style="margin-top: 10px;">
        <div class="modal-content" style="border-radius: 6px; overflow: hidden; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">

            <div id="modalOcupacionHeader" class="modal-header" style="background: #f0ad4e; color: white; padding: 12px 20px; border-bottom: none; transition: background-color 0.3s ease;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1; font-size: 22px; margin-top: -2px;"><span>&times;</span></button>
                <h4 class="modal-title" style="font-size: 16px; font-weight: bold; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-building-user"></i> CAPACIDAD Y USO DE ESPACIOS (AFORO) - <span id="modalOcupacionEstadoText">EVALUANDO...</span>
                </h4>
            </div>

            <div class="modal-body" style="padding: 20px;">

                <!-- Cintillo Estilizado -->
                <div class="row">
                    <div class="col-xs-12">
                        <div style="display: flex; width: 100%; border-radius: 6px; overflow: hidden; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; font-family: sans-serif;">

                            <div id="cintilloOcupacionCritico" style="flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #f9dbdb; font-size: 14px; opacity: 0.75;">
                                Crítico <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&le; 30%</span>
                            </div>

                            <div id="cintilloOcupacionTolerable" style="flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #fef0de; font-size: 14px; opacity: 0.75;">
                                Tolerable <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">40% - 70%</span>
                            </div>

                            <div id="cintilloOcupacionOptimo" style="flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #e2f3e2; font-size: 14px; opacity: 0.75;">
                                Óptimo <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&ge; 70%</span>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Botones con diseño unificado (btn-xs y padding idéntico) -->
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-xs-12 text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-xs btn-default" style="padding: 4px 12px;" onclick="actualizarOcupacion('semana')">Semana</button>
                            <button type="button" class="btn btn-xs btn-default active" style="padding: 4px 12px;" onclick="actualizarOcupacion('mes')">Mes</button>
                            <button type="button" class="btn btn-xs btn-default" style="padding: 4px 12px;" onclick="actualizarOcupacion('trimestre')">Trimestre</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <div style="background: #ffffff; border: 1px solid #e3e3e3; padding: 15px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); height: 260px; display: flex; align-items: center; justify-content: center;">
                            <div id="chartModalOcupacion" style="width: 100%;"></div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-xs-6" style="padding-right: 7px;">
                                <div style="background: #fdfdfd; border: 1px solid #e3e3e3; border-radius: 4px; padding: 10px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                                    <span style="font-size: 20px; font-weight: bold; color: #333;" id="totalAsistenciasPeriodo">0</span>
                                    <p style="margin: 0; font-size: 11px; color: #777; font-weight: 600;">Asistencias Totales</p>
                                </div>
                            </div>
                            <div class="col-xs-6" style="padding-left: 7px;">
                                <div style="background: #fdfdfd; border: 1px solid #e3e3e3; border-radius: 4px; padding: 10px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                                    <span style="font-size: 20px; font-weight: bold; color: #f0ad4e;" id="promedioOcupacionGlobal">0%</span>
                                    <p style="margin: 0; font-size: 11px; color: #777; font-weight: 600;">Ocupación Promedio</p>
                                </div>
                            </div>
                        </div>

                        <h5 style="margin: 0 0 8px 0; font-weight: bold; color: #444; font-size: 12px; letter-spacing: 0.3px; text-transform: uppercase;">
                            <i class="fa-solid fa-table-columns" style="color: #f0ad4e;"></i> Desglose por Sala
                        </h5>

                        <div class="table-responsive" style="max-height: 180px; overflow-y: auto; border: 1px solid #e3e3e3; border-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
                            <table class="table table-hover table-striped table-condensed" style="font-size: 11.5px; margin-bottom: 0;">
                                <thead style="position: sticky; top: 0; background: #f5f5f5; z-index: 2; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                    <tr style="color: #555;">
                                        <th style="padding: 8px;">Sala</th>
                                        <th class="text-center" style="padding: 8px;">Cap. Máxima</th>
                                        <th class="text-center" style="padding: 8px;">Ocupación Pico</th>
                                        <th class="text-center" style="padding: 8px;">Promedio</th>
                                        <th class="text-center" style="padding: 8px;">Estado</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaOcupacionCuerpo">
                                    <tr>
                                        <td colspan="5" class="text-center text-muted" style="padding: 20px;">
                                            <i class="fa-solid fa-spinner fa-spin"></i> Cargando...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info" style="border-left: 5px solid #2e6da4; margin: 8px 0 0 0; padding: 5px 10px; font-size: 11px;">
                    <i class="fa-solid fa-info-circle"></i> <strong>Nota:</strong> Datos promediados según el periodo seleccionado.
                </div>
            </div>

            <div class="modal-footer" style="background: #fafafa; border-top: 1px solid #eee; padding: 10px 20px;">
                <button type="button" class="btn btn-sm btn-default" style="font-weight: 600; padding: 5px 14px;" data-dismiss="modal">CERRAR</button>
                <button type="button" class="btn btn-sm btn-info" onclick="descargarPDF('Ocupacion')">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Reporte
                </button>
            </div>
        </div>
    </div>
</div>