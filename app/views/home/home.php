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
		<div class="container-fluid">
			<div class="page-header">
				<h1 class="text-titles">Sistema <small>Gestion Bibliografica</small></h1>
			</div>
		</div>
		<div class="full-box text-center" style="padding: 30px 10px;">
			<article class="full-box tile">
				<div class="full-box tile-title text-center text-titles text-uppercase">
					Administradores
				</div>
				<div class="full-box tile-icon text-center">
					<i class="fa-solid fa-user-tie"></i>
				</div>
				<div class="full-box tile-number text-titles">
					<p class="full-box">7</p>
					<small>Registrados</small>
				</div>
			</article>
			<article class="full-box tile">
				<div class="full-box tile-title text-center text-titles text-uppercase">
					Blibliotecarios
				</div>
				<div class="full-box tile-icon text-center">
					<i class="fa-solid fa-address-book"></i>
				</div>
				<div class="full-box tile-number text-titles">
					<p class="full-box">10</p>
					<small>Registrados</small>
				</div>
			</article>

			<article class="full-box tile">
				<div class="full-box tile-title text-center text-titles text-uppercase">
					visitantes
				</div>
				<div class="full-box tile-icon text-center">
					<i class="fa-solid fa-users"></i>
				</div>
				<div class="full-box tile-number text-titles">
					<p class="full-box">10</p>
					<small>Registrados</small>
				</div>
			</article>


		</div>
		<div class="container-fluid">


			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-chart-bar"></i> &nbsp; Biblioteca <small>Libros Más Solicitados</small></h3>
				</div>
				<div class="panel-body">

					<section id="book-ranking" class="cd-container">

						<div class="book-ranking-block">
							<div class="book-ranking-position text-info">
								<i class="zmdi zmdi-star zmdi-hc-2x"></i>
								<span>#1</span>
							</div>
							<div class="book-ranking-content">
								<h4 class="text-dark font-weight-bold mb-1">Cien años de soledad</h4>
								<p class="text-muted small mb-0">
									<i class="zmdi zmdi-account-box zmdi-hc-fw"></i> Autor: <em>Gabriel García Márquez</em>
								</p>
								<p class="text-muted small mb-1">
									<i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i> Total de Préstamos: <strong>125</strong>
								</p>
								<span class="badge badge-info">
									<i class="zmdi zmdi-labels zmdi-hc-fw"></i> Ficción
								</span>
							</div>
						</div>

						<div class="book-ranking-block">
							<div class="book-ranking-position text-info">
								<i class="zmdi zmdi-chevron-up zmdi-hc-2x"></i>
								<span>#2</span>
							</div>
							<div class="book-ranking-content">
								<h4 class="text-dark font-weight-bold mb-1">El código Da Vinci</h4>
								<p class="text-muted small mb-0">
									<i class="zmdi zmdi-account-box zmdi-hc-fw"></i> Autor: <em>Dan Brown</em>
								</p>
								<p class="text-muted small mb-1">
									<i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i> Total de Préstamos: <strong>98</strong>
								</p>
								<span class="badge badge-info">
									<i class="zmdi zmdi-labels zmdi-hc-fw"></i> Thriller
								</span>
							</div>
						</div>

						<div class="book-ranking-block">
							<div class="book-ranking-position text-info">
								<i class="zmdi zmdi-pin-drop zmdi-hc-2x"></i>
								<span>#3</span>
							</div>
							<div class="book-ranking-content">
								<h4 class="text-dark font-weight-bold mb-1">Sapiens: De animales a dioses</h4>
								<p class="text-muted small mb-0">
									<i class="zmdi zmdi-account-box zmdi-hc-fw"></i> Autor: <em>Yuval Noah Harari</em>
								</p>
								<p class="text-muted small mb-1">
									<i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i> Total de Préstamos: <strong>85</strong>
								</p>
								<span class="badge badge-info">
									<i class="zmdi zmdi-labels zmdi-hc-fw"></i> No Ficción
								</span>
							</div>
						</div>

						<div class="book-ranking-block">
							<div class="book-ranking-position text-info">
								<i class="zmdi zmdi-bookmark zmdi-hc-2x"></i>
								<span>#4</span>
							</div>
							<div class="book-ranking-content">
								<h4 class="text-dark font-weight-bold mb-1">1984</h4>
								<p class="text-muted small mb-0">
									<i class="zmdi zmdi-account-box zmdi-hc-fw"></i> Autor: <em>George Orwell</em>
								</p>
								<p class="text-muted small mb-1">
									<i class="zmdi zmdi-bookmark-outline zmdi-hc-fw"></i> Total de Préstamos: <strong>70</strong>
								</p>
								<span class="badge badge-info">
									<i class="zmdi zmdi-labels zmdi-hc-fw"></i> Distopía
								</span>
							</div>
						</div>

					</section>
				</div>
			</div>
		</div>
		<!-- <div class="container-fluid">
			<div class="page-header">
				<h1 class="text-titles">Sistema <small>Tempo en linea</small></h1>
			</div>
			<section id="cd-timeline" class="cd-container">
				<div class="cd-timeline-block">
					<div class="cd-timeline-img">
						<img src="assets/avatars/StudetMaleAvatar.png" alt="user-picture">
					</div>
					<div class="cd-timeline-content">
						<h4 class="text-center text-titles">1 - Name (Admin)</h4>
						<p class="text-center">
							<i class="zmdi zmdi-timer zmdi-hc-fw"></i> Start: <em>7:00 AM</em> &nbsp;&nbsp;&nbsp;
							<i class="zmdi zmdi-time zmdi-hc-fw"></i> End: <em>7:17 AM</em>
						</p>
						<span class="cd-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i> 07/07/2016</span>
					</div>
				</div>
				<div class="cd-timeline-block">
					<div class="cd-timeline-img">
						<img src="assets/avatars/StudetMaleAvatar.png" alt="user-picture">
					</div>
					<div class="cd-timeline-content">
						<h4 class="text-center text-titles">2 - Name (Teacher)</h4>
						<p class="text-center">
							<i class="zmdi zmdi-timer zmdi-hc-fw"></i> Start: <em>7:00 AM</em> &nbsp;&nbsp;&nbsp;
							<i class="zmdi zmdi-time zmdi-hc-fw"></i> End: <em>7:17 AM</em>
						</p>
						<span class="cd-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i> 07/07/2016</span>
					</div>
				</div>
				<div class="cd-timeline-block">
					<div class="cd-timeline-img">
						<img src="assets/avatars/StudetMaleAvatar.png" alt="user-picture">
					</div>
					<div class="cd-timeline-content">
						<h4 class="text-center text-titles">3 - Name (Student)</h4>
						<p class="text-center">
							<i class="zmdi zmdi-timer zmdi-hc-fw"></i> Start: <em>7:00 AM</em> &nbsp;&nbsp;&nbsp;
							<i class="zmdi zmdi-time zmdi-hc-fw"></i> End: <em>7:17 AM</em>
						</p>
						<span class="cd-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i> 07/07/2016</span>
					</div>
				</div>
				<div class="cd-timeline-block">
					<div class="cd-timeline-img">
						<img src="assets/avatars/StudetMaleAvatar.png" alt="user-picture">
					</div>
					<div class="cd-timeline-content">
						<h4 class="text-center text-titles">4 - Name (Personal Ad.)</h4>
						<p class="text-center">
							<i class="zmdi zmdi-timer zmdi-hc-fw"></i> Start: <em>7:00 AM</em> &nbsp;&nbsp;&nbsp;
							<i class="zmdi zmdi-time zmdi-hc-fw"></i> End: <em>7:17 AM</em>
						</p>
						<span class="cd-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i> 07/07/2016</span>
					</div>
				</div>
			</section> -->


		</div>
	</section>

	<!--====== Scripts -->
	<?php
	include "../component/scripts.php";
	?>
</body>

</html>