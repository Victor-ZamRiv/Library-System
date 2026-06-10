document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('form-registro-logros');
    const inputFecha = document.getElementById('fecha_logro');
    const inputInv = document.getElementById('involucrados');
    const inputDesc = document.getElementById('descripcion_logro');

    const errorFecha = document.getElementById('fecha-error');
    const errorInv = document.getElementById('inv-error');
    const errorDesc = document.getElementById('desc-error');

    // --- Configuración de Límites de Fecha (Máximo 1 semana atrás) ---
    const hoy = new Date();
    const minFecha = new Date();
    minFecha.setDate(hoy.getDate() - 7); // 7 días atrás
    
    const formatFecha = (f) => f.toISOString().split('T')[0];
    
    inputFecha.min = formatFecha(minFecha);
    inputFecha.max = formatFecha(hoy);

    function toggleError(input, errorElement, show, mensaje = "") {
        const formGroup = input.closest('.form-group');
        if (show) {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            if (formGroup) formGroup.classList.add('has-error');
            if (errorElement) {
                errorElement.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${mensaje}`;
                errorElement.style.display = 'block';
            }
        } else {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            if (formGroup) formGroup.classList.remove('has-error');
            if (errorElement) {
                errorElement.style.display = 'none';
                errorElement.innerHTML = '';
            }
        }
    }

    // --- Validaciones ---

    function validarFecha() {
        const valor = inputFecha.value;
        if (valor === "") {
            toggleError(inputFecha, errorFecha, true, "Seleccione una fecha.");
            return false;
        }

        const fechaSeleccionada = new Date(valor + "T00:00:00");
        fechaSeleccionada.setHours(0,0,0,0);
        const hoySinHora = new Date();
        hoySinHora.setHours(0,0,0,0);

        // Volvemos a instanciar minFecha limpia para comparar con precisión
        const minFechaLimite = new Date();
        minFechaLimite.setDate(hoySinHora.getDate() - 7);
        minFechaLimite.setHours(0,0,0,0);

        if (fechaSeleccionada < minFechaLimite || fechaSeleccionada > hoySinHora) {
            toggleError(inputFecha, errorFecha, true, "La fecha debe estar entre hace 1 semana y hoy.");
            return false;
        }

        toggleError(inputFecha, errorFecha, false);
        return true;
    }

    function validarInvolucrados() {
        const valor = inputInv.value.trim();
        if (valor === "") {
            toggleError(inputInv, errorInv, true, "Este campo es obligatorio.");
            return false;
        }
        // Validación de letras seguidas idénticas (3 o más)
        if (/([a-zA-ZáéíóúÁÉÍÓÚñÑ])\1{2,}/i.test(valor)) {
            toggleError(inputInv, errorInv, true, "El campo involucrados contiene un exceso de letras idénticas seguidas.");
            return false;
        }
        toggleError(inputInv, errorInv, false);
        return true;
    }

    function validarDescripcion() {
        const valor = inputDesc.value.trim();
        if (valor === "") {
            toggleError(inputDesc, errorDesc, true, "La descripción es obligatoria.");
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

    // --- Eventos en tiempo real y Sanitización ---

    // Bloqueo estricto de escritura en el input de fecha (Solo permite usar el calendario)
    inputFecha.addEventListener('keydown', function(e) {
        // Permitir Tab, Escape, Enter o teclas de navegación para accesibilidad, bloquear el resto
        if (e.key !== "Tab" && e.key !== "Escape" && e.key !== "Enter") {
            e.preventDefault();
        }
    });
    inputFecha.addEventListener('change', validarFecha);
    inputFecha.addEventListener('blur', validarFecha);

    // Involucrados (Filtro para solo letras, espacios y control de comas si separas nombres)
    inputInv.addEventListener('input', function() {
        // Solo permite letras, espacios, comas y puntos
        this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s,.]/g, '');
        this.value = this.value.replace(/,{2,}/g, ',');
        this.value = this.value.replace(/\.{2,}/g, '.');
        
        if (this.classList.contains('is-invalid')) validarInvolucrados();
    });
    inputInv.addEventListener('blur', function() {
        this.value = this.value.trim().replace(/\s+/g, ' ');
        validarInvolucrados();
    });

    // Descripción de Logro (Filtros estrictos aplicados)
    inputDesc.addEventListener('input', function() {
        // 1. Permitir únicamente letras, números, espacios, puntos y comas
        this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s,.]/g, '');
        
        // 2. Impedir comas seguidas (ej: ,, -> ,)
        this.value = this.value.replace(/,{2,}/g, ',');
        
        // 3. Impedir puntos seguidos (ej: .. -> .)
        this.value = this.value.replace(/\.{2,}/g, '.');
        
        // 4. Impedir combinaciones juntas de punto y coma (ej: ., o ,. -> se reduce a un carácter simple)
        this.value = this.value.replace(/\.,/g, ',');
        this.value = this.value.replace(/,\./g, '.');
        
        if (this.classList.contains('is-invalid')) validarDescripcion();
    });
    inputDesc.addEventListener('blur', function() {
        this.value = this.value.trim().replace(/\s+/g, ' ');
        validarDescripcion();
    });

    // --- Intercepción Final ---
    form.addEventListener('submit', function(e) {
        const v1 = validarFecha();
        const v2 = validarInvolucrados();
        const v3 = validarDescripcion();

        if (!v1 || !v2 || !v3) {
            e.preventDefault();
            
            // Scroll suave hacia el primer error visual de la plantilla
            const primerError = document.querySelector('.has-error, .is-invalid');
            if (primerError) {
                primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
});