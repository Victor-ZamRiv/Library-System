<!DOCTYPE html>
<html lang="es">
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/css/style-book-info.css">
<style>
    /* Estilo auxiliar para alinear correctamente el botón en el encabezado */
    .panel-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
<title>Info Libro</title>
<?php include VIEW_PATH . '/component/heat.php'; ?>

<body>
    <?php include VIEW_PATH . '/component/sidebar.php'; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . '/component/navbar.php'; ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class=""></i> Información Libro</small></h1>
            </div>
        </div>

        <div class="container-fluid">
            <div class="panel panel-info">
                <div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                    <h3 class="panel-title" style="margin: 0;">
                        <i class="zmdi zmdi-info"></i> &nbsp; <?= htmlspecialchars($libro->getTitulo()) ?>
                    </h3>
                    
                    
                </div>
                
                <div class="panel-body">
                    <div class="ficha-bibliografica">

                        <div class="ficha-row">
                            <div class="cota-box ficha-item">
                                <div class="label-ficha">COTA</div>
                                <div class="content-ficha" style="text-decoration: none; margin-top:10px;">
                                    <?= nl2br(htmlspecialchars($libro->getCota())) ?>
                                </div>
                            </div>

                            <div style="flex-grow: 1;">
                                <div class="ficha-row" style="border-bottom: 1px solid #333;">
                                    <div class="ficha-item" style="width: 100%;">
                                        <span class="label-ficha">AUTOR:</span>
                                        <span class="content-ficha">
                                            <?php
                                            $nombres = array_map(fn($a) => $a->getNombre(), $libro->getAutores());
                                            echo htmlspecialchars(implode(", ", $nombres));
                                            ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="ficha-row">
                                    <div class="ficha-item" style="width: 100%; min-height: 60px;">
                                        <span class="label-ficha">TÍTULO:</span>
                                        <span class="content-ficha"><?= htmlspecialchars($libro->getTitulo()) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ficha-row">
                            <div class="ficha-item" style="flex: 1;">
                                <span class="label-ficha">EDICIÓN:</span>
                                <span class="content-ficha"><?= htmlspecialchars($libro->getEdicion() ?? 'N/A') ?></span>
                            </div>
                            <div class="ficha-item" style="flex: 1;">
                                <span class="label-ficha">CIUDAD:</span>
                                <span class="content-ficha"><?= htmlspecialchars($libro->getCiudad() ?? 'N/A') ?></span>
                            </div>
                        </div>

                        <div class="ficha-row">
                            <div class="ficha-item" style="width: 100%;">
                                <span class="label-ficha">EDITORIAL:</span>
                                <span class="content-ficha"><?= $libro->getEditorial() ? htmlspecialchars($libro->getEditorial()->getNombre()) : '---' ?></span>
                            </div>
                        </div>

                        <div class="ficha-row">
                            <div class="ficha-item" style="flex: 1;">
                                <span class="label-ficha">FECHA:</span>
                                <span class="content-ficha"><?= htmlspecialchars($libro->getAnioPublicacion() ?? '---') ?></span>
                            </div>
                            <div class="ficha-item" style="flex: 1;">
                                <span class="label-ficha">PAG. O VOL.:</span>
                                <span class="content-ficha"><?= htmlspecialchars($libro->getPaginas()) ?> Pág. / <?= htmlspecialchars($libro->getVolumen() ?? '1') ?></span>
                            </div>
                        </div>

                        <div class="ficha-row">
                            <div class="ficha-item" style="flex: 1;">
                                <span class="label-ficha">ISBN:</span>
                                <span class="content-ficha"><?= htmlspecialchars($libro->getIsbn() ?? 'N/A') ?></span>
                            </div>
                            <div class="ficha-item" style="flex: 1;">
                                <span class="label-ficha">EJEMPLARES:</span>
                                <span class="content-ficha">
                                    <?php
                                    if (!empty($libro->getEjemplares())) {
                                        echo count($libro->getEjemplares()) . " Unidades";
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>

                        <div class="ficha-row">
                            <div class="ficha-item" style="width: 100%; min-height: 80px;">
                                <span class="label-ficha">OBSERVACIONES:</span>
                                <span class="content-ficha"><?= htmlspecialchars($libro->getObservaciones() ?? 'S/O') ?></span>
                            </div>
                        </div>

                    </div>

                    <p class="text-center" style="margin-top: 20px;">
                        <a href="<?= BASE_URL ?>/libros" class="btn btn-secondary btn-raised">Volver</a>
                        <button onclick="window.print();" class="btn btn-info btn-raised">Imprimir Ficha</button>
                        <a href="<?= BASE_URL ?>/libros/edit?id=<?= $libro->getIdLibro() ?>" class="btn btn-warning btn-raised">Editar Libro</a>
                    </p>
                </div>
                <div class="etiqueta-lomo-oculta">

                    <div style="font-weight: bold;"><?= htmlspecialchars($libro->getIdsala()) ?></div>
                    <div style="font-weight: bold;"><?= htmlspecialchars($libro->getCota()) ?></div>

                </div>
            </div>
        </div>

    </section>

    

    <?php include VIEW_PATH . '/component/scripts.php'; ?>
</body>

</html>