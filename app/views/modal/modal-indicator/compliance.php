<div class="modal fade" id="modalDetalleCumplimiento" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" style="margin-top: 10px;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #5cb85c; color: white; padding: 10px 15px;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" style="font-size: 16px;">
                    <i class="fa-solid fa-gauge-high"></i> Informe Detallado de Cumplimiento
                </h4>
            </div>

            <div class="modal-body" style="padding: 10px 15px;">
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-xs-12 text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-xs btn-success btn-raised" onclick="actualizarCumplimiento('semana')">Semana</button>
                            <button type="button" class="btn btn-xs btn-info btn-raised" onclick="actualizarCumplimiento('mes')">Mes</button>
                            <button type="button" class="btn btn-xs btn-warning btn-raised" onclick="actualizarCumplimiento('trimestre')">Trimestre</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <div id="chartModalPlazos" style="margin-bottom: 10px; min-height: 180px;"></div>
                    </div>
                    
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-xs-6" style="padding: 2px;">
                                <div class="well well-sm text-center" style="margin-bottom: 4px; padding: 5px;">
                                    <h4 class="text-success" id="indLibros" style="margin:0; font-weight: bold;">95%</h4>
                                    <small style="font-size: 10px; display: block; line-height: 1;">Libros General</small>
                                </div>
                            </div>
                            <div class="col-xs-6" style="padding: 2px;">
                                <div class="well well-sm text-center" style="margin-bottom: 4px; padding: 5px;">
                                    <h4 class="text-primary" id="indAudio" style="margin:0; font-weight: bold;">88%</h4>
                                    <small style="font-size: 10px; display: block; line-height: 1;">Audiovisual</small>
                                </div>
                            </div>
                            <div class="col-xs-6" style="padding: 2px;">
                                <div class="well well-sm text-center" style="margin-bottom: 4px; padding: 5px;">
                                    <h4 class="text-warning" id="indInter" style="margin:0; font-weight: bold;">72%</h4>
                                    <small style="font-size: 10px; display: block; line-height: 1;">Interbibliotecario</small>
                                </div>
                            </div>
                            <div class="col-xs-6" style="padding: 2px;">
                                <div class="well well-sm text-center" style="margin-bottom: 4px; padding: 5px;">
                                    <h4 class="text-danger" id="indBloqueados" style="margin:0; font-weight: bold;">12</h4>
                                    <small style="font-size: 10px; display: block; line-height: 1;">Bloqueados</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr style="margin: 8px 0;">
                
                <h5 style="margin: 0 0 5px 0; font-weight: bold;"><i class="fa-solid fa-list-check"></i> Desglose de devoluciones</h5>
                
                <div class="table-responsive" style="max-height: 140px; overflow-y: auto;">
                    <table class="table table-bordered table-striped table-condensed" style="font-size: 11px; margin-bottom: 0;">
                        <thead style="position: sticky; top: 0; background: white; z-index: 1;">
                            <tr class="success">
                                <th>Categoría</th>
                                <th>Total</th>
                                <th>A Tiempo</th>
                                <th>Mora L.</th>
                                <th>Mora G.</th>
                            </tr>
                        </thead>
                        <tbody id="tablaCumplimientoCuerpo">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer" style="padding: 8px 15px;">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-sm btn-info" onclick="descargarPDF('Cumplimiento')">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Reporte
                </button>
            </div>
        </div>
    </div>
</div>