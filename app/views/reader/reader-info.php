<!DOCTYPE html>
<html lang="es">

<head>
    <title>Detalles del Lector</title>
    <?php include VIEW_PATH . "/component/heat.php" ?>
    <style>
        /* --- Estilo para la Ficha Clásica (Oculta en pantalla) --- */
        .ficha-lector {
            display: none;
            background-color: #fff;
            border: 2px solid #333;
            font-family: 'Courier New', Courier, monospace;
            color: #000;
            max-width: 900px;
            margin: 0 auto;
            text-transform: uppercase;
        }

        .ficha-row { display: flex; border-bottom: 1px solid #333; }
        .ficha-item { padding: 10px; border-right: 1px solid #333; flex: 1; }
        .ficha-item:last-child { border-right: none; }
        .label-ficha { font-weight: bold; font-size: 0.85em; display: block; }
        .content-ficha { font-size: 1.05em; border-bottom: 1px dotted #666; display: inline-block; width: 100%; min-height: 20px; }
        .ficha-header { background-color: #f2f2f2; text-align: center; font-weight: bold; border-bottom: 2px solid #333; padding: 5px; }

        /* --- Estilo de IMPRESIÓN CORREGIDO --- */
        @media print {
            /* 1. Ocultamos todo el cuerpo de la página */
            body * {
                display: none !important;
            }

            /* 2. Mostramos SOLO la ficha y sus hijos */
            .ficha-lector, 
            .ficha-lector * {
                display: block !important;
            }

            /* 3. Aseguramos que las filas mantengan el diseño Flex */
            .ficha-row {
                display: flex !important;
            }

            /* 4. Reseteamos márgenes del body para que no salga en blanco */
            body, html {
                height: auto !important;
                background-color: #fff !important;
                display: block !important;
            }

            .ficha-lector {
                display: block !important;
                position: relative !important; /* Cambiado de fixed a relative */
                width: 100% !important;
                margin: 0 !important;
                border: 2px solid #000 !important;
            }

            @page {
                size: auto;
                margin: 1cm;
            }

            .ficha-header {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                background-color: #f2f2f2 !important;
            }
        }
    </style>
</head>

<body>
    <!-- Encapsulamos la vista moderna en un div para manejarlo mejor -->
    <div class="no-print">
        <?php include VIEW_PATH . "/component/sidebar.php" ?>

        <section class="full-box dashboard-contentPage">
            <?php include VIEW_PATH . "/component/navbar.php" ?>

            <div class="container-fluid">
                <div class="page-header">
                    <h1 class="text-titles">
                        <i class="fa-solid fa-book-open-reader"></i> Información del Lector
                        
                    </h1>
                </div>

                <?php include VIEW_PATH . "/component/readerbar.php" ?>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa-solid fa-eye"></i> DATOS DEL LECTOR</h3>
                    </div>
                    <div class="panel-body">
                        <!-- Contenido de la vista moderna que ya tienes -->
                        <fieldset>
                            <legend> &nbsp; <i class="fa-solid fa-user"></i> Información personal</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <p><strong>N° de Carnet:</strong><br><?= $lector->getCarnet() ?></p>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <p><strong>Cédula:</strong><br><?= $lector->getPersona()->getCedula() ?></p>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <p><strong>Nombres:</strong><br><?= $lector->getPersona()->getNombre() ?></p>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <p><strong>Apellidos:</strong><br><?= $lector->getPersona()->getApellido() ?></p>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <p><strong>Sexo:</strong><br><?= ($lector->getSexo() == 'M') ? 'Masculino' : 'Femenino' ?></p>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <p><strong>Teléfono:</strong><br><?= $lector->getPersona()->getTelefono() ?></p>
                                    </div>
                                    <div class="col-xs-12">
                                        <p><strong>Dirección:</strong><br><?= $lector->getDireccion() ?></p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <br>

                        <fieldset>
                            <legend> &nbsp; <i class="fa-solid fa-briefcase"></i> Información Laboral</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4">
                                        <p><strong>Profesión:</strong><br><?= $lector->getProfesion() ?></p>
                                    </div>
                                    <div class="col-xs-12 col-sm-4">
                                        <p><strong>Dirección Profesión:</strong><br><?= $lector->getDireccionProfesion() ?></p>
                                    </div>
                                    <div class="col-xs-12 col-sm-4">
                                        <p><strong>Teléfono Profesión:</strong><br><?= $lector->getTelefonoProfesion() ?></p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <br>

                        <fieldset>
                            <legend> &nbsp; <i class="fa-solid fa-address-book"></i> Referencias</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="well well-sm">
                                            <p><strong>Referencia Legal o Personal:</strong><br><?= $lector->getRefLegal() ?></p>
                                            <p><strong>Teléfono:</strong> <?= $lector->getRefLegalTel() ?></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="well well-sm">
                                            <p><strong>Referencia Personal:</strong><br> <?= $lector->getRefPersonal() ?></p>
                                            <p><strong>Teléfono:</strong> <?= $lector->getRefPersonalTel() ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <p class="text-center" style="margin-top: 20px;">
                            <a href="<?= BASE_URL ?>/lectores" class="btn btn-secondary btn-raised">
                                <i class="fa-solid fa-arrow-left"></i> Volver
                            </a>
                            <button onclick="window.print();" class="btn btn-info btn-raised">
                                <i class="fa-solid fa-print"></i> Imprimir Ficha
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- FICHA CLÁSICA (Saldrá en la impresión) -->
    <div class="ficha-lector">
        <div class="ficha-header">FICHA DE REGISTRO DE LECTOR</div>
        <div class="ficha-row">
            <div class="ficha-item">
                <span class="label-ficha">N° DE CARNET:</span>
                <span class="content-ficha"><?= $lector->getCarnet() ?></span>
            </div>
            <div class="ficha-item">
                <span class="label-ficha">CÉDULA DE IDENTIDAD:</span>
                <span class="content-ficha"><?= $lector->getPersona()->getCedula() ?></span>
            </div>
        </div>
        <div class="ficha-row">
            <div class="ficha-item">
                <span class="label-ficha">NOMBRES:</span>
                <span class="content-ficha"><?= $lector->getPersona()->getNombre() ?></span>
            </div>
            <div class="ficha-item">
                <span class="label-ficha">APELLIDOS:</span>
                <span class="content-ficha"><?= $lector->getPersona()->getApellido() ?></span>
            </div>
        </div>
        <div class="ficha-row">
            <div class="ficha-item" style="flex: 0 0 150px;">
                <span class="label-ficha">SEXO:</span>
                <span class="content-ficha"><?= ($lector->getSexo() == 'M') ? 'MASCULINO' : 'FEMENINO' ?></span>
            </div>
            <div class="ficha-item">
                <span class="label-ficha">TELÉFONO:</span>
                <span class="content-ficha"><?= $lector->getPersona()->getTelefono() ?></span>
            </div>
            <div class="ficha-item">
                <span class="label-ficha">PROFESIÓN/OCUPACIÓN:</span>
                <span class="content-ficha"><?= $lector->getProfesion() ?></span>
            </div>
        </div>
        <div class="ficha-row">
            <div class="ficha-item">
                <span class="label-ficha">DIRECCIÓN DOMICILIARIA:</span>
                <span class="content-ficha"><?= $lector->getDireccion() ?></span>
            </div>
        </div>
        <div class="ficha-row">
            <div class="ficha-item" style="flex: 2;">
                <span class="label-ficha">DIRECCIÓN LABORAL:</span>
                <span class="content-ficha"><?= $lector->getDireccionProfesion() ?></span>
            </div>
            <div class="ficha-item">
                <span class="label-ficha">TELÉFONO TRABAJO:</span>
                <span class="content-ficha"><?= $lector->getTelefonoProfesion() ?></span>
            </div>
        </div>
        <div class="ficha-header" style="border-top: 1px solid #333; font-size: 0.9em;">REFERENCIAS PERSONALES / LEGALES</div>
        <div class="ficha-row">
            <div class="ficha-item">
                <span class="label-ficha">REFERENCIA 1:</span>
                <span class="content-ficha"><?= $lector->getRefLegal() ?></span>
                <span class="label-ficha" style="margin-top:5px;">TELÉFONO:</span>
                <span class="content-ficha"><?= $lector->getRefLegalTel() ?></span>
            </div>
            <div class="ficha-item">
                <span class="label-ficha">REFERENCIA 2:</span>
                <span class="content-ficha"><?= $lector->getRefPersonal() ?></span>
                <span class="label-ficha" style="margin-top:5px;">TELÉFONO:</span>
                <span class="content-ficha"><?= $lector->getRefPersonalTel() ?></span>
            </div>
        </div>
    </div>

    <?php include VIEW_PATH . "/component/scripts.php" ?>
</body>
</html>