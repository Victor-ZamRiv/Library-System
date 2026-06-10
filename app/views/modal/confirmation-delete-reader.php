<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa-solid fa-user-slash text-warning"></i> Confirmar Suspensión</h4>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea suspender al lector <strong id="nombreLectorModal"></strong>?</p>
                <p class="text-muted">El lector no podrá realizar nuevos préstamos, pero se conservará su historial en el sistema.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a href="#" id="btnConfirmarEliminar" class="btn btn-warning btn-raised">
                    <i class="fa-solid fa-ban"></i> Suspender Lector
                </a>
            </div>
        </div>
    </div>
</div>