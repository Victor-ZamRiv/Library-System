<!DOCTYPE html>
<html lang="es">

<title>Administración</title>
<!-- head -->
<?php include "../component/heat.php" ?>

<body>
    <!-- SideBar -->
    <?php include "../component/sidebar.php" ?>


    <!-- Content page-->
    <section class="full-box dashboard-contentPage">
        <!-- NavBar -->
        <?php include "../component/navbar.php" ?>
        <!-- Content page -->

        <?php include "../component/readerbar.php" ?>

        <!-- Panel nuevo lector -->
        <div class="container-fluid">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"> NUEVO LECTOR</h3>
                </div>
                <div class="panel-body">
                    <form>
                        <fieldset>
                            <legend><i class="zmdi zmdi-account-box"></i> &nbsp; Información personal</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">N° de Carnet </label>
                                            <input pattern="[0-9X/-]{1,30}" class="form-control" type="text" name="carnet-reg" required="" maxlength="30" placeholder="XXXXXX/XX">
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Cédula </label>
                                            <input pattern="[0-9-]{1,30}" class="form-control" type="text" name="cedula-reg" required="" maxlength="30">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombres </label>
                                            <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="nombre-reg" required="" maxlength="30">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Apellidos </label>
                                            <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="apellido-reg" required="" maxlength="30">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Sexo</label>
                                            <select class="form-control" name="sexo-reg" required>
                                                <option value="m">Masculino</option>
                                                <option value="f">Femenino</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Dirección </label>
                                            <input class="form-control" type="text" name="direccion-reg" required="" maxlength="100">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Teléfono</label>
                                            <input pattern="[0-9-]{1,15}" class="form-control" type="text" name="telefono-reg" maxlength="15" placeholder="XXXX-XXXXXXX">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <br>

                        <fieldset>
                            <legend><i class="zmdi zmdi-case"></i> &nbsp; Información Laboral</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Profesión </label>
                                            <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" type="text" name="profesion-reg" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Dirección Profesión</label>
                                            <input class="form-control" type="text" name="direccion-profesion-reg" maxlength="100">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Teléfono Profesión</label>
                                            <input pattern="[0-9-]{1,15}" class="form-control" type="text" name="telefono-profesion-reg" maxlength="15" placeholder="XXXX-XXXXXXX">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <br>

                        <fieldset>
                            <legend><i class="zmdi zmdi-account-box-o"></i> &nbsp; Referencias</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Referencia Legal o Personal</label>
                                            <input class="form-control" type="text" name="referencia-legal-personal-reg" maxlength="100">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Referencia Personal</label>
                                            <input class="form-control" type="text" name="referencia-personal-reg" maxlength="100">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Teléfono Referencia Legal:</label>
                                            <input pattern="[0-9-]{1,15}" class="form-control" type="text" name="telefono-referencia-legal-reg" maxlength="15" placeholder="XXXX-XXXXXXX">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Teléfono Referencia Personal:</label>
                                            <input pattern="[0-9-]{1,15}" class="form-control" type="text" name="telefono-referencia-personal-reg" maxlength="15" placeholder="XXXX-XXXXXXX">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <p class="text-center" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-success btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>

    </section>

    <!--====== Scripts -->
    <?php include "../component/scripts.php" ?>

</body>

</html>




<!-- <div class="card-body">

    <h4 class="card-title text-center font-weight-bold mb-3">Datos Personales</h4>
    <hr class="mt-0 mb-3">

    <div class="mb-4">
        <p class="mb-1"><strong class="mr-2">N° de Carnet:</strong> 003456/23</p>
        <p class="mb-1"><strong class="mr-2">Cédula:</strong> 27458925</p>z
        <p class="mb-1"><strong class="mr-2">Nombres:</strong> Victor Simón</p>
        <p class="mb-1"><strong class="mr-2">Apellidos:</strong> Zambrano Rivero</p>
        <p class="mb-1"><strong class="mr-2">Sexo:</strong> M</p>

        <p class="mb-1"><strong class="mr-2">Dirección:</strong></p>
        <p class="mb-1 ml-3">Caigüire, calle el cementerio</p>

        <p class="mb-1"><strong class="mr-2">Teléfono:</strong> 0424-8630743</p>
        <p class="mb-1"><strong class="mr-2">Profesión:</strong> Estudiante</p>

        <p class="mb-1"><strong class="mr-2">Dirección de trabajo o profesión:</strong></p>
        <p class="mb-1 ml-3">Cantarrana</p>

        <p class="mb-0"><strong class="mr-2">Teléfono de trabajo o profesión:</strong></p>
    </div>

    <hr class="mt-0 mb-3">

    <h4 class="card-title text-center font-weight-bold my-3">Referencias</h4>
    <hr class="mt-0 mb-3">

    <div class="mb-4">
        <div class="d-flex justify-content-between mb-1">
            <p class="mb-0"><strong class="mr-2">Referencia Legal o personal:</strong> Carmen Rivero</p>
            <p class="mb-0"><strong class="mr-2">Teléfono:</strong> 0426-4589364</p>
        </div>

        <div class="d-flex justify-content-between mb-0">
            <p class="mb-0"><strong class="mr-2">Referencia Personal:</strong></p>
            <p class="mb-0"><strong class="mr-2">Teléfono:</strong></p>
        </div>
    </div>

    <hr class="mt-0 mb-3">

    <h4 class="card-title text-center font-weight-bold my-3">Datos de Cuenta</h4>
    <hr class="mt-0 mb-3">

    <div class="d-flex justify-content-between mb-3">
        <p class="mb-0"><strong class="mr-2">Nombre de Usuario:</strong> Admin</p>
        <p class="mb-0"><strong class="mr-2">Contraseña:</strong> Admin*2025</p>
        <p class="text-left">
        <div class="label label-success">Nivel 1</div> Control total del sistema
        </p>
        <hr class="mt-0 mb-3">

        <h4 class="card-title text-center font-weight-bold my-3">Estado y Vencimiento</h4>
        <hr class="mt-0 mb-3">

        <div class="d-flex justify-content-between mb-3">
            <p class="mb-0"><strong class="mr-2">Estado:</strong> Activo</p>
            <p class="mb-0"><strong class="mr-2">Vencimiento:</strong> 06-02-2026</p>
        </div>
        <p class="mb-0"><strong class="mr-2">Registro:</strong> 06-02-2025</p>

    </div>
    <hr class="mt-0 mb-3">

    <div class="card-footer text-center">
        <a href="#!" class="btn btn-secondary btn-raised btn-sm">
            Imprimir
        </a>
        <a href="../admin/Edit-admin.php" class="btn btn-info btn-raised btn-sm">
            Editar Datos
        </a>
    </div>
</div> -->