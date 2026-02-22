<!DOCTYPE html>
<html lang="es">

	<title>Categorias</title>
<!-- head -->
 <?php include VIEW_PATH .  "/component/heat.php" ?>
<body>
<!-- sidebar -->
	<?php
	include VIEW_PATH .  "/component/sidebar.php";
	?> 

	<!-- Content page-->
	<section class="full-box dashboard-contentPage">
		<!-- NavBar -->
		<?php include VIEW_PATH .  "/component/navbar.php" ?> 
		<!-- Content page -->
		<div class="container-fluid">
			<div class="page-header">
			  <h1 class="text-titles"><i class="fa-solid fa-book"></i> Catálogo <small>Lista de Area de Conocimiento</small></h1>
			</div>
		</div>

		<?php include VIEW_PATH .  '/component/categorybar.php'; ?>

		<!-- Panel listado de categorias -->
		<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE CATEORÍAS</h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover text-center">
							<thead>
								<tr>
									
									<th class="text-center">CÓDIGO</th>
									<th class="text-center">NOMBRE</th>
									<th class="text-center">ACTUALIZAR</th>
									<th class="text-center">ELIMINAR</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									
									<td>700</td>
									<td>Desarrollo web</td>
									<td>
										<a href="#!" class="btn btn-success btn-raised btn-xs">
											<i class="fa-solid fa-pencil"></i>
										</a>
									</td>
									<td>
										<form>
											<button type="#" class="btn btn-danger btn-raised btn-xs">
												<i class="fa-solid fa-ban"></i>
											</button>
										</form>
									</td>
								</tr>
								
							</tbody>
						</table>
					</div>
					<nav class="text-center">
						<ul class="pagination pagination-sm">
							<li class="disabled"><a href="javascript:void(0)">«</a></li>
							<li class="active"><a href="javascript:void(0)">1</a></li>
							<li><a href="javascript:void(0)">2</a></li>
							<li><a href="javascript:void(0)">3</a></li>
							<li><a href="javascript:void(0)">4</a></li>
							<li><a href="javascript:void(0)">5</a></li>
							<li><a href="javascript:void(0)">»</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
		
	</section>

	<!--====== Scripts -->
	<?php
	include VIEW_PATH .  "/component/scripts.php";
	?>
</body>
</html>