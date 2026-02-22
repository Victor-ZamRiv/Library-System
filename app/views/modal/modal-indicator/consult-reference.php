<div class="modal fade" id="modalDetalleReferencia" tabindex="-1" role="dialog" aria-labelledby="modalDetalleReferenciaLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #5bc0de; color: white;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalDetalleReferenciaLabel">
                    <i class="fa-solid fa-magnifying-glass"></i> Detalle: Consultas de Referencia
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Ratio de Referencia</h4>
                        <p>Representa la cantidad promedio de consultas que realiza cada usuario activo en el servicio de orientación bibliográfica.</p>
                        <div class="well well-sm">
                            <strong>Total Consultas Mes:</strong> 480<br>
                            <strong>Usuarios que Consultaron:</strong> 200<br>
                            <strong>Promedio:</strong> 2.4 consultas/usuario
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div style="padding: 20px; border: 2px dashed #5bc0de; border-radius: 10px; background-color: #faffff;">
                            <h2 style="color: #31b0d5; margin-top: 0;">2.4</h2>
                            <p class="text-muted">Consultas por Usuario</p>
                            <i class="fa-solid fa-users-rectangle" style="font-size: 40px; color: #5bc0de;"></i>
                        </div>
                    </div>
                </div>
                <hr>
                <h4>Top Temáticas Consultadas</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="active">
                                <th>Área del Conocimiento</th>
                                <th>Consultas</th>
                                <th>Eficiencia de Respuesta</th>
                            </tr>
                        </thead>
                        <tbody id="tablaReferenciaCuerpo">
                            <tr>
                                <td>Ciencias Sociales</td>
                                <td>150</td>
                                <td><span class="label label-success">95%</span></td>
                            </tr>
                            <tr>
                                <td>Tecnología y Medicina</td>
                                <td>120</td>
                                <td><span class="label label-warning">80%</span></td>
                            </tr>
                            <tr>
                                <td>Literatura y Arte</td>
                                <td>210</td>
                                <td><span class="label label-success">98%</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" onclick="descargarPDF('Referencia')">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Informe
                </button>
            </div>
        </div>
    </div>
</div>