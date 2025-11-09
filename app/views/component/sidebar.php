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
					<img src="../../../public/assets/avatars/AdminMaleAvatar.png" alt="UserIcon">
					<figcaption class="text-center text-titles">Nombre de usuario</figcaption>
				</figure>
				<ul class="full-box list-unstyled text-center">
					<li>
						<a href="../data/my-data.php" title="Mis datos">
							<i class="fa-solid fa-user"></i>
						</a>
					</li>
					<li>
						<a href="../data/my-account.php" title="Mi cuenta">
							<i class="fa-solid fa-gear"></i>
						</a>
					</li>
					<li>
						<a href="../login/login.php" title="Salir del sistema">
							<i class="fa-solid fa-door-open"></i>
						</a>
					</li>
				</ul>
			</div>
			<!-- Menú de barra lateral -->
			<ul class="list-unstyled full-box dashboard-sideBar-Menu">
				<li>
					<a href="../home/home.php">
						<i class="fa-solid fa-gauge"></i> Dashboard
					</a>
				</li>
				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						Catálogo <i class="fa-solid fa-caret-down"></i>
					</a>
					<ul class="list-unstyled full-box">
						<li>
							<a href="../category/category.php"> Categorías</a>
						</li>
						<li>
							<a href="../catalog/catalog.php"> Libros</a>
						</li>
						
						<li>
							<a href="../book/book.php"> Nuevo libro</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						 Préstamos <i class="fa-solid fa-caret-down"></i>
					</a>
					<ul class="list-unstyled full-box">
						
						<li>
							<a href="#"> Préstamo </a>
						</li>
						
					
						
						<li>
							<a href="../fine/fine.php"> Multa</a>
						</li>
						
					
					</ul>
					
				</li>
				
				
				<li>
					<a href="#!" class="btn-sideBar-SubMenu">
						 Usuarios <i class="fa-solid fa-caret-down"></i>
					</a>
					<ul class="list-unstyled full-box">
						
						<li>
							<a href="../admin/admin.php"> Administradores</a>
						</li>
						<li>
							<a href="#"> Bibliotecarios</a>
						</li>
						<li>
							<a href="#"> Jefes de sala</a>
						</li>
						
					</ul>
						<li>
							<a href="#"> Lectores</a>
						</li>
					</ul>
				</li>	
				
			</ul>
		</div>
	</section>
