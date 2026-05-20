<!DOCTYPE html>
<html lang="es">

<title>Editar Datos</title>
<?php
include  VIEW_PATH . "/component/heat.php";
$preguntas = $data['preguntas'] ?? [];
$administrador = $data['administrador'] ?? null;
?>

<body>

    <?php
    include VIEW_PATH . "/component/sidebar.php";
    ?>

    <section class="full-box dashboard-contentPage">
        <?php
        include VIEW_PATH . "/component/navbar.php";
        ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"> Editar Datos</small></h1>
            </div>
        </div>

        <div class="container-fluid">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"> MI CUENTA</h3>
                </div>
                <div class="panel-body">
                    <form method="POST" action="<?= BASE_URL ?>/administradores/update" id="form-editar-usuario">
                        <fieldset>
                            <input type="hidden" name="idAdmin" value="<?= $administrador->getIdAdministrador() ?>">
                            <legend>Datos de Acceso </legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Nombre de Usuario</label>
                                            <input
                                                pattern="[a-zA-Z0-9]{4,15}"
                                                class="form-control"
                                                type="text"
                                                name="username-up"
                                                id="usuario-reg"
                                                required=""
                                                maxlength="15"
                                                value="<?=  htmlspecialchars($administrador->getNombreUsuario()) ?>"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('user-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('user-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="user-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Solo letras y números (4-15 caracteres).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Rol</label>
                                            <select name="rol-up" id="rol-up" class="form-control">
                                                <option value="Director" <?= ($administrador && $administrador->getRol() === 'Director') ? 'selected' : '' ?>>Director</option>
                                                <option value="Jefe de sala" <?= ($administrador && $administrador->getRol() === 'Jefe de sala') ? 'selected' : '' ?>>Jefe de sala</option>
                                                <option value="Bibliotecario" <?= ($administrador && $administrador->getRol() === 'Bibliotecario') ? 'selected' : '' ?>>Bibliotecario</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Contraseña</label>
                                            <input
                                                class="form-control"
                                                type="password"
                                                name="password-up"
                                                id="password1-reg"
                                                minlength="8"
                                                maxlength="70"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('pass1-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('pass1-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="pass1-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> La contraseña debe tener mínimo 8 caracteres.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Repetir contraseña</label>
                                            <input
                                                class="form-control"
                                                type="password"
                                                name="password-confirm-up"
                                                id="password2-reg"
                                                onblur="validarPasswordsUnificadas(this)">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="pass2-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Las contraseñas no coinciden.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Pregunta de seguridad </label>
                                            <select class="form-control" name="pregunta-tipo-reg" id="pregunta-tipo-reg" required>
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <?php foreach ($preguntas as $pregunta): ?>
                                                    <option 
                                                        value="<?= htmlspecialchars($pregunta->getIdPregunta()) ?>"
                                                        <?= ($administrador && $administrador->getIdPregunta() === $pregunta->getIdPregunta()) ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($pregunta->getPregunta()) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Respuesta de seguridad </label>
                                            <input
                                                class="form-control"
                                                type="text"
                                                name="pregunta-resp-reg"
                                                id="pregunta-resp-reg"
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,50}"
                                                maxlength="50"
                                                onblur="validarTexto(this, 'resp-error')">

                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="resp-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> La respuesta es inválida.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12">
                                        <legend style="margin-top: 20px;">Datos Personales</legend>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Cédula</label>
                                            <input
                                                pattern="[0-9]{6,12}"
                                                class="form-control"
                                                type="text"
                                                name="cedula-up"
                                                id="dni-reg"
                                                required=""
                                                maxlength="8"
                                                readonly
                                                value="<?=  htmlspecialchars($administrador->getPersona()->getCedula()) ?>"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('dni-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('dni-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="dni-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> La Cédula es inválida (6-8 dígitos).
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Nombres</label>
                                            <input
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}"
                                                class="form-control"
                                                type="text"
                                                name="nombres-up"
                                                id="nombre-reg"
                                                required=""
                                                maxlength="30"
                                                readonly
                                                value="<?=  htmlspecialchars($administrador->getPersona()->getNombre()) ?>"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('nombre-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('nombre-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="nombre-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Solo letras y espacios máximo 30 caracteres.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Apellidos</label>
                                            <input
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}"
                                                class="form-control"
                                                type="text"
                                                name="apellidos-up"
                                                id="apellido-reg"
                                                required=""
                                                maxlength="30"
                                                readonly
                                                value="<?=  htmlspecialchars($administrador->getPersona()->getApellido()) ?>"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('apellido-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('apellido-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="apellido-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Solo letras y espacios máximo 30 caracteres.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Teléfono</label>
                                            <input
                                                pattern="[0-9]{11}"
                                                class="form-control"
                                                type="text"
                                                name="user-phone-up"
                                                id="telf-reg"
                                                maxlength="11"
                                                value="<?=  htmlspecialchars($administrador->getPersona()->getTelefono()) ?>"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('tel-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('tel-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="tel-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese un Teléfono válido Ejem: 0424-5772539 (solo 11 dígitos).
                                            </div>
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

    <?php
    include  VIEW_PATH . "/component/scripts.php";
    ?>
    <script src="<?= PUBLIC_PATH ?>/js/validations/user/createuser.js"></script>
</body>

</html>