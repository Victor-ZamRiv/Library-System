<div class="modal fade" id="modalDetalleOcupacion" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document" style="margin-top: 10px;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2e6da4; color: white; padding: 10px 15px;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" style="font-size: 16px;">
                    <i class="fa-solid fa-building-user"></i> Capacidad y Uso de Espacios
                </h4>
            </div>

            <div class="modal-body" style="padding: 10px 15px;">
                <div class="row" style="margin-bottom: 8px;">
                    <div class="col-xs-12 text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-xs btn-primary" onclick="actualizarOcupacion('semana')">Semana</button>
                            <button type="button" class="btn btn-xs btn-info" onclick="actualizarOcupacion('mes')">Mes</button>
                            <button type="button" class="btn btn-xs btn-warning" onclick="actualizarOcupacion('trimestre')">Trimestre</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="chartModalOcupacion" style="background: #fdfdfd; border: 1px solid #eee; padding: 5px; border-radius: 4px; max-height: 220px; min-height: 180px;"></div>
                    </div>
                </div>

                <h5 style="margin: 10px 0 5px 0; font-weight: bold;">
                    <i class="fa-solid fa-table-columns"></i> Análisis de Aforo por Sala
                </h5>

                <div class="table-responsive" style="max-height: 150px; overflow-y: auto; border: 1px solid #ddd;">
                    <table class="table table-hover table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
                        <thead style="position: sticky; top: 0; background: #f9f9f9; z-index: 1;">
                            <tr class="active">
                                <th>Sala</th>
                                <th>Cap. Máx.</th>
                                <th>Pico</th>
                                <th>Promedio</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody id="tablaOcupacionCuerpo">
                            </tbody>
                    </table>
                </div>

                <div class="alert alert-info" style="border-left: 5px solid #2e6da4; margin: 8px 0 0 0; padding: 5px 10px; font-size: 11px;">
                    <i class="fa-solid fa-info-circle"></i> <strong>Nota:</strong> Datos promediados según el periodo seleccionado.
                </div>
            </div>

            <div class="modal-footer" style="padding: 8px 15px;">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-sm btn-info" onclick="descargarPDF('Ocupacion')">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Reporte
                </button>
            </div>
        </div>
    </div>
</div>