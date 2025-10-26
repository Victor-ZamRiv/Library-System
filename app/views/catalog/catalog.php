<!DOCTYPE html>
<html lang="es">

<?php
include "../component/heat.php";
?>

<body>

    <?php
    include "../component/sidebar.php";
    ?>
    <section class="full-box dashboard-contentPage">
        <?php
        include "../component/navbar.php";
        ?>
        <div class="container-fluid ">
            <div class="page-header">
                <h1 class="text-titles"><i class="zmdi zmdi-book-image zmdi-hc-fw"></i> CATÁLOGO <small> LIBROS</small></h1>
            </div>
        </div>

        <div class="container-fluid text-center">
    <div class="d-inline-block" style="max-width: 1200px; width: 100%;">
    <div class="card shadow-lg p-2 mb-5 bg-white rounded">
        <div class="card-body">
            <div class="row justify-content-center mb-2 g-3 align-items-center">

                <div class="col-12 col-md-5 col-lg-4">
                    <input type="text" class="form-control" placeholder="Buscar libro, autor o tema...">
                </div>

                <div class="col-12 col-md-5 col-lg-5 d-flex justify-content-center justify-content-md-start flex-wrap gap-2 order-3 order-md-2">

                    <div class="btn-group">
                        <a href="javascript:void(0)" class="btn btn-default btn-raised">SALA</a>
                        <a href="javascript:void(0)" data-target="dropdown-menu" class="btn btn-default btn-raised dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#!">Sala A - Literatura Clásica</a></li>
                            <li><a href="#!">Sala B - Obras Modernas</a></li>
                            <li><a href="#!">Sala C - Referencia</a></li>
                        </ul>
                    </div>

                    <div class="btn-group">
                        <a href="javascript:void(0)" class="btn btn-default btn-raised">ÁREA</a>
                        <a href="javascript:void(0)" data-target="dropdown-menu" class="btn btn-default btn-raised dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#!">Ficción</a></li>
                            <li><a href="#!">No Ficción</a></li>
                            <li><a href="#!">Cómics/Manga</a></li>
                        </ul>
                    </div>

                    <div class="btn-group">
                        <a href="javascript:void(0)" class="btn btn-default btn-raised">ORDENAR POR</a>
                        <a href="javascript:void(0)" data-target="dropdown-menu" class="btn btn-default btn-raised dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#!">Título (A-Z)</a></li>
                            <li><a href="#!">Autor</a></li>
                            <li><a href="#!">Fecha de Publicación</a></li>
                            <li><a href="#!">Popularidad</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-12 col-md-2 col-lg-2 d-flex justify-content-center order-2 order-md-3">
                    <button class="btn btn-primary w-100" type="button">
                        <i class="fa-solid fa-magnifying-glass"></i> Buscar
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
        <div class="container-fluid">
            <h2 class="text-titles text-center">Categoría seleccionada</h2>

            <div class="row ">

                <div class=" col-sm-3 text-center">
                    <div class="book-card" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">

                        <div class="book-info">
                            <img src="../../../public/img/naruto-manga.webp" alt="Naruto Manga Cover" class="img-responsive" style="max-height: 250px; display: block; margin: 0 auto;">

                            <h4 class="text-titles" style="margin-top: 10px;">NARUTO</h4>
                            <p><strong>Autor:</strong> Kishimoto</p>
                        </div>

                        <div class="book-actions" style="margin-top: 15px;">
                            <a href="../book/book-info.php" class="btn btn-primary btn-sm" title="Más información"><i class="fa-solid fa-circle-info"></i> Más Info</a>
                            <a href="book-config.html" class="btn btn-primary btn-sm" title="Gestionar libro"><i class="fa-solid fa-wrench"></i> Gestión</a>
                        </div>
                    </div>
                </div>

                <div class=" col-sm-3 text-center">
                    <div class="book-card" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">

                        <div class="book-info">
                            <img src="../../../public/img/kny1.png" alt="KImetsu" class="img-responsive" style="max-height: 250px; display: block; margin: 0 auto;">

                            <h4 class="text-titles" style="margin-top: 10px;">Kimetsu no Yaiba</h4>
                            <p><strong>Autor:</strong> Koyoharu</p>
                        </div>

                        <div class="book-actions" style="margin-top: 15px;">
                            <a href="../book/book-info.php" class="btn btn-primary btn-sm" title="Más información"><i class="fa-solid fa-circle-info"></i> Más Info</a>
                            <a href="book-config.html" class="btn btn-primary btn-sm" title="Gestionar libro"><i class="fa-solid fa-wrench"></i> Gestión</a>
                        </div>
                    </div>
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

    <?php
    include "../component/scripts.php";
    ?>
</body>

</html>