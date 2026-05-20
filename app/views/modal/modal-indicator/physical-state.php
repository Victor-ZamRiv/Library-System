<div class="modal fade" id="modalEstadoFisico" tabindex="-1" role="dialog" aria-labelledby="modalEstadoFisicoLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- ID para cambiar dinámicamente el fondo del header -->
            <div class="modal-header" id="modalFisicoHeader" style="color: white;">
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
                            <strong>Fórmula:</strong> <br>
                            (Ejemplares en buen estado / Total ejemplares auditados) × 100
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <!-- ID para cambiar dinámicamente el color del borde y fondo de la caja informativa -->
                        <div id="modalFisicoContenedorPorcentaje" style="padding: 20px; border: 2px dashed #ddd; border-radius: 10px;">
                            <!-- ID para cambiar el texto y color del porcentaje grande -->
                            <h2 id="modalFisicoPorcentaje" style="margin-top: 0; font-weight: bold;">--%</h2>
                            <p class="text-muted" style="margin-bottom: 5px;">Promedio General (<span id="modalFisicoEstadoText">--</span>)</p>
                            <div class="progress" style="margin-bottom: 0;">
                                <!-- ID para alterar el width y la clase de color de la barra -->
                                <div id="modalFisicoBarra" class="progress-bar" style="width: 0%"></div>
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