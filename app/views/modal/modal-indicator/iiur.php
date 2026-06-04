<div class="modal fade" id="modalDetalleIiur" tabindex="-1" role="dialog" aria-labelledby="modalIiurLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <?php
            // Datos reales desde el controlador (se espera $iiur)
            $valorIiur = $iiur['valor'] ?? 0;
            $desgloseIiur = $iiur['desglose'] ?? [];

            // Lógica de estado y color según rangos
            if ($valorIiur >= 2.0) {
                $colorDinamicoIiur = '#5cb85c';
                $textoEstadoIiur = 'LOGRADO';
            } elseif ($valorIiur >= 1.0) {
                $colorDinamicoIiur = '#f0ad4e';
                $textoEstadoIiur = 'EN PROCESO';
            } else {
                $colorDinamicoIiur = '#d9534f';
                $textoEstadoIiur = 'CRÍTICO';
            }
            ?>

            <div class="modal-header" style="background-color: <?= $colorDinamicoIiur ?>; color: white; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalIiurLabel" style="color: white; font-weight: bold;">
                    <i class="fa-solid fa-chart-line"></i> Intensidad de Uso (IIUR)
                </h4>
            </div>

            <div class="modal-body" style="padding-top: 15px;">
                <!-- Barra de Estados -->
                <div class="row">
                    <div class="col-xs-12">
                        <div style="display: flex; width: 100%; border-radius: 6px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; font-family: sans-serif;">
                            
                            <div style="flex: 1; padding: 12px; transition: all 0.3s ease;
                                <?= $textoEstadoIiur === 'LOGRADO' ? 'background-color: #5cb85c; color: white; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #e2f3e2; color: #444; font-size: 14px; opacity: 0.75;' ?>">
                                LOGRADO <span style="display: block; font-size: 12px; font-weight: normal; color: #444;">≥ 2.0</span>
                            </div>

                            <div style="flex: 1; padding: 12px; transition: all 0.3s ease;
                                <?= $textoEstadoIiur === 'EN PROCESO' ? 'background-color: #f0ad4e; color: white; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #fef0de; color: #444; font-size: 14px; opacity: 0.75;' ?>">
                                EN PROCESO <span style="display: block; font-size: 12px; font-weight: normal; color: #444;">1.0 - 1.9</span>
                            </div>

                            <div style="flex: 1; padding: 12px; transition: all 0.3s ease;
                                <?= $textoEstadoIiur === 'CRÍTICO' ? 'background-color: #d9534f; color: white; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #f9dbdb; color: #444; font-size: 14px; opacity: 0.75;' ?>">
                                CRÍTICO <span style="display: block; font-size: 12px; font-weight: normal; color: #444;">&lt; 1.0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p class="text-justify">Mide la relación entre consultas y ejemplares para optimizar la eficiencia de uso de la colección.</p>
                        <div class="well well-sm">
                            <strong>Fórmula:</strong> <br>
                            Total Consultas / Total Ejemplares (último mes)
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div style="padding: 20px; border: 2px solid <?= $colorDinamicoIiur ?>; border-radius: 10px; background-color: #fafafa;">
                            <h2 style="margin-top: 0; font-weight: bold; color: <?= $colorDinamicoIiur ?>; font-size: 36px;"><?= number_format($valorIiur, 2) ?></h2>
                            <p class="text-muted" style="margin-bottom: 5px; font-size: 13px;">
                                Intensidad: <strong style="color: <?= $colorDinamicoIiur ?>; text-transform: uppercase;"><?= $textoEstadoIiur ?></strong>
                            </p>
                        </div>
                    </div>
                </div>

                <hr>

                <h4>Desglose por Área de Conocimiento</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="active">
                                <th>Área</th>
                                <th>Consultas</th>
                                <th>Ejemplares</th>
                                <th>Índice</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody id="tablaIiurCuerpo">
                            <?php if (!empty($desgloseIiur)): ?>
                                <?php foreach ($desgloseIiur as $item): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($item['area']) ?></strong></td>
                                        <td class="text-center"><?= number_format($item['consultas']) ?></td>
                                        <td class="text-center"><?= number_format($item['ejemplares']) ?></td>
                                        <td class="text-center font-weight-bold"><?= $item['iiur'] ?></td>
                                        <td class="text-center"><span class="label label-<?= $item['clase'] ?>"><?= $item['texto'] ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center">No hay datos disponibles para el período.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" onclick="descargarPDF('Iiur')">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Informe
                </button>
            </div>
        </div>
    </div>
</div>