<div class="modal fade" id="modalParticipacionActividades" tabindex="-1" role="dialog" aria-labelledby="modalParticipacionLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <?php
            // 1. Lógica de colores basada en los umbrales del cintillo (<=30% Crítico, <70% Tolerable, >=70% Óptimo)
            if ($participacionActividades <= 30) {
                $colorSolidoAct = '#d9534f'; // Crítico (Rojo)
                $textoEstadoActividades = 'Crítico';
            } elseif ($participacionActividades < 70) { 
                $colorSolidoAct = '#f0ad4e'; // Tolerable (Naranja)
                $textoEstadoActividades = 'Tolerable';
            } else {
                $colorSolidoAct = '#5cb85c'; // Óptimo (Verde)
                $textoEstadoActividades = 'Óptimo';
            }
            ?>

            <div class="modal-header" id="modalParticipacionHeader" style="background-color: <?= $colorSolidoAct ?> !important; color: white; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalParticipacionLabel" style="color: white; font-weight: bold;">
                    <i class="fa-solid fa-chalkboard-user"></i> Indicador: Participación en Actividades y Talleres
                </h4>
            </div>

            <div class="modal-body" style="padding-top: 15px;">
                <div class="row">
                    <div class="col-xs-12">
                        <div style="display: flex; width: 100%; border-radius: 6px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; font-family: sans-serif;">
                            
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoActividades === 'Crítico' ? 'background-color: #d9534f; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3); color: white;' : 'background-color: #f9dbdb; font-size: 14px; opacity: 0.75;' ?>">
                                Crítico <span style="display: block; font-size: 12px; font-weight: normal; color: <?= $textoEstadoActividades === 'Crítico' ? '#f5f5f5' : '#444444' ?>;">&le; 30%</span>
                            </div>
                            
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoActividades === 'Tolerable' ? 'background-color: #f0ad4e; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3); color: white;' : 'background-color: #fef0de; font-size: 14px; opacity: 0.75;' ?>">
                                Tolerable <span style="display: block; font-size: 12px; font-weight: normal; color: <?= $textoEstadoActividades === 'Tolerable' ? '#f5f5f5' : '#444444' ?>;">30% - 70%</span>
                            </div>
                            
                            <div style="flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease;
                                <?= $textoEstadoActividades === 'Óptimo' ? 'background-color: #5cb85c; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3); color: white;' : 'background-color: #e2f3e2; font-size: 14px; opacity: 0.75;' ?>">
                                Óptimo <span style="display: block; font-size: 12px; font-weight: normal; color: <?= $textoEstadoActividades === 'Óptimo' ? '#f5f5f5' : '#444444' ?>;">&ge; 70%</span>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h4>Impacto Social y Educativo</h4>
                        <p class="text-justify">Este indicador mide el porcentaje de usuarios registrados en el sistema que participan activamente en las diferentes convocatorias, talleres de lectura y actividades culturales desarrolladas por la institución.</p>
                        <div class="well well-sm">
                            <strong>Fórmula de Cálculo:</strong> <br>
                            (Total de asistentes a actividades / Total de usuarios registrados) × 100
                        </div>
                    </div>

                    <div class="col-md-6 text-center">
                        <div id="modalActividadesContenedorPorcentaje" style="padding: 20px; border: 2px solid <?= $colorSolidoAct ?> !important; border-radius: 10px; background-color: #fafafa;">
                            <h2 id="modalActividadesPorcentaje" style="margin-top: 0; font-weight: bold; color: <?= $colorSolidoAct ?> !important; font-size: 36px;"><?= $participacionActividades ?>%</h2>
                            <p class="text-muted" style="margin-bottom: 5px; font-size: 13px;">
                                Nivel de Integración (<strong style="color: <?= $colorSolidoAct ?> !important; text-transform: uppercase;"><?= $textoEstadoActividades ?></strong>)
                            </p>
                            <div class="progress" style="margin-bottom: 0; height: 12px; background-color: #eee;">
                                <div id="modalActividadesBarra" class="progress-bar" style="width: <?= $participacionActividades ?>%; background-color: <?= $colorSolidoAct ?> !important;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <h4>Desglose por Categoría de Actividad</h4>
                <div class="table-responsive">
                    <table class="table table-hover" id="tablaActividadesReporte">
                        <thead>
                            <tr class="active">
                                <th>Categoría</th>
                                <th>Eventos Realizados</th>
                                <th>Total Asistentes</th>
                                <th>Participación (%)</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody id="tablaActividadesCuerpo">
                            <?php if (isset($desgloseActividades) && !empty($desgloseActividades)): ?>
                                <?php foreach ($desgloseActividades as $actividad): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($actividad['categoria']) ?></strong></td>
                                        <td><?= number_format($actividad['eventos_realizados']) ?></td>
                                        <td><?= number_format($actividad['total_asistentes']) ?></td>
                                        <td><span class="label label-<?= $actividad['clase'] ?>"><?= $actividad['porcentaje'] ?>%</span></td>
                                        <td><?= htmlspecialchars($actividad['estado']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No hay datos de desglose de actividades disponibles en este momento.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" onclick="descargarPDF('Actividades')">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Informe
                </button>
            </div>
        </div>
    </div>
</div>