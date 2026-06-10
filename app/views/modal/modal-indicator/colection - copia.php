<div class="modal fade" id="modalColeccion" tabindex="-1" role="dialog" aria-labelledby="modalColeccionLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Encabezado con ID para cambio dinámico de color -->
            <div class="modal-header" id="modalColeccionHeader" style="color: white;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalColeccionLabel">
                    <i class="fa-solid fa-archive"></i> Estado de Actualización de la Colección
                </h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Déficit de Actualización</h4>
                        <p>Este indicador mide el porcentaje de títulos nuevos adquiridos en el último año frente a la meta de renovación bibliográfica anual.</p>
                        <div class="well well-sm">
                            <strong>Fórmula:</strong> <br>
                            (Ejemplares registrados en Sala Estatal / Total de ejemplares) × 100
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <!-- Contenedor con ID para cambios dinámicos -->
                        <div id="modalColeccionContenedorPorcentaje" style="padding: 20px; border: 2px dashed #ddd; border-radius: 10px;">
                            <h2 id="modalColeccionPorcentaje" style="margin-top: 0; font-weight: bold;"><?= $coleccionEstatal ?>%</h2>
                            <p class="text-muted" style="margin-bottom: 5px;">Nivel de Renovación Actual (<span id="modalColeccionEstadoText">--</span>)</p>
                            <div class="progress" style="margin-bottom: 0;">
                                <div id="modalColeccionBarra" class="progress-bar" style="width: <?= $coleccionEstatal ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <h4>Necesidades por Sala</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="active">
                                <th>Sala</th>
                                <th>Títulos Totales</th>
                                <th>Novedades (Recientes)</th>
                                <th>Estado</th>
                                <th>Acción Requerida</th>
                            </tr>
                        </thead>
                        <tbody id="tablaColeccionCuerpo">
                            <?php if (!empty($necesidadesColeccion)): ?>
                                <?php foreach ($necesidadesColeccion as $item): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($item['sala']) ?></strong></td>
                                    <td><?= number_format($item['titulos_totales']) ?></td>
                                    <td><?= number_format($item['novedades']) ?></td>
                                    <td><span class="label label-<?= $item['clase'] ?>"><?= $item['porcentaje'] ?>%</span></td>
                                    <td><?= htmlspecialchars($item['accion']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center">No hay datos disponibles</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" onclick="descargarPDF('Coleccion')">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Informe
                </button>
            </div>
        </div>
    </div>
</div>