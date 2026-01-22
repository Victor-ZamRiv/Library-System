<!DOCTYPE html>
<html lang="es">

<title>Lectores</title>
<!-- head -->
<?php include VIEW_PATH . "/component/heat.php" ?>

<body>
    <!-- SideBar -->
    <?php include VIEW_PATH . "/component/sidebar.php" ?>


    <!-- Content page-->
    <section class="full-box dashboard-contentPage">
        <!-- NavBar -->
        <?php include VIEW_PATH . "/component/navbar.php" ?>
        <!-- Content page -->

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"> <i class="fa-solid fa-book-open-reader"></i> Lectores <small> Nuevo Lector</small></h1>
            </div>
        </div>
        <?php include VIEW_PATH . "/component/readerbar.php" ?>

        <!-- Panel nuevo lector -->
        <div class="container-fluid">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"> CREAR LECTOR</h3>
                </div>
                <div class="panel-body">
                    <form action="#" method="POST" enctype="application/x-www-form-urlencoded" id="form-registro-lector">
                        <fieldset>
                            <legend> &nbsp; Información personal</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="carnet-reg"><span class="text-danger">*</span> N° de Carnet </label>
                                            <input
                                                pattern="[0-9X/-]{1,30}"
                                                class="form-control"
                                                type="text"
                                                name="carnet-reg"
                                                id="carnet-reg"
                                                required
                                                minlength="10"
                                                maxlength="10"
                                                placeholder="XXXXXXXX/XX"
                                                title="N° de Carnet: 10 dígitos en formato XXXXXXXX/XX"
                                                aria-describedby="carnet-error"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('carnet-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('carnet-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="carnet-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese un N° de Carnet válido de 10 dígitos.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="cedula-reg"><span class="text-danger">*</span> Cédula </label>
                                            <input
                                                pattern="[0-9-]{1,30}"
                                                class="form-control"
                                                type="text"
                                                name="cedula-reg"
                                                id="cedula-reg"
                                                required
                                                maxlength="8"
                                                minlength="6"
                                                title="Solo números y guiones (máximo 30 caracteres)"
                                                aria-describedby="cedula-error"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('cedula-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('cedula-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="cedula-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese una Cédula válida (solo números, entre 6 y 8 dígitos).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="nombre-reg"><span class="text-danger">*</span> Nombres </label>
                                            <input
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}"
                                                class="form-control"
                                                type="text"
                                                name="nombre-reg"
                                                id="nombre-reg"
                                                required
                                                maxlength="30"
                                                title="Solo letras y espacios (máximo 30 caracteres)"
                                                aria-describedby="nombre-error"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('nombre-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('nombre-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="nombre-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese Nombres válidos (solo letras y espacios, máximo 30 caracteres).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="apellido-reg"><span class="text-danger">*</span> Apellidos </label>
                                            <input
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}"
                                                class="form-control"
                                                type="text"
                                                name="apellido-reg"
                                                id="apellido-reg"
                                                required
                                                maxlength="30"
                                                title="Solo letras y espacios (máximo 30 caracteres)"
                                                aria-describedby="apellido-error"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('apellido-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('apellido-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="apellido-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese Apellidos válidos (solo letras y espacios, máximo 30 caracteres).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="sexo-reg"><span class="text-danger">*</span> Sexo</label>
                                            <select class="form-control" name="sexo-reg" id="sexo-reg" required>
                                                <option value="" disabled selected>Seleccione el sexo</option>
                                                <option value="m">Masculino</option>
                                                <option value="f">Femenino</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="direccion-reg"><span class="text-danger">*</span> Dirección </label>
                                            <input
                                                class="form-control"
                                                type="text"
                                                name="direccion-reg"
                                                id="direccion-reg"
                                                required
                                                maxlength="100"
                                                title="Dirección (máximo 100 caracteres)"
                                                aria-describedby="direccion-error"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('direccion-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('direccion-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="direccion-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese una Dirección (máximo 100 caracteres).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="telefono-reg">Teléfono</label>
                                            <input
                                                pattern="[0-9]{11}"
                                                class="form-control"
                                                type="text"
                                                name="telefono-reg"
                                                id="telefono-reg"
                                                maxlength="11" placeholder="XXXXXXXXXXX" title="Solo números (11 caracteres)"
                                                aria-describedby="telefono-error"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('telefono-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('telefono-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese un Teléfono válido Ejem: 0424-5772539 (solo 11 dígitos).
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
                                            <label class="control-label" for="profesion-reg">Profesión </label>
                                            <input
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}"
                                                class="form-control"
                                                type="text"
                                                name="profesion-reg"
                                                id="profesion-reg"
                                                maxlength="50"
                                                title="Solo letras y espacios (máximo 50 caracteres)"
                                                aria-describedby="profesion-error"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('profesion-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('profesion-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="profesion-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese una Profesión válida (solo letras y espacios, máximo 50 caracteres).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="direccion-profesion-reg">Dirección Profesión</label>
                                            <input
                                                class="form-control"
                                                type="text"
                                                name="direccion-profesion-reg"
                                                id="direccion-profesion-reg"
                                                maxlength="100"
                                                title="Dirección de la Profesión (máximo 100 caracteres)"
                                                aria-describedby="direccion-profesion-error"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('direccion-profesion-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('direccion-profesion-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="direccion-profesion-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese una Dirección de Profesión válida (máximo 100 caracteres).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="telefono-profesion-reg">Teléfono Profesión</label>
                                            <input
                                                pattern="[0-9-]{1,15}"
                                                class="form-control"
                                                type="text"
                                                name="telefono-profesion-reg"
                                                id="telefono-profesion-reg"
                                                maxlength="11"
                                                placeholder="XXXX-XXXXXXX"
                                                title="Solo números (11 dígitos)"
                                                aria-describedby="telefono-profesion-error"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('telefono-profesion-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('telefono-profesion-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-profesion-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese un Teléfono de Profesión válido Ejem: 0424-5772539 (solo 11 dígitos).
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
                                            <label class="control-label" for="referencia-legal-personal-reg">Referencia Legal o Personal</label>
                                            <input
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,100}"
                                                class="form-control"
                                                type="text"
                                                name="referencia-legal-personal-reg"
                                                id="referencia-legal-personal-reg"
                                                maxlength="100"
                                                title="Solo letras y espacios (máximo 100 caracteres)"
                                                aria-describedby="referencia-legal-personal-error"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('referencia-legal-personal-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('referencia-legal-personal-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="referencia-legal-personal-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese una Referencia Legal válida (solo nombres y apellidos, máximo 100 caracteres).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="referencia-personal-reg">Referencia Personal</label>
                                            <input
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,100}"
                                                class="form-control"
                                                type="text"
                                                name="referencia-personal-reg"
                                                id="referencia-personal-reg"
                                                maxlength="100"
                                                title="Solo letras y espacios (máximo 100 caracteres)"
                                                aria-describedby="referencia-personal-error"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('referencia-personal-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('referencia-personal-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="referencia-personal-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese una Referencia Personal válida (solo nombres y apellidos, máximo 100 caracteres).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="telefono-referencia-legal-reg">Teléfono Referencia Legal:</label>
                                            <input
                                                pattern="[0-9-]{1,15}"
                                                class="form-control"
                                                type="text"
                                                name="telefono-referencia-legal-reg"
                                                id="telefono-referencia-legal-reg"
                                                maxlength="11"
                                                placeholder="XXXX-XXXXXXX"
                                                title="Solo números (11 dígitos)"
                                                aria-describedby="telefono-referencia-legal-error"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('telefono-referencia-legal-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('telefono-referencia-legal-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-referencia-legal-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese un Teléfono de Referencia Legal válido Ejem: 0424-5772539 (solo 11 dígitos).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="telefono-referencia-personal-reg">Teléfono Referencia Personal:</label>
                                            <input
                                                pattern="[0-9-]{1,15}"
                                                class="form-control"
                                                type="text"
                                                name="telefono-referencia-personal-reg"
                                                id="telefono-referencia-personal-reg"
                                                maxlength="11"
                                                placeholder="XXXX-XXXXXXX"
                                                title="Solo números(11 dígitos)"
                                                aria-describedby="telefono-referencia-personal-error"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('telefono-referencia-personal-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('telefono-referencia-personal-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-referencia-personal-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese un Teléfono de Referencia Personal válido Ejem: 0424-5749084 (salo 11 dígitos).
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <p class="text-center" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-success btn-raised btn-sm"> Guardar</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>

    </section>

    <!--====== Scripts -->
    <?php include VIEW_PATH . "/component/scripts.php" ?>
    <script src="<?= PUBLIC_PATH ?>/js/validations/reader/createvalidation.js"></script>
</body>

</html>