<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Logro</title>
    <?php 
    // Priorizamos los datos "old" de la sesión (por si hubo error de validación) 
    // sobre los datos que vienen de la base de datos ($logro)
    include VIEW_PATH . "/component/heat.php"; 
    ?>
</head>

<body>

    <?php include VIEW_PATH . "/component/sidebar.php"; ?>
    
    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles">
                    <i class="fa-solid fa-trophy"></i> Editar Logro
                </h1>
            </div>
        </div>

        <div class="container-fluid text-center" style="max-width: 900px;">
            <div class="card shadow-lg p-3 mb-4 bg-white rounded text-left">
                <div class="card-body">

                    <h3 class="text-center text-titles">Actualizar Logro</h3>
                    <hr>
                    
                    <form action="<?= BASE_URL ?>/logro/update" method="POST" id="form-editar-logro">
                        
                        <input type="hidden" name="id" value="<?= $logro->getIdLogro() ?>">
                        
                        <input type="hidden" name="idAdmin" value="<?= $_SESSION['administrador']['id'] ?>">                        
                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label"><span class="text-danger">*</span> Fecha del Logro:</label>
                                    <input type="date" class="form-control" name="fecha" id="fecha"
                                           value="<?= htmlspecialchars($old['fecha'] ?? $logro->getFecha()) ?>" 
                                           onkeydown="return false" required>
                                    <div class="invalid-feedback bg-danger text-danger rounded-pill" id="fecha-error" style="display: none; padding: 5px 15px; font-size: 12px; margin-top: 5px;">
                                        <i class="fas fa-exclamation-circle"></i> La fecha del logro es obligatoria.
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label"><span class="text-danger">*</span> Involucrados:</label>
                                    <input type="text" class="form-control" name="involucrados" id="involucrados"
                                           value="<?= htmlspecialchars($old['involucrados'] ?? $logro->getInvolucrados()) ?>" 
                                           placeholder="Ej: Equipo de Mantenimiento..." required>
                                    <div class="invalid-feedback bg-danger text-danger rounded-pill" id="involucrados-error" style="display: none; padding: 5px 15px; font-size: 12px; margin-top: 5px;">
                                        <i class="fas fa-exclamation-circle"></i> El campo de involucrados es obligatorio.
                                    </div>
                                    <small class="text-muted">Personas o departamentos que participaron.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group label-floating">
                            <label class="control-label"><span class="text-danger">*</span> Descripción del Logro:</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="5" 
                                      placeholder="Describa el éxito alcanzado..." required><?= htmlspecialchars($old['descripcion'] ?? $logro->getDescripcion()) ?></textarea>
                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="descripcion-error" style="display: none; padding: 5px 15px; font-size: 12px; margin-top: 5px;">
                                <i class="fas fa-exclamation-circle"></i> La descripción del logro es obligatoria.
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <a href="<?= BASE_URL ?>/eventos" class="btn btn-default btn-raised">Cancelar</a>
                            <button type="submit" class="btn btn-success btn-raised">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
    </section>
