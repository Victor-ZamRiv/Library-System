<?php
$old = $_SESSION['old_data'] ?? [];
$error = $_SESSION['error'] ?? null;
unset($_SESSION['old_data'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="es">

    <title>Nuevo Usuario</title>
    <?php include VIEW_PATH . "/component/heat.php" ?>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php" ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php" ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"> Usuarios <small>Nuevo Usuario</small></h1>
            </div>
        </div>

        <?php if ($error !== null): ?>
        <div class="container-fluid">
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </div>
        </div>
        <?php endif; ?>

        <?php include VIEW_PATH . "/component/userbar.php" ?>

        <div class="container-fluid">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"> &nbsp; CREAR USUARIO</h3>
                </div>
                <div class="panel-body">
                    <form action="<?= BASE_URL ?>/administradores/store" method="POST" id="form-registro-usuario">
                        <fieldset>
                            <legend> &nbsp; Información personal</legend>

                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Cédula </label>
                                            <input
                                                pattern="[0-9]{6,12}"
                                                class="form-control"
                                                type="text"
                                                name="cedula"
                                                id="dni-reg"
                                                value="<?= htmlspecialchars($old['cedula'] ?? '') ?>"
                                                required
                                                maxlength="8"
                                                aria-describedby="dni-error"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('dni-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('dni-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="dni-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> La Cédula es inválida, Ingrese una Cédula válida (6-8 dígitos).
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Nombres </label>
                                            <input
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}"
                                                class="form-control"
                                                type="text"
                                                name="nombre-reg"
                                                id="nombre-reg"
                                                value="<?= htmlspecialchars($old['nombre-reg'] ?? '') ?>"
                                                required
                                                maxlength="30"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('nombre-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('nombre-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="nombre-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Solo letras y espacios máximo 30 caracteres.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Apellidos </label>
                                            <input
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}"
                                                class="form-control"
                                                type="text"
                                                name="apellido-reg"
                                                id="apellido-reg"
                                                value="<?= htmlspecialchars($old['apellido-reg'] ?? '') ?>"
                                                required
                                                maxlength="30"
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
                                                name="telf-reg"
                                                value="<?= htmlspecialchars($old['telf-reg'] ?? '') ?>"
                                                id="telf-reg"
                                                maxlength="11"
												placeholder="XXXX-XXXXXXX"
                                                onblur="if (this.value !== '' && !this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('tel-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('tel-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="tel-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i>  Por favor, ingrese un Teléfono válido Ejem: 0424-5772539 (solo 11 dígitos).

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <br>

                        <fieldset>
                            <legend><i class="zmdi zmdi-key"></i> &nbsp; Datos de la cuenta</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Nombre de usuario </label>
                                            <input
                                                pattern="[a-zA-Z0-9]{4,15}"
                                                class="form-control"
                                                type="text"
                                                name="usuario-reg"
                                                id="usuario-reg"
                                                value="<?= htmlspecialchars($old['usuario-reg'] ?? '') ?>"
                                                required
                                                maxlength="15"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('user-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('user-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="user-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Solo letras y números (4-15 caracteres).
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Contraseña </label>
                                            <input
                                                class="form-control"
                                                type="password"
                                                name="password1-reg"
                                                id="password1-reg"
                                                required
                                                minlength="8"
                                                maxlength="70"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('pass1-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('pass1-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="pass1-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i>La contraseña debe tener mínimo 8 caracteres.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Repita la contraseña </label>
                                            <input
                                                class="form-control"
                                                type="password"
                                                name="password2-reg"
                                                id="password2-reg"
                                                required
                                                onblur="validarPasswordsUnificadas(this)">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="pass2-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Las contraseñas no coinciden.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend><i class="zmdi zmdi-star"></i> &nbsp; Nivel de privilegios</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <p class="text-left"><span class="label label-success">Nivel 1</span> Director (Control total del sistema)</p>
                                        <p class="text-left"><span class="label label-primary">Nivel 2</span> Jefe de sala (Permiso para registro y control estadístico) </p>
                                        <p class="text-left"><span class="label label-info">Nivel 3</span> Bibliotecario (Permiso para Gestion de catálogo y circulación)</p>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <label>Selecciona el Nivel de Privilegio:</label><br>
                                        <label><input type="radio" name="rol" value="Director"> Nivel 1</label><br>
                                        <label><input type="radio" name="rol" value="Jefe de sala"> Nivel 2</label><br>
                                        <label><input type="radio" name="rol" value="Bibliotecario" checked> Nivel 3</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <p class="text-center" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-info btn-raised btn-sm"> Guardar</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/component/scripts.php" ?>
	<script src="<?= PUBLIC_PATH ?>/js/validations/user/createuser.js"></script>
</body>
</html>