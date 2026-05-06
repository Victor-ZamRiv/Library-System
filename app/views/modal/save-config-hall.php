<!-- MODAL DE CONFIRMACIÓN PARA GUARDAR -->
    <div class="modal fade" id="confirmSaveModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa-solid fa-triangle-exclamation text-primary"></i> Confirmar Guardado
                    </h4>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de que desea <strong>guardar los cambios</strong> en la configuración de salas?</p>
                    <div class="alert alert-info">
                        <ul>
                            <li>Se actualizarán los estados y capacidades de todas las salas</li>
                            <li>Los cambios se aplicarán inmediatamente</li>
                        </ul>
                    </div>
                    <p class="text-warning">Revise que todos los valores sean correctos antes de continuar.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formSalas" class="btn btn-primary btn-raised">
                        <i class="fa-solid fa-floppy-disk"></i> Sí, Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>