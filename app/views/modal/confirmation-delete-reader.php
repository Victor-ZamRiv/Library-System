<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa-solid fa-triangle-exclamation text-danger"></i> Confirmar Eliminación</h4>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de que desea eliminar al lector <strong id="nombreLectorModal"></strong>?</p>
                    <p class="text-danger">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a href="#" id="btnConfirmarEliminar" class="btn btn-danger btn-raised">
                        <i class="fa-solid fa-trash-can"></i> Eliminar
                    </a>
                </div>
            </div>
        </div>
    </div>