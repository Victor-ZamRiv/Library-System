<!DOCTYPE html>
<html lang="es">

<head>
    <title>Detalles del Préstamo</title>
    <?php include VIEW_PATH . "/component/heat.php"; ?>
    <style>
        /* Estilos para que la impresión se parezca al formato físico */
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
                box-shadow: none !important;
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
    </style>
</head>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-lg-10 col-lg-offset-1">
                    <div class="card shadow-lg p-4 mb-5 bg-white rounded">
                        <div class="card-body">

                            
                            <!-- ENCABEZADO INSTITUCIONAL -->
                            <div class="row institucion-header">
                                <!-- ESPACIO PARA EL LOGO -->
                                <div class="col-xs-2 text-center">
                                    <!-- Deja este espacio para tu imagen -->
                                    <img src="<?php echo PUBLIC_PATH; ?>/img/img-login/gobernacion1.png" alt="Logo" style="width: 80px; height: auto;">
                                </div>

                                <!-- TEXTO INSTITUCIONAL -->
                                <div class="col-xs-8 text-center">
                                    <p class="mb-0">República Bolivariana de Venezuela</p>
                                    <p class="mb-0">Gobernación del Estado Sucre</p>
                                    <p class="mb-0">Dirección de Cultura del Estado Sucre</p>
                                    <p class="mb-0">División de Bibliotecas Públicas del Estado Sucre</p>
                                    <h5 class="mt-1"><strong>Biblioteca Pública Central "Armando Zuloaga Blanco"</strong></h5>
                                </div>

                                <!-- ESPACIO SIMÉTRICO (Opcional, para centrar el texto perfectamente) -->
                                <div class="col-xs-2"></div>
                            </div>

                            <div class="text-center ticket-title">
                                <h4 class="mb-0">PRÉSTAMO CIRCULANTE</h4>
                            </div>

                            <!-- DATOS DEL LECTOR -->
                            <div class="row mb-3">
                                <div class="col-xs-12 col-sm-8">
                                    <p><strong>Nombre del Lector:</strong> <span class="border-bottom" style="display:inline-block; width:70%;">Juan Pérez</span></p>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <p><strong>N° de Carnet:</strong> <span class="border-bottom">12345678</span></p>
                                </div>
                            </div>

                            <!-- TABLA DE LIBROS (Estructura igual al formato físico) -->
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
                                        <tr>
                                            <td>LIB001</td>
                                            <td>Cálculo de Stewart</td>
                                            <td>James Stewart</td>
                                            <td>27/04/2024</td>
                                        </tr>
                                        <!-- Espacios vacíos para mantener la estética del formato si hay pocos libros -->
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- FECHAS Y RESPONSABLE -->
                            <div class="row mt-4">
                                <div class="col-xs-6">
                                    <p><strong>Fecha de Préstamo:</strong> 20/04/2024</p>
                                    <p><strong>Responsable:</strong> ____________________</p>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <p><strong>Usuario (Firma):</strong> ____________________</p>
                                </div>
                            </div>

                            <hr class="no-print">

                            <!-- ACCIONES (No se imprimen) -->
                            <div class="text-center no-print">
                                <button type="button" class="btn btn-primary btn-raised btn-devolucion" data-toggle="modal" data-target="#modalDevolucion">
                                    <i class="fa-solid fa-arrow-rotate-left"></i> Procesar Devolución
                                </button>
                                <button type="button" class="btn btn-info btn-raised" onclick="window.print();">
                                    <i class="fa-solid fa-print"></i> Imprimir Comprobante
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/component/scripts.php"; ?>
    <?php include VIEW_PATH . "/modal/return-loan.php" ?>
</body>

</html>