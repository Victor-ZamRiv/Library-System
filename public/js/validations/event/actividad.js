document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('form-registro-actividad');
    const inputFecha = document.getElementById('fecha');
    const errorFecha = document.getElementById('fecha-error');
    
    const inputCategoria = document.getElementById('categoria');
    const errorCategoria = document.getElementById('cat-error');

    const inputAsistentes = document.getElementById('asistentes');
    const errorAsistentes = document.getElementById('asist-error');

    const inputOrganizador = document.getElementById('organizador');
    const errorOrganizador = document.getElementById('org-error');

    const inputDesc = document.getElementById('descripcion');
    const errorDesc = document.getElementById('desc-error');

    // --- Configuración de límites de Fecha ---
    const hoy = new Date();
    const formatFecha = (f) => f.toISOString().split('T')[0];

    const minFecha = new Date();
    minFecha.setDate(hoy.getDate() - 7);
    minFecha.setHours(0,0,0,0);
    inputFecha.min = formatFecha(minFecha);

    const maxFecha = new Date();
    maxFecha.setMonth(hoy.getMonth() + 2);
    inputFecha.max = formatFecha(maxFecha);

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
        const hoySinHora = new Date();
        hoySinHora.setHours(0, 0, 0, 0);

        if (valor === "") {
            toggleError(inputFecha, errorFecha, true, "La fecha del evento es obligatoria.");
            return false;
        }

        const fechaSeleccionada = new Date(valor + "T00:00:00");

        if (fechaSeleccionada < minFecha || fechaSeleccionada > maxFecha) {
            toggleError(inputFecha, errorFecha, true, "Fecha fuera de rango (1 semana atrás hasta 2 meses adelante).");
            return false;
        }

        toggleError(inputFecha, errorFecha, false);
        
        const selectEstado = document.getElementById('estado');
        if (fechaSeleccionada > hoySinHora) {
            selectEstado.value = "Pendiente";
        }
        return true;
    }

    function validarCategoria() {
        if (inputCategoria.value === "" || inputCategoria.value === null) {
            toggleError(inputCategoria, errorCategoria, true, "Debe seleccionar una categoría de forma obligatoria.");
            return false;
        }
        toggleError(inputCategoria, errorCategoria, false);
        return true;
    }

    function validarAsistentes() {
        const valorRaw = inputAsistentes.value.trim();

        if (valorRaw === "") {
            toggleError(inputAsistentes, errorAsistentes, true, "El número de asistentes es obligatorio.");
            return false;
        }

        const valor = parseInt(valorRaw, 10);

        if (isNaN(valor) || valor < 1) {
            toggleError(inputAsistentes, errorAsistentes, true, "El número mínimo permitido es 1 asistente.");
            return false;
        }

        if (valor > 1000) {
            toggleError(inputAsistentes, errorAsistentes, true, "El máximo permitido es 1000 asistentes.");
            return false;
        }

        toggleError(inputAsistentes, errorAsistentes, false);
        return true;
    }

    function validarOrganizador() {
        const valor = inputOrganizador.value.trim();

        if (valor === "") {
            toggleError(inputOrganizador, errorOrganizador, true, "El campo organizador es obligatorio.");
            return false;
        }
        if (/([a-zA-ZáéíóúÁÉÍÓÚñÑ])\1{2,}/i.test(valor)) {
            toggleError(inputOrganizador, errorOrganizador, true, "El texto contiene un exceso de letras idénticas seguidas.");
            return false;
        }
        toggleError(inputOrganizador, errorOrganizador, false);
        return true;
    }

    function validarDescripcion() {
        const valor = inputDesc.value.trim();

        if (valor === "") {
            toggleError(inputDesc, errorDesc, true, "La descripción de la actividad es obligatoria.");
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

    // Categoría
    inputCategoria.addEventListener('change', validarCategoria);
    inputCategoria.addEventListener('blur', validarCategoria);

    // Número de asistentes
    inputAsistentes.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.classList.contains('is-invalid')) validarAsistentes();
    });
    inputAsistentes.addEventListener('blur', validarAsistentes);

    // Organizador
    inputOrganizador.addEventListener('input', function() {
        this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s,]/g, '');
        this.value = this.value.replace(/,{2,}/g, ',');
        if (this.classList.contains('is-invalid')) validarOrganizador();
    });
    inputOrganizador.addEventListener('blur', function() {
        this.value = this.value.trim().replace(/\s+/g, ' ');
        validarOrganizador();
    });

    // Descripción (Filtros estrictos para comas, puntos y sus combinaciones)
    inputDesc.addEventListener('input', function() {
        // 1. Permitir únicamente letras, números, espacios, puntos y comas
        this.value = this.value.replace(/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s,.]/g, '');
        
        // 2. Impedir comas seguidas (ej: ,, -> ,)
        this.value = this.value.replace(/,{2,}/g, ',');
        
        // 3. Impedir puntos seguidos (ej: .. -> .)
        this.value = this.value.replace(/\.{2,}/g, '.');
        
        // 4. Impedir combinaciones juntas de punto y coma (ej: ., o ,. -> se reduce al último escrito o carácter simple)
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
        const vCat = validarCategoria();
        const vAsis = validarAsistentes();
        const vOrg = validarOrganizador();
        const vDesc = validarDescripcion();

        if (!vFecha || !vCat || !vAsis || !vOrg || !vDesc) {
            e.preventDefault();
        }
    });
});