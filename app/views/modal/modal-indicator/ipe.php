<div class="modal fade" id="modalDetalleIpe" tabindex="-1" role="dialog" aria-labelledby="modalIpeLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <?php
            // Datos reales desde el controlador (se espera $ipe)
            $valorIpe = $ipe['valor'] ?? 0;
            $totalAsistentes = $ipe['total_asistentes'] ?? 0;
            $totalEventos = $ipe['total_eventos'] ?? 0;

            // Lógica de estado y color según rangos
            if ($valorIpe <= 15) {
                $colorDinamicoIpe = '#d9534f';
                $textoEstadoIpe = 'CRÍTICO';
            } elseif ($valorIpe < 30) {
                $colorDinamicoIpe = '#f0ad4e';
                $textoEstadoIpe = 'EN PROCESO';
            } else {
                $colorDinamicoIpe = '#5cb85c';
                $textoEstadoIpe = 'LOGRADO';
            }
            ?>

            <div class="modal-header" style="background-color: <?= $colorDinamicoIpe ?>; color: white; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalIpeLabel" style="color: white; font-weight: bold;">
                    <i class="fa-solid fa-users-rectangle"></i> Tasa de Productividad de Eventos (IPE)
                </h4>
            </div>

            <div class="modal-body" style="padding-top: 15px;">
                <!-- Barra de Estados -->
                <div class="row">
                    <div class="col-xs-12">
                        <div style="display: flex; width: 100%; border-radius: 6px; overflow: hidden; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; font-family: sans-serif;">
                            
                            <div style="flex: 1; padding: 12px; transition: all 0.3s ease;
                                <?= $textoEstadoIpe === 'CRÍTICO' ? 'background-color: #d9534f; color: white; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #f9dbdb; color: #444; font-size: 14px; opacity: 0.75;' ?>">
                                CRÍTICO <span style="display: block; font-size: 12px; font-weight: normal; color: #444;">≤ 15 asistentes/evento</span>
                            </div>

                            <div style="flex: 1; padding: 12px; transition: all 0.3s ease;
                                <?= $textoEstadoIpe === 'EN PROCESO' ? 'background-color: #f0ad4e; color: white; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #fef0de; color: #444; font-size: 14px; opacity: 0.75;' ?>">
                                EN PROCESO <span style="display: block; font-size: 12px; font-weight: normal; color: #444;">16 - 29 asistentes/evento</span>
                            </div>

                            <div style="flex: 1; padding: 12px; transition: all 0.3s ease;
                                <?= $textoEstadoIpe === 'LOGRADO' ? 'background-color: #5cb85c; color: white; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);' : 'background-color: #e2f3e2; color: #444; font-size: 14px; opacity: 0.75;' ?>">
                                LOGRADO <span style="display: block; font-size: 12px; font-weight: normal; color: #444;">≥ 30 asistentes/evento</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p class="text-justify">Mide la eficacia en la captación de público por cada actividad realizada. Representa el promedio de asistentes por evento, permitiendo evaluar la relevancia y atractivo de la programación cultural.</p>
                        <div class="well well-sm">
                            <strong>Fórmula:</strong> <br>
                            Total de asistentes a eventos / Total de eventos realizados (mes actual)
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div style="padding: 20px; border: 2px solid <?= $colorDinamicoIpe ?>; border-radius: 10px; background-color: #fafafa;">
                            <h2 style="margin-top: 0; font-weight: bold; color: <?= $colorDinamicoIpe ?>; font-size: 36px;"><?= number_format($valorIpe, 1) ?></h2>
                            <p class="text-muted" style="margin-bottom: 5px; font-size: 13px;">
                                Promedio de asistentes por evento<br>
                                <strong style="color: <?= $colorDinamicoIpe ?>; text-transform: uppercase;"><?= $textoEstadoIpe ?></strong>
                            </p>
                        </div>
                    </div>
                </div>

                <hr>

                <h4>Resumen del Período (Mes Actual)</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Total de eventos realizados</th>
                                <td class="text-center"><?= number_format($totalEventos) ?></td>
                            </tr>
                            <tr>
                                <th>Total de asistentes a eventos</th>
                                <td class="text-center"><?= number_format($totalAsistentes) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="alert alert-info">
                    <i class="fa-solid fa-info-circle"></i> <strong>Nota:</strong> El indicador se calcula con los datos del mes actual (primer día al último día del mes). Si no hay eventos registrados, el valor será 0.
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" onclick="descargarPDF('Ipe')">
                    <i class="fa-solid fa-file-pdf"></i> Descargar Informe
                </button>
            </div>
        </div>
    </div>
</div>