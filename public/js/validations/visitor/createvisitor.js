document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.getElementById('form-registro-visitantes');
    const fechaInput = document.getElementById('fecha-reg');
    const fechaError = document.getElementById('fecha-error');
    
    // Selects Obligatorios
    const salaSelect = document.getElementById('sala-reg');
    const turnoSelect = document.getElementById('turno-reg');

    /**
     * --- 1. CONFIGURACIÓN DE LÍMITES DE FECHA ---
     */
    let fechaMinima = "";
    let fechaMaxima = "";

    if (fechaInput) {
        const hoy = new Date();
        const haceTresDias = new Date();
        haceTresDias.setDate(hoy.getDate() - 3);

        const formatDate = (date) => {
            let d = date.getDate().toString().padStart(2, '0');
            let m = (date.getMonth() + 1).toString().padStart(2, '0');
            let y = date.getFullYear();
            return `${y}-${m}-${d}`;
        };

        fechaMinima = formatDate(haceTresDias);
        fechaMaxima = formatDate(hoy);

        fechaInput.min = fechaMinima;
        fechaInput.max = fechaMaxima;
    }

    /**
     * --- 1.2 FUNCIÓN GENÉRICA PARA CAMPOS OBLIGATORIOS (Fecha, Sala, Turno) ---
     */
    const validarCampoObligatorio = (elemento, errorId, esFecha = false) => {
        const errorElement = document.getElementById(errorId);
        
        // 1. Validar si está vacío o no se ha seleccionado opción válida
        if (!elemento || !elemento.value || elemento.value.trim() === "") {
            elemento.classList.add('is-invalid');
            elemento.classList.remove('is-valid');
            
            if (errorElement) {
                errorElement.innerHTML = '<i class="fas fa-exclamation-circle"></i> Este campo es obligatorio.';
                errorElement.style.display = 'block';
                
                // Si es el campo de fecha, le añadimos dinámicamente el fondo de error de Bootstrap
                if (esFecha) {
                    errorElement.className = "bg-danger text-danger rounded-pill p-1";
                }
            }
            return false;
        }

        // 2. Validación extra exclusiva para el rango de la fecha
        if (esFecha && (elemento.value < fechaMinima || elemento.value > fechaMaxima)) {
            elemento.classList.add('is-invalid');
            elemento.classList.remove('is-valid');
            
            if (errorElement) {
                errorElement.innerHTML = '<i class="fas fa-exclamation-circle"></i> La fecha debe ser de hoy o máximo 3 días atrás.';
                errorElement.style.display = 'block';
                
                // Si vuelve al error de rango original, le quitamos el bloque de fondo para que quede texto rojo simple
                errorElement.className = "text-danger";
            }
            elemento.value = ""; // Limpia el valor incorrecto
            return false;
        }

        // 3. Si pasa las validaciones, el campo es válido
        elemento.classList.remove('is-invalid');
        elemento.classList.add('is-valid');
        
        if (errorElement) {
            // En el caso de la fecha, si es válida, ocultamos el bloque por completo
            if (esFecha) {
                errorElement.style.display = 'none';
            } else {
                errorElement.style.display = 'none';
            }
        }
        return true;
    };

    // Asignación de eventos en tiempo real para campos principales
    if (fechaInput) {
        fechaInput.addEventListener('blur', () => validarCampoObligatorio(fechaInput, 'fecha-error', true));
        fechaInput.addEventListener('change', () => validarCampoObligatorio(fechaInput, 'fecha-error', true));
    }

    if (salaSelect) {
        salaSelect.addEventListener('blur', () => validarCampoObligatorio(salaSelect, 'sala-error'));
        salaSelect.addEventListener('change', () => validarCampoObligatorio(salaSelect, 'sala-error'));
    }

    if (turnoSelect) {
        turnoSelect.addEventListener('blur', () => validarCampoObligatorio(turnoSelect, 'turno-error'));
        turnoSelect.addEventListener('change', () => validarCampoObligatorio(turnoSelect, 'turno-error'));
    }

    /**
     * --- 2. VALIDACIÓN DE CAMPOS NUMÉRICOS ---
     */
    const inputsNumericos = document.querySelectorAll('.input-numerico');

    inputsNumericos.forEach(input => {
        input.addEventListener('keydown', function (e) {
            const teclasPermitidas = ['Backspace', 'Tab', 'Enter', 'Escape', 'ArrowLeft', 'ArrowRight', 'Delete'];
            if (teclasPermitidas.includes(e.key)) return;

            if (!/^[0-9]$/.test(e.key)) {
                e.preventDefault();
            }
        });

        input.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
            
            if (this.value.length > 1 && this.value.startsWith('0')) {
                this.value = this.value.replace(/^0+/, '');
            }

            if (this.value.length > 3) {
                this.value = this.value.slice(0, 3);
            }
        });

        input.addEventListener('blur', function () {
            if (this.value.trim() === "") {
                this.value = "0";
            }

            const valorNumerico = parseInt(this.value, 10);
            this.classList.remove('is-invalid');
            
            if (isNaN(valorNumerico) || valorNumerico < 0) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else {
                this.classList.add('is-valid');
            }
        });
    });

    /**
     * --- 3. VALIDACIÓN DE OBSERVACIONES ---
     */
    const obsInput = document.getElementById('observaciones');
    const obsError = document.getElementById('obs-error');

    if (obsInput) {
        obsInput.addEventListener('input', function() {
            const regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]*$/;
            if (!regex.test(this.value)) {
                this.classList.add('is-invalid');
                if (obsError) obsError.style.display = 'block';
            } else {
                this.classList.remove('is-invalid');
                if (obsError) obsError.style.display = 'none';
            }
        });
    }

    /**
     * --- 4. CONTROL DE ENVÍO (SUBMIT) ---
     */
    if (formulario) {
        formulario.addEventListener('submit', function (e) {
            // Forzar re-validación de los tres campos obligatorios antes de procesar el guardado
            const fechaValida = validarCampoObligatorio(fechaInput, 'fecha-error', true);
            const salaValida  = validarCampoObligatorio(salaSelect, 'sala-error');
            const turnoValido = validarCampoObligatorio(turnoSelect, 'turno-error');

            const camposInvalidos = formulario.querySelectorAll('.is-invalid');

            if (!fechaValida || !salaValida || !turnoValido || camposInvalidos.length > 0) {
                e.preventDefault();
                alert("Por favor, corrija los errores en el formulario antes de guardar.");
            }
        });
    }
});