<div class="modal fade" id="confirmDeleteUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning"></i> Confirmar Suspensión
                </h4>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea suspender la cuenta del usuario: <strong id="modalUserName"></strong>?</p>
                <p class="text-muted"><small>Nota: Se revocarán de manera temporal todos los accesos al sistema para este perfil.</small></p>
                <p class="text-warning"><strong>El usuario no podrá iniciar sesión hasta que sea reactivado.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-warning btn-raised">
                    <i class="zmdi zmdi-lock"></i> Suspender Usuario
                </a>
            </div>
        </div>
    </div>
</div>