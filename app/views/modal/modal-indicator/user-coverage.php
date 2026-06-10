<div class="modal fade" id="modalDetalleCobertura" tabindex="-1" role="dialog" aria-labelledby="modalDetalleCoberturaLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
            <?php
            // Inicialización y evaluación matemática para el comportamiento del cintillo
            $coberturaVal = isset($cobertura) ? $cobertura : 0;
            if ($coberturaVal < 40) {
                $colorDinamicoCobertura = '#d9534f'; // Crítico (Rojo)
                $textoEstadoCobertura = 'Crítico';
            } elseif ($coberturaVal < 70) {
                $colorDinamicoCobertura = '#f0ad4e'; // Tolerable (Amarillo/Naranja)
                $textoEstadoCobertura = 'Tolerable';
            } else {
                $colorDinamicoCobertura = '#5cb85c'; // Óptimo (Verde)
                $textoEstadoCobertura = 'Óptimo';
            }
            ?>
            
            <div class="modal-header" id="modalCoberturaHeader" style="background-color: <?= $colorDinamicoCobertura ?> !important; color: white; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalDetalleCoberturaLabel" style="color: white; font-weight: bold;">
                    <i class="fa-solid fa-chart-line"></i> Análisis de Cobertura de Usuarios
                </h4>
            </div>
            
            <div class="modal-body" style="padding-top: 15px;">
                <!-- CINTILLO AJUSTADO, DINÁMICO Y CON TEXTO OSCURO -->
                <div class="row">
                    <div class="col-xs-12">
                        <div style="display: flex; width: 100%; border-radius: 6px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; font-family: sans-serif;">
                            
                            <!-- Bloque Crítico -->
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoCobertura === 'Crítico' ? 'background-color: #d9534f; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #f9dbdb; font-size: 14px; opacity: 0.75;' ?>">
                                Crítico <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&lt; 40%</span>
                            </div>
                            
                            <!-- Bloque Tolerable -->
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoCobertura === 'Tolerable' ? 'background-color: #f0ad4e; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #fef0de; font-size: 14px; opacity: 0.75;' ?>">
                                Tolerable <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">40% - 70%</span>
                            </div>
                            
                            <!-- Bloque Óptimo -->
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoCobertura === 'Óptimo' ? 'background-color: #5cb85c; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #e2f3e2; font-size: 14px; opacity: 0.75;' ?>">
                                Óptimo <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&ge; 70%</span>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h4>Impacto en la Comunidad</h4>
                        <p class="text-justify">Mide el porcentaje de ciudadanos registrados en la biblioteca respecto al total de habitantes del área de influencia.</p>
                        <div class="well well-sm">
                            <strong>Fórmula:</strong> <br>
                            (Usuarios registrados en préstamos circulante / Población objetivo) × 100
                        </div>
                    </div>
                    
                    <div class="col-md-6 text-center">
                        <div id="modalCoberturaContenedorPorcentaje" style="padding: 20px; border: 2px solid <?= $colorDinamicoCobertura ?> !important; border-radius: 10px; background-color: #fafafa;">
                            <h2 id="modalCoberturaPorcentaje" style="margin-top: 0; font-weight: bold; color: <?= $colorDinamicoCobertura ?> !important; font-size: 36px;"><?= $coberturaVal ?>%</h2>
                            <p class="text-muted" style="margin-bottom: 5px; font-size: 13px;">
                                Cobertura Poblacional Actual (<strong style="color: <?= $colorDinamicoCobertura ?> !important; text-transform: uppercase;"><?= $textoEstadoCobertura ?></strong>)
                            </p>
                            <div class="progress" style="margin-bottom: 0; height: 12px; background-color: #eee;">
                                <div id="modalCoberturaBarra" class="progress-bar" style="width: <?= $coberturaVal ?>%; background-color: <?= $colorDinamicoCobertura ?> !important;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <h4>Crecimiento por Segmento</h4>
                <div class="table-responsive">
                    <table class="table table-hover" id="tablaCobertura">
                        <thead>
                            <tr class="active">
                                <th>Segmento</th>
                                <th>Total Registrados</th>
                                <th>Nuevos (Mes Actual)</th>
                                <th>Tendencia</th>
                            </tr>
                        </thead>
                        <tbody id="tablaCoberturaCuerpo">
                            <?php if (isset($segmentosCobertura) && is_array($segmentosCobertura) && count($segmentosCobertura) > 0): ?>
                                <?php foreach ($segmentosCobertura as $seg): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($seg['segmento']) ?></strong></td>
                                        <td><?= number_format($seg['total_registrados']) ?></td>
                                        <td><?= number_format($seg['nuevos_mes']) ?></td>
                                        <td>
                                            <?php if ($seg['tendencia'] == 'Alta'): ?>
                                                Alta
                                            <?php elseif ($seg['tendencia'] == 'Estable'): ?>
                                                Estable
                                            <?php else: ?>
                                                Baja
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No hay datos de cobertura disponibles</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" onclick="descargarPDF('Cobertura')">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Informe
                </button>
            </div>
        </div>
    </div>
</div>