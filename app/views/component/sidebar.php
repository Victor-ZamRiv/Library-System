	<?php include  VIEW_PATH . "/component/notification.php"; ?>

	<style>
	    /* Resaltado Azul Sidebar (Más oscuro y conciso) */
	    .dashboard-sideBar-Menu li.active>a {
	        background-color: #1b4f72 !important;
	        /* Azul petróleo oscuro */
	        color: #ffffff !important;
	        font-weight: bold;
	        border-left: 5px solid #007bff;
	        /* Indicador azul brillante */
	    }

	    .dashboard-sideBar-Menu li.active>a i {
	        color: #ffffff !important;
	    }

	    .dashboard-sideBar-Menu li a:hover {
	        background-color: rgba(0, 123, 255, 0.1);
	        color: #007bff;
	        text-decoration: none;
	    }

	    /* Estilo para que el submenú se vea jerárquico cuando está activo */
	    .dashboard-sideBar-Menu ul li.active>a {
	        background-color: #21618c !important;
	        /* Un tono ligeramente distinto para sub-elementos */
	        border-left: 3px solid #3498db;
	    }
	</style>



	<section class="full-box cover dashboard-sideBar">
	    <div class="full-box dashboard-sideBar-bg btn-menu-dashboard"></div>
	    <div class="full-box dashboard-sideBar-ct">
	        <div class="full-box text-uppercase text-center text-titles dashboard-sideBar-title">
	            Biblioteca Pública
	        </div>
	        <div class="full-box dashboard-sideBar-UserInfo">
	            <figure class="full-box">
	                <img src="<?= PUBLIC_PATH ?>/assets/avatars/AdminMaleAvatar.png" alt="UserIcon">
	                <figcaption class="text-center text-titles"><?= $_SESSION['administrador']['nombre_usuario'] ?></figcaption>
	            </figure>
	            <ul class="full-box list-unstyled text-center">
	                <li><a href="<?= BASE_URL ?>/administradores/show?id=<?= $_SESSION['administrador']['id'] ?>"><i class="fa-solid fa-user"></i></a></li>
	                <li><a href="#" data-toggle="modal" data-target="#logoutModal"><i class="fa-solid fa-door-open"></i></a></li>
	            </ul>
	        </div>
	        <ul class="list-unstyled full-box dashboard-sideBar-Menu">
	            <!-- Dashboard: Visible para todos -->
	            <li><a href="<?= BASE_URL ?>/dashboard"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>

<<<<<<< HEAD
	            <!-- Lectores: Bibliotecario, Jefe de Sala y Director -->
	            <li style="<?= $styleVisitas ?>"><a href="<?= BASE_URL ?>/lectores"><i class="fa-solid fa-book-open-reader"></i> Lectores</a></li>
=======
    <!-- Configuración: SOLO DIRECTOR -->
    <li style="<?= $styleAdminOnly ?>">
        <a href="#!" class="btn-sideBar-SubMenu">
            <i class="fa-solid fa-gears"></i> Configuración <i class="fa-solid fa-caret-down"></i>
        </a>
        <ul class="list-unstyled full-box">
            <li><a href="<?= BASE_URL ?>/configuracion/indicator">Indicadores</a></li>
            <li><a href="<?= BASE_URL ?>/configuracion/sala">Salas</a></li>
            
            <li><a href="<?= BASE_URL ?>/configuracion/prestamos"> Prestamos</a></li>
            <li><a href="<?= BASE_URL ?>/historial"> Historial</a></li>
        </ul>
    </li>
</ul>
    </div>
</section>
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908

	            <!-- Usuarios: SOLO DIRECTOR -->
	            <li style="<?= $styleAdminOnly ?>">
	                <a href="#!" class="btn-sideBar-SubMenu">
	                    <i class="fa-solid fa-user"></i> Usuarios <i class="fa-solid fa-caret-down"></i>
	                </a>
	                <ul class="list-unstyled full-box">
	                    <li><a href="<?= BASE_URL ?>/administradores/register"> Nuevo Usuario</a></li>
	                    <li><a href="<?= BASE_URL ?>/administradores"> Lista de Usuarios</a></li>
	                </ul>
	            </li>
	            <!-- Reportes: SOLO DIRECTOR -->
	            <li style="<?= $styleAdminOnly ?>">
	                <a href="#!" class="btn-sideBar-SubMenu">
	                    <i class="fa-solid fa-user"></i> Reportes <i class="fa-solid fa-caret-down"></i>
	                </a>
	                <ul class="list-unstyled full-box">
	                    <li><a href="<?= BASE_URL ?>/reportes/operativo"> Reporte Institucional</a></li>
	                </ul>
	            </li>

	            <!-- Configuración: SOLO DIRECTOR -->
	            <li style="<?= $styleAdminOnly ?>">
	                <a href="#!" class="btn-sideBar-SubMenu">
	                    <i class="fa-solid fa-gears"></i> Configuración <i class="fa-solid fa-caret-down"></i>
	                </a>
	                <ul class="list-unstyled full-box">
	                    <li><a href="<?= BASE_URL ?>/configuracion/indicator">Indicadores</a></li>
	                    <li><a href="<?= BASE_URL ?>/configuracion/sala">Salas</a></li>

	                    <li><a href="<?= BASE_URL ?>/configuracion/prestamos"> Prestamos</a></li>
	                    <li><a href="<?= BASE_URL ?>/historial"> Historial</a></li>
	                </ul>
	            </li>
	        </ul>
	    </div>
	</section>

	<script>
	    document.addEventListener('keydown', function(e) {
	        // 1. Evitar ejecuciones accidentales si el usuario está escribiendo en un formulario
	        const activo = document.activeElement.tagName;
	        if (activo === 'INPUT' || activo === 'TEXTAREA' || document.activeElement.isContentEditable) {
	            return;
	        }

	        // Convertir la tecla presionada a minúscula para estandarizar la validación
	        const tecla = e.key.toLowerCase();

	        // 2. Evaluar combinaciones con la tecla ALT
	        if (e.altKey) {
	            switch (tecla) {
	                case 'p': // Alt + P: Nuevo Préstamo
	                    e.preventDefault(); // Detiene acciones nativas del navegador si las hay
	                    window.location.href = '<?= BASE_URL ?>/prestamos/create';
	                    break;

	                case 'c': // Alt + C: Catálogo / Lista de Libros
	                    e.preventDefault();
	                    window.location.href = '<?= BASE_URL ?>/libros';
	                    break;

	                case 'd': // Alt + D: Lista de Préstamos / Devoluciones
	                    e.preventDefault();
	                    window.location.href = '<?= BASE_URL ?>/prestamos';
	                    break;

	                case 'l': // Alt + L: Nuevo Lector
	                    e.preventDefault();
	                    window.location.href = '<?= BASE_URL ?>/lectores/create';
	                    break;

	                case 'v': // Alt + V: Registro de Visitas
	                    e.preventDefault();
	                    window.location.href = '<?= BASE_URL ?>/visitantes/registro';
	                    break;

	                case 'h': // Alt + h: Vista del dashboard
	                    e.preventDefault();
	                    window.location.href = '<?= BASE_URL ?>/dashboard';
	                    break;
	            }
	        }
	    });
	    document.addEventListener("DOMContentLoaded", function() {
	        const currentUrl = window.location.href.split(/[?#]/)[0]; // Quitamos parámetros para comparar rutas limpias
	        let matchFound = false;

	        // 1. PASO: Buscar coincidencia EXACTA
	        $('.dashboard-sideBar-Menu a').each(function() {
	            const href = this.href; // Obtenemos la URL completa del enlace
	            if (href && !href.includes('#!')) {
	                if (currentUrl === href) {
	                    $(this).closest('li').addClass('active');

	                    // Si es un hijo, marcar el contenedor padre
	                    const subMenu = $(this).closest('ul');
	                    if (!subMenu.hasClass('dashboard-sideBar-Menu')) {
	                        subMenu.closest('li').addClass('active');
	                    }
	                    matchFound = true;
	                    return false; // Salir del bucle
	                }
	            }
	        });

	        // 2. PASO: Si no hubo exacta, buscar por inclusión (Para páginas con IDs o parámetros)
	        if (!matchFound) {
	            $('.dashboard-sideBar-Menu a').each(function() {
	                const href = $(this).attr('href');
	                if (href && href.length > 5 && currentUrl.includes(href)) {
	                    $(this).closest('li').addClass('active');
	                    const subMenu = $(this).closest('ul');
	                    if (!subMenu.hasClass('dashboard-sideBar-Menu')) {
	                        subMenu.closest('li').addClass('active');
	                    }
	                    return false;
	                }
	            });
	        }
	    });
	</script>

	<?php include VIEW_PATH . "/modal/confirmation-log-out.php" ?>



	<script>
	    // 4. Toasts
	    (function() {
	        // Bloque de Éxito
	        <?php if (isset($success) && $success): ?>
	            if (typeof agregarToast === 'function') {
	                agregarToast({
	                    tipo: 'exito',
	                    titulo: '¡Éxito!',
	                    descripcion: '<?= addslashes(htmlspecialchars($success)) ?>'
	                });
	            }
	        <?php endif; ?>

	        // Bloque de Error
	        <?php if (isset($error) && $error): ?>
	            if (typeof agregarToast === 'function') {
	                agregarToast({
	                    tipo: 'error',
	                    titulo: 'Error',
	                    descripcion: '<?= addslashes(htmlspecialchars($error)) ?>'
	                });
	            }
	        <?php endif; ?>

	        // Bloque de Info (NUEVO)
	        <?php if (isset($info) && $info): ?>
	            if (typeof agregarToast === 'function') {
	                agregarToast({
	                    tipo: 'info',
	                    titulo: 'Información',
	                    descripcion: '<?= addslashes(htmlspecialchars($info)) ?>'
	                });
	            }
	        <?php endif; ?>

	        // Bloque de Warning (NUEVO)
	        <?php if (isset($warning) && $warning): ?>
	            if (typeof agregarToast === 'function') {
	                agregarToast({
	                    tipo: 'warning',
	                    titulo: 'Atención',
	                    descripcion: '<?= addslashes(htmlspecialchars($warning)) ?>'
	                });
	            }
	        <?php endif; ?>
	    })();
	</script>