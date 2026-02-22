<div class="modal fade" id="modalAsistenciaEstatal" tabindex="-1" role="dialog" aria-labelledby="modalAsistenciaEstatalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #f0ad4e; color: white;">
                <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 1;"><span>&times;</span></button>
                <h4 class="modal-title" id="modalAsistenciaEstatalLabel">
                    <i class="fa-solid fa-users-line"></i> Reporte de Asistencia: Sala Estatal
                </h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Análisis de Afluencia</h4>
                        <p>Este indicador mide el volumen de usuarios que ingresan a la Sala Estatal para consultas de acervo regional, archivos históricos o investigación local.</p>
                        <div class="well well-sm">
                            <strong>Objetivo Mensual:</strong> 500 Visitantes<br>
                            <strong>Logrado a la fecha:</strong> 340 Visitantes<br>
                            <i class="fa-solid fa-circle-exclamation text-warning"></i> Se recomienda aumentar la difusión de las colecciones regionales.
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div style="padding: 20px; border: 2px dashed #f0ad4e; border-radius: 10px; background-color: #fffaf0;">
                            <h2 style="color: #f0ad4e; margin-top: 0;">68%</h2>
                            <p class="text-muted">Cumplimiento de Meta de Visitas</p>
                            <div class="progress" style="margin-bottom: 0;">
                                <div class="progress-bar progress-bar-warning" style="width: 68%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <h4>Perfil del Visitante (Sala Estatal)</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="active">
                                <th>Tipo de Usuario</th>
                                <th>Nro. de Visitas</th>
                                <th>Promedio de Permanencia</th>
                                <th>Tendencia</th>
                            </tr>
                        </thead>
                        <tbody id="tablaAsistenciaEstatalCuerpo">
                            <tr>
                                <td><strong>Investigadores / Historiadores</strong></td>
                                <td>85</td>
                                <td>120 min</td>
                                <td><i class="fa-solid fa-arrow-trend-up text-success"></i> Alta</td>
                            </tr>
                            <tr>
                                <td><strong>Estudiantes Universitarios</strong></td>
                                <td>140</td>
                                <td>45 min</td>
                                <td><i class="fa-solid fa-arrow-trend-down text-danger"></i> Baja</td>
                            </tr>
                            <tr>
                                <td><strong>Público General</strong></td>
                                <td>65</td>
                                <td>30 min</td>
                                <td><i class="fa-solid fa-minus text-muted"></i> Estable</td>
                            </tr>
                            <tr>
                                <td><strong>Escuelas (Visitas Guiadas)</strong></td>
                                <td>50</td>
                                <td>60 min</td>
                                <td><i class="fa-solid fa-arrow-trend-up text-success"></i> Alta</td>
                            </tr>
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