<!DOCTYPE html>
<html lang="es">
<title>Catálogo</title>
<?php
include VIEW_PATH . '/component/heat.php';
?>

<body>

    <?php
    include VIEW_PATH . '/component/sidebar.php';
    ?>
    <section class="full-box dashboard-contentPage">
        <?php
        include VIEW_PATH . '/component/navbar.php';
        ?>
        <div class="container-fluid ">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-book"></i> Catálogo <small> Libros</small></h1>
            </div>
        </div>

        <div class="container-fluid text-center">
    <div class="d-inline-block" style="max-width: 1200px; width: 100%;">
        <div class="card shadow-lg p-2 mb-5 bg-white rounded">
            <div class="card-body">
                <form action="<?= BASE_URL ?>/libros/search" method="GET" id="searchForm">
                    <div class="row g-2 align-items-center">
                        
                        <div class="col-12 col-md-4">
                            <input type="text" name="valor" class="form-control" placeholder="Buscar libro, autor o tema..." >
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
            <h2 class="text-titles text-center">Categoría seleccionada</h2>

            <div class="row ">
                <?php foreach ($libros as $libro): ?>
                    <div class=" col-sm-3 text-center">
                        <div class="book-card" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">

                            <div class="book-info">
                                <img src="<?= PUBLIC_PATH ?>/img/portada.png" alt="portada" class="img-responsive" style="max-height: 250px; display: block; margin: 0 auto;">

                                <h4 class="text-titles" style="margin-top: 10px;"><?= $libro->getTitulo() ?></h4>
                                <p><strong>Autor:</strong> <?php foreach ($libro->getAutores() as $autor) {
                                                                echo htmlspecialchars($autor->getNombre()) . ' ';
                                                            } ?></p>
                            </div>

                            <div class="book-actions" style="margin-top: 15px;">
                                <a href="<?= BASE_URL ?>/libros/show?id=<?= $libro->getIdLibro() ?>" class="btn btn-primary btn-sm" title="Más información"><i class="fa-solid fa-circle-info"></i> Más Info</a>
                                <a href="<?= BASE_URL ?>/libros/edit?id=<?= $libro->getIdLibro() ?>" class="btn btn-primary btn-sm" title="Gestionar libro"><i class="fa-solid fa-wrench"></i> Gestión</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="col-xs-12">
                <nav class="text-center">
                    <ul class="pagination pagination-sm">
                        <li class="disabled"><a href="javascript:void(0)">«</a></li>
                        <li class="active"><a href="javascript:void(0)">1</a></li>
                        <li><a href="javascript:void(0)">2</a></li>
                        <li><a href="javascript:void(0)">3</a></li>
                        <li><a href="javascript:void(0)">4</a></li>
                        <li><a href="javascript:void(0)">5</a></li>
                        <li><a href="javascript:void(0)">»</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        </div>


    </section>

    <?php include VIEW_PATH . '/component/scripts.php'; ?>
    <script>
function updateDropdown(field, value, text) {
    // Actualiza el valor oculto
    document.getElementById('input-' + field.replace('_', '-')).value = value;
    
    // Actualiza el texto del botón manteniendo el caret (la flechita)
    const labelBtn = document.getElementById('label-' + field.replace('_', '-'));
    labelBtn.innerHTML = text + ' <span class="caret"></span>';
}
</script>
</body>

</html>