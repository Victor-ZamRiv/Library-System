<!-- barra lateral -->
<section class="full-box cover dashboard-sideBar">
	<div class="full-box dashboard-sideBar-bg btn-menu-dashboard"></div>
	<div class="full-box dashboard-sideBar-ct">
		<!--Titulo de la barra lateral -->
		<div class="full-box text-uppercase text-center text-titles dashboard-sideBar-title">
			Biblioteca Publica <i class="zmdi zmdi-close btn-menu-dashboard visible-xs"></i>
		</div>
		<!-- Información del usuario de la barra lateral -->
		<div class="full-box dashboard-sideBar-UserInfo">
			<figure class="full-box">
				<img src=<?php echo PUBLIC_PATH . "/assets/avatars/AdminMaleAvatar.png"?> alt="UserIcon">
				<figcaption class="text-center text-titles"><?= $_SESSION['administrador']['nombre_usuario'] ?></figcaption>
			</figure>
			<ul class="full-box list-unstyled text-center">
				<li>
					<a href="<?= BASE_URL ?>/administradores/show?id=<?= $_SESSION['administrador']['id'] ?>" title="Mis datos">
						<i class="fa-solid fa-user"></i>
					</a>
				</li>

				<li>
					<a href="<?= BASE_URL ?>/logout" title="Salir del sistema">
						<i class="fa-solid fa-door-open"></i>
					</a>
				</li>
			</ul>
		</div>
		<!-- Menú de barra lateral -->
		<ul class="list-unstyled full-box dashboard-sideBar-Menu">
			<li>
				<a href="<?= BASE_URL ?>/dashboard">
					<i class="fa-solid fa-gauge"></i> Dashboard 
				</a>
			</li>
			<li>
				<a href="<?= BASE_URL ?>/lectores"> 
					<i class="fa-solid fa-book-open-reader"></i> Lectores</a>
			</li>
			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="fa-solid fa-users"></i>  Visitantes <i class="fa-solid fa-caret-down"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="../visitors/visitor.php"> Registro de Visitantes</a>
					</li>
					<li>
						<a href="../visitors/visitor-list.php"> Gestión de  de Visitantes</a>
					</li>

				</ul>
			</li>

			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="fa-solid fa-calendar"></i> Eventos <i class="fa-solid fa-caret-down"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="<?= BASE_URL ?>/actividad/create"> Registro de Actividades</a>
					</li>
					<li>
						<a href="<?= BASE_URL ?>/logro/create"> Registro de Logros</a>
					</li>
					<li>
						<a href="<?= BASE_URL ?>/evento-list"> Lista de Eventos</a>
					</li>

				</ul>
			</li>
			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="fa-solid fa-book"></i> Catálogo <i class="fa-solid fa-caret-down"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="<?php //../category/category.php?>"> Areas de Conocimiento</a>
					</li>
					<li>
						<a href= <?php echo BASE_URL ."/libros"; ?>> Libros</a>
					</li>

					<li>
						<a href= <?php echo BASE_URL ."/libros/create"; ?>> Nuevo libro</a>
					</li>
				</ul>
			</li>


			


			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="fa-solid fa-bookmark"></i> Préstamo <i class="fa-solid fa-caret-down"></i>
				</a>
				<ul class="list-unstyled full-box">
					<li>
						<a href="../loan/loan-list.php"> Lista de Préstamos </a>
					</li>
					<li>
						<a href="../loan/loan.php"> Nuevo Préstamo </a>
					</li>
					<li>
						<a href="../fine/fine.php"> Multa</a>
					</li>
				</ul>
			</li>

			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="fa-solid fa-user"></i> Usuarios <i class="fa-solid fa-caret-down"></i>
				</a>
				<ul class="list-unstyled full-box">

					<li>
						<a href="<?= BASE_URL ?>/administradores/register"> Nuevo Usuario</a>
					</li>
					<li>
						<a href="<?= BASE_URL ?>/administradores"> Lista de Usuarios</a>
					</li>


				</ul>

			<li>
				<a href="#!" class="btn-sideBar-SubMenu">
					<i class="fa-solid fa-gears"></i> Configuración <i class="fa-solid fa-caret-down"></i>
				</a>
				<ul class="list-unstyled full-box">

					<li>
						<a href="#">Salas </a>
					</li>
				</ul>

			</li>
			
		</ul>
		</li>

		</ul>
	</div>
</section>