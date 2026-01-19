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
		<!-- contenido de la barra de navegacion -->




		<!-- Content page -->
		<div class="container-fluid" style="padding-top: 20px;">
    <div class="page-header text-center">
        <h2 class="text-titles">
            <i class="fa-solid fa-landmark"></i> Gestión de la Biblioteca "Armando Zuloaga Blanco"
        </h2>
        
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa-solid fa-users"></i> Perspectiva: Clientes</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <div class="well well-sm text-center">
                        <h5 class="text-uppercase text-titles">Cobertura de Usuarios</h5>
                        <h3 class="text-info">15%</h3>
                        <small class="text-muted">Meta: Ascendente</small>
                    </div>
                    <div class="well well-sm text-center">
                        <h5 class="text-uppercase text-titles">Consultas de Referencia</h5>
                        <h3 class="text-info">2.4</h3>
                        <small class="text-muted">Razón por usuario activo</small>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-8">
                    <div class="thumbnail" style="padding: 15px;">
                        <h5 class="text-center text-titles">Promedio de Consultas Mensuales</h5>
                        <div style="height: 180px;">
                            <canvas id="chartConsultas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa-solid fa-gears"></i> Perspectiva: Procesos Internos</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-md-5">
                    <div class="thumbnail" style="padding: 15px;">
                        <h5 class="text-center text-titles">Tasa de Cumplimiento de Plazos</h5>
                        <div style="height: 150px;">
                            <canvas id="chartPlazos"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-7">
                    <div class="row text-center">
                        <div class="col-xs-6 col-sm-4">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <i class="fa-solid fa-rotate fa-2x text-success"></i>
                                    <h5 style="font-size: 11px;">ROTACIÓN</h5>
                                    <p class="h4">24%</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <i class="fa-solid fa-chair fa-2x text-success"></i>
                                    <h5 style="font-size: 11px;">OCUPACIÓN</h5>
                                    <p class="h4">65%</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <i class="fa-solid fa-book-medical fa-2x text-success"></i>
                                    <h5 style="font-size: 11px;">ESTADO FÍSICO</h5>
                                    <p class="h4">92%</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <i class="fa-solid fa-map-location-dot fa-2x text-success"></i>
                                    <h5 style="font-size: 11px;">ASISTENCIA SALA ESTATAL</h5>
                                    <p class="h4">18%</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <i class="fa-solid fa-archive fa-2x text-success"></i>
                                    <h5 style="font-size: 11px;">COLECCIÓN ESTATAL</h5>
                                    <p class="h4">35%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa-solid fa-graduation-cap"></i> Perspectiva: Aprendizaje y Crecimiento</h3>
        </div>
        <div class="panel-body text-center">
            <div class="col-xs-12">
                <p class="lead text-titles">Participación en Actividades y Talleres</p>
                <div class="progress" style="height: 30px;">
                    <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" style="width: 25%; line-height: 30px; font-size: 16px;">
                        25% de Usuarios Registrados
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


		</div>
		<div class="container-fluid">
			<!-- contenedor de notificaciones -->
			<?php
			include "../component/notification.php";
			?>
			<!-- contenedor de notificaciones -->

			


		</div>
	</section>

	<!--====== Scripts -->
	<?php
	include "../component/scripts.php";
	?>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const optionsDefaults = {
        maintainAspectRatio: false,
        responsive: true,
        plugins: { legend: { position: 'bottom', labels: { boxWidth: 10 } } }
    };

    // Gráfica de Consultas (Clientes)
    new Chart(document.getElementById('chartConsultas'), {
        type: 'line',
        data: {
            labels: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
            datasets: [{
                label: 'Promedio Consultas',
                data: [40, 45, 38, 50, 42, 30],
                borderColor: '#2e6da4',
                backgroundColor: 'rgba(46, 109, 164, 0.1)',
                fill: true
            }]
        },
        options: optionsDefaults
    });

    // Gráfica de Plazos (Procesos Internos)
    new Chart(document.getElementById('chartPlazos'), {
        type: 'doughnut',
        data: {
            labels: ['A tiempo', 'Fuera de plazo'],
            datasets: [{
                data: [88, 12],
                backgroundColor: ['#5cb85c', '#d9534f']
            }]
        },
        options: optionsDefaults
    });
</script>
</body>

</html>