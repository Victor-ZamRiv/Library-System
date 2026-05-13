<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalles del Préstamo</title>
    <?php include VIEW_PATH . "/component/heat.php"; ?>
    <style>
        /* Estilos para limpiar sombras y forzar bordes */
        .card,
        .btn,
        .table {
            box-shadow: none !important; 
            /* Elimina cualquier sombra residual */
            text-shadow: none !important;
        }

        @media print {

            .dashboard-sideBar,
            .navbar-info,
            .btn-devolucion,
            .no-print {
                display: none !important;
            }

            .dashboard-contentPage {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }

            .card {
                border: 1px solid #000 !important;
                padding: 10px !important;
            }

            .table-bordered th,
            .table-bordered td {
                border: 1px solid #000 !important;
            }
        }

        .institucion-header {
            text-transform: uppercase;
            font-size: 12px;
            line-height: 1.2;
        }

        .ticket-title {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            margin: 10px 0;
            padding: 5px 0;
            font-weight: bold;
        }

        /* Borde definido para la carta en pantalla */
        .card-flat {
            border: 1px solid #000 !important;
            border-radius: 0px;
            /* Opcional: bordes rectos para un look más de "documento" */
            background-color: #fff;
        }
    </style>
</head>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>
        <br>
        <div class="container-fluid mt-4">
            <div class="row">
                <div class="col-xs-12 col-lg-10 col-lg-offset-1">

                    <!-- Tarjeta -->
                    <div class="card card-flat p-4 mb-5 rounded">
                        <div class="card-body pb-5">

                            <!-- ENCABEZADO INSTITUCIONAL -->
                            <div class="row institucion-header">
                                <div class="col-xs-2 text-center">
                                    <img src="<?php echo PUBLIC_PATH; ?>/img/img-login/gobernacion1.png" alt="Logo" style="width: 80px; height: auto;">
                                </div>

                                <div class="col-xs-8 text-center">
                                    <p class="mb-0">República Bolivariana de Venezuela</p>
                                    <p class="mb-0">Gobernación del Estado Sucre</p>
                                    <p class="mb-0">Dirección de Cultura del Estado Sucre</p>
                                    <p class="mb-0">División de Bibliotecas Públicas del Estado Sucre</p>
                                    <h5 class="mt-1"><strong>Biblioteca Pública Central "Armando Zuloaga Blanco"</strong></h5>
                                </div>

                                <div class="col-xs-2 text-center">
                                    <img src="<?php echo PUBLIC_PATH; ?>/img/img-login/libro.png" alt="Logo" style="width: 80px; height: auto;">
                                </div>
                            </div>

                            <div class="text-center ticket-title">
                                <h4 class="mb-0">PRÉSTAMO CIRCULANTE</h4>
                            </div>

                            <!-- DATOS DEL LECTOR -->
                            <div class="row mb-3">
                                <div class="col-xs-12 col-sm-8">
                                    <p><strong>Nombre del Lector:</strong> <span class="border-bottom" style="display:inline-block; width:70%;"><?= htmlspecialchars($lector->getPersona()->getNombre() . ' ' . $lector->getPersona()->getApellido()) ?></span></p>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <p><strong>N° de Carnet:</strong> <span class="border-bottom"><?= htmlspecialchars($lector->getCarnet()) ?></span></p>
                                </div>
                            </div>

                            <!-- TABLA DE LIBROS -->
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr class="active">
                                            <th style="width: 20%;">COTA</th>
                                            <th style="width: 40%;">TÍTULO</th>
                                            <th style="width: 20%;">AUTOR</th>
                                            <th style="width: 20%;">FECHA VCTO.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $fechaVencimiento = date('d/m/Y', strtotime($prestamo->getFechaRecepcionEstipulada()));
                                        $totalFilas = count($ejemplares);
                                        $filasVacias = max(0, 3 - $totalFilas); // para mantener 3 filas visuales (opcional)
                                        ?>
                                        <?php foreach ($ejemplares as $item): 
                                            $libro = $item['libro'];
                                            $autores = $item['autores'];
                                            $nombresAutores = array_map(fn($a) => $a->getNombre(), $autores);
                                            $autorTexto = implode(', ', $nombresAutores);
                                            $fechaReal = $prestamo->getFechaRecepcionReal();
                                            $fechaDevolucion = $fechaReal ? date('d/m/Y', strtotime($fechaReal)) : 'Pendiente';
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($libro->getCota()) ?></td>
                                                <td><?= htmlspecialchars($libro->getTitulo()) ?></td>
                                                <td><?= htmlspecialchars($autorTexto) ?></td>
                                                <td><?= $fechaVencimiento ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php for ($i = 0; $i < $filasVacias; $i++): ?>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- FECHAS Y RESPONSABLE -->
                            <div class="row mt-4">
                                <div class="col-xs-6">
                                    <p><strong>Fecha de Préstamo:</strong> <?= date('d/m/Y', strtotime($prestamo->getFechaEntrega())) ?></p>
                                    <p class="mt-5"><strong>Responsable:</strong> <?= htmlspecialchars($administrador->getPersona()->getNombre() . ' ' . $administrador->getPersona()->getApellido()) ?></p>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <p><strong>Fecha de Devolución:</strong> 
                                        <?= $prestamo->getFechaRecepcionReal() ? date('d/m/Y', strtotime($prestamo->getFechaRecepcionReal())) : 'Pendiente' ?>
                                    </p>
                                    <p class="mt-5"><strong>Usuario (Firma):</strong> ____________________</p>
                                </div>
                            </div>

                            <!-- SECCIÓN DE ACCIONES (Botones sin sombras) -->
                            <div class="no-print mt-5">
                                <hr>
                                <div class="text-center">
                                    <a href="<?= BASE_URL ?>/prestamos" class="btn btn-secondary btn-raised">
                                        <i class="fa-solid fa-arrow-left"></i> Volver
                                    </a>

                                    <button type="button" class="btn btn-warning btn-raised" data-toggle="modal" data-target="#modalRenovacion">
                                        <i class="fa-solid fa-calendar-plus"></i> Renovar Préstamo
                                    </button>

                                    <button type="button" class="btn btn-primary btn-raised primary" data-toggle="modal" data-target="#modalDevolucion">
                                        <i class="fa-solid fa-arrow-rotate-left"></i> Procesar Devolución
                                    </button>

                                    <button type="button" class="btn btn-info btn-raised info" onclick="window.print();">
                                        <i class="fa-solid fa-print"></i> Imprimir Comprobante
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/component/scripts.php"; ?>
    <?php include VIEW_PATH . "/modal/return-loan.php" ?>
    <?php include VIEW_PATH . "/modal/loan-renewal.php" ?>
</body>

</html>