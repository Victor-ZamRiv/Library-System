document.addEventListener('DOMContentLoaded', () => {
    const carnetInput = document.getElementById('carnet-reg');
    const libro1 = document.getElementById('libro1');
    const LONGITUD_CARNET = 10;
    const MAX_LENGTH_COTA = 30;
    const COTA_REGEX = /^(?:[A-Za-z]{1,2}\s[A-Za-z0-9]{1,4}|\d{3}.*\s[A-Za-z0-9]{4})$/;

    if (!carnetInput) return;

    // --- VALIDACIÓN DE CARNET ---
    const manejarFeedbackCarnet = (inputElement, esValido) => {
        const errorDiv = document.getElementById('carnet-error');
        if (esValido) {
            inputElement.classList.remove('is-invalid');
            inputElement.classList.add('is-valid');
            if (errorDiv) errorDiv.style.display = 'none';
            libro1.disabled = false; // Habilita el primer libro si el carnet es ok
        } else {
            inputElement.classList.add('is-invalid');
            inputElement.classList.remove('is-valid');
            if (errorDiv) {
                errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> El carnet debe tener exactamente ${LONGITUD_CARNET} dígitos.`;
                errorDiv.style.display = 'block';
            }
            deshabilitarTodosLosLibros();
        }
    };

    const deshabilitarTodosLosLibros = () => {
        document.querySelectorAll('.cota-input').forEach(input => {
            input.disabled = true;
            input.value = "";
            input.classList.remove('is-valid', 'is-invalid');
            const errId = 'error-' + input.id;
            if(document.getElementById(errId)) document.getElementById(errId).style.display = 'none';
        });
    };

    // Restricción de teclado (solo números)
    carnetInput.addEventListener('keypress', (evt) => {
        const charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) evt.preventDefault();
    });

    ['input', 'blur'].forEach(evento => {
        carnetInput.addEventListener(evento, () => {
            carnetInput.value = carnetInput.value.replace(/[^0-9]/g, '');
            const esValido = carnetInput.value.length === LONGITUD_CARNET;
            carnetInput.setCustomValidity(esValido ? '' : 'Longitud incorrecta');
            manejarFeedbackCarnet(carnetInput, esValido);
        });
    });

    // --- LÓGICA DE COTAS ---
    window.validarCota = function(inputElement) {
        const errorDisplay = document.getElementById('error-' + inputElement.id);
        const valor = inputElement.value.trim();
        let mensajeError = '';

        if (inputElement.required && valor === "") {
            mensajeError = 'Campo requerido.';
        } else if (valor.length > 0) {
            if (valor.length > MAX_LENGTH_COTA) mensajeError = `Máximo ${MAX_LENGTH_COTA} caracteres.`;
            else if (!COTA_REGEX.test(valor)) mensajeError = 'Formato incorrecto (Ej: NH H234).';
        }

        inputElement.setCustomValidity(mensajeError);
        actualizarEstadoVisual(inputElement, mensajeError, errorDisplay);
        gestionarBloqueoSecuencial();
    };

    function actualizarEstadoVisual(input, mensaje, display) {
        if (!input.checkValidity()) {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            if (display) {
                display.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${mensaje}`;
                display.style.display = 'block';
            }
        } else {
            input.classList.remove('is-invalid');
            if (input.value !== "") input.classList.add('is-valid');
            if (display) display.style.display = 'none';
        }
    }

    function gestionarBloqueoSecuencial() {
        const l1 = document.getElementById('libro1');
        const l2 = document.getElementById('libro2');
        const l3 = document.getElementById('libro3');

        l2.disabled = !(l1.value !== "" && l1.checkValidity());
        if(l2.disabled) { l2.value = ""; l3.disabled = true; l3.value = ""; }
        
        l3.disabled = !(l2.value !== "" && l2.checkValidity());
        if(l3.disabled) l3.value = "";
    }
});