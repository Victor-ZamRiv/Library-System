document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('form-multa');
    const inputPrestamo = document.getElementById('busqueda-multa');
    const inputMonto = document.getElementById('monto');
    const inputConcepto = document.getElementById('concepto');

    // --- 1. RESTRICCIÓN PARA EL PRÉSTAMO (Solo números) ---
    inputPrestamo.addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
    });

    // --- 2. RESTRICCIÓN PARA EL MONTO (3 enteros, 2 decimales) ---
    inputMonto.addEventListener('input', function (e) {
        let value = e.target.value;
        // Solo números y un punto
        value = value.replace(/[^0-9.]/g, '');
        const parts = value.split('.');
        
        // Evitar más de un punto
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }
        // Limitar a 3 enteros
        if (parts[0].length > 3) {
            parts[0] = parts[0].substring(0, 3);
        }
        // Limitar a 2 decimales
        if (parts[1] && parts[1].length > 2) {
            parts[1] = parts[1].substring(0, 2);
        }
        e.target.value = parts[1] !== undefined ? parts[0] + '.' + parts[1] : parts[0];
    });

    // --- 3. RESTRICCIÓN PARA EL CONCEPTO (Solo letras y espacios) ---
    inputConcepto.addEventListener('input', function (e) {
        // La regex permite: a-z, A-Z, acentos (áéíóú...), eñes (ñÑ) y espacios
        e.target.value = e.target.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
    });

    // --- FUNCIONES DE VALIDACIÓN VISUAL ---
    const mostrarEstado = (input, errorId, esValido) => {
        const errorDiv = document.getElementById(errorId);
        if (esValido) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            if (errorDiv) errorDiv.style.display = 'none';
        } else {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            if (errorDiv) errorDiv.style.display = 'block';
        }
    };

    // Validaciones al perder el foco (onblur)
    inputMonto.addEventListener('blur', function() {
        const num = parseFloat(this.value);
        const valido = !isNaN(num) && num > 0;
        mostrarEstado(this, 'monto-error', valido);
    });

    inputConcepto.addEventListener('blur', function() {
        const valido = this.value.trim().length >= 5; // Mínimo 5 letras
        mostrarEstado(this, 'concepto-error', valido);
    });

    // --- VALIDACIÓN AL ENVIAR EL FORMULARIO ---
    form.addEventListener('submit', function (e) {
        const montoNum = parseFloat(inputMonto.value);
        const esMontoValido = !isNaN(montoNum) && montoNum > 0;
        const esPrestamoValido = inputPrestamo.value.length > 0;
        const esConceptoValido = inputConcepto.value.trim().length >= 5;

        if (!esMontoValido || !esPrestamoValido || !esConceptoValido) {
            e.preventDefault();
            
            // Marcar errores visualmente
            mostrarEstado(inputMonto, 'monto-error', esMontoValido);
            mostrarEstado(inputPrestamo, 'busqueda-error', esPrestamoValido);
            mostrarEstado(inputConcepto, 'concepto-error', esConceptoValido);

            alert('Por favor, verifique los datos:\n- Monto: Mayor a 0 (Máx 999.99)\n- Concepto: Solo letras (Mín. 5)\n- Préstamo: Solo números');
        }
    });
});