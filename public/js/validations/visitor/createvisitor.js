document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.getElementById('form-registro-visitantes');
    const fechaInput = document.getElementById('fecha-reg');
    const fechaError = document.getElementById('fecha-error');

    /**
     * --- 1. CONFIGURACIÓN Y VALIDACIÓN DE FECHA ---
     */
    if (fechaInput) {
        const hoy = new Date();
        const haceTresDias = new Date();
        haceTresDias.setDate(hoy.getDate() - 3);

        // Función para formatear fecha a YYYY-MM-DD sin desfase horario
        const formatDate = (date) => {
            let d = date.getDate().toString().padStart(2, '0');
            let m = (date.getMonth() + 1).toString().padStart(2, '0');
            let y = date.getFullYear();
            return `${y}-${m}-${d}`;
        };

        const fechaMinima = formatDate(haceTresDias);
        const fechaMaxima = formatDate(hoy);

        // Restricción visual en el calendario nativo
        fechaInput.min = fechaMinima;
        fechaInput.max = fechaMaxima;

        fechaInput.addEventListener('change', function () {
            if (!this.value) return;

            // Comparación de strings (más segura que objetos Date en JS)
            if (this.value < fechaMinima || this.value > fechaMaxima) {
                fechaError.style.display = 'block';
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
                this.value = ""; 
            } else {
                fechaError.style.display = 'none';
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    }

    /**
     * --- 2. VALIDACIÓN DE CAMPOS NUMÉRICOS ---
     */
    const inputsNumericos = document.querySelectorAll('.input-numerico');

    inputsNumericos.forEach(input => {
        // Bloqueo de teclas no numéricas
        input.addEventListener('keydown', function (e) {
            const teclasPermitidas = ['Backspace', 'Tab', 'Enter', 'Escape', 'ArrowLeft', 'ArrowRight', 'Delete'];
            if (teclasPermitidas.includes(e.key)) return;

            if (!/^[0-9]$/.test(e.key)) {
                e.preventDefault();
            }
        });

        // Limpieza de ceros a la izquierda y caracteres extraños
        input.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
            
            if (this.value.length > 1 && this.value.startsWith('0')) {
                this.value = this.value.replace(/^0+/, '');
            }

            if (this.value.length > 3) {
                this.value = this.value.slice(0, 3);
            }
        });

        // Auto-relleno con cero y validación visual al salir
        input.addEventListener('blur', function () {
            const errorElement = this.parentElement.querySelector('.error-msg');
            
            if (this.value.trim() === "") {
                this.value = "0";
            }

            const valorNumerico = parseInt(this.value, 10);
            this.classList.remove('is-invalid', 'is-valid');

            if (isNaN(valorNumerico) || valorNumerico < 0) {
                this.classList.add('is-invalid');
                if (errorElement) errorElement.style.display = 'block';
            } else {
                this.classList.add('is-valid');
                if (errorElement) errorElement.style.display = 'none';
            }
        });
    });

    /**
     * --- 3. VALIDACIÓN DE OBSERVACIONES (Regex) ---
     */
    const obsInput = document.getElementById('observaciones');
    const obsError = document.getElementById('obs-error');

    if (obsInput) {
        obsInput.addEventListener('input', function() {
            // El regex permite letras, números, espacios y tildes
            const regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]*$/;
            if (!regex.test(this.value)) {
                this.classList.add('is-invalid');
                obsError.style.display = 'block';
            } else {
                this.classList.remove('is-invalid');
                obsError.style.display = 'none';
            }
        });
    }

    /**
     * --- 4. CONTROL DE ENVÍO (PREVENT SUBMIT) ---
     */
    if (formulario) {
        formulario.addEventListener('submit', function (e) {
            const camposInvalidos = formulario.querySelectorAll('.is-invalid');
            const fechaVacia = fechaInput && !fechaInput.value;

            if (camposInvalidos.length > 0 || fechaVacia) {
                e.preventDefault(); // Detiene el envío
                alert("Por favor, corrija los errores en el formulario antes de guardar.");
                
                if(fechaVacia) {
                    fechaInput.classList.add('is-invalid');
                    fechaError.style.display = 'block';
                }
            }
        });
    }
});