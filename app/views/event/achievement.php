<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Logros</title>
    <?php 
    $old = $_SESSION['old'] ?? [];
    $error = $_SESSION['error'] ?? null;
    unset($_SESSION['old'], $_SESSION['error']);
    include VIEW_PATH . "/component/heat.php"; ?>
</head>

<body>

    <?php include VIEW_PATH . "/component/sidebar.php"; ?>
    
    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles">
                    <i class="fa-solid fa-calendar"></i> Registro Logros
                </h1>
            </div>
        </div>

        <div class="container-fluid text-center" style="max-width: 900px;">
            <div class="card shadow-lg p-3 mb-4 bg-white rounded text-left">
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>
                    <h3 class="text-center text-titles">Nuevo Logro Alcanzado</h3>
                    <hr>
                    
                    <form action="<?= BASE_URL ?>/logro/store" method="POST" id="form-logros">
                        <input type="hidden" name="idAdmin" value="<?= $_SESSION['administrador']['id'] ?>">                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label"><span class="text-danger">*</span> Fecha del Logro:</label>
                                    <input type="date" id="logro_fecha" value="<?= htmlspecialchars($old['fecha'] ?? '') ?>" class="form-control" name="fecha" required>
                                    <div class="invalid-feedback bg-danger text-danger rounded-pill" id="error-fecha" style="display: none; padding: 5px 15px; margin-top: 5px; font-size: 12px;"></div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label"><span class="text-danger">*</span> Involucrados:</label>
                                    <input type="text" id="logro_involucrados" value="<?= htmlspecialchars($old['involucrados'] ?? '') ?>" class="form-control" name="involucrados" placeholder="Ej: Equipo de Mantenimiento, Bibliotecarios..." required>
                                    <small class="text-muted" id="help-involucrados">Personas o departamentos que participaron.</small>
                                    <div class="invalid-feedback bg-danger text-danger rounded-pill" id="error-involucrados" style="display: none; padding: 5px 15px; margin-top: 5px; font-size: 12px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><span class="text-danger">*</span> Descripción del Logro:</label>
                            <textarea id="logro_descripcion" class="form-control" name="descripcion" rows="5" placeholder="Describa el éxito o meta alcanzada..." required><?= htmlspecialchars($old['descripcion'] ?? '') ?></textarea>
                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="error-descripcion" style="display: none; padding: 5px 15px; margin-top: 5px; font-size: 12px;"></div>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-info btn-raised">
                                 Registrar Logro
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
    </section>

    <?php include VIEW_PATH . "/component/scripts.php"; ?>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('form-logros');
        const fechaInput = document.getElementById('logro_fecha');
        const involucradosInput = document.getElementById('logro_involucrados');
        const descripcionInput = document.getElementById('logro_descripcion');

        const errorFecha = document.getElementById('error-fecha');
        const errorInvolucrados = document.getElementById('error-involucrados');
        const errorDescripcion = document.getElementById('error-descripcion');

        // Obtener la fecha de hoy local en formato YYYY-MM-DD
        const hoy = new Date().toLocaleDateString('en-CA');

        // Calcular exactamente 7 días hábiles hacia atrás omitiendo Sábados (6) y Domingos (0)
        function calcularMinimoFecha() {
            let d = new Date();
            let habilesRestados = 0;
            while (habilesRestados < 7) {
                d.setDate(d.getDate() - 1);
                let diaSemana = d.getDay();
                if (diaSemana !== 0 && diaSemana !== 6) {
                    habilesRestados++;
                }
            }
            return d.toLocaleDateString('en-CA');
        }

        const fechaMinima = calcularMinimoFecha();

        // Aplicar límites nativos al calendario visual
        fechaInput.setAttribute('max', hoy);
        fechaInput.setAttribute('min', fechaMinima);

        // Control Visual de Feedback estilo Bootstrap
        function asignarFeedback(input, errorDiv, esValido, mensaje = "") {
            const formGroup = input.closest('.form-group');
            if (esValido) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                if (formGroup) formGroup.classList.remove('has-error');
                errorDiv.style.display = 'none';
                errorDiv.innerHTML = '';
            } else {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                if (formGroup) formGroup.classList.add('has-error');
                errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${mensaje}`;
                errorDiv.style.display = 'block';
            }
        }

        // --- VALIDACIONES DE CAMPO INDIVIDUALES ---

        function validarFecha() {
            const valor = fechaInput.value;
            if (!valor) {
                asignarFeedback(fechaInput, errorFecha, false, "La fecha es obligatoria.");
                return false;
            }
            if (valor > hoy) {
                asignarFeedback(fechaInput, errorFecha, false, "La fecha no puede ser posterior al día de hoy.");
                return false;
            }
            if (valor < fechaMinima) {
                asignarFeedback(fechaInput, errorFecha, false, `La fecha no puede ser mayor a 7 días hábiles de antigüedad (${fechaMinima}).`);
                return false;
            }
            asignarFeedback(fechaInput, errorFecha, true);
            return true;
        }

        function validarInvolucrados() {
            const valor = involucradosInput.value.trim();
            if (valor === "") {
                asignarFeedback(involucradosInput, errorInvolucrados, false, "El campo de involucrados es obligatorio.");
                return false;
            }
            if (/([a-zA-ZáéíóúÁÉÍÓÚñÑ])\1{2,}/i.test(valor)) {
                asignarFeedback(involucradosInput, errorInvolucrados, false, "El texto contiene un exceso de letras idénticas seguidas.");
                return false;
            }
            asignarFeedback(involucradosInput, errorInvolucrados, true);
            return true;
        }

        function validarDescripcion() {
            const valor = descripcionInput.value.trim();
            if (valor === "") {
                asignarFeedback(descripcionInput, errorDescripcion, false, "La descripción del logro es obligatoria.");
                return false;
            }
            // Valida letras repetidas consecutivas (3 o más)
            if (/([a-zA-ZáéíóúÁÉÍÓÚñÑ])\1{2,}/i.test(valor)) {
                asignarFeedback(descripcionInput, errorDescripcion, false, "La descripción contiene un exceso de letras idénticas seguidas.");
                return false;
            }
            // Valida números repetidos consecutivos (3 o más, ej: 111)
            if (/([0-9])\1{2,}/.test(valor)) {
                asignarFeedback(descripcionInput, errorDescripcion, false, "La descripción contiene un exceso de números idénticos seguidos.");
                return false;
            }
            asignarFeedback(descripcionInput, errorDescripcion, true);
            return true;
        }

        // --- MANIPULADORES DE EVENTOS ---

        fechaInput.addEventListener('input', validarFecha);
        fechaInput.addEventListener('blur', validarFecha);

        // Input de Involucrados
        involucradosInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s,.]/g, '');
            if (this.classList.contains('is-invalid')) validarInvolucrados();
        });
        involucradosInput.addEventListener('blur', function() {
            this.value = this.value.trim().replace(/\s+/g, ' ');
            validarInvolucrados();
        });

        // Input de Descripción (Solo letras, números, espacios, puntos y comas)
        descripcionInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s,.]/g, '');
            if (this.classList.contains('is-invalid')) validarDescripcion();
        });
        descripcionInput.addEventListener('blur', function() {
            this.value = this.value.trim().replace(/\s+/g, ' ');
            validarDescripcion();
        });

        // --- INTERCEPCIÓN DEL SUBMIT ---
        form.addEventListener('submit', function(e) {
            const fValida = validarFecha();
            const iValido = validarInvolucrados();
            const dValida = validarDescripcion();

            if (!fValida || !iValido || !dValida) {
                e.preventDefault();

                if (typeof swal === 'function') {
                    swal({ 
                        title: "¡Verifique los datos!", 
                        text: "Por favor corrija los campos marcados en rojo antes de guardar el logro.", 
                        type: "error" 
                    });
                } else {
                    alert("Por favor complete los campos correctamente.");
                }
            }
        });
    });
    </script>
</body>
</html>