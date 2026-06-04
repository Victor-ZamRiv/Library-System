<div class="modal fade" id="modalDetalleIdcar" tabindex="-1" role="dialog" aria-labelledby="modalIdcarLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <?php
            // Lógica de estados actualizada según imagen
            if ($valorIdcar > 25) {
                $colorDinamicoIdcar = '#d9534f';
                $textoEstadoIdcar = 'CRÍTICO';
            } elseif ($valorIdcar >= 11) {
                $colorDinamicoIdcar = '#f0ad4e';
                $textoEstadoIdcar = 'EN PROCESO';
            } else {
                $colorDinamicoIdcar = '#5cb85c';
                $textoEstadoIdcar = 'LOGRADO';
            }
            ?>

            <div class="modal-header" style="background-color: <?= $colorDinamicoIdcar ?>; color: white; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalIdcarLabel" style="color: white; font-weight: bold;">
                    <i class="fa-solid fa-book-medical"></i> Índice de Deterioro
                </h4>
            </div>

            <div class="modal-body" style="padding-top: 15px;">
                <!-- Barra de Estados Actualizada -->
                <div class="row">
                    <div class="col-xs-12">
                        <div style="display: flex; width: 100%; border-radius: 6px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; font-family: sans-serif;">
                            
                            <div style="flex: 1; padding: 12px; transition: all 0.3s ease;
                                <?= $textoEstadoIdcar === 'CRÍTICO' ? 'background-color: #d9534f; color: white; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #f9dbdb; color: #444; font-size: 14px; opacity: 0.75;' ?>">
                                CRÍTICO <span style="display: block; font-size: 12px; font-weight: normal; color: #444;">> 25%</span>
                            </div>

                            <div style="flex: 1; padding: 12px; transition: all 0.3s ease;
                                <?= $textoEstadoIdcar === 'EN PROCESO' ? 'background-color: #f0ad4e; color: white; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #fef0de; color: #444; font-size: 14px; opacity: 0.75;' ?>">
                                EN PROCESO <span style="display: block; font-size: 12px; font-weight: normal; color: #444;">11% - 25%</span>
                            </div>

                            <div style="flex: 1; padding: 12px; transition: all 0.3s ease;
                                <?= $textoEstadoIdcar === 'LOGRADO' ? 'background-color: #5cb85c; color: white; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #e2f3e2; color: #444; font-size: 14px; opacity: 0.75;' ?>">
                                LOGRADO <span style="display: block; font-size: 12px; font-weight: normal; color: #444;">≤ 10%</span>
                            </div>
                        </div>
                    </div>
                </div>

                

                <div class="row">
                    <div class="col-md-6">
                        <p class="text-justify">Mide el estado físico de la colección de alta rotación para garantizar la calidad del servicio bibliotecario.</p>
                        <div class="well well-sm">
                            <strong>Fórmula:</strong> <br>
                            (Ejemplares dañados / Total ejemplares) x 100
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div style="padding: 20px; border: 2px solid <?= $colorDinamicoIdcar ?>; border-radius: 10px; background-color: #fafafa;">
                            <h2 style="margin-top: 0; font-weight: bold; color: <?= $colorDinamicoIdcar ?>; font-size: 36px;"><?= number_format($valorIdcar, 1) ?>%</h2>
                            <p class="text-muted" style="margin-bottom: 5px; font-size: 13px;">
                                Estado Actual: <strong style="color: <?= $colorDinamicoIdcar ?>; text-transform: uppercase;"><?= $textoEstadoIdcar ?></strong>
                            </p>
                        </div>
                    </div>
                </div>

                <hr>

                <h4>Detalle de Libros de Alta Rotación</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="active">
                                <th>Cota</th>
                                <th>Título del Libro</th>
                                <th>Total de Ejemplares</th>
                                <th>Ejemplares Dañados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($detalleLibrosAltaRotacion)): ?>
                                <?php foreach ($detalleLibrosAltaRotacion as $libro): ?>
                                <tr>
                                    <td><?= htmlspecialchars($libro['cota']) ?></td>
                                    <td><?= htmlspecialchars($libro['titulo']) ?></td>
                                    <td class="text-center"><?= $libro['total_ejemplares'] ?></td>
                                    <td class="text-center"><?= $libro['danados'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center">No hay libros de alta rotación en el período.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" onclick="descargarPDF('Idcar')">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Informe
                </button>
            </div>
        </div>
    </div>
</div>