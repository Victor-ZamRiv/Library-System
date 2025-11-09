<!DOCTYPE html>
<html lang="es">
<!-- heat -->
<?php
include "../component/heat.php";
?>

<body>

    <!-- SideBar -->
    <?php
    include "../component/sidebar.php";
    ?>
    <!-- contenido de la barra lateral -->

    <!-- Content page-->
    <section class="full-box dashboard-contentPage">
        <!-- NavBar -->
        <?php
        include "../component/navbar.php";
        ?>
        <!-- Content page -->
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"> Editar Datos</small></h1>
            </div>
        </div>

        <!-- Panel mi cuenta -->
        <div class="container-fluid">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"> MI CUENTA</h3>
                </div>
                <div class="panel-body">
                    <form>
                        <fieldset>
                            <legend>Datos de Acceso </legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombre de Usuario</label>
                                            <input class="form-control" type="text" name="username-up" required="" maxlength="50" value="Admin">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Contraseña</label>
                                            <input class="form-control" type="password" name="password-up" required="" maxlength="50" value="Admin*2025">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nivel de Acceso</label>
                                            <input class="form-control" type="text" name="access-level-up" readonly value="Nivel 1">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Rol</label>
                                            <input class="form-control" type="text" name="access-description-up" readonly value="Administrador">
                                        </div>
                                    </div>

                                    
                                    <legend>Datos Personales</legend>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Cédula</label>
                                            <input pattern="[0-9]{1,15}" class="form-control" type="text" name="cedula-up" required="" maxlength="15" value="">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Nombres</label>
                                            <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" type="text" name="nombres-up" required="" maxlength="50" value="">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Apellidos</label>
                                            <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" type="text" name="apellidos-up" required="" maxlength="50" value="">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Teléfono</label>
                                            <input class="form-control" type="text" name="user-phone-up" value="04248802343">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </fieldset>

                        <p class="text-center" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-success btn-raised btn-sm"> Actualizar</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>

    </section>

    <!--====== Scripts -->
    <?php
    include "../component/scripts.php";
    ?>
</body>

</html>