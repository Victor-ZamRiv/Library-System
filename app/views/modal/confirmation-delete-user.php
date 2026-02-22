<div class="modal fade" id="confirmDeleteUserModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">
						<i class="fas fa-exclamation-triangle text-danger"></i> Confirmar Eliminación
					</h4>
				</div>
				<div class="modal-body">
					<p>¿Está seguro de que desea eliminar la cuenta del usuario: <strong id="modalUserName"></strong>?</p>
					<p class="text-muted"><small>Nota: Se revocarán todos los accesos del sistema para este perfil.</small></p>
					<p class="text-danger"><strong>Esta acción es irreversible.</strong></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					<a href="#" id="confirmDeleteBtn" class="btn btn-danger btn-raised">
						<i class="zmdi zmdi-delete"></i> Eliminar Usuario
					</a>
				</div>
			</div>
		</div>
	</div>