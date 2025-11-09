<!DOCTYPE html>
<html lang="es">

<!-- heat -->
<?php
include "../component/heat.php";
?>

<body>
	<!-- SideBar -->
	<?php
	include "../component/sidebar.php";
	?>
	<!-- contenido de la barra lateral -->

	<!-- Content page-->
	<section class="full-box dashboard-contentPage">
		<!-- NavBar -->
		<?php
		include "../component/navbar.php";
		?>
		<!-- Content page -->
		<div class="container-fluid">
			<div class="page-header">
				<h1 class="text-titles"><i class="zmdi zmdi-account-circle zmdi-hc-fw"></i> Información de Usuario</small></h1>
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
								<p class="mb-0"><strong class="mr-2">Cédula:</strong> 0</p>
								<p class="mb-0"><strong class="mr-2">Nombres:</strong> Firsh Admin</p>
								<p class="mb-0"><strong class="mr-2">Apellidos:</strong> </p>
								<p class="mb-0"><strong class="mr-2">Teléfono:</strong> </p>
								
								<hr class="mt-0 mb-3">
							</div>
							<div class="d-flex justify-content-between mb-3">
								<p class="mb-0"><strong class="mr-2">Nombre de Usuario:</strong> Admin</p>
								<p class="mb-0"><strong class="mr-2">Contraseña:</strong> Admin*2025</p>
								<p class="text-left">
								<div class="label label-success">Nivel 1</div> Control total del sistema
								</p>
								<hr class="mt-0 mb-3">
							</div>


							<div class="card-footer text-center">
								<a href="../admin/Edit-admin.php" class="btn btn-info btn-raised btn-sm">
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
	include "../component/scripts.php";
	?>
</body>

</html>