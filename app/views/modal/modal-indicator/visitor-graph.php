<div class="modal fade" id="modalDetalleConsultasGrafico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #2e6da4; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <i class="fa-solid fa-circle-info"></i> Detalle de Consultas y Obras
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="well well-sm text-center">
                            <h5 class="text-uppercase">Total Periodo</h5>
                            <h3 class="text-primary">210</h3>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="well well-sm text-center">
                            <h5 class="text-uppercase">Más concurrido</h5>
                            <h3 class="text-success">Jueves</h3>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="well well-sm text-center">
                            <h5 class="text-uppercase">Tendencia</h5>
                            <h3 class="text-warning"><i class="fa-solid fa-arrow-up"></i> 12%</h3>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr class="info">
                                <th>Periodo / Día</th>
                                <th>Consultas Niños</th>
                                <th>Consultas Adultos</th>
                                <th>Total Obras</th>
                                <th>% Participación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Lunes</td>
                                <td>10</td>
                                <td>30</td>
                                <td><strong>40</strong></td>
                                <td>19%</td>
                            </tr>
                            <tr>
                                <td>Martes</td>
                                <td>15</td>
                                <td>30</td>
                                <td><strong>45</strong></td>
                                <td>21%</td>
                            </tr>
                            <tr>
                                <td>Miércoles</td>
                                <td>8</td>
                                <td>30</td>
                                <td><strong>38</strong></td>
                                <td>18%</td>
                            </tr>
                            </tbody>
                        <tfoot>
                            <tr class="active">
                                <th colspan="3" class="text-right">TOTAL ACUMULADO:</th>
                                <th colspan="2" class="text-primary">123 Obras</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-raised" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-raised"><i class="fa-solid fa-file-pdf"></i> Exportar PDF</button>
            </div>
        </div>
    </div>
</div>