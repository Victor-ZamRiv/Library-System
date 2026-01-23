<!DOCTYPE html>
<html lang="es">

<head>
    <title>Detalles del Lector</title>
    <?php include VIEW_PATH . "/component/heat.php" ?>
</head>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php" ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php" ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles">
                    <i class="fa-solid fa-book-open-reader"></i> Lectores 
                    <small> Información del Lector</small>
                </h1>
            </div>
        </div>
        
        <?php include VIEW_PATH . "/component/readerbar.php" ?>

        <div class="container-fluid">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa-solid fa-eye"></i> DATOS DEL LECTOR</h3>
                </div>
                <div class="panel-body">
                    
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
                                    <p><strong>Sexo:</strong><br><?php if ($lector->getSexo() == 'M') echo 'Masculino'; else echo 'Femenino'; ?></p>
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
                        <a href="<?= BASE_URL ?>/lectores/list" class="btn btn-info btn-raised">
                            <i class="fa-solid fa-arrow-left"></i> Volver al listado
                        </a>
                        <button onclick="window.print();" class="btn btn-default btn-raised">
                            <i class="fa-solid fa-print"></i> Imprimir Ficha
                        </button>
                    </p>
                </div>
            </div>
        </div>

    </section>

    <?php include VIEW_PATH . "/component/scripts.php" ?>
</body>
</html>