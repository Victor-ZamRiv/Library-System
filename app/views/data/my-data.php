<!DOCTYPE html>
<html lang="es">

<!-- heat -->
<?php
include VIEW_PATH . "/component/heat.php";
?>

<body>
	<!-- SideBar -->
	<?php
	include VIEW_PATH . "/component/sidebar.php";
	?>
	<!-- contenido de la barra lateral -->

	<!-- Content page-->
	<section class="full-box dashboard-contentPage">
		<!-- NavBar -->
		<?php
		include VIEW_PATH . "/component/navbar.php";
		?>
		<!-- Content page -->
		<div class="container-fluid">
			<div class="page-header">
				<h1 class="text-titles"> Información de Usuario</small></h1>
			</div>
		</div>

		<!-- Panel mis datos -->
		<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"> MIS DATOS</h3>
				</div>
				<div class="panel-body text-center">
					<div class="card shadow-sm " style="max-width: 600px;">
						<div class="card-body">


							<h4 class="card-title text-center font-weight-bold my-3">Datos de Cuenta</h4>
							<hr class="mt-0 mb-3">

							<div class="d-flex justify-content-between mb-3">
								<p class="mb-0"><strong class="mr-2">Cédula:</strong> <?= htmlspecialchars($administrador->getPersona()->getCedula()) ?></p>
								<p class="mb-0"><strong class="mr-2">Nombres:</strong> <?= htmlspecialchars($administrador->getPersona()->getNombre()) ?></p>
								<p class="mb-0"><strong class="mr-2">Apellidos:</strong> <?= htmlspecialchars($administrador->getPersona()->getApellido()) ?></p>
								<p class="mb-0"><strong class="mr-2">Teléfono:</strong> <?= htmlspecialchars($administrador->getPersona()->getTelefono()) ?></p>
								
								<hr class="mt-0 mb-3">
							</div>
							<div class="d-flex justify-content-between mb-3">
								<p class="mb-0"><strong class="mr-2">Nombre de Usuario:</strong> Admin</p>
								<!-- <p class="mb-0"><strong class="mr-2">Contraseña:</strong> Admin*2025</p> -->
								<p class="text-left">
								<div class="label label-success">Nivel</div>: <?= htmlspecialchars($administrador->getRol()) ?>
								</p>
								<hr class="mt-0 mb-3">
							</div>


							<div class="card-footer text-center">
								<a href="../user/edit-user.php" class="btn btn-info btn-raised btn-sm">
									Editar Datos
								</a>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

	</section>

	<!--====== Scripts -->
	<?php
	include VIEW_PATH . "/component/scripts.php";
	?>
</body>

</html>