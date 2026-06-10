<!-- MODAL DE CONFIRMACIÓN DE CAMBIOS -->
    <div class="modal fade" id="modalConfirmacionActualizacion" tabindex="-1" role="dialog" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalConfirmacionLabel">
                        <i class="fas fa-exclamation-triangle text-info" style="margin-right: 5px;"></i>
                        Confirmar Actualización de Datos
                    </h4>
                </div>
                <div class="modal-body">
                    <p class="lead text-center mb-4" id="modal-descripcion-cambios">
                        Por favor, verifique las modificaciones antes de guardar de forma permanente.
                    </p>
                    <div id="resumen-cambios-lector" class="p-3 table-responsive">
                        <!-- Aquí se renderiza dinámicamente la tabla de cambios o el mensaje de "sin cambios" -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar / Seguir Editando</button>
                    <button type="button" class="btn btn-info btn-raised" id="btn-confirmar-update" style="display:none;">Confirmar y Guardar</button>
                </div>
            </div>
        </div>
    </div>