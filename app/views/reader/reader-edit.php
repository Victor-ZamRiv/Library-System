<!DOCTYPE html>
<html lang="es">

<title>Editar Lector</title>
<?php include VIEW_PATH . "/component/heat.php" ?>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php" ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php" ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"> <i class="fa-solid fa-user-pen"></i> Lectores <small> Editar Lector</small></h1>
            </div>
        </div>
        <?php include VIEW_PATH . "/component/readerbar.php" ?>
        <?php //var_dump($lector);
        ?>

        <div class="container-fluid">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"> MODIFICAR DATOS DEL LECTOR</h3>
                </div>
                <div class="panel-body">
                    <form action="<?= BASE_URL ?>/lectores/update" method="POST" id="form-registro-lector">

                        <input type="hidden" name="id" value="<?php echo $lector->getIdLector(); ?>">

                        <fieldset>
                            <legend> &nbsp; Información personal</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="carnet-reg"><span class="text-danger">*</span> N° de Carnet</label>
                                            <input class="form-control" type="text" name="carnet-reg" id="carnet-reg" required
                                                pattern="[0-9X/-]{1,30}" minlength="10" maxlength="10"
                                                placeholder="XXXXXXXX/XX" title="N° de Carnet: 10 dígitos en formato XXXXXXXX/XX"
                                                value="<?php echo $lector->getCarnet(); ?>"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('carnet-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('carnet-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="carnet-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese un N° de Carnet válido de 10 dígitos.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="cedula-reg"><span class="text-danger">*</span> Cédula</label>
                                            <input class="form-control" type="text" name="cedula-reg" id="cedula-reg" required
                                                pattern="[0-9-]{1,30}" minlength="6" maxlength="8"
                                                title="Solo números y guiones (máximo 30 caracteres)"
                                                value="<?php echo $lector->getPersona()->getCedula(); ?>"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('cedula-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('cedula-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="cedula-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese una Cédula válida (solo números, entre 6 y 8 dígitos).
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="nombre-reg"><span class="text-danger">*</span> Nombres</label>
                                            <input class="form-control" type="text" name="nombre-reg" id="nombre-reg" required
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30"
                                                title="Solo letras y espacios (máximo 30 caracteres)"
                                                value="<?php echo $lector->getPersona()->getNombre(); ?>"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('nombre-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('nombre-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="nombre-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese Nombres válidos.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="apellido-reg"><span class="text-danger">*</span> Apellidos</label>
                                            <input class="form-control" type="text" name="apellido-reg" id="apellido-reg" required
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30"
                                                title="Solo letras y espacios (máximo 30 caracteres)"
                                                value="<?php echo $lector->getPersona()->getApellido(); ?>"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('apellido-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('apellido-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="apellido-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese Apellidos válidos.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="sexo-reg"><span class="text-danger">*</span> Sexo</label>
                                            <select class="form-control" name="sexo-reg" id="sexo-reg" required>
                                                <option value="m" <?php if ($lector->getSexo() == 'm') echo 'selected'; ?>>Masculino</option>
                                                <option value="f" <?php if ($lector->getSexo() == 'f') echo 'selected'; ?>>Femenino</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="direccion-reg"><span class="text-danger">*</span> Dirección</label>
                                            <input class="form-control" type="text" name="direccion-reg" id="direccion-reg" required
                                                maxlength="100" title="Dirección (máximo 100 caracteres)"
                                                value="<?php echo $lector->getDireccion(); ?>"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('direccion-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('direccion-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="direccion-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese una Dirección (máximo 100 caracteres).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="telefono-reg">Teléfono</label>
                                            <input class="form-control" type="text" name="telefono-reg" id="telefono-reg"
                                                pattern="[0-9]{11}" maxlength="11" placeholder="XXXXXXXXXXX" title="Solo números (11 caracteres)"
                                                value="<?php echo $lector->getPersona()->getTelefono(); ?>"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('telefono-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('telefono-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Ingrese un Teléfono válido (11 dígitos).
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <br>

                        <fieldset>
                            <legend> &nbsp; Información Laboral</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="profesion-reg">Profesión</label>
                                            <input class="form-control" type="text" name="profesion-reg" id="profesion-reg"
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" maxlength="50"
                                                title="Solo letras y espacios (máximo 50 caracteres)"
                                                value="<?php echo $lector->getProfesion(); ?>"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('profesion-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('profesion-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="profesion-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Ingrese una Profesión válida.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="direccion-profesion-reg">Dirección Profesión</label>
                                            <input class="form-control" type="text" name="direccion-profesion-reg" id="direccion-profesion-reg"
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{1,100}" maxlength="100"
                                                value="<?php echo $lector->getDireccionProfesion(); ?>"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('direccion-profesion-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('direccion-profesion-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="direccion-profesion-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Ingrese una Dirección de Profesión válida.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="telefono-profesion-reg">Teléfono Profesión</label>
                                            <input class="form-control" type="text" name="telefono-profesion-reg" id="telefono-profesion-reg"
                                                pattern="[0-9]{11}" maxlength="11"
                                                value="<?php echo $lector->getTelefonoProfesion(); ?>"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('telefono-profesion-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('telefono-profesion-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-profesion-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Ingrese un Teléfono de Profesión válido.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <br>

                        <fieldset>
                            <legend> &nbsp; Referencias</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="referencia-legal-personal-reg">Referencia Legal</label>
                                            <input class="form-control" type="text" name="referencia-legal-personal-reg" id="referencia-legal-personal-reg"
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,100}" maxlength="100"
                                                value="<?php echo $lector->getRefLegal(); ?>"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('referencia-legal-personal-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('referencia-legal-personal-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="referencia-legal-personal-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Ingrese una Referencia Legal válida.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="referencia-personal-reg">Referencia Personal</label>
                                            <input class="form-control" type="text" name="referencia-personal-reg" id="referencia-personal-reg"
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,100}" maxlength="100"
                                                value="<?php echo $lector->getRefPersonal(); ?>"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('referencia-personal-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('referencia-personal-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="referencia-personal-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Ingrese una Referencia Personal válida.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="telefono-referencia-legal-reg">Teléfono Referencia Legal</label>
                                            <input class="form-control" type="text" name="telefono-referencia-legal-reg" id="telefono-referencia-legal-reg"
                                                pattern="[0-9]{11}" maxlength="11"
                                                value="<?php echo $lector->getRefLegalTel(); ?>"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('telefono-referencia-legal-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('telefono-referencia-legal-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-referencia-legal-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Ingrese un Teléfono de Referencia Legal válido.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="telefono-referencia-personal-reg">Teléfono Referencia Personal</label>
                                            <input class="form-control" type="text" name="telefono-referencia-personal-reg" id="telefono-referencia-personal-reg"
                                                pattern="[0-9]{11}" maxlength="11"
                                                value="<?php echo $lector->getRefPersonalTel(); ?>"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('telefono-referencia-personal-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('telefono-referencia-personal-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-referencia-personal-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Ingrese un Teléfono de Referencia Personal válido.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <p class="text-center" style="margin-top: 20px;">
                            <a href="<?= BASE_URL ?>/lectores" class="btn btn-secondary btn-raised">
                                <i class="fa-solid fa-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-info btn-raised">Actualizar Cambios</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/component/scripts.php" ?>
    <script src="<?= PUBLIC_PATH ?>/js/validations/reader/createvalidation.js"></script>
</body>

</html>