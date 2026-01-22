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

    // --- Regla: Solo letras, números y espacios ---
    const regexAlfaNumerico = /^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ]+$/;

    function toggleError(input, errorElement, show, mensaje) {
        if (show) {
            input.classList.add('is-invalid');
            if (mensaje) errorElement.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${mensaje}`;
            errorElement.style.display = 'block';
        } else {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            errorElement.style.display = 'none';
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

        if (fechaSeleccionada < minFecha || fechaSeleccionada > hoySinHora) {
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
        if (!regexAlfaNumerico.test(valor)) {
            toggleError(inputInv, errorInv, true, "Solo se permiten letras, números y espacios.");
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
        if (!regexAlfaNumerico.test(valor)) {
            toggleError(inputDesc, errorDesc, true, "Solo se permiten letras, números y espacios.");
            return false;
        }
        toggleError(inputDesc, errorDesc, false);
        return true;
    }

    // --- Eventos ---
    inputFecha.addEventListener('change', validarFecha);
    inputInv.addEventListener('input', validarInvolucrados);
    inputDesc.addEventListener('input', validarDescripcion);

    form.addEventListener('submit', function(e) {
        const v1 = validarFecha();
        const v2 = validarInvolucrados();
        const v3 = validarDescripcion();

        if (!v1 || !v2 || !v3) {
            e.preventDefault();
        }
    });
});