<!DOCTYPE html>
<html lang="es">
<!-- head -->
<title>Lista de Usuarios</title>
<?php include VIEW_PATH . "/component/heat.php" ?>

<body>
	<!-- SideBar -->
	<?php include VIEW_PATH . "/component/sidebar.php" ?>

	<!-- Content page-->
	<section class="full-box dashboard-contentPage">
		<!-- NavBar -->

		<?php include VIEW_PATH . "/component/navbar.php" ?>

		<!-- Content page -->
		<div class="container-fluid">
			<div class="page-header">
				<h1 class="text-titles"> Usuarios <small>Lista de Usuarios</small></h1>
			</div>
		</div>
		<?php include VIEW_PATH . "/component/userbar.php" ?>

		<!-- Panel listado de administradores -->
		<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"> &nbsp; LISTA DE USUARIOS</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<form action="<?= BASE_URL ?>/administradores/search">
							<div class="col-xs-12 col-md-6">
								<div class="form-group label-floating">
									<label class="control-label">¿A quién buscas?</label>
									<input type="text" class="form-control" name="buscar" id="inputSearch">
								</div>
							</div>
							<div class="col-xs-12 col-md-6 text-right">
								<br>
								<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-search"></i> Buscar</button>
							</div>
						</form>
					</div>
					<br>

					<div class="table-responsive">
						<table class="table table-hover text-center">
							<thead>
								<tr>
									<th class="text-center">Usuario</th>
									<th class="text-center">Cédula</th>
									<th class="text-center">Nombres</th>
									<th class="text-center">Apellidos</th>
									<th class="text-center">Teléfono</th>
									<th class="text-center">Ver más</th>
									<th class="text-center">Eliminar</th>
								</tr>
							</thead>
							<tbody>
								
									<?php if (empty($administradores)): ?>
									<tr>
										<td colspan="7">No se encontraron administradores.</td>
									</tr>
									<?php else: ?>
										<?php foreach ($administradores as $admin): ?>
										<tr>
											<td><?= htmlspecialchars($admin->getNombreUsuario()) ?></td>
											<td><?= htmlspecialchars($admin->getPersona()->getCedula()) ?></td>
											<td><?= htmlspecialchars($admin->getPersona()->getNombre()) ?></td>
											<td><?= htmlspecialchars($admin->getPersona()->getApellido()) ?></td>
											<td><?= htmlspecialchars($admin->getPersona()->getTelefono()) ?></td>

											<td>
												<a href="user-info.php" class="btn btn-success btn-raised btn-sm">

													<i class="fa-solid fa-info"></i>
												</a>
											</td>
										<?php if ($admin->getIdAdministrador() != $_SESSION['administrador']['id']): ?>
											<td>
												<a href="#!" class="btn btn-danger btn-raised btn-sm"
													data-toggle="modal"
													data-target="#confirmDeleteUserModal"


													data-id="<?= $admin->getIdAdministrador() ?>"


													data-nombre="<?= htmlspecialchars($admin->getNombreUsuario()) ?>"><i class="fa-solid fa-trash"></i>
												</a>
											</td>
										</tr>
										<?php endif; ?>
										<?php endforeach; ?>
									<?php endif; ?>
								</tr>

							</tbody>
						</table>
					</div>
					<nav class="text-center">
						<ul class="pagination pagination-sm">
							<li class="disabled"><a href="javascript:void(0)">«</a></li>
							<li class="active"><a href="javascript:void(0)">1</a></li>
							<li><a href="javascript:void(0)">»</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>


	</section>

	<?php include VIEW_PATH . "/modal/confirmation-delete-user.php" ?>

	<!--====== Scripts -->

	<?php include VIEW_PATH . "/component/scripts.php" ?>


	<script>
		$(document).ready(function() {
			$('#confirmDeleteUserModal').on('show.bs.modal', function(event) {
				var button = $(event.relatedTarget); // Botón que activó el modal
				var userId = button.data('id'); // Extraer info de atributos data-*
				var userName = button.data('nombre');

				var modal = $(this);
				modal.find('#modalUserName').text(userName);

				// Ajusta esta URL según tu sistema de rutas (ejemplo: administradores/delete/ID)
				var deleteUrl = '<?= BASE_URL ?>/administradores/delete?id=' + userId;
				modal.find('#confirmDeleteBtn').attr('href', deleteUrl);
			});
		});
	</script>

</body>

</html>