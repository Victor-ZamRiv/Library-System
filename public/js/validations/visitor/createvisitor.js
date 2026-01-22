

document.addEventListener("DOMContentLoaded", function () {
    // 1. CONFIGURACIÓN DINÁMICA DE LA FECHA
    const inputFecha = document.getElementById('fecha-reg');
    const hoy = new Date();
    const anioActual = hoy.getFullYear();
    const mes = String(hoy.getMonth() + 1).padStart(2, '0');
    const dia = String(hoy.getDate()).padStart(2, '0');
    const fechaActualFormateada = `${anioActual}-${mes}-${dia}`;
    const inicioAnioFormateado = `${anioActual}-01-01`;

    inputFecha.setAttribute('max', fechaActualFormateada);
    inputFecha.setAttribute('min', inicioAnioFormateado);

    // 2. VALIDACIÓN DE FECHA
    inputFecha.addEventListener('blur', function () {
        validarEstado(this, document.getElementById('fecha-error'));
    });

    // 3. VALIDACIÓN PARA TODOS LOS CAMPOS (NUMÉRICOS Y OBSERVACIONES)
    // --- BLOQUEO DE TECLAS, CARACTERES ESPECIALES Y LÍMITE DE 3 DÍGITOS ---
    const inputsNumericos = document.querySelectorAll('.input-numerico');

    inputsNumericos.forEach(input => {
        input.addEventListener('keydown', function (e) {
            // 1. Permitir teclas de control
            const teclasPermitidas = ['Backspace', 'Tab', 'Enter', 'Escape', 'ArrowLeft', 'ArrowRight', 'Delete'];
            if (teclasPermitidas.includes(e.key)) return;

            // 2. Bloquear si no es un número (bloquea 'e', '.', ',', '-', '+')
            if (!/^[0-9]$/.test(e.key)) {
                e.preventDefault();
                return;
            }

            // 3. Limitar a 3 dígitos
            // Si ya hay 3 caracteres y no se ha seleccionado texto para sobrescribir
            if (this.value.length >= 3 && this.selectionStart === this.selectionEnd) {
                e.preventDefault();
            }
        });

        // 4. Validación extra al pegar o escribir (por si acaso)
        input.addEventListener('input', function () {
            if (this.value.length > 3) {
                this.value = this.value.slice(0, 3);
            }
        });

        // 5. Evitar pegado de contenido no válido
        input.addEventListener('paste', function (e) {
            const data = e.clipboardData.getData('text');
            // Si no es número o si el resultado final excedería los 3 dígitos
            if (!/^\d+$/.test(data) || (this.value.length + data.length > 3)) {
                e.preventDefault();
            }
        });
    });

    // Función auxiliar para aplicar estilos de validación
    function validarEstado(input, errorElement) {
        let esValido = true;

        // Validación especial para OBSERVACIONES (porque textarea no soporta pattern)
        if (input.id === 'observaciones' && input.value !== "") {
            // Esta es la expresión regular: Letras, números, acentos, eñes y espacios
            const patron = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$/;
            esValido = patron.test(input.value);
        } else {
            // Validación estándar para el resto (fecha y números)
            esValido = input.value === "" && !input.hasAttribute('required') ? true : input.checkValidity();
        }

        if (!esValido) {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            if (errorElement) errorElement.style.display = 'block';
        } else {
            input.classList.remove('is-invalid');
            // Solo añadir is-valid si no está vacío
            if (input.value !== "") {
                input.classList.add('is-valid');
            }
            if (errorElement) errorElement.style.display = 'none';
        }
    }
});