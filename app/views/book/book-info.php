<!DOCTYPE html>
<html lang="es">
<style>
    .ficha-bibliografica {
        background-color: #fff;
        border: 2px solid #333;
        padding: 0;
        font-family: 'Courier New', Courier, monospace;
        /* Fuente estilo máquina de escribir */
        color: #000;
        max-width: 800px;
        margin: 20px auto;
        text-transform: uppercase;
        /* La mayoría de las fichas usan mayúsculas */
    }

    .ficha-row {
        display: flex;
        border-bottom: 1px solid #333;
    }

    .ficha-row:last-child {
        border-bottom: none;
    }

    .ficha-item {
        padding: 8px;
        border-right: 1px solid #333;
    }

    .ficha-item:last-child {
        border-right: none;
    }

    .label-ficha {
        font-weight: bold;
        font-size: 0.85em;
        margin-right: 5px;
    }

    .content-ficha {
        font-size: 1.1em;
        text-decoration: underline;
        /* Simula la línea donde se escribe */
    }

    /* Estilo específico para la COTA (el recuadro lateral) */
    .cota-box {
        width: 150px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-right: 2px solid #333;
    }

    @media print {

        .sidebar,
        .navbar,
        .btn,
        .page-header {
            display: none !important;
        }

        .ficha-bibliografica {
            border: 2px solid #000;
            width: 100%;
        }

        .full-box {
            margin: 0;
            padding: 0;
        }
    }
</style>
<title>Info Libro</title>
<!-- SideBar -->
<?php include VIEW_PATH . '/component/heat.php'; ?>

<body>
    <!-- SideBar -->
    <?php include VIEW_PATH . '/component/sidebar.php'; ?>

    <!-- Content page-->
    <section class="full-box dashboard-contentPage">
        <!-- NavBar -->

        <?php include VIEW_PATH . '/component/navbar.php'; ?>

        <!-- Content page -->
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class=""></i> Información Libro</small></h1>
            </div>
        </div>

        <div class="container-fluid">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="zmdi zmdi-info"></i> &nbsp; <?= htmlspecialchars($libro->getTitulo()) ?></h3>
                </div>
                <div class="panel-body">
                    <div class="ficha-bibliografica">

                        <!-- Fila Superior: Cota, Autor y Título -->
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
                                        <span class="label-ficha">TITULO:</span>
                                        <span class="content-ficha"><?= htmlspecialchars($libro->getTitulo()) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fila Edición y Ciudad -->
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

                        <!-- Fila Editorial -->
                        <div class="ficha-row">
                            <div class="ficha-item" style="width: 100%;">
                                <span class="label-ficha">EDITORIAL:</span>
                                <span class="content-ficha"><?= $libro->getEditorial() ? htmlspecialchars($libro->getEditorial()->getNombre()) : '---' ?></span>
                            </div>
                        </div>

                        <!-- Fila Fecha y Páginas/Volumen -->
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

                        <!-- Fila ISBN y Ejemplares -->
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

                        <!-- Fila Observaciones -->
                        <div class="ficha-row">
                            <div class="ficha-item" style="width: 100%; min-height: 80px;">
                                <span class="label-ficha">OBSERVACIONES:</span>
                                <span class="content-ficha"><?= htmlspecialchars($libro->getObservaciones() ?? 'S/O') ?></span>
                            </div>
                        </div>

                    </div>

                    <!-- Botones de Acción -->
                    <p class="text-center" style="margin-top: 20px;">
                        <a href="<?= BASE_URL ?>/libros" class="btn btn-secondary btn-raised">Volver</a>
                        <button onclick="window.print();" class="btn btn-info btn-raised">Imprimir Ficha</button>
                        <a href="<?= BASE_URL ?>/libros/edit?id=<?= $libro->getIdLibro() ?>" class="btn btn-warning btn-raised">Editar Libro</a>
                    </p>
                </div>
            </div>
        </div>

    </section>

    <!--====== Scripts -->
    <?php include VIEW_PATH . '/component/scripts.php'; ?>
</body>

</html>