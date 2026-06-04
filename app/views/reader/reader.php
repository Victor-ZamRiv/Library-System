<!DOCTYPE html>
<html lang="es">

<head>
    <title>Nuevo Lector</title>
    <?php include VIEW_PATH . "/component/heat.php" ?>
    <style>
        /* Alineación de teléfonos en una sola línea */
        .phone-group {
            display: flex;
            align-items: center;
        }

        .phone-group .select-prefix {
            width: 35% !important;
            margin-right: 5px;
        }

        .phone-group .input-number-main {
            width: 65% !important;
        }

        /* Alineación de Cédula en una sola línea */
        .cedula-group {
            display: flex;
            align-items: center;
        }

        .cedula-group .select-nacionalidad {
            width: 25% !important;
            margin-right: 5px;
        }

        .cedula-group .input-cedula-main {
            width: 75% !important;
        }

        .form-group input:disabled,
        .form-group select:disabled {
            pointer-events: none;
            cursor: not-allowed;
        }

        .form-group {
            pointer-events: auto;
        }

        /* Si el label está DESPUÉS del input en el HTML */
        .is-invalid~label,
        .is-invalid+label {
            color: #dc3545 !important;
            /* Rojo estándar de Bootstrap */
        }

        /* Estructura tradicional donde el label está ANTES del input con pseudo-clase :has() */
        .mb-3:has(.is-invalid) label,
        .form-group:has(.is-invalid) label {
            color: #dc3545 !important;
        }
    </style>
