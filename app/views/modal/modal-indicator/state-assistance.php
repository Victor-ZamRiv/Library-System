<div class="modal fade" id="modalAsistenciaEstatal" tabindex="-1" role="dialog" aria-labelledby="modalAsistenciaEstatalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <?php
            // Evaluación matemática única para este modal
            if ($asistenciaEstatal <= 30) {
                $colorDinamicoAsistencia = '#d9534f'; // Crítico (Rojo)
                $textoEstadoAsistencia = 'Crítico';
            } elseif ($asistenciaEstatal < 70) {
                $colorDinamicoAsistencia = '#f0ad4e'; // Tolerable (Amarillo/Naranja)
                $textoEstadoAsistencia = 'Tolerable';
            } else {
                $colorDinamicoAsistencia = '#5cb85c'; // Óptimo (Verde)
                $textoEstadoAsistencia = 'Óptimo';
            }
            ?>

            <div class="modal-header" id="modalAsistenciaHeader" style="background-color: <?= $colorDinamicoAsistencia ?> !important; color: white; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalAsistenciaEstatalLabel" style="color: white; font-weight: bold;">
                    <i class="fa-solid fa-users-line"></i> Reporte de Asistencia: Sala Estatal
                </h4>
            </div>

            <div class="modal-body" style="padding-top: 15px;">
                <div class="row">
                    <div class="col-xs-12">
                        <div style="display: flex; width: 100%; border-radius: 6px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; font-family: sans-serif;">
                            
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoAsistencia === 'Crítico' ? 'background-color: #d9534f; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #f9dbdb; font-size: 14px; opacity: 0.75;' ?>">
                                Crítico <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&le; 30%</span>
                            </div>
                            
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoAsistencia === 'Tolerable' ? 'background-color: #f0ad4e; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #fef0de; font-size: 14px; opacity: 0.75;' ?>">
                                Tolerable <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">30% - 70%</span>
                            </div>
                            
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoAsistencia === 'Óptimo' ? 'background-color: #5cb85c; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #e2f3e2; font-size: 14px; opacity: 0.75;' ?>">
                                Óptimo <span style="display: block; font-size: 12px; font-weight: normal; color: #444444;">&ge; 70%</span>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h4>Afluencia de la Sala Estatal</h4>
                        <p class="text-justify">Proporción de usuarios que asisten específicamente a la Sala Estatal en relación con las visitas generales registradas en la biblioteca.</p>
                        <div class="well well-sm">
                            <strong>Fórmula:</strong> <br>
                            (Visitas Sala Estatal / Total de Visitas) × 100
                        </div>
                    </div>

                    <div class="col-md-6 text-center">
                        <div id="modalAsistenciaContenedorPorcentaje" style="padding: 20px; border: 2px solid <?= $colorDinamicoAsistencia ?> !important; border-radius: 10px; background-color: #fafafa;">
                            <h2 id="modalAsistenciaPorcentaje" style="margin-top: 0; font-weight: bold; color: <?= $colorDinamicoAsistencia ?> !important; font-size: 36px;"><?= $asistenciaEstatal ?>%</h2>
                            <p class="text-muted" style="margin-bottom: 5px; font-size: 13px;">
                                Frecuencia de Visitas de la Sala Estatal (<strong style="color: <?= $colorDinamicoAsistencia ?> !important; text-transform: uppercase;"><?= $textoEstadoAsistencia ?></strong>)
                            </p>
                            <div class="progress" style="margin-bottom: 0; height: 12px; background-color: #eee;">
                                <div id="modalAsistenciaBarra" class="progress-bar" style="width: <?= $asistenciaEstatal ?>%; background-color: <?= $colorDinamicoAsistencia ?> !important;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <h4>Tendencia de Usuarios</h4>
                <div class="table-responsive">
                    <table class="table table-hover" id="tablaAsistenciaEstatal">
                        <thead>
                            <tr class="active">
                                <th>Tipo de Usuario</th>
                                <th>Nro. de Visitas</th>
                                
                                <th>Tendencia</th>
                            </tr>
                        </thead>
                        <tbody id="tablaAsistenciaEstatalCuerpo">
                            <?php if (isset($asistenciaEstatalPorTipo) && is_array($asistenciaEstatalPorTipo) && count($asistenciaEstatalPorTipo) > 0): ?>
                                <?php foreach ($asistenciaEstatalPorTipo as $item): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($item['tipo']) ?></strong></td>
                                        <td><?= number_format($item['visitas']) ?></td>
                                         
                                        <td>
                                            <?php if ($item['tendencia'] == 'alta'): ?>
                                                Alta
                                            <?php elseif ($item['tendencia'] == 'estable'): ?>
                                                Estable
                                            <?php else: ?>
                                                Baja
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No hay datos de asistencia disponibles</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" onclick="descargarPDF('AsistenciaEstatal')">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Informe
                </button>
            </div>
        </div>
    </div>
</div>