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

<<<<<<< HEAD
        // Control Visual de Feedback estilo Bootstrap e integración con .form-group
=======
        // Control Visual de Feedback estilo Bootstrap
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
        function asignarFeedback(input, errorDiv, esValido, mensaje = "") {
            const formGroup = input.closest('.form-group');
            if (esValido) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                if (formGroup) formGroup.classList.remove('has-error');
<<<<<<< HEAD
                if (errorDiv) {
                    errorDiv.style.display = 'none';
                    errorDiv.innerHTML = '';
                }
=======
                errorDiv.style.display = 'none';
                errorDiv.innerHTML = '';
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
            } else {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                if (formGroup) formGroup.classList.add('has-error');
<<<<<<< HEAD
                if (errorDiv) {
                    errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${mensaje}`;
                    errorDiv.style.display = 'block';
                }
=======
                errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${mensaje}`;
                errorDiv.style.display = 'block';
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
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
<<<<<<< HEAD
                asignarFeedback(fechaInput, errorFecha, false, `La fecha no puede superar los 7 días hábiles de antigüedad (${fechaMinima}).`);
=======
                asignarFeedback(fechaInput, errorFecha, false, `La fecha no puede ser mayor a 7 días hábiles de antigüedad (${fechaMinima}).`);
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
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
<<<<<<< HEAD
            // Valida números repetidos consecutivos (3 o más)
=======
            // Valida números repetidos consecutivos (3 o más, ej: 111)
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
            if (/([0-9])\1{2,}/.test(valor)) {
                asignarFeedback(descripcionInput, errorDescripcion, false, "La descripción contiene un exceso de números idénticos seguidos.");
                return false;
            }
            asignarFeedback(descripcionInput, errorDescripcion, true);
            return true;
        }

<<<<<<< HEAD
        // --- MANIPULADORES DE EVENTOS EN TIEMPO REAL ---

        // Bloqueo estricto de escritura para la fecha (Obliga a desplegar el calendario)
        fechaInput.addEventListener('keydown', function(e) {
            if (e.key !== "Tab" && e.key !== "Escape" && e.key !== "Enter") {
                e.preventDefault();
            }
        });
        fechaInput.addEventListener('change', validarFecha);
        fechaInput.addEventListener('blur', validarFecha);

        // Input de Involucrados (Filtro en tiempo real)
        involucradosInput.addEventListener('input', function() {
            // Permitir letras, espacios, comas y puntos
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s,.]/g, '');
            
            // Impedir duplicación consecutiva de comas y puntos
            this.value = this.value.replace(/,{2,}/g, ',');
            this.value = this.value.replace(/\.{2,}/g, '.');
            
=======
        // --- MANIPULADORES DE EVENTOS ---

        fechaInput.addEventListener('input', validarFecha);
        fechaInput.addEventListener('blur', validarFecha);

        // Input de Involucrados
        involucradosInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s,.]/g, '');
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
            if (this.classList.contains('is-invalid')) validarInvolucrados();
        });
        involucradosInput.addEventListener('blur', function() {
            this.value = this.value.trim().replace(/\s+/g, ' ');
            validarInvolucrados();
        });

<<<<<<< HEAD
        // Input de Descripción (Filtros estrictos y avanzados de puntuación)
        descripcionInput.addEventListener('input', function() {
            // 1. Permitir únicamente letras, números, espacios, puntos y comas
            this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s,.]/g, '');
            
            // 2. Impedir comas seguidas (ej: ,, -> ,)
            this.value = this.value.replace(/,{2,}/g, ',');
            
            // 3. Impedir puntos seguidos (ej: .. -> .)
            this.value = this.value.replace(/\.{2,}/g, '.');
            
            // 4. Impedir combinaciones juntas de punto y coma (ej: ., o ,. -> se normalizan)
            this.value = this.value.replace(/\.,/g, ',');
            this.value = this.value.replace(/,\./g, '.');
            
=======
        // Input de Descripción (Solo letras, números, espacios, puntos y comas)
        descripcionInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s,.]/g, '');
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
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

<<<<<<< HEAD
                // Hace un scroll suave directo hacia el elemento con error
                const primerError = document.querySelector('.has-error, .is-invalid');
                if (primerError) {
                    primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }

=======
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
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