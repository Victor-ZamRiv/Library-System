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

        /* TARJETA COMO LINK COMPLETAMENTE CLICKEABLE */
        .book-link {
            display: block;
            color: inherit;
            text-decoration: none !important;
        }
        .book-link:hover, .book-link:focus {
            color: inherit;
        }

        .book-card {
            position: relative; /* Necesario para posicionar la etiqueta */
            background: #fff;
            border: 1px solid #ccc;
            padding: 25px 15px 20px 15px; /* Ajuste de paddings para balancear el diseño sin botones */
            margin-bottom: 20px;
            overflow: hidden; 
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        /* ETIQUETA EN LA ESQUINA SUPERIOR DERECHA */
        .corner-tag {
            position: absolute;
            top: 0;
            right: 0;
            background-color: var(--ribbon-color, #95a5a6);
            color: #fff;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom-left-radius: 6px;
            box-shadow: -1px 1px 4px rgba(0,0,0,0.15);
            z-index: 10;
        }

    </style>
</head>

<body>

    <?php include VIEW_PATH . '/component/sidebar.php'; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . '/component/navbar.php'; ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-book"></i> Libros</h1>
            </div>
        </div>

        <div class="container-fluid text-center" style="display:flex; justify-content:center">
            <div class="d-inline-block" style="max-width: 1200px; width: 100%;">
                <div class="card shadow-lg p-2 mb-5 bg-white rounded">
                    <div class="card-body">
                        <form action="<?= BASE_URL ?>/libros" method="GET" id="searchForm">
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
                        
                        switch ($codigoSala) {
                            case 'G':
                                $imagenSala = 'portada-sala-general.png';
                                $hexColor = '#439a11';
                                $nombreSala = 'General';
                                break;
                            case 'R':
                                $imagenSala = 'portada-sala-referencia.png';
                                $hexColor = '#0555bd';
                                $nombreSala = 'Referencia';
                                break;
                            case 'SE':
                                $imagenSala = 'portada-sala-estatal.png';
                                $hexColor = '#d6d00f';
                                $nombreSala = 'Estatal';
                                break;
                            case 'X':
                                $imagenSala = 'portada-sala-infantil.png';
                                $hexColor = '#8b31bf';
                                $nombreSala = 'Infantil';
                                break;
                            default:
                                $imagenSala = 'portada.png';
                                $hexColor = '#95a5a6';
                                $nombreSala = 'Otro';
                                break;
                        }
                    ?>
                    
                    <div class="col-sm-3 text-center">
                        <a href="<?= BASE_URL ?>/libros/show?id=<?= $libro->getIdLibro() ?>" class="book-link">
                            <div class="book-card" style="--ribbon-color: <?= $hexColor ?>;">
                                
                                <div class="corner-tag"><?= $nombreSala ?></div>

                                <div class="book-info">
                                    <img src="<?= PUBLIC_PATH ?>/img/portadas-de-libros/<?= $imagenSala ?>"
                                         alt="Portada"
                                         class="img-responsive"
                                         style="max-height: 250px; display: block; margin: 0 auto;">

                                    <h4 class="text-titles" style="margin-top: 15px;"><?= $libro->getTitulo() ?></h4>
                                    <p style="margin-bottom: 0;"><strong>Autor:</strong> 
                                        <?php foreach ($libro->getAutores() as $autor) {
                                            echo htmlspecialchars($autor->getNombre()) . ' ';
                                        } ?>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="col-xs-12">
                <?php if (isset($paginacion) && $paginacion['ultima'] > 1): ?>
                <nav class="text-center">
                    <ul class="pagination pagination-sm">
                        <?php if ($paginacion['actual'] > 1): ?>
                            <li><a href="?page=1&<?= http_build_query(array_merge($filtros, ['page' => 1])) ?>">«</a></li>
                            <li><a href="?page=<?= $paginacion['actual']-1 ?>&<?= http_build_query($filtros) ?>">‹</a></li>
                        <?php else: ?>
                            <li class="disabled"><a href="#">«</a></li>
                        <?php endif; ?>
                        
                        <li class="active"><a href="#"><?= $paginacion['actual'] ?></a></li>
                        
                        <?php if ($paginacion['actual'] < $paginacion['ultima']): ?>
                            <li><a href="?page=<?= $paginacion['actual']+1 ?>&<?= http_build_query($filtros) ?>">›</a></li>
                            <li><a href="?page=<?= $paginacion['ultima'] ?>&<?= http_build_query($filtros) ?>">»</a></li>
                        <?php else: ?>
                            <li class="disabled"><a href="#">›</a></li>
                            <li class="disabled"><a href="#">»</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <?php endif; ?>
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