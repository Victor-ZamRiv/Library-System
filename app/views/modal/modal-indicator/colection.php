<div class="modal fade" id="modalColeccion" tabindex="-1" role="dialog" aria-labelledby="modalColeccionLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <?php
            // 1. Unificación de criterios: Menor o igual a 30% es Crítico (siguiendo el cintillo)
            if ($coleccionEstatal <= 30) {
                $colorSolido = '#d9534f'; // Crítico (Rojo)
                $textoEstadoColeccion = 'Crítico';
            } elseif ($coleccionEstatal < 70) { 
                $colorSolido = '#f0ad4e'; // Tolerable (Naranja)
                $textoEstadoColeccion = 'Tolerable';
            } else {
                $colorSolido = '#5cb85c'; // Óptimo (Verde)
                $textoEstadoColeccion = 'Óptimo';
            }
            ?>

            <div class="modal-header" id="modalColeccionHeader" style="background-color: <?= $colorSolido ?> !important; color: white; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalColeccionLabel" style="color: white; font-weight: bold;">
                    <i class="fa-solid fa-archive"></i> Estado de la Colección: Sala Estatal
                </h4>
            </div>

            <div class="modal-body" style="padding-top: 15px;">
                <div class="row">
                    <div class="col-xs-12">
                        <div style="display: flex; width: 100%; border-radius: 6px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; font-family: sans-serif;">
                            
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoColeccion === 'Crítico' ? 'background-color: #d9534f; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #f9dbdb; font-size: 14px; opacity: 0.75;' ?>">
                                Crítico <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&le; 30%</span>
                            </div>
                            
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoColeccion === 'Tolerable' ? 'background-color: #f0ad4e; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #fef0de; font-size: 14px; opacity: 0.75;' ?>">
                                Tolerable <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">30% - 70%</span>
                            </div>
                            
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoColeccion === 'Óptimo' ? 'background-color: #5cb85c; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #e2f3e2; font-size: 14px; opacity: 0.75;' ?>">
                                Óptimo <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&ge; 70%</span>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h4>Participación de la Sala Estatal</h4>
                        <p class="text-justify">Porcentaje de ejemplares que pertenecen a la Sala Estatal en relación al total de la colección de la biblioteca.</p>
                        <div class="well well-sm">
                            <strong>Fórmula:</strong> <br>
                            (Ejemplares en Sala Estatal / Total de ejemplares) × 100
                        </div>
                    </div>

                    <div class="col-md-6 text-center">
                        <div id="modalColeccionContenedorPorcentaje" style="padding: 20px; border: 2px solid <?= $colorSolido ?> !important; border-radius: 10px; background-color: #fafafa;">
                            <h2 id="modalColeccionPorcentaje" style="margin-top: 0; font-weight: bold; color: <?= $colorSolido ?> !important; font-size: 36px;"><?= $coleccionEstatal ?>%</h2>
                            <p class="text-muted" style="margin-bottom: 5px; font-size: 13px;">
                                Representación de la Sala Estatal (<strong style="color: <?= $colorSolido ?> !important; text-transform: uppercase;"><?= $textoEstadoColeccion ?></strong>)
                            </p>
                            <div class="progress" style="margin-bottom: 0; height: 12px; background-color: #eee;">
                                <div id="modalColeccionBarra" class="progress-bar" style="width: <?= $coleccionEstatal ?>%; background-color: <?= $colorSolido ?> !important;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <h4>Renovación de la colección</h4>
                <div class="table-responsive">
                    <table class="table table-hover" id="tablaColeccionReporte">
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
                            <?php
                            $estatalData = null;
                            if (isset($necesidadesColeccion) && is_array($necesidadesColeccion)) {
                                foreach ($necesidadesColeccion as $item) {
                                    if (stripos(strtoupper($item['sala']), 'ESTATAL') !== false) {
                                        $estatalData = $item;
                                        break;
                                    }
                                }
                            }
                            ?>
                            <?php if ($estatalData): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($estatalData['sala']) ?></strong></td>
                                    <td><?= number_format($estatalData['titulos_totales']) ?></td>
                                    <td><?= number_format($estatalData['novedades']) ?></td>
                                    <td><span class="label label-<?= $estatalData['clase'] ?>"><?= $estatalData['porcentaje'] ?>%</span></td>
                                    <td><?= htmlspecialchars($estatalData['accion']) ?></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No hay datos disponibles para la Sala Estatal</td>
                                </tr>
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