<!DOCTYPE html>
<html lang="es">

	<title>Categorias</title>
 <?php include "../component/heat.php"; ?>
<body>
	<!-- SideBar -->
	<?php
	include "../component/sidebar.php";
	?>
	<!-- contenido de la barra lateral -->

	<!-- Content page-->
	<section class="full-box dashboard-contentPage">
		<!-- NavBar -->
		<?php include "../component/navbar.php" ?>
		<!-- Content page -->
		<div class="container-fluid">
			<div class="page-header">
			  <h1 class="text-titles"><i class="fa-solid fa-book"></i> Catálogo <small>Nueva Area de Conocimiento</small></h1>
			</div>
		</div>

				<?php include '../component/categorybar.php'; ?>


		<!-- Panel nueva categoria -->
		<div class="container-fluid">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; NUEVA CATEORÍA</h3>
				</div>
				<div class="panel-body">
					<form>
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-assignment-o"></i> &nbsp; Información de la categoría</legend>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Código </label>
										  	<input pattern="[0-9]{1,7}" class="form-control" type="text" name="codigo-reg" required="" maxlength="7">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Nombre </label>
										  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="nombre-reg" required="" maxlength="30">
										</div>
				    				</div>
				    			</div>
				    		</div>
				    	</fieldset>
					    <p class="text-center" style="margin-top: 20px;">
					    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
					    </p>
				    </form>
				</div>
			</div>
		</div>
		
	</section>

	<!--====== Scripts -->
	<?php include "../component/scripts.php" ?>
</body>
</html>