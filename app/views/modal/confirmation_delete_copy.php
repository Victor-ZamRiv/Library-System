<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="confirmDeleteModalLabel"><i class="fa-solid fa-triangle-exclamation text-danger"></i> Confirmar Descatalogación</h4>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea descatalogar el ejemplar <span id="ejemplar-code-to-delete"></span>?</p>
                
                <div class="form-group" style="margin-top: 20px; margin-bottom: 20px;">
                    <label for="motivo-descatalogar" class="control-label">Motivo de la descatalogación:</label>
                    <select class="form-control" id="motivo-descatalogar" name="motivo_descatalogar" required>
                        <option value="" disabled selected>-- Seleccione un motivo --</option>
                        <option value="Extraviado">Extraviado</option>
                        <option value="Daño Total">Daño Total</option>
                    </select>
                </div>

                <p class="text-warning"><i class="fa-solid fa-info-circle"></i> El ejemplar cambiará su estado a "Descatalogado" al guardar los cambios, pero podrá ser reincorporado al sistema si es necesario.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger btn-raised btn-lg" id="confirm-delete-btn" onclick="ejecutarEliminacionEjemplar()">Descatalogar</button>
            </div>
        </div>
    </div>
</div>