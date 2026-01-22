document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('form-registro-actividad');
    const inputFecha = document.getElementById('fecha');
    const errorFecha = document.getElementById('fecha-error');
    
    const inputAsistentes = document.getElementById('asistentes');
    const errorAsistentes = document.getElementById('asist-error');
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

    // --- Función Genérica para mostrar/ocultar errores ---
    function toggleError(input, errorElement, show, mensaje) {
        if (show) {
            input.classList.add('is-invalid');
            if (mensaje) {
                errorElement.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${mensaje}`;
            }
            errorElement.style.display = 'block';
        } else {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            errorElement.style.display = 'none';
        }
    }

    // --- Validación de Fecha ---
    function validarFecha() {
        const valor = inputFecha.value;
        const hoySinHora = new Date();
        hoySinHora.setHours(0, 0, 0, 0);

        if (valor === "") {
            toggleError(inputFecha, errorFecha, true, "Por favor, seleccione una fecha.");
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

    // --- Validación de Asistentes ---
    function validarAsistentes() {
        const valorRaw = inputAsistentes.value;
        const valor = parseInt(valorRaw);

        if (valorRaw === "") {
            toggleError(inputAsistentes, errorAsistentes, true, "El número de asistentes es requerido.");
            return false;
        }

        if (valor <= 0) {
            toggleError(inputAsistentes, errorAsistentes, true, "El número debe ser mayor que 0.");
            return false;
        }

        if (valor > 1000) {
            toggleError(inputAsistentes, errorAsistentes, true, "El máximo permitido es 1000 asistentes.");
            return false;
        }

        toggleError(inputAsistentes, errorAsistentes, false);
        return true;
    }

    // --- Validación de Descripción ---
    function validarDescripcion() {
        const regex = /^[a-zA-Z0-9\s.,áéíóúÁÉÍÓÚñÑ]+$/;
        if (inputDesc.value.trim() === "") {
            toggleError(inputDesc, errorDesc, true, "La descripción es obligatoria.");
            return false;
        }
        if (!regex.test(inputDesc.value)) {
            toggleError(inputDesc, errorDesc, true, "Solo letras, números y espacios.");
            return false;
        }
        toggleError(inputDesc, errorDesc, false);
        return true;
    }

    // --- Eventos en tiempo real ---
    inputFecha.addEventListener('change', validarFecha);
    inputAsistentes.addEventListener('input', validarAsistentes);
    inputDesc.addEventListener('input', validarDescripcion);

    // --- Validar al enviar (Sin Alert) ---
    form.addEventListener('submit', function(e) {
        // Ejecutamos todas las validaciones
        const v1 = validarFecha();
        const v2 = validarAsistentes();
        const v3 = validarDescripcion();

        // Si alguna falla, cancelamos el envío
        if (!v1 || !v2 || !v3) {
            e.preventDefault();
            // El usuario verá los mensajes de error bajo cada input
        }
    });
});