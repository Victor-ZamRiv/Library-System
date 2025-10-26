<!DOCTYPE html>
<html lang="es">

	<title>Info Libro</title>
	<!-- SideBar -->
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
			  <h1 class="text-titles"><i class="zmdi zmdi-book zmdi-hc-fw"></i> INFORMACIÓN LIBRO</small></h1>
			</div>
		</div>
		
		<!-- Panel info libro -->
		<div class="container-fluid">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-info"></i> &nbsp; NARUTO</h3>
        </div>
        <div class="panel-body">
            
            <fieldset>
                <legend><i class="zmdi zmdi-library"></i> &nbsp; Información del Libro</legend>
                <div class="container-fluid" style="font-size: 1.1em;">
                    <div class="row">
                        <div class="col-xs-12">
                            <p><strong>Cota:</strong> <span style="font-family: monospace;">X N N6TY</span></p>
                        </div>
                        <div class="col-xs-12">
                            <p><strong>Título:</strong> Naruto</p>
                        </div>
                        <div class="col-xs-12">
                            <p><strong>Autor:</strong> <a href="#" class="text-primary">Kishimoto</a></p>
                        </div>
                        
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Edición:</strong> 3</p>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Ciudad:</strong> Tokio</p>
                        </div>

                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Editorial:</strong> Planeta</p>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Páginas:</strong> 21</p>
                        </div>
                        
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Fecha:</strong> 2005</p>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>ISBN:</strong> 1234-123-3242-12</p>
                        </div>

                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Ejemplares:</strong> 3</p>
                        </div>
                        <div class="col-xs-12">
                            <p><strong>Observaciones:</strong></p>
                        </div>
                        
                    </div>
                </div>
            </fieldset>
            
            <br>
            
            <fieldset>
				<legend><i class="zmdi zmdi-library"></i> &nbsp; Ejemplares</legend>
               
                <div class="container-fluid" style="font-size: 1.1em;">
                    <div class="row">
                        
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Ejemplar:</strong> e1</p>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Estado:</strong> Disponible</p>
                        </div>

                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Ejemplar:</strong> e2</p>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Estado:</strong> Disponible</p>
                        </div>

                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Ejemplar:</strong> e3</p>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Estado:</strong> Disponible</p>
                        </div>
                        
                        </div>
                </div>
            </fieldset>

        </div>
    </div>
</div>

	</section>

	<!--====== Scripts -->
	<!-- SideBar -->
	<?php include "../component/scripts.php" ?>
</body>
</html>