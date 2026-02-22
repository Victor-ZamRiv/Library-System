<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="logoutModalLabel">
					<i class="fa-solid fa-right-from-bracket text-primary"></i> Confirmar Salida
				</h4>
			</div>
			<div class="modal-body text-center">
				<p>¿Estás seguro de que deseas cerrar tu sesión actual?</p>
				<p class="text-muted"><small>Asegúrate de haber guardado todos tus cambios antes de salir.</small></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Permanecer aquí</button>
				<a href="<?= BASE_URL ?>/login" class="btn btn-primary btn-raised">
					<i class="fa-solid fa-door-open"></i> Cerrar Sesión
				</a>
			</div>
		</div>
	</div>
</div>