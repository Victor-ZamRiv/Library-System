<div class="modal fade" id="modalRotacion" tabindex="-1" role="dialog" aria-labelledby="modalRotacionLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #d9534f; color: white;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalRotacionLabel">
                    <i class="fa-solid fa-rotate"></i> Análisis Detallado: Índice de Rotación
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>¿Cómo se calcula?</h4>
                        <p>El índice de rotación mide cuántas veces circula la colección en relación al total de ejemplares disponibles.</p>
                        <div class="well well-sm">
                            <strong>Fórmula:</strong> <br>
                            (Préstamos Totales / Total de Libros en Inventario) X 100
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div style="padding: 20px; border: 2px dashed #eee; border-radius: 10px;">
                            <h2 class="text-danger">24%</h2>
                            <p class="text-muted">Estado Actual: <strong>Crítico</strong></p>
                            <div class="progress">
                                <div class="progress-bar progress-bar-danger" style="width: 24%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <h4>Desglose por Categorías</h4>
                <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>Categoría</th>
                            <th>Inventario</th>
                            <th>Préstamos</th>
                            <th>Rotación</th>
                        </tr>
                    </thead>
                    <tbody id="tablaRotacionCuerpo">
                        <tr>
                            <td>Literatura</td>
                            <td>1,200</td>
                            <td>450</td>
                            <td><span class="text-warning">37%</span></td>
                        </tr>
                        <tr>
                            <td>Ciencias Exactas</td>
                            <td>800</td>
                            <td>85</td>
                            <td><span class="text-danger">10%</span></td>
                        </tr>
                        <tr>
                            <td>Historia</td>
                            <td>500</td>
                            <td>120</td>
                            <td><span class="text-danger">24%</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" onclick="descargarPDF('Rotacion')">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Informe
                </button>
            </div>
        </div>
    </div>
</div>