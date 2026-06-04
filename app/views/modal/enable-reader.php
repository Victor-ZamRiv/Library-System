<div class="modal fade" id="disabledReadersModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document"> 
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="fa-solid fa-user-slash text-danger"></i> Lectores Inhabilitados
                </h4>
            </div>
            <div class="modal-body">
                <p class="text-muted">A continuación se muestran los lectores que actualmente tienen el servicio suspendido.</p>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>N° CARNET</th>
                                <th>CÉDULA</th>
                                <th>NOMBRE COMPLETO</th>
                                <th>TELÉFONO</th>
                                <th>PROFESIÓN</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaLectoresInhabilitados">
                            <tr>
                                <td><strong>87654321/24</strong></td>
                                <td>25909345</td>
                                <td>Juan Pérez Gómez</td>
                                <td>04128973452</td>
                                <td>Arquitecto</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-success btn-raised btn-habilitar" data-id="1">
                                        <i class="fa-solid fa-user-check"></i> Habilitar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <!-- Botón institucional añadido para PDF de suspendidos -->
                 <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" onclick="descargarPDF('LectoresInhabilitados');" class="btn btn-danger btn-raised btn-sm">
                    <i class="fa-solid fa-file-pdf"></i> Imprimir Suspendidos
                </button>
                
            </div>
        </div>
    </div>
</div>