<!-- <script src="<?= PUBLIC_PATH ?>/js/validations/event/achievement.js"></script> Unificar scripts-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    // Captura dinámica para funcionar tanto en la vista de registro como en la de edición
    const form = document.getElementById('form-registro-logro') || document.getElementById('form-editar-logro');
    
    if (!form) return;

    const inputFecha = document.getElementById('fecha');
    const errorFecha = document.getElementById('fecha-error');
    
    const inputInvolucrados = document.getElementById('involucrados');
    const errorInvolucrados = document.getElementById('involucrados-error');

    const inputDesc = document.getElementById('descripcion');
    const errorDesc = document.getElementById('descripcion-error');

    // --- Configuración de límites de Fecha (Ejemplo: Máximo hasta el día de hoy) ---
    const hoy = new Date();
    const formatFecha = (f) => f.toISOString().split('T')[0];
    inputFecha.max = formatFecha(hoy);

    // --- Control Visual de Feedback ---
    function toggleError(input, errorElement, show, mensaje = "") {
        const formGroup = input.closest('.form-group');
        if (show) {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            if (formGroup) formGroup.classList.add('has-error');
            errorElement.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${mensaje}`;
            errorElement.style.display = 'block';
        } else {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            if (formGroup) formGroup.classList.remove('has-error');
            errorElement.style.display = 'none';
            errorElement.innerHTML = '';
        }
    }

    // --- Funciones de Validación Individuales ---

    function validarFecha() {
        const valor = inputFecha.value;

        if (valor === "") {
            toggleError(inputFecha, errorFecha, true, "La fecha del logro es obligatoria.");
            return false;
        }

        const fechaSeleccionada = new Date(valor + "T00:00:00");
        const hoySinHora = new Date();
        hoySinHora.setHours(0,0,0,0);

        if (fechaSeleccionada > hoySinHora) {
            toggleError(inputFecha, errorFecha, true, "La fecha del logro no puede ser del futuro.");
            return false;
        }

        toggleError(inputFecha, errorFecha, false);
        return true;
    }

    function validarInvolucrados() {
        const valor = inputInvolucrados.value.trim();

        if (valor === "") {
            toggleError(inputInvolucrados, errorInvolucrados, true, "El campo de involucrados es obligatorio.");
            return false;
        }
        // Validación de letras consecutivas idénticas (3 o más)
        if (/([a-zA-ZáéíóúÁÉÍÓÚñÑ])\1{2,}/i.test(valor)) {
            toggleError(inputInvolucrados, errorInvolucrados, true, "El texto contiene un exceso de letras idénticas seguidas.");
            return false;
        }
        toggleError(inputInvolucrados, errorInvolucrados, false);
        return true;
    }

    function validarDescripcion() {
        const valor = inputDesc.value.trim();

        if (valor === "") {
            toggleError(inputDesc, errorDesc, true, "La descripción del logro es obligatoria.");
            return false;
        }
        // Validación de caracteres alfabéticos seguidos idénticos (3 o más)
        if (/([a-zA-ZáéíóúÁÉÍÓÚñÑ])\1{2,}/i.test(valor)) {
            toggleError(inputDesc, errorDesc, true, "La descripción contiene un exceso de letras idénticas seguidas.");
            return false;
        }
        // Validación de números seguidos idénticos (3 o más)
        if (/([0-9])\1{2,}/.test(valor)) {
            toggleError(inputDesc, errorDesc, true, "La descripción contiene un exceso de números idénticos seguidos.");
            return false;
        }
        toggleError(inputDesc, errorDesc, false);
        return true;
    }

    // --- Manejadores de Eventos en tiempo real e interceptores blur ---

    // Fecha
    inputFecha.addEventListener('change', validarFecha);
    inputFecha.addEventListener('blur', validarFecha);

    // Involucrados (Reglas de Organizador: Solo letras, espacios y comas. NO PUNTOS. NO COMAS SEGUIDAS)
    inputInvolucrados.addEventListener('input', function() {
        this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s,]/g, '');
        this.value = this.value.replace(/,{2,}/g, ',');
        
        if (this.classList.contains('is-invalid')) validarInvolucrados();
    });
    inputInvolucrados.addEventListener('blur', function() {
        this.value = this.value.trim().replace(/\s+/g, ' ');
        validarInvolucrados();
    });

    // Descripción (Reglas de Descripción: Filtros estrictos para comas, puntos y combinaciones pegadas)
    inputDesc.addEventListener('input', function() {
        this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s,.]/g, '');
        
        // Evitar signos repetidos seguidos
        this.value = this.value.replace(/,{2,}/g, ',');
        this.value = this.value.replace(/\.{2,}/g, '.');
        
        // Evitar combinaciones mixtas de punto y coma pegadas
        this.value = this.value.replace(/\.,/g, ',');
        this.value = this.value.replace(/,\./g, '.');
        
        if (this.classList.contains('is-invalid')) validarDescripcion();
    });
    inputDesc.addEventListener('blur', function() {
        this.value = this.value.trim().replace(/\s+/g, ' ');
        validarDescripcion();
    });

    // --- Intercepción Final del Formulario ---
    form.addEventListener('submit', function(e) {
        const vFecha = validarFecha();
        const vInvol = validarInvolucrados();
        const vDesc = validarDescripcion();

        if (!vFecha || !vInvol || !vDesc) {
            e.preventDefault();
        }
    });
});
    </script>
    <?php include VIEW_PATH . "/component/scripts.php"; ?>
</body>
</html>