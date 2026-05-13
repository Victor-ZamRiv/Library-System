<!DOCTYPE html>
<html lang="es">

<head>
    <title>Catálogo</title>
    <?php include VIEW_PATH . '/component/heat.php'; ?>
    <style>
        /* LEYENDA MODERNA */
        .legend-container {
            background: #fff;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 8px;
        }
        .legend-flex {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            list-style: none;
            padding: 0;
        }
        .legend-item {
            display: flex;
            align-items: center;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            color: #555;
        }
        .dot {
            height: 12px;
            width: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }

        /* COLORES DE IDENTIFICACIÓN */
        .bg-general { background-color: #439a11 !important; }
        .bg-referencia { background-color: #0555bd !important; }
        .bg-estatal { background-color: #d6d00f !important; }
        .bg-infantil { background-color: #8b31bf !important; }

        /* TARJETA CON ESQUINA DE COLOR */
        .book-card {
            position: relative; /* Necesario para posicionar la esquina */
            background: #fff;
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            overflow: hidden; /* Corta el exceso del triángulo */
            transition: transform 0.2s;
        }
        
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

    </style>
</head>

<body>

    <?php include VIEW_PATH . '/component/sidebar.php'; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . '/component/navbar.php'; ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-book"></i> Catálogo <small> Libros</small></h1>
            </div>
        </div>

        <!-- BUSCADOR (Se mantienen tus estilos originales) -->
        <div class="container-fluid text-center">
            <div class="d-inline-block" style="max-width: 1200px; width: 100%;">
                <div class="card shadow-lg p-2 mb-5 bg-white rounded">
                    <div class="card-body">
                        <form action="<?= BASE_URL ?>/libros/search" method="GET" id="searchForm">
                            <div class="row g-2 align-items-center">
                                <div class="col-12 col-md-4">
                                    <input type="text" name="valor" class="form-control" placeholder="Buscar libro, autor o tema...">
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="d-flex flex-row gap-1 justify-content-center">
                                        <input type="hidden" name="sala" id="input-sala" value="todas">
                                        <input type="hidden" name="area" id="input-area" value="todas">
                                        <input type="hidden" name="campo" id="input-buscar-por" value="titulo">

                                        <div class="btn-group flex-fill">
                                            <button type="button" class="btn btn-default btn-raised btn-sm dropdown-toggle w-100" data-toggle="dropdown" id="label-sala">
                                                SALA <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="javascript:void(0)" onclick="updateDropdown('sala', 'G', 'General')">General</a></li>
                                                <li><a href="javascript:void(0)" onclick="updateDropdown('sala', 'R', 'Referencia')">Referencia</a></li>
                                                <li><a href="javascript:void(0)" onclick="updateDropdown('sala', 'SE', 'Estatal')">Estatal</a></li>
                                                <li><a href="javascript:void(0)" onclick="updateDropdown('sala', 'X', 'Infantil')">Infantil</a></li>
                                            </ul>
                                        </div>
                                        <div class="btn-group flex-fill">
                                            <button type="button" class="btn btn-default btn-raised btn-sm dropdown-toggle w-100" data-toggle="dropdown" id="label-area">
                                                ÁREA <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="javascript:void(0)" onclick="updateDropdown('area', 'N', 'Novela')">Novela</a></li>
                                                <li><a href="javascript:void(0)" onclick="updateDropdown('area', 'NV', 'Novela Venezolana')">Novela Venezolana</a></li>
                                            </ul>
                                        </div>
                                        <div class="btn-group flex-fill">
                                            <button type="button" class="btn btn-default btn-raised btn-sm dropdown-toggle w-100" data-toggle="dropdown" id="label-buscar-por">
                                                POR <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="javascript:void(0)" onclick="updateDropdown('buscar_por', 'autor', 'Autor')">Autor</a></li>
                                                <li><a href="javascript:void(0)" onclick="updateDropdown('buscar_por', 'titulo', 'Título')">Título</a></li>
                                                <li><a href="javascript:void(0)" onclick="updateDropdown('buscar_por', 'cota', 'Cota')">Cota</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-2">
                                    <button class="btn btn-primary w-100" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- LEYENDA MODERNA -->
        <div class="container-fluid">
            <div class="legend-container shadow-sm">
                <div class="legend-flex">
                    <div class="legend-item"><span class="dot bg-general"></span> General</div>
                    <div class="legend-item"><span class="dot bg-referencia"></span> Referencia</div>
                    <div class="legend-item"><span class="dot bg-estatal"></span> Estatal</div>
                    <div class="legend-item"><span class="dot bg-infantil"></span> Infantil</div>
                </div>
            </div>

            <h2 class="text-titles text-center">Categoría seleccionada</h2>

            <div class="row">
                <?php foreach ($libros as $libro): ?>
                    <?php
                        $codigoSala = (method_exists($libro, 'getIdSala')) ? $libro->getIdSala() : 'default';
                        
                        // Asignamos el color hexadecimal según la sala para el triángulo
                        switch ($codigoSala) {
                            case 'G':
                                $imagenSala = 'portada-sala-general.png';
                                $hexColor = '#3498db';
                                break;
                            case 'R':
                                $imagenSala = 'portada-sala-referencia.png';
                                $hexColor = '#e74c3c';
                                break;
                            case 'SE':
                                $imagenSala = 'portada-sala-estatal.png';
                                $hexColor = '#f1c40f';
                                break;
                            case 'X':
                                $imagenSala = 'portada-sala-infantil.png';
                                $hexColor = '#2ecc71';
                                break;
                            default:
                                $imagenSala = 'portada.png';
                                $hexColor = '#95a5a6';
                                break;
                        }
                    ?>
                    
                    <div class="col-sm-3 text-center">
                        <!-- Tarjeta con variable de color para la esquina -->
                        <div class="book-card" style="--ribbon-color: <?= $hexColor ?>;">
                            
                            <!-- El Triángulo en la esquina -->
                            <div class="corner-ribbon"></div>

                            <div class="book-info">
                                <img src="<?= PUBLIC_PATH ?>/img/portadas-de-libros/<?= $imagenSala ?>"
                                     alt="Portada"
                                     class="img-responsive"
                                     style="max-height: 250px; display: block; margin: 0 auto;">

                                <h4 class="text-titles" style="margin-top: 10px;"><?= $libro->getTitulo() ?></h4>
                                <p><strong>Autor:</strong> 
                                    <?php foreach ($libro->getAutores() as $autor) {
                                        echo htmlspecialchars($autor->getNombre()) . ' ';
                                    } ?>
                                </p>
                            </div>

                            <div class="book-actions" style="margin-top: 15px;">
                                <!-- Botones originales de tu código -->
                                <a href="<?= BASE_URL ?>/libros/show?id=<?= $libro->getIdLibro() ?>" class="btn btn-primary btn-sm" title="Más información">
                                    <i class="fa-solid fa-circle-info"></i> Más Info
                                </a>
                                <a href="<?= BASE_URL ?>/libros/edit?id=<?= $libro->getIdLibro() ?>" class="btn btn-primary btn-sm" title="Gestionar libro">
                                    <i class="fa-solid fa-wrench"></i> Gestión
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- PAGINACIÓN -->
            <div class="col-xs-12">
                <nav class="text-center">
                    <ul class="pagination pagination-sm">
                        <li class="disabled"><a href="javascript:void(0)">«</a></li>
                        <li class="active"><a href="javascript:void(0)">1</a></li>
                        <li><a href="javascript:void(0)">»</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . '/component/scripts.php'; ?>
    <script>
        function updateDropdown(field, value, text) {
            document.getElementById('input-' + field.replace('_', '-')).value = value;
            const labelBtn = document.getElementById('label-' + field.replace('_', '-'));
            labelBtn.innerHTML = text + ' <span class="caret"></span>';
        }
    </script>
</body>
</html>