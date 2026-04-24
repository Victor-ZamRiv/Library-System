<div class="modal fade" id="modalEstadoFisico" tabindex="-1" role="dialog" aria-labelledby="modalEstadoFisicoLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #5cb85c; color: white;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalEstadoFisicoLabel">
                    <i class="fa-solid fa-book-medical"></i> Salud de la Colección por Sala
                </h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Estado Global</h4>
                        <p>Porcentaje de libros que se encuentran en condiciones óptimas para el préstamo y consulta directa.</p>
                        <div class="well well-sm">
                            <i class="fa-solid fa-circle-info"></i> <strong>Nota:</strong> Los libros en la sala <strong>Infantil</strong> requieren revisión semanal debido al alto uso.
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div style="padding: 20px; border: 2px dashed #5cb85c; border-radius: 10px; background-color: #f9fff9;">
                            <h2 style="color: #5cb85c; margin-top: 0;">92%</h2>
                            <p class="text-muted">Promedio General</p>
                            <div class="progress" style="margin-bottom: 0;">
                                <div class="progress-bar progress-bar-success" style="width: 92%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <h4>Desglose por Salas</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="active">
                                <th>Sala</th>
                                <th>Total Libros</th>
                                <th>Buen Estado</th>
                                <th>En Reparación</th>
                                <th>Salud Física</th>
                            </tr>
                        </thead>
                        <tbody id="tablaSaludCuerpo">
                            <tr>
                                <td><strong>General</strong></td>
                                <td>8,500</td>
                                <td>8,100</td>
                                <td>400</td>
                                <td><span class="label label-success">95.2%</span></td>
                            </tr>
                            <tr>
                                <td><strong>Referencia</strong></td>
                                <td>1,200</td>
                                <td>1,185</td>
                                <td>15</td>
                                <td><span class="label label-success">98.7%</span></td>
                            </tr>
                            <tr>
                                <td><strong>Estatal</strong></td>
                                <td>3,400</td>
                                <td>3,000</td>
                                <td>400</td>
                                <td><span class="label label-warning">88.2%</span></td>
                            </tr>
                            <tr>
                                <td><strong>Infantil</strong></td>
                                <td>2,100</td>
                                <td>1,800</td>
                                <td>300</td>
                                <td><span class="label label-danger">85.7%</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" onclick="descargarPDF('Salud')">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Informe
                </button>
            </div>
        </div>
    </div>
</div>