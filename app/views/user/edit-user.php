<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Datos</title>
    <?php
    include VIEW_PATH . "/component/heat.php";
    $preguntas = $data['preguntas'] ?? [];
    $administrador = $data['administrador'] ?? null;
    ?>
    <style>
        /* Alineación de la cédula en una sola línea */
        .cedula-group {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .cedula-group .select-nacionalidad {
            width: 30% !important;
            margin-right: 10px;
        }

        .cedula-group .input-cedula-main {
            width: 70% !important;
        }

        /* Contenedor relativo y estilos para los ojos de las contraseñas */
        .password-container {
            position: relative;
            width: 100%;
        }

        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 10;
            color: #777;
            font-size: 16px;
        }

        /* Evita que el texto de la contraseña se solape con el icono */
        .password-container input {
            padding-right: 35px !important;
        }
<<<<<<< HEAD

=======
        
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
        /* Asegura el estilo de puntero prohibido para campos de solo lectura */
        .form-group input[readonly],
        .form-group select[disabled] {
            pointer-events: none;
            cursor: not-allowed;
            background-color: #f9f9f9;
        }
    </style>
</head>

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
                <h1 class="text-titles"> <i class="fa-solid fa-user-pen"></i> Editar Datos</h1>
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
                                                value="<?= htmlspecialchars($administrador->getNombreUsuario()) ?>"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('user-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('user-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="user-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Solo letras y números (4-15 caracteres).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Rol</label>

                                            <select id="rol-up" class="form-control" disabled>
                                                <option value="Director" <?= ($administrador && $administrador->getRol() === 'Director') ? 'selected' : '' ?>>Director</option>
                                                <option value="Jefe de sala" <?= ($administrador && $administrador->getRol() === 'Jefe de sala') ? 'selected' : '' ?>>Jefe de sala</option>
                                                <option value="Bibliotecario" <?= ($administrador && $administrador->getRol() === 'Bibliotecario') ? 'selected' : '' ?>>Bibliotecario</option>
                                            </select>

                                            <input type="hidden" name="rol-up" value="<?= $administrador ? $administrador->getRol() : '' ?>">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"> Contraseña (Dejar en blanco para no cambiar)</label>
                                            <div class="password-container">
                                                <input
                                                    class="form-control"
                                                    type="password"
                                                    name="password-up"
                                                    id="password1-reg"
                                                    minlength="8"
                                                    maxlength="70"
                                                    onblur="if (this.value === '') { this.classList.remove('is-invalid'); document.getElementById('pass1-error').style.display = 'none'; } else if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('pass1-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('pass1-error').style.display = 'none'; }">
                                                <i class="fas fa-eye toggle-password" id="btn-toggle-pass1"></i>
                                            </div>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="pass1-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> La contraseña debe tener mínimo 8 caracteres.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"> Repetir contraseña</label>
                                            <div class="password-container">
                                                <input
                                                    class="form-control"
                                                    type="password"
                                                    name="password2-reg"
                                                    id="password2-reg"
                                                    onblur="if (this.value === '' && document.getElementById('password1-reg').value === '') { this.classList.remove('is-invalid'); document.getElementById('pass2-error').style.display = 'none'; } else { validarPasswordsUnificadas(this); }">
                                                <i class="fas fa-eye toggle-password" id="btn-toggle-pass2"></i>
                                            </div>
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
                                            <label class="control-label" for="dni-reg"><span class="text-danger">*</span> Cédula</label>
<<<<<<< HEAD
                                            <?php
                                            $cedulaOriginal = $administrador->getPersona()->getCedula();
                                            $numeroCedulaLimpiada = str_replace(['V-', 'E-'], '', $cedulaOriginal);
=======
                                            <?php 
                                                $cedulaOriginal = $administrador->getPersona()->getCedula(); 
                                                $numeroCedulaLimpiada = str_replace(['V-', 'E-'], '', $cedulaOriginal);
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
                                            ?>
                                            <div class="cedula-group" style="margin-top: 0px;">
                                                <select class="form-control select-nacionalidad" id="prefijo-cedula" disabled>
                                                    <option value="V-" <?= (strpos($cedulaOriginal, 'V-') === 0) ? 'selected' : '' ?>>V-</option>
                                                    <option value="E-" <?= (strpos($cedulaOriginal, 'E-') === 0) ? 'selected' : '' ?>>E-</option>
                                                </select>
                                                <input
                                                    pattern="[0-9]{6,12}"
                                                    class="form-control input-cedula-main"
                                                    type="text"
                                                    id="dni-reg"
                                                    required=""
                                                    maxlength="8"
                                                    readonly
                                                    value="<?= htmlspecialchars($numeroCedulaLimpiada) ?>"
                                                    onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('dni-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('dni-error').style.display = 'none'; }">
                                            </div>
<<<<<<< HEAD

=======
                                            
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
                                            <input type="hidden" name="cedula-up" id="cedula-final" value="<?= htmlspecialchars($cedulaOriginal) ?>">

                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="dni-error" style="display: none; padding: 5px 15px; margin-top: 5px;">
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
                                                value="<?= htmlspecialchars($administrador->getPersona()->getNombre()) ?>"
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
                                                value="<?= htmlspecialchars($administrador->getPersona()->getApellido()) ?>"
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
                                                value="<?= htmlspecialchars($administrador->getPersona()->getTelefono()) ?>"
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
                            <button type="submit" class="btn btn-success btn-raised btn-lg"> Actualizar</button>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const txtPassword1 = document.getElementById("password1-reg");
            const txtPassword2 = document.getElementById("password2-reg");
            const btnTogglePass1 = document.getElementById("btn-toggle-pass1");
            const btnTogglePass2 = document.getElementById("btn-toggle-pass2");
            const formEditar = document.getElementById("form-editar-usuario");

            // Intercepta el submit para ensamblar la cédula en caso de que alguna vez quites el "readonly"
            formEditar.addEventListener("submit", function(e) {
                const prefijo = document.getElementById("prefijo-cedula").value;
                const numeroCedula = document.getElementById("dni-reg").value;
                document.getElementById("cedula-final").value = prefijo + numeroCedula;
            });

            // Función única que cambia el estado de ambos campos en base al tipo actual del primero
            function alternarAmbasContrasenas() {
                if (txtPassword1.type === "password") {
                    // Cambiar inputs a tipo texto
                    txtPassword1.type = "text";
                    txtPassword2.type = "text";

                    // Cambiar iconos a ojo tachado en ambos
                    btnTogglePass1.classList.remove("fa-eye");
                    btnTogglePass1.classList.add("fa-eye-slash");
                    btnTogglePass2.classList.remove("fa-eye");
                    btnTogglePass2.classList.add("fa-eye-slash");
                } else {
                    // Cambiar inputs a tipo password
                    txtPassword1.type = "password";
                    txtPassword2.type = "password";

                    // Cambiar iconos a ojo abierto en ambos
                    btnTogglePass1.classList.remove("fa-eye-slash");
                    btnTogglePass1.classList.add("fa-eye");
                    btnTogglePass2.classList.remove("fa-eye-slash");
                    btnTogglePass2.classList.add("fa-eye");
                }
            }

            // Asignamos la misma función de control al evento click de ambos botones
            btnTogglePass1.addEventListener("click", alternarAmbasContrasenas);
            btnTogglePass2.addEventListener("click", alternarAmbasContrasenas);
        });
    </script>
</body>

</html>