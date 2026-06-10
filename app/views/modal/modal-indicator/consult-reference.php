<div class="modal fade" id="modalDetalleReferencia" tabindex="-1" role="dialog" aria-labelledby="modalDetalleReferenciaLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
            <?php
            // Inicialización de seguridad y evaluación del Ratio de Referencia
            $razonRefVal = isset($razonReferencia) ? (float)$razonReferencia : 0.0;
            
            if ($razonRefVal <= 1.0) {
                $colorDinamicoReferencia = '#d9534f'; // Crítico (Rojo)
                $textoEstadoReferencia = 'Crítico';
            } elseif ($razonRefVal < 2.0) {
                $colorDinamicoReferencia = '#f0ad4e'; // Tolerable (Amarillo/Naranja)
                $textoEstadoReferencia = 'Tolerable';
            } else {
                $colorDinamicoReferencia = '#5cb85c'; // Óptimo (Verde)
                $textoEstadoReferencia = 'Óptimo';
            }
            ?>
            
            <div class="modal-header" id="modalReferenciaHeader" style="background-color: <?= $colorDinamicoReferencia ?> !important; color: white; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalDetalleReferenciaLabel" style="color: white; font-weight: bold;">
                    <i class="fa-solid fa-magnifying-glass"></i> Detalle: Consultas de Referencia
                </h4>
            </div>
            
            <div class="modal-body" style="padding-top: 15px;">
                <div class="row">
                    <div class="col-xs-12">
                        <div style="display: flex; width: 100%; border-radius: 6px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; font-family: sans-serif;">
                            
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoReferencia === 'Crítico' ? 'background-color: #d9534f; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #f9dbdb; font-size: 14px; opacity: 0.75;' ?>">
                                Crítico <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&le; 1.0</span>
                            </div>
                            
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoReferencia === 'Tolerable' ? 'background-color: #f0ad4e; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #fef0de; font-size: 14px; opacity: 0.75;' ?>">
                                Tolerable <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">1.1 - 2.0</span>
                            </div>
                            
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoReferencia === 'Óptimo' ? 'background-color: #5cb85c; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #e2f3e2; font-size: 14px; opacity: 0.75;' ?>">
                                Óptimo <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&ge; 2.0</span>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h4>Ratio de Referencia</h4>
                        <p class="text-justify">Representa la cantidad promedio de consultas que realiza cada usuario activo en el servicio de orientación bibliográfica.</p>
                        <div class="well well-sm">
                            <strong>Total Consultas Mes:</strong> <?= number_format($totalConsultasMes ?? 0) ?><br>
                            <strong>Usuarios que Consultaron:</strong> <?= number_format($usuariosConsultaron ?? 0) ?><br>
                            <strong>Promedio:</strong> <?= $razonRefVal ?> consultas/usuario
                        </div>
                    </div>
                    
                    <div class="col-md-6 text-center">
                        <div id="modalReferenciaContenedorPorcentaje" style="padding: 20px; border: 2px solid <?= $colorDinamicoReferencia ?> !important; border-radius: 10px; background-color: #fafafa;">
                            <h2 id="modalReferenciaPorcentaje" style="margin-top: 0; font-weight: bold; color: <?= $colorDinamicoReferencia ?> !important; font-size: 36px;"><?= $razonRefVal ?></h2>
                            <p class="text-muted" style="margin-bottom: 5px; font-size: 13px;">
                                Ratio de Consultas por Usuario (<strong style="color: <?= $colorDinamicoReferencia ?> !important; text-transform: uppercase;"><?= $textoEstadoReferencia ?></strong>)
                            </p>
                            <div class="progress" style="margin-bottom: 0; height: 12px; background-color: #eee;">
                                <div id="modalReferenciaBarra" class="progress-bar" style="width: <?= min(($razonRefVal * 35), 100) ?>%; background-color: <?= $colorDinamicoReferencia ?> !important;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <h4>Top Temáticas Consultadas</h4>
                <div class="table-responsive">
                    <table class="table table-hover" id="tablaReferencia">
                        <thead>
                            <tr class="active">
                                <th>Área del Conocimiento</th>
                                <th>Consultas</th>
                                <th>Eficiencia de Respuesta</th>
                            </tr>
                        </thead>
                        <tbody id="tablaReferenciaCuerpo">
                            <?php if (isset($topTematicas) && is_array($topTematicas) && count($topTematicas) > 0): ?>
                                <?php foreach ($topTematicas as $item): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($item['area']) ?></strong></td>
                                        <td><?= number_format($item['consultas']) ?></td>
                                        <td><?= isset($item['eficiencia']) ? htmlspecialchars($item['eficiencia']) : '100% Óptimo' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No hay datos de consultas disponibles</td>
                                </tr>
                            <?php endif; ?>
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