<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Nuevo Usuario</title>
    <?php include VIEW_PATH . "/component/heat.php" ?>
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

        /* Alineación de teléfonos en una sola línea */
        .phone-group {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .phone-group .select-prefix {
            width: 30% !important;
            margin-right: 10px;
        }

        .phone-group .input-number-main {
            width: 70% !important;
        }

        .form-group input:disabled,
        .form-group select:disabled {
            pointer-events: none;
            cursor: not-allowed;
        }

        .form-group {
            pointer-events: auto;
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
    </style>
</head>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php" ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php" ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"> <i class="fa-solid fa-user"></i> Nuevo Usuario</h1>
            </div>
        </div>
        <?php include VIEW_PATH . "/component/userbar.php" ?>

        <div class="container-fluid">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"> &nbsp; CREAR USUARIO</h3>
                </div>
                <div class="panel-body">
                    <form action="<?php echo BASE_URL; ?>/administradores/store" method="POST" id="form-registro-usuario">
                        <fieldset>
                            <legend> &nbsp; Información personal</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="cedula-reg"><span class="text-danger">*</span> Cédula</label>
                                            <div class="cedula-group" style="margin-top: 0px;">
                                                <select class="form-control select-nacionalidad" id="prefijo-cedula">
                                                    <option value="V-" <?php echo (isset($old['cedula']) && strpos($old['cedula'], 'V-') === 0) ? 'selected' : '' ?>>V-</option>
                                                    <option value="E-" <?php echo (isset($old['cedula']) && strpos($old['cedula'], 'E-') === 0) ? 'selected' : '' ?>>E-</option>
                                                </select>
                                                <input
                                                    pattern="[0-9]{6,8}"
                                                    class="form-control input-cedula-main"
                                                    type="text"
                                                    id="cedula-reg"
                                                    required
                                                    maxlength="8"
                                                    placeholder="12345678"
                                                    value="<?php echo htmlspecialchars(str_replace(['V-', 'E-'], '', $old['cedula'] ?? '')); ?>"
                                                    aria-describedby="dni-error"
                                                    onblur="if (!this.checkValidity() || parseInt(this.value) < 800000) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('dni-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('dni-error').style.display = 'none'; }">
                                            </div>
                                            <input type="hidden" name="cedula" id="cedula-final" value="<?php echo htmlspecialchars($old['cedula'] ?? '') ?>">
                                            
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="dni-error" style="display: none; padding: 5px 15px; margin-top: 5px;">
                                                <i class="fas fa-exclamation-circle"></i> La Cédula es inválida. Ingrese un número válido (Mínimo 800,000).
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
                                                required
                                                maxlength="30"
                                                value="<?php echo htmlspecialchars($old['nombre-reg'] ?? ''); ?>"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('nombre-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('nombre-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="nombre-error" style="display: none; padding: 5px 15px; margin-top: 5px;">
                                                <i class="fas fa-exclamation-circle"></i> Solo letras y espacios máximo 30 caracteres.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Apellidos </label>
                                            <input
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}"
                                                class="form-control"
                                                type="text"
                                                name="apellido-reg"
                                                id="apellido-reg"
                                                required
                                                maxlength="30"
                                                value="<?php echo htmlspecialchars($old['apellido-reg'] ?? ''); ?>"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('apellido-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('apellido-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="apellido-error" style="display: none; padding: 5px 15px; margin-top: 5px;">
                                                <i class="fas fa-exclamation-circle"></i> Solo letras y espacios máximo 30 caracteres.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Teléfono Personal</label>
                                            <div class="phone-group" style="margin-top: 0px;">
                                                <select class="form-control select-prefix" id="pref-reg">
                                                    <option value="0414" <?php echo (isset($old['pref-reg']) && $old['pref-reg'] == '0414') ? 'selected' : '' ?>>0414</option>
                                                    <option value="0424" <?php echo (isset($old['pref-reg']) && $old['pref-reg'] == '0424') ? 'selected' : '' ?>>0424</option>
                                                    <option value="0416" <?php echo (isset($old['pref-reg']) && $old['pref-reg'] == '0416') ? 'selected' : '' ?>>0416</option>
                                                    <option value="0426" <?php echo (isset($old['pref-reg']) && $old['pref-reg'] == '0426') ? 'selected' : '' ?>>0426</option>
                                                    <option value="0412" <?php echo (isset($old['pref-reg']) && $old['pref-reg'] == '0412') ? 'selected' : '' ?>>0412</option>
                                                    <option value="0422" <?php echo (isset($old['pref-reg']) && $old['pref-reg'] == '0422') ? 'selected' : '' ?>>0422</option>
                                                </select>
                                                <input
                                                    type="text"
                                                    class="form-control input-number-main"
                                                    id="num-reg"
                                                    maxlength="7"
                                                    placeholder="1234567"
                                                    value="<?php echo htmlspecialchars($old['num-reg'] ?? '') ?>"
                                                    required>
                                            </div>
                                            <input type="hidden" name="telf-reg" id="telefono-reg" value="<?php echo htmlspecialchars($old['telf-reg'] ?? '') ?>">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-error" style="display: none; padding: 5px 15px; margin-top: 5px;"></div>
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
                                                required
                                                maxlength="15"
                                                value="<?php echo htmlspecialchars($old['usuario-reg'] ?? ''); ?>"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('user-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('user-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="user-error" style="display: none; padding: 5px 15px; margin-top: 5px;">
                                                <i class="fas fa-exclamation-circle"></i> Solo letras y números (4-15 caracteres).
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Contraseña </label>
                                            <div class="password-container">
                                                <input
                                                    class="form-control"
                                                    type="password"
                                                    name="password1-reg"
                                                    id="password1-reg"
                                                    required
                                                    minlength="8"
                                                    maxlength="70"
                                                    onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('pass1-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('pass1-error').style.display = 'none'; }">
                                                <i class="fas fa-eye toggle-password" id="btn-toggle-pass1"></i>
                                            </div>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="pass1-error" style="display: none; padding: 5px 15px; margin-top: 5px;">
                                                <i class="fas fa-exclamation-circle"></i> La contraseña debe tener mínimo 8 caracteres.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Repita la contraseña </label>
                                            <div class="password-container">
                                                <input
                                                    class="form-control"
                                                    type="password"
                                                    name="password2-reg"
                                                    id="password2-reg"
                                                    required
                                                    onblur="validarPasswordsUnificadas(this)">
                                                <i class="fas fa-eye toggle-password" id="btn-toggle-pass2"></i>
                                            </div>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="pass2-error" style="display: none; padding: 5px 15px; margin-top: 5px;">
                                                <i class="fas fa-exclamation-circle"></i> Las contraseñas no coinciden.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Pregunta de seguridad </label>
                                            <select class="form-control" name="pregunta-seguridad" id="pregunta-tipo-reg" required>
                                                <option value="" disabled selected>Seleccione una opción</option>
                                                <?php foreach ($preguntas as $pregunta): ?>
                                                    <option value="<?php echo htmlspecialchars($pregunta->getIdPregunta()) ?>" <?php echo (isset($old['pregunta-seguridad']) && $old['pregunta-seguridad'] == $pregunta->getIdPregunta()) ? 'selected' : '' ?>><?php echo htmlspecialchars($pregunta->getPregunta()) ?></option>
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
                                                name="respuesta-reg"
                                                id="pregunta-resp-reg"
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,50}"
                                                required
                                                maxlength="50"
                                                value="<?php echo htmlspecialchars($old['respuesta-reg'] ?? ''); ?>"
                                                onblur="validarTexto(this, 'resp-error')">

                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="resp-error" style="display: none; padding: 5px 15px; margin-top: 5px;">
                                                <i class="fas fa-exclamation-circle"></i> La respuesta es inválida.
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
                                        <p class="text-left"><span class="label label-success">Nivel 1</span> Manejo de catalogo y prestamos</p>
                                        <p class="text-left"><span class="label label-primary">Nivel 2</span> Gestión de salas y actividades</p>
                                        <p class="text-left"><span class="label label-info">Nivel 3</span> Control total del sistema</p>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <label>Selecciona el Nivel de Privilegio:</label><br>
                                        <label><input type="radio" name="rol" value="Bibliotecario" <?php echo (!isset($old['rol']) || $old['rol'] == 'Bibliotecario') ? 'checked' : '' ?>> Bibliotecario</label><br>
                                        <label><input type="radio" name="rol" value="Jefe de sala" <?php echo (isset($old['rol']) && $old['rol'] == 'Jefe de sala') ? 'checked' : '' ?>> Jefe de sala</label><br>
                                        <label><input type="radio" name="rol" value="Director" <?php echo (isset($old['rol']) && $old['rol'] == 'Director') ? 'checked' : '' ?>> Director</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <p class="text-center" style="margin-top: 20px;">
                            <button type="button" id="btn-pre-guardar" class="btn btn-success btn-raised btn-lg"> Confirmar</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/modal/confirmation-new-user.php" ?>
    <?php include VIEW_PATH . "/component/scripts.php" ?>
    <script src="<?php echo PUBLIC_PATH; ?>/js/validations/user/createuser.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("form-registro-usuario");
            const btnPreGuardar = document.getElementById("btn-pre-guardar");
            const btnConfirmarSubmit = document.getElementById("btn-confirmar-submit");
            const resumenContenedor = document.getElementById("resumen-datos-usuario");

            const txtPassword1 = document.getElementById("password1-reg");
            const txtPassword2 = document.getElementById("password2-reg");
            const btnTogglePass1 = document.getElementById("btn-toggle-pass1");
            const btnTogglePass2 = document.getElementById("btn-toggle-pass2");

            // Función única que cambia el estado de ambos campos en base al tipo actual del primero
            function alternarAmbasContrasenas() {
                if (txtPassword1.type === "password") {
                    txtPassword1.type = "text";
                    txtPassword2.type = "text";
                    
                    btnTogglePass1.classList.remove("fa-eye");
                    btnTogglePass1.classList.add("fa-eye-slash");
                    btnTogglePass2.classList.remove("fa-eye");
                    btnTogglePass2.classList.add("fa-eye-slash");
                } else {
                    txtPassword1.type = "password";
                    txtPassword2.type = "password";
                    
                    btnTogglePass1.classList.remove("fa-eye-slash");
                    btnTogglePass1.classList.add("fa-eye");
                    btnTogglePass2.classList.remove("fa-eye-slash");
                    btnTogglePass2.classList.add("fa-eye");
                }
            }

            // Asignamos la misma función de control al evento click de ambos botones
            btnTogglePass1.addEventListener("click", alternarAmbasContrasenas);
            btnTogglePass2.addEventListener("click", alternarAmbasContrasenas);

            // Al hacer clic en el botón visible de guardar
            btnPreGuardar.addEventListener("click", function () {
                const dniInput = document.getElementById("cedula-reg");
                const prefijoCedula = document.getElementById("prefijo-cedula").value;
                
                if (parseInt(dniInput.value) < 800000) {
                    dniInput.classList.add('is-invalid');
                    document.getElementById('dni-error').style.display = 'block';
                    form.reportValidity();
                    return;
                }

                if (form.checkValidity()) {
                    // Ensamblaje de la cédula
                    const cedulaCompleta = prefijoCedula + dniInput.value;
                    document.getElementById("cedula-final").value = cedulaCompleta;

                    const nombres = document.getElementById("nombre-reg").value;
                    const apellidos = document.getElementById("apellido-reg").value;
                    
                    const prefijoTel = document.getElementById("pref-reg").value;
                    const numeroTel = document.getElementById("num-reg").value;
                    const telefonoCompleto = `${prefijoTel}-${numeroTel}`;
                    
                    const usuario = document.getElementById("usuario-reg").value;
                    const rolSeleccionado = document.querySelector('input[name="rol"]:checked').value;

                    document.getElementById("telefono-reg").value = prefijoTel + numeroTel;

                    let tablaHTML = `
                        <table class="table table-bordered table-striped" style="background-color: #fff; width: 100%; margin-bottom: 0;">
                            <thead>
                                <tr style="background-color: #d9edf7;">
                                    <th colspan="2" style="color: #31708f; font-weight: bold; padding: 10px;">
                                        Información del Nuevo Administrador
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width: 35%; font-weight: bold; background-color: #f9f9f9;">Cédula:</td>
                                    <td>${cedulaCompleta}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; background-color: #f9f9f9;">Nombre Completo:</td>
                                    <td>${nombres} ${apellidos}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; background-color: #f9f9f9;">Teléfono Personal:</td>
                                    <td>${telefonoCompleto}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; background-color: #f9f9f9;">Nombre de Usuario:</td>
                                    <td>${usuario}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; background-color: #f9f9f9;">Nivel de Privilegio (Rol):</td>
                                    <td>${rolSeleccionado}</td>
                                </tr>
                            </tbody>
                        </table>
                    `;

                    resumenContenedor.innerHTML = tablaHTML;
                    $('#modalConfirmarUsuario').modal('show');
                } else {
                    form.reportValidity();
                }
            });

            btnConfirmarSubmit.addEventListener("click", function () {
                this.disabled = true;
                this.innerText = "Procesando...";
                form.submit();
            });
        });
    </script>
</body>

</html>