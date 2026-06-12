<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lista de Usuarios</title>
    <?php include VIEW_PATH . "/component/heat.php" ?>
</head>
<body>
    <?php include VIEW_PATH . "/component/sidebar.php" ?>

<<<<<<< HEAD
    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php" ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"> <i class="fa-solid fa-users"></i> Lista de Usuarios</h1>
            </div>
        </div>
        <?php include VIEW_PATH . "/component/userbar.php" ?>

        <div class="container-fluid">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"> &nbsp; LISTA DE USUARIOS</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <form action="<?= BASE_URL ?>/administradores" method="GET">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">¿A quién buscas?</label>
                                    <input type="text" class="form-control" name="buscar" value="<?= htmlspecialchars($search ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 text-right">
                                <br>
                                <button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-search"></i> Buscar</button>
                                <button type="button" class="btn btn-warning btn-raised btn-sm" data-toggle="modal" data-target="#disabledUsersModal">
                                    <i class="fa-solid fa-ban"></i> Suspendidos <?= ($totalInactivos ?? 0) > 0 ? '(' . ($totalInactivos ?? 0) . ')' : '' ?>
                                </button>
                                <button type="button" class="btn btn-success btn-raised btn-sm" onclick="descargarPDF('Usuarios');">
                                    <i class="fa-solid fa-file-pdf"></i> IMPRIMIR HABILITADOS
                                </button>
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
                                    <th class="text-center">Suspender</th>
                                </tr>
                            </thead>
                            <tbody id="tablaUsuariosCuerpo">
                                <?php if (empty($administradores)): ?>
                                    <tr><td colspan="6">No se encontraron administradores activos.<?php else: ?>
                                    <?php foreach ($administradores as $admin): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($admin->getNombreUsuario()) ?></td>
                                            <td><?= htmlspecialchars($admin->getPersona()->getCedula()) ?></td>
                                            <td><?= htmlspecialchars($admin->getPersona()->getNombre()) ?></td>
                                            <td><?= htmlspecialchars($admin->getPersona()->getApellido()) ?></td>
                                            <td><?= htmlspecialchars($admin->getPersona()->getTelefono()) ?></td>
                                            <td>
                                                <?php if ($admin->getIdAdministrador() != $_SESSION['administrador']['id']): ?>
                                                    <button class="btn btn-danger btn-raised btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#confirmDeleteUserModal"
                                                        data-id="<?= $admin->getIdAdministrador() ?>"
                                                        data-nombre="<?= htmlspecialchars($admin->getNombreUsuario()) ?>">
                                                        <i class="fa-solid fa-ban"></i>
                                                    </button>
                                                <?php else: ?>
                                                    <span class="label label-default">Actual</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if (isset($paginacion) && $paginacion['ultima'] > 1): ?>
                    <nav class="text-center">
                        <ul class="pagination pagination-sm">
                            <?php if ($paginacion['actual'] > 1): ?>
                                <li><a href="?page=1&buscar=<?= urlencode($search ?? '') ?>">«</a></li>
                                <li><a href="?page=<?= $paginacion['actual']-1 ?>&buscar=<?= urlencode($search ?? '') ?>">‹</a></li>
                            <?php else: ?>
                                <li class="disabled"><a href="#">«</a></li>
                            <?php endif; ?>
                            <li class="active"><a href="#"><?= $paginacion['actual'] ?></a></li>
                            <?php if ($paginacion['actual'] < $paginacion['ultima']): ?>
                                <li><a href="?page=<?= $paginacion['actual']+1 ?>&buscar=<?= urlencode($search ?? '') ?>">›</a></li>
                                <li><a href="?page=<?= $paginacion['ultima'] ?>&buscar=<?= urlencode($search ?? '') ?>">»</a></li>
                            <?php else: ?>
                                <li class="disabled"><a href="#">›</a></li>
                                <li class="disabled"><a href="#">»</a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/modal/confirmation-delete-user.php" ?>
    <?php include VIEW_PATH . "/modal/enable-user.php" ?>

    <?php include VIEW_PATH . "/component/scripts.php" ?>
    <script src="<?= PUBLIC_PATH ?>/js/pdf-generator.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/html2canvas.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jsPDF.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jspdf-autotable.js"></script>

    <script>
        $(document).ready(function() {
            $('#confirmDeleteUserModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var userId = button.data('id');
                var username = button.data('nombre');
                var modal = $(this);
                modal.find('#modalUserName').text(username);
                var deleteUrl = '<?= BASE_URL ?>/administradores/delete?id=' + userId;
                modal.find('#confirmDeleteBtn').attr('href', deleteUrl);
            });
        });
    </script>
=======
	<!-- Content page-->
	<section class="full-box dashboard-contentPage">
		<!-- NavBar -->
		<?php include VIEW_PATH . "/component/navbar.php" ?>

		<!-- Content page -->
		<div class="container-fluid">
			<div class="page-header">
				<h1 class="text-titles"> <i class="fa-solid fa-users"></i> Lista de Usuarios</h1>
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
								<button type="button" class="btn btn-warning btn-raised btn-sm" data-toggle="modal" data-target="#disabledUsersModal"><i class="fa-solid fa-ban"></i> Suspendidos</button>
								<button type="button" class="btn btn-success btn-raised btn-sm" onclick="descargarPDF('Usuarios');">
									<i class="fa-solid fa-file-pdf"></i>IMPRIMIR HABILITADOS
								</button>
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

									<th class="text-center">Suspender</th>
								</tr>
							</thead>
							<!-- SE AGREGÓ EL ID REQUERIDO POR PDF-GENERATOR.JS -->
							<tbody id="tablaUsuariosCuerpo">

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
												<?php if ($admin->getIdAdministrador() != $_SESSION['administrador']['id']): ?>
													<button class="btn btn-danger btn-raised btn-sm"
														data-toggle="modal"
														data-target="#confirmDeleteUserModal"
														data-id="<?= $admin->getIdAdministrador() ?>"
														data-nombre="<?= htmlspecialchars($admin->getNombreUsuario()) ?>">
														<i class="fa-solid fa-ban"></i>
													</button>
												<?php else: ?>
													<span class="label label-default">Actual</span>
												<?php endif; ?>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>

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
	<?php include VIEW_PATH . "/modal/enable-user.php" ?>

	<!--====== Scripts -->
	<?php include VIEW_PATH . "/component/scripts.php" ?>
	<script src="<?= PUBLIC_PATH ?>/js/pdf-generator.js"></script>
	<script src="<?= PUBLIC_PATH ?>/js/pdf/html2canvas.js"></script>
	<script src="<?= PUBLIC_PATH ?>/js/pdf/jsPDF.js"></script>
	<script src="<?= PUBLIC_PATH ?>/js/pdf/jspdf-autotable.js"></script>

	<script>
		$(document).ready(function() {
			$('#confirmDeleteUserModal').on('show.bs.modal', function(event) {
				var button = $(event.relatedTarget); // Botón que activó el modal
				var userId = button.data('id'); // Extraer el ID
				var username = button.data('nombre'); // Extrae el nombre de usuario que alteramos arriba

				var modal = $(this);
				// Inyecta el nombre de usuario en el contenedor del modal
				modal.find('#modalUserName').text(username);

				// Ajusta la URL de redirección para la suspensión
				var deleteUrl = '<?= BASE_URL ?>/administradores/delete?id=' + userId;
				modal.find('#confirmDeleteBtn').attr('href', deleteUrl);
			});
		});
	</script>
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
</body>
</html>