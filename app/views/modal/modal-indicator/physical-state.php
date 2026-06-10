<div class="modal fade" id="modalEstadoFisico" tabindex="-1" role="dialog" aria-labelledby="modalEstadoFisicoLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
            <?php 
            // Determinar color sólido dinámico basado en la lógica del dashboard
            $colorSolidoFisico = '#5cb85c'; // Óptimo (Verde)
            $textoEstadoFisico = 'Óptimo'; // Inicialización por defecto

            if ($estadoFisico <= 30) {
                $colorSolidoFisico = '#d9534f'; // Crítico (Rojo)
                $textoEstadoFisico = 'Crítico';
            } elseif ($estadoFisico < 70) {
                $colorSolidoFisico = '#f0ad4e'; // Tolerable (Amarillo/Naranja)
                $textoEstadoFisico = 'Tolerable';
            }
            ?>

            <div class="modal-header" id="modalFisicoHeader" style="background-color: <?= $colorSolidoFisico ?>; color: white; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalEstadoFisicoLabel" style="color: white; font-weight: bold;">
                    <i class="fa-solid fa-book-medical"></i> Salud de la Colección por Sala
                </h4>
            </div>

            <div class="modal-body" style="padding-top: 15px;">
                <div class="row">
                    <div class="col-xs-12">
                        <div style="display: flex; width: 100%; border-radius: 6px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; font-family: sans-serif;">
                            
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoFisico === 'Crítico' ? 'background-color: #d9534f; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #f9dbdb; font-size: 14px; opacity: 0.75;' ?>">
                                Crítico <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&le; 30%</span>
                            </div>
                            
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoFisico === 'Tolerable' ? 'background-color: #f0ad4e; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #fef0de; font-size: 14px; opacity: 0.75;' ?>">
                                Tolerable <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">31% - 69%</span>
                            </div>
                            
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoFisico === 'Óptimo' ? 'background-color: #5cb85c; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #e2f3e2; font-size: 14px; opacity: 0.75;' ?>">
                                Óptimo <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&ge; 70%</span>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h4>Salud Física Global</h4>
                        <p class="text-justify">Porcentaje de libros aptos para su lectura y préstamo que no requieren un proceso inmediato de restauración física o encuadernación.</p>
                        <div class="well well-sm">
                            <strong>Fórmula:</strong> <br>
                            (Libros en Buen Estado / Inventario Total) × 100
                        </div>
                    </div>
                    
                    <div class="col-md-6 text-center">
                        <div id="modalFisicoContenedorPorcentaje" style="padding: 20px; border: 2px solid <?= $colorSolidoFisico ?>; border-radius: 10px; background-color: #fafafa;">
                            <h2 id="modalFisicoPorcentaje" style="margin-top: 0; font-weight: bold; color: <?= $colorSolidoFisico ?>; font-size: 36px;"><?= $estadoFisico ?>%</h2>
                            <p class="text-muted" style="margin-bottom: 5px; font-size: 13px;">
                                Estado Físico General (<strong style="color: <?= $colorSolidoFisico ?>; text-transform: uppercase;"><?= $textoEstadoFisico ?></strong>)
                            </p>
                            <div class="progress" style="margin-bottom: 0; height: 12px; background-color: #eee;">
                                <div id="modalFisicoBarra" class="progress-bar" style="width: <?= $estadoFisico ?>%; background-color: <?= $colorSolidoFisico ?>;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <h4>Distribución de Salud Física por Sala</h4>
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
                            <?php foreach ($estadoFisicoPorSalas as $sala): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($sala['sala']) ?></strong></td>
                                <td><?= number_format($sala['total']) ?></td>
                                <td><?= number_format($sala['buenos']) ?></td>
                                <td><?= number_format($sala['en_reparacion']) ?></td>
                                <td><span class="label label-<?= $sala['clase'] ?>"><?= $sala['porcentaje'] ?>%</span></td>
                            </tr>
                            <?php endforeach; ?>
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