</head>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php" ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php" ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"> <i class="fa-solid fa-book-open-reader"></i> Nuevo Lector</h1>
            </div>
        </div>
        <?php include VIEW_PATH . "/component/readerbar.php" ?>

        <div class="container-fluid">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"> REGISTRAR LECTOR</h3>
                </div>
                <div class="panel-body">
                    <form action="<?= BASE_URL ?>/lectores/store" method="POST" id="form-registro-lector">

                        <fieldset>
                            <legend> &nbsp; Información personal</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="carnet-reg"><span class="text-danger">*</span> N° de Carnet</label>
                                            <input class="form-control" type="text" name="carnet-reg" id="carnet-reg" value="<?= htmlspecialchars($old['carnet-reg'] ?? '') ?>" required>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="carnet-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group label-floating"> <label class="control-label" for="cedula-reg"><span class="text-danger">*</span> Cédula</label>

                                            <div class="cedula-group">
                                                <select class="form-control select-nacionalidad" id="prefijo-cedula">
                                                    <option value="V-">V-</option>
                                                    <option value="E-">E-</option>
                                                </select>
                                                <input class="form-control input-cedula-main" type="text" id="cedula-reg" value="<?= htmlspecialchars($old['cedula'] ?? '') ?>" required maxlength="8" placeholder="12345678">
                                            </div>

                                            <input type="hidden" name="cedula" id="cedula-final">

                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="cedula-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="nombre-reg"><span class="text-danger">*</span> Nombres </label>
                                            <input class="form-control" type="text" name="nombre-reg" id="nombre-reg" value="<?= htmlspecialchars($old['nombre-reg'] ?? '') ?>" required>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="nombre-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="apellido-reg"><span class="text-danger">*</span> Apellidos </label>
                                            <input class="form-control" type="text" name="apellido-reg" id="apellido-reg" value="<?= htmlspecialchars($old['apellido-reg'] ?? '') ?>" required>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="apellido-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="sexo-reg"><span class="text-danger">*</span> Sexo</label>
                                            <select class="form-control" name="sexo-reg" id="sexo-reg" required>
                                                <option value="" disabled <?php if (!isset($old['sexo-reg'])) echo 'selected'; ?>>Seleccione el sexo</option>
                                                <option value="M" <?php if (isset($old['sexo-reg']) && $old['sexo-reg'] == 'M') echo 'selected'; ?>>Masculino</option>
                                                <option value="F" <?php if (isset($old['sexo-reg']) && $old['sexo-reg'] == 'F') echo 'selected'; ?>>Femenino</option>
                                            </select>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="sexo-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="direccion-reg"><span class="text-danger">*</span> Dirección </label>
                                            <input class="form-control" type="text" name="direccion-reg" id="direccion-reg" value="<?= htmlspecialchars($old['direccion-reg'] ?? '') ?>" required>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="direccion-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="num-reg"><span class="text-danger">*</span> Teléfono Personal</label>

                                            <div class="phone-group" style="margin-bottom: 5px;">
                                                <select class="form-control select-prefix" id="pref-reg">
                                                    <option value="0414">0414</option>
                                                    <option value="0424">0424</option>
                                                    <option value="0416">0416</option>
                                                    <option value="0426">0426</option>
                                                    <option value="0412">0412</option>
                                                    <option value="0422">0422</option>
                                                </select>
                                                <input type="text" class="form-control input-number-main" id="num-reg" maxlength="7" placeholder="1234567" required>
                                            </div>

                                            <input type="hidden" name="telefono-reg" id="telefono-reg">

                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-reg-error"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <br>

                        <fieldset>
                            <legend> &nbsp; Información Laboral (Opcional)</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="profesion-reg">Profesión</label>
                                            <input class="form-control" type="text" name="profesion-reg" id="profesion-reg">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="profesion-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="direccion-profesion-reg">Dirección Laboral</label>
                                            <input class="form-control" type="text" name="direccion-profesion-reg" id="direccion-profesion-reg">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="direccion-profesion-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Teléfono Profesión</label>
                                            <div class="phone-group">
                                                <select class="form-control select-prefix" id="pref-prof">
                                                    <option value="0414">0414</option>
                                                    <option value="0424">0424</option>
                                                    <option value="0416">0416</option>
                                                    <option value="0426">0426</option>
                                                    <option value="0412">0412</option>
                                                    <option value="0422">0422</option>
                                                </select>
                                                <input type="text" class="form-control input-number-main" id="num-prof" maxlength="7">
                                            </div>
                                            <input type="hidden" name="telefono-profesion-reg" id="telefono-profesion-reg">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-profesion-error"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <br>

                        <fieldset>
                            <legend> &nbsp; Referencias (Opcional)</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="referencia-legal-personal-reg">Referencia Legal</label>
                                            <input class="form-control" type="text" name="ref-legal-reg" id="referencia-legal-personal-reg">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="referencia-legal-personal-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="referencia-personal-reg">Referencia Personal</label>
                                            <input class="form-control" type="text" name="ref-personal-reg" id="referencia-personal-reg">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="referencia-personal-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Teléfono Ref. Legal</label>
                                            <div class="phone-group">
                                                <select class="form-control select-prefix" id="pref-ref-l">
                                                    <option value="0414">0414</option>
                                                    <option value="0424">0424</option>
                                                    <option value="0416">0416</option>
                                                    <option value="0426">0426</option>
                                                    <option value="0412">0412</option>
                                                    <option value="0422">0422</option>
                                                </select>
                                                <input type="text" class="form-control input-number-main" id="num-ref-l" maxlength="7">
                                            </div>
                                            <input type="hidden" name="telefono-ref-legal-reg" id="telefono-ref-legal-reg">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-referencia-legal-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Teléfono Ref. Personal</label>
                                            <div class="phone-group">
                                                <select class="form-control select-prefix" id="pref-ref-p">
                                                    <option value="0414">0414</option>
                                                    <option value="0424">0424</option>
                                                    <option value="0416">0416</option>
                                                    <option value="0426">0426</option>
                                                    <option value="0412">0412</option>
                                                    <option value="0422">0422</option>
                                                </select>
                                                <input type="text" class="form-control input-number-main" id="num-ref-p" maxlength="7">
                                            </div>
                                            <input type="hidden" name="telefono-ref-personal-reg" id="telefono-ref-personal-reg">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-referencia-personal-error"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <p class="text-center" style="margin-top: 20px;">
                            <button type="button" class="btn btn-success btn-raised btn-lg" id="btn-previsualizar"> Confirmar</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("form-registro-lector");
            const btnPrevisualizar = document.getElementById("btn-previsualizar");
            const btnConfirmarEnvio = document.getElementById("btn-confirmar-envio");
            const modal = $("#modalConfirmacionLector");

            // Elementos del control de Cédula
            const prefijoCedula = document.getElementById("prefijo-cedula");
            const inputCedulaMain = document.getElementById("cedula-reg");
            const inputCedulaFinal = document.getElementById("cedula-final");

            function procesarTelefonos() {
                const tiposTel = [{
                        pref: 'pref-reg',
                        num: 'num-reg',
                        hidden: 'telefono-reg'
                    },
                    {
                        pref: 'pref-prof',
                        num: 'num-prof',
                        hidden: 'telefono-profesion-reg'
                    },
                    {
                        pref: 'pref-ref-l',
                        num: 'num-ref-l',
                        hidden: 'telefono-ref-legal-reg'
                    },
                    {
                        pref: 'pref-ref-p',
                        num: 'num-ref-p',
                        hidden: 'telefono-ref-personal-reg'
                    }
                ];

                tiposTel.forEach(tel => {
                    const prefEl = document.getElementById(tel.pref);
                    const numEl = document.getElementById(tel.num);
                    const hiddenEl = document.getElementById(tel.hidden);

                    if (prefEl && numEl && hiddenEl) {
                        const numVal = numEl.value.trim();
                        if (numVal.length === 7) {
                            hiddenEl.value = prefEl.value + numVal;
                        } else {
                            hiddenEl.value = "";
                        }
                    }
                });
            }

            function procesarCedula() {
                if (prefijoCedula && inputCedulaMain && inputCedulaFinal) {
                    const cedulaVal = inputCedulaMain.value.trim();
                    if (cedulaVal !== "") {
                        // Unifica el prefijo (V- o E-) con los dígitos
                        inputCedulaFinal.value = prefijoCedula.value + cedulaVal;
                    } else {
                        inputCedulaFinal.value = "";
                    }
                }
            }

            btnPrevisualizar.addEventListener("click", function() {
                // 1. Forzar la validación nativa de HTML5
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                // 2. Unificar los teléfonos y la cédula en los inputs ocultos
                procesarTelefonos();
                procesarCedula();

                // 3. Extraer valores para la tabla del resumen
                const carnet = document.getElementById("carnet-reg").value;
                const cedula = document.getElementById("cedula-final").value; // Toma el valor completo unificado
                const nombre = document.getElementById("nombre-reg").value;
                const apellido = document.getElementById("apellido-reg").value;
                const sexoSelect = document.getElementById("sexo-reg");
                const sexoTxt = sexoSelect.options[sexoSelect.selectedIndex].text;
                const direccion = document.getElementById("direccion-reg").value;
                const telefonoPers = document.getElementById("telefono-reg").value;

                // Opcionales
                const profesion = document.getElementById("profesion-reg").value || '<span class="text-muted">No especificado</span>';
                const dirLaboral = document.getElementById("direccion-profesion-reg").value || '<span class="text-muted">No especificado</span>';
                const telLaboral = document.getElementById("telefono-profesion-reg").value || '<span class="text-muted">No especificado</span>';

                const refLegal = document.getElementById("referencia-legal-personal-reg").value || '<span class="text-muted">No especificado</span>';
                const telRefLegal = document.getElementById("telefono-ref-legal-reg").value || '<span class="text-muted">No especificado</span>';
                const refPers = document.getElementById("referencia-personal-reg").value || '<span class="text-muted">No especificado</span>';
                const telRefPers = document.getElementById("telefono-ref-personal-reg").value || '<span class="text-muted">No especificado</span>';

                // 4. Construir la estructura visual del resumen
                const htmlResumen = `
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" style="margin-bottom: 0;">
                    <thead>
                        <tr class="info"><th colspan="2"><b>Información Personal</b></th></tr>
                    </thead>
                    <tbody>
                        <tr><td style="width: 30%;"><b>N° de Carnet:</b></td><td>${carnet}</td></tr>
                        <tr><td><b>Cédula:</b></td><td>${cedula}</td></tr>
                        <tr><td><b>Nombre Completo:</b></td><td>${nombre} ${apellido}</td></tr>
                        <tr><td><b>Sexo:</b></td><td>${sexoTxt}</td></tr>
                        <tr><td><b>Dirección de Habitación:</b></td><td>${direccion}</td></tr>
                        <tr><td><b>Teléfono Personal:</b></td><td>${telefonoPers}</td></tr>
                    </tbody>
                    
                    <thead>
                        <tr class="info"><th colspan="2"><b>Información Laboral</b></th></tr>
                    </thead>
                    <tbody>
                        <tr><td><b>Profesión:</b></td><td>${profesion}</td></tr>
                        <tr><td><b>Dirección Laboral:</b></td><td>${dirLaboral}</td></tr>
                        <tr><td><b>Teléfono de Trabajo:</b></td><td>${telLaboral}</td></tr>
                    </tbody>

                    <thead>
                        <tr class="info"><th colspan="2"><b>Referencias</b></th></tr>
                    </thead>
                    <tbody>
                        <tr><td><b>Ref. Legal / Teléfono:</b></td><td>${refLegal} (${telRefLegal})</td></tr>
                        <tr><td><b>Ref. Personal / Teléfono:</b></td><td>${refPers} (${telRefPers})</td></tr>
                    </tbody>
                </table>
            </div>
        `;

                // 5. Inyectar HTML en el modal y abrirlo
                document.getElementById("resumen-datos-lector").innerHTML = htmlResumen;
                modal.modal("show");
            });

            // 6. Enviar definitivamente si confirma en el modal
            if (btnConfirmarEnvio) {
                btnConfirmarEnvio.addEventListener("click", function() {
                    btnConfirmarEnvio.disabled = true;
                    btnConfirmarEnvio.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Registrando...';
                    form.submit();
                });
            }
        });
    </script>
    <?php include VIEW_PATH . "/modal/confirmation-reader.php" ?>

    <?php include VIEW_PATH . "/component/scripts.php" ?>
    <script src="<?= PUBLIC_PATH ?>/js/validations/reader/createvalidation.js"></script>
</body>

</html>