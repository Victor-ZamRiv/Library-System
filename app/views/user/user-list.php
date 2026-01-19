<!DOCTYPE html>
<html lang="es">
<!-- head -->
 <title>Lista de Usuarios</title>
<?php include "../component/heat.php" ?>

<body>
	<!-- SideBar -->
	<?php include "../component/sidebar.php" ?>

	<!-- Content page-->
	<section class="full-box dashboard-contentPage">
		<!-- NavBar -->

		<?php include "../component/navbar.php" ?>

		<!-- Content page -->
		<div class="container-fluid">
			<div class="page-header">
				<h1 class="text-titles"> Usuarios <small>Lista de Usuarios</small></h1>
			</div>
		</div>
		<?php include "../component/userbar.php" ?>

		<!-- Panel listado de administradores -->
		<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"> &nbsp; LISTA DE USUARIOS</h3>
				</div>
				<div class="panel-body">
					<div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="form-group label-floating">
                                <label class="control-label">¿A quién buscas?</label>
                                <input type="text" class="form-control" id="inputSearch">
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 text-right">
                            <br>
                            <button class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-search"></i> Buscar</button>
                        </div>
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
								<tr>
									<td>Admin</td>
									<td>0</td>
									<td>Firsh Admin</td>
									<td></td>
									<td></td>

									<td>
										<a href="#!" class="btn btn-success btn-raised btn-sm">

											<i class="fa-solid fa-info"></i>
										</a>
									</td>
									<td>
										<a href="#!" class="btn btn-danger btn-raised btn-sm">

											<i class="fa-solid fa-info"></i>
										</a>
									</td>
								</tr>
								<tr>
									<td>Administrador1</td>
									<td>27459925</td>
									<td>Victor Simón</td>
									<td>Zambrano Rivero</td>
									<td>0424-8630743</td>

									<td>
										<a href="#!" class="btn btn-success btn-raised btn-sm">
											<i class="fa-solid fa-info"></i>
										</a>
									</td>
									<td>
										<a href="#!" class="btn btn-danger btn-raised btn-sm">
											<i class="fa-solid fa-info"></i>
										</a>
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

	<?php include "../component/scripts.php" ?>

</body>

</html>