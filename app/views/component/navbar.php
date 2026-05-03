<style>
    @media (min-width: 768px) {
        .dropdown:hover > .dropdown-menu { display: block; margin-top: 0; }
        #quick-search-box {
            position: absolute; right: 100%; top: 50%;
            transform: translateY(-50%); padding-right: 10px; z-index: 1100;
        }
        #input-search-quick { 
            width: 180px; 
            background-color: white !important; 
            color: #333 !important; 
            border: 1px solid #0056b3 !important;
        }
    }

    @media (max-width: 767px) {
        #quick-search-box {
            position: static !important; transform: none !important;
            padding: 10px 15px !important; width: 100%; background-color: #f1f1f1;
        }
        #input-search-quick { width: 100% !important; height: 40px; }
    }

    /* Resaltado Azul Navbar */
    .navbar-nav > li.active > a {
        background-color: #e7f1ff !important; 
        color: #004085 !important;
        font-weight: 600;
    }
    .dropdown-menu > li.active > a {
        background-color: #0056b3 !important;
        color: #ffffff !important;
    }
    .fa-chevron-down { transition: transform 0.3s ease; }
    .open > a > .fa-chevron-down { transform: rotate(-180deg); }
</style>

<nav class="navbar navbar-default full-box" style="border: none; border-bottom: 1px solid #e1e1e1; margin-bottom: 0;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-options">
                <i class="fa-solid fa-ellipsis-vertical"></i>
            </button>
            <a href="<?= BASE_URL ?>/dashboard" class="navbar-brand btn-menu-dashboard"><i class="fa-solid fa-bars"></i></a>
        </div>

        <div class="collapse navbar-collapse" id="navbar-options">
            <ul class="nav navbar-nav navbar-right">
                

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa-solid fa-users"></i> Visitas <i class="fa-solid fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= BASE_URL ?>/visitantes/registro">Registro de Visitas</a></li>
                        <li><a href="<?= BASE_URL ?>/visitantes">Gestión de Visitas</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa-solid fa-book"></i> Catálogo <i class="fa-solid fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= BASE_URL ?>/libros/opcion">Registro de Libros</a></li>
                        <li><a href="<?= BASE_URL ?>/libros">Libros</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="fa-solid fa-bookmark"></i> Préstamos <i class="fa-solid fa-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= BASE_URL ?>/prestamos">Lista de Préstamos</a></li>
                        <li><a href="<?= BASE_URL ?>/prestamos/create">Nuevo Préstamo</a></li>                      
                        <li role="separator" class="divider"></li>
                        <li><a href="<?= BASE_URL ?>/multas"><i class="fa-solid fa-hand-holding-dollar"></i> Multas</a></li>
                    </ul>
                </li>

                <li class="hidden-xs" style="display: flex; align-items: center; padding: 0 15px; height: 50px;">
                    <img src="<?= PUBLIC_PATH ?>/img/img-login/libro.png" alt="Logo" style="max-height: 40px;">
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const currentUrl = window.location.href;
        const currentPath = window.location.pathname;

        // Resaltado Navbar
        $('.navbar-nav a').each(function() {
            const href = $(this).attr('href');
            if (href && href !== "#" && (currentUrl.endsWith(href) || currentPath.endsWith(href))) {
                $(this).closest('li').addClass('active');
                if ($(this).closest('.dropdown-menu').length) $(this).closest('.dropdown').addClass('active');
            }
        });

       
    });
</script>
