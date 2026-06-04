<div class="modal fade" id="modalRotacion" tabindex="-1" role="dialog" aria-labelledby="modalRotacionLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <?php
            // Determinar color sólido dinámico basado en la lógica del dashboard
            $colorSolidoRotacion = '#5cb85c'; // Óptimo (Verde)
            $textoEstadoRotacion = 'Óptimo'; // Inicialización por defecto

            if ($rotacion < 5) {
                $colorSolidoRotacion = '#d9534f'; // Crítico (Rojo)
                $textoEstadoRotacion = 'Crítico';
            } elseif ($rotacion <= 15) {
                $colorSolidoRotacion = '#f0ad4e'; // Tolerable (Amarillo/Naranja)
                $textoEstadoRotacion = 'Tolerable';
            }
            ?>

            <div class="modal-header" id="modalRotacionHeader" style="background-color: <?= $colorSolidoRotacion ?>; color: white; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalRotacionLabel" style="color: white; font-weight: bold;">
                    <i class="fa-solid fa-rotate"></i> Análisis Detallado: Índice de Rotación
                </h4>
            </div>

            <div class="modal-body" style="padding-top: 15px;">
                <div class="row">
                    <div class="col-xs-12">
                        <div style="display: flex; width: 100%; border-radius: 6px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; font-family: sans-serif;">

                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                <?= $textoEstadoRotacion === 'Crítico' ? 'background-color: #d9534f; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #f9dbdb; font-size: 14px; opacity: 0.75;' ?>">
                                Crítico <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&lt; 5%</span>
                            </div>

                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                <?= $textoEstadoRotacion === 'Tolerable' ? 'background-color: #f0ad4e; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #fef0de; font-size: 14px; opacity: 0.75;' ?>">
                                Tolerable <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">5% - 15%</span>
                            </div>

                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                <?= $textoEstadoRotacion === 'Óptimo' ? 'background-color: #5cb85c; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #e2f3e2; font-size: 14px; opacity: 0.75;' ?>">
                                Óptimo <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&gt; 15%</span>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h4>Índice de Rotación General</h4>
                        <p class="text-justify">Mide la frecuencia con la que los libros de la colección circulan fuera de los estantes en base a los préstamos realizados.</p>
                        <div class="well well-sm">
                            <strong>Fórmula:</strong> <br>
                            (Total de Préstamos / Inventario Total) × 100
                        </div>
                    </div>

                    <div class="col-md-6 text-center">
                        <div id="modalRotacionContenedorPorcentaje" style="padding: 20px; border: 2px solid <?= $colorSolidoRotacion ?>; border-radius: 10px; background-color: #fafafa;">
                            <h2 id="modalRotacionPorcentaje" style="margin-top: 0; font-weight: bold; color: <?= $colorSolidoRotacion ?>; font-size: 36px;"><?= $rotacion ?>%</h2>
                            <p class="text-muted" style="margin-bottom: 5px; font-size: 13px;">
                                Estado del Índice de Rotación (<strong style="color: <?= $colorSolidoRotacion ?>; text-transform: uppercase;"><?= $textoEstadoRotacion ?></strong>)
                            </p>
                            <div class="progress" style="margin-bottom: 0; height: 12px; background-color: #eee;">
                                <div id="modalRotacionBarra" class="progress-bar" style="width: <?= $rotacion ?>%; background-color: <?= $colorSolidoRotacion ?>;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <h4>Rotación por Categorías</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="active">
                                <th>Categoría</th>
                                <th>Inventario</th>
                                <th>Préstamos</th>
                                <th>Rotación</th>
                            </tr>
                        </thead>
                        <tbody id="tablaRotacionCuerpo">
                            <?php if (isset($rotacionCategorias) && is_array($rotacionCategorias) && count($rotacionCategorias) > 0): ?>
                                <?php foreach ($rotacionCategorias as $cat): ?>
                                    <tr>
                                        <?php if ($cat['prestamos'] > 0): ?>
                                            <td><strong><?= htmlspecialchars($cat['categoria']) ?></strong></td>
                                            <td><?= number_format($cat['inventario']) ?></td>
                                            <td><?= number_format($cat['prestamos']) ?></td>
                                            <td><span class="label label-<?= $cat['clase'] ?>"><?= $cat['rotacion'] ?>%</span></td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No hay datos disponibles</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
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