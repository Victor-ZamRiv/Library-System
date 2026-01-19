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
                    <p class="text-danger">Esta acción no se puede deshacer y el ejemplar será marcado para eliminación al guardar los cambios.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger btn-raised btn-lg" id="confirm-delete-btn" onclick="ejecutarEliminacionEjemplar()">Descatalogar</button>
                </div>
            </div>
        </div>
    </div>


