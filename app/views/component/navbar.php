<style>
    /* 1. Comportamiento en Escritorio (Desktop) */
    @media (min-width: 768px) {
        .dropdown:hover > .dropdown-menu {
            display: block;
            margin-top: 0;
        }
        #quick-search-box {
            position: absolute;
            right: 100%;
            top: 50%;
            transform: translateY(-50%);
            padding-right: 10px;
            z-index: 1100;
        }
        #input-search-quick {
            width: 180px;
            background-color: white !important;
            color: #333 !important;
        }
    }

    /* 2. Solución Responsive y Flechas Font Awesome (Móvil) */
    @media (max-width: 767px) {
        /* Bloquear cualquier inyección de texto de Material Icons */
        .dropdown-toggle::after { display: none !important; content: "" !important; }
        
        .navbar-nav .dropdown-toggle {
            display: flex !important;
            align-items: center;
            justify-content: space-between; /* Separa el texto de la flecha en móvil */
        }

        #quick-search-box {
            position: static !important;
            transform: none !important;
            padding: 10px 15px !important;
            width: 100%;
            background-color: #f9f9f9;
        }

        #input-search-quick {
            width: 100% !important;
            height: 40px;
            color: #333 !important;
            background-color: #fff !important;
            border: 1px solid #ccc !important;
        }

        .navbar-nav .open .dropdown-menu > li > a {
            padding-left: 30px !important;
            line-height: 35px;
        }
    }
    
    /* Estilo para las flechas Font Awesome */
    .fa-chevron-down {
        font-size: 0.8em;
        margin-left: 8px;
        transition: transform 0.3s ease;
    }
    
    /* Rotación de la flecha cuando el dropdown está abierto */
    .open > a > .fa-chevron-down {
        transform: rotate(-180deg);
    }
</style>

<nav class="navbar navbar-default full-box" style="border: none; border-bottom: 1px solid #e1e1e1; margin-bottom: 0;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-options">
                <i class="fa-solid fa-ellipsis-vertical"></i>
            </button>
            <a href="<?= BASE_URL ?>/dashboard" class="navbar-brand btn-menu-dashboard">
                <i class="fa-solid fa-bars"></i>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="navbar-options">
            <ul class="nav navbar-nav navbar-right">
                
                <li style="position: relative;">
                    <a href="javascript:void(0);" id="btn-search-toggle" style="display: flex; align-items: center; cursor: pointer;">
                        <i class="fa-solid fa-magnifying-glass"></i>&nbsp;<span class="hidden-sm">Buscar</span>
                    </a>
                    <div id="quick-search-box" style="display: none;">
                        <input type="text" id="input-search-quick" class="form-control" placeholder="Buscar libro..." autocomplete="off">
                    </div>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="fa-solid fa-users"></i> Visitas <i class="fa-solid fa-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= BASE_URL ?>/visitantes/registro">Registro de Visitas</a></li>
                        <li><a href="<?= BASE_URL ?>/visitantes">Gestión de Visitas</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="fa-solid fa-calendar"></i> Eventos <i class="fa-solid fa-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= BASE_URL ?>/eventos">Listado de Eventos</a></li>
                        <li><a href="<?= BASE_URL ?>/actividad/create">Registro de Actividades</a></li>
                        <li><a href="<?= BASE_URL ?>/logro/create">Registro de Logros</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        <i class="fa-solid fa-book"></i> Catálogo <i class="fa-solid fa-chevron-down"></i>
                    </a>
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
                        <li><a href="#">Lista de Préstamos</a></li>
                        <li><a href="#">Nuevo Préstamo</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#"><i class="fa-solid fa-hand-holding-dollar"></i> Multas</a></li>
                    </ul>
                </li>

                <li class="hidden-xs" style="display: flex; align-items: center; padding: 0 15px; height: 50px;">
                    <img src="<?= PUBLIC_PATH ?>/img/img-login/libro.png" alt="Logo" style="max-height: 40px; width: auto;">
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="contenedor-toast" id="contenedor-toast"></div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        const searchInput = $('#input-search-quick');
        const searchBox = $('#quick-search-box');

        // 1. Control del Buscador
        $(document).on('click', '#btn-search-toggle', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if ($(window).width() < 768) {
                searchBox.stop().slideToggle('fast');
            } else {
                searchBox.stop().fadeToggle('fast');
            }

            setTimeout(() => {
                if (searchBox.is(':visible')) searchInput.focus();
            }, 300);
        });

        // 2. Búsqueda con Enter (Aislada y Segura)
        searchInput.on('keypress', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                e.stopPropagation();
                var query = $(this).val().trim();
                if (query !== "") {
                    window.location.href = "<?= BASE_URL ?>/search?book=" + encodeURIComponent(query);
                }
            }
        });

        // 3. Cerrar al hacer clic fuera
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#btn-search-toggle, #quick-search-box').length) {
                if (searchBox.is(':visible')) {
                    if ($(window).width() < 768) {
                        searchBox.slideUp('fast');
                    } else {
                        searchBox.fadeOut('fast');
                    }
                }
            }
        });

        // 4. Toasts
        (function() {
            <?php if (isset($success) && $success): ?>
                if (typeof agregarToast === 'function') {
                    agregarToast({ tipo: 'exito', titulo: '¡Éxito!', descripcion: '<?= addslashes(htmlspecialchars($success)) ?>' });
                }
            <?php endif; ?>

            <?php if (isset($error) && $error): ?>
                if (typeof agregarToast === 'function') {
                    agregarToast({ tipo: 'error', titulo: 'Error', descripcion: '<?= addslashes(htmlspecialchars($error)) ?>' });
                }
            <?php endif; ?>
        })();
    });
</script>