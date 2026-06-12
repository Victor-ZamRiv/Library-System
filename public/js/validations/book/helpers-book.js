/**
 * --- VALIDACIONES ALGORÍTMICAS Y FORMATEO DE LIBROS ---
 * Sistema de Gestión Bibliotecaria (SGB) - MVC Puro
 */

// ============================================================================
// 1. CONFIGURACIÓN DE CAMPOS (Mapeo exclusivo para el formulario de libros)
// ============================================================================
const CAMPOS_NUMERICOS = ['year-reg', 'edicion-reg', 'paginas-reg', 'ejemplares-reg', 'volumen-reg'];
const CAMPOS_ALFABETICOS = ['titulo-reg', 'autor-reg', 'editorial-reg'];
const CAMPOS_DIRECCION = ['ciudad-reg']; // Usa la misma regla de caracteres que ubicación

// ============================================================================
// 2. FILTROS Y SANITIZACIÓN EN TIEMPO REAL (Defensa de Entradas)
// ============================================================================
function aplicarFiltrosSanitizacion(inputElement) {
    const id = inputElement.id;

    inputElement.addEventListener('input', () => {
        let valorOriginal = inputElement.value;

        if (CAMPOS_NUMERICOS.includes(id)) {
            inputElement.value = valorOriginal.replace(/[^0-9]/g, '');
        } 
        else if (CAMPOS_ALFABETICOS.includes(id)) {
            // Ajuste: El título permite números según tu patrón HTML, autor y editorial no.
            if(id === 'titulo-reg') {
                inputElement.value = valorOriginal.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s]/g, '');
            } else {
                inputElement.value = valorOriginal.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            }
        }
        else if (CAMPOS_DIRECCION.includes(id)) {
            inputElement.value = valorOriginal.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s.,#\-]/g, '');
        }
    });
}

// ============================================================================
// 3. PROCESADORES DE TEXTO Y NORMALIZADORES (Formateo)
// ============================================================================
function capitalizarTexto(texto) {
    return texto.toLowerCase()
        .split(' ')
        .filter(palabra => palabra.length > 0)
        .map(palabra => palabra.charAt(0).toUpperCase() + palabra.slice(1))
        .join(' ');
}

function normalizarYFormatearCampos(inputElement) {
    const id = inputElement.id;

    inputElement.addEventListener('blur', () => {
        let valor = inputElement.value.trim();
        if (valor === "") return;

        // Eliminar espacios dobles intermedios
        valor = valor.replace(/\s+/g, ' ');

        if (CAMPOS_ALFABETICOS.includes(id) || CAMPOS_DIRECCION.includes(id)) {
            inputElement.value = capitalizarTexto(valor);
        } else {
            inputElement.value = valor;
        }
    });
}

// ============================================================================
// 4. FUNCIONES AUXILIARES DE VALIDACIÓN SEMÁNTICA
// ============================================================================
/**
 * Verifica si un texto contiene 3 o más letras idénticas seguidas de forma consecutiva.
 */
function tieneLetrasRepetidasInvalidos(texto) {
    const regexLetrasRepetidas = /([a-zA-ZáéíóúÁÉÍÓÚñÑ])\1{2,}/i;
    return regexLetrasRepetidas.test(texto);
}

/**
 * Verifica si un texto contiene más de 4 números idénticos seguidos de forma consecutiva (5 o más).
 */
function tieneNumerosRepetidosInvalidos(texto) {
    const regexNumerosRepetidas = /([0-9])\1{4,}/;
    return regexNumerosRepetidas.test(texto);
}

// ============================================================================
// 5. MOTOR VISUAL DE ESTADOS DE ERROR
// ============================================================================
function actualizarEstadoInput(input, errorElement, mensaje) {
    const esValido = input.checkValidity();
    const formGroup = input.closest('.form-group');

    input.classList.toggle('is-invalid', !esValido);
    input.classList.toggle('is-valid', esValido);

    if (errorElement) {
        if (!esValido) {
            if (formGroup) formGroup.classList.add('has-error');

            let textoError = mensaje || input.validationMessage;
            if (input.validity.valueMissing) {
                textoError = "Este campo es obligatorio.";
            }

            errorElement.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${textoError}`;
            errorElement.style.display = 'block';
        } else {
            if (formGroup) formGroup.classList.remove('has-error');
            errorElement.style.display = 'none';
            errorElement.innerHTML = '';
        }
    }
}

// ============================================================================
// 6. VALIDACIONES INDIVIDUALES POR CAMPO (Llamadas desde el HTML)
// ============================================================================
function validarTitulo(input) {
    const error = document.getElementById('titulo-error');
    let msg = "";

    if (tieneLetrasRepetidasInvalidos(input.value)) {
        msg = "El título contiene demasiadas letras repetidas consecutivas.";
    }

    input.setCustomValidity(msg);
    actualizarEstadoInput(input, error, msg);
}

function formatearAutor(input) {
    let palabras = input.value.toLowerCase().split(' ');
    input.value = palabras.map(p => p.charAt(0).toUpperCase() + p.slice(1)).join(' ').trim();
    
    const error = document.getElementById('autor-error');
    let msg = "";

    if (tieneLetrasRepetidasInvalidos(input.value)) {
        msg = "El nombre del autor contiene letras repetidas no válidas.";
    }

    input.setCustomValidity(msg);
    actualizarEstadoInput(input, error, msg);
}

function validarCiudad(input) {
    const error = document.getElementById('ciudad-error');
    let msg = "";

    if (tieneLetrasRepetidasInvalidos(input.value)) {
        msg = "La ciudad contiene demasiados caracteres repetidos.";
    }

    input.setCustomValidity(msg);
    actualizarEstadoInput(input, error, msg);
}

function validarEditorial(input) {
    const error = document.getElementById('editorial-error');
    let msg = "";

    if (tieneLetrasRepetidasInvalidos(input.value)) {
        msg = "La editorial contiene demasiadas letras repetidas.";
    }

    input.setCustomValidity(msg);
    actualizarEstadoInput(input, error, msg);
}

function validarAnio(input) {
    const error = document.getElementById('year-error');
    const valor = parseInt(input.value, 10);
    const actual = new Date().getFullYear();
    const MIN = 1800; // Ajusta según el libro más antiguo de la biblioteca
    let msg = "";

    if (input.value.trim() === "") {
        input.setCustomValidity(""); 
    } else if (tieneNumerosRepetidosInvalidos(input.value)) {
        msg = "El año no es válido (números repetidos).";
    } else if (valor > actual) {
        msg = `El año no puede ser superior a ${actual}.`;
    } else if (valor <= MIN) {
        msg = `El año debe ser posterior a ${MIN}.`;
    } else if (!/^\d{4}$/.test(input.value)) {
        msg = "Ingrese un año válido de 4 dígitos.";
    } else {
        input.setCustomValidity("");
    }

    input.setCustomValidity(msg);
    actualizarEstadoInput(input, error, msg);
}

function validarNumerico(input, errorId, max, campo) {
    const valor = input.value.trim();
    const errorDiv = document.getElementById(errorId);
    const num = parseInt(valor, 10);
    let msg = "";

    if (valor === "") {
        input.setCustomValidity(""); 
    } else if (tieneNumerosRepetidosInvalidos(valor)) {
        msg = "Número inválido (valores repetidos).";
    } else if (!/^\d+$/.test(valor)) {
        msg = "Solo se permiten números.";
    } else if (num < 1 || num > max || (valor.length > 1 && valor.startsWith("0"))) {
        msg = `${campo} debe estar entre 1 y ${max} (sin ceros a la izquierda).`;
    } else {
        input.setCustomValidity("");
    }

    input.setCustomValidity(msg);
    actualizarEstadoInput(input, errorDiv, msg);
}

// Alias globales para eventos inline del formulario
const validarEdicion = (el) => validarNumerico(el, 'edicion-error', 999, 'Edición');
const validarPaginas = (el) => validarNumerico(el, 'paginas-error', 9999, 'Páginas');
const validarEjemplares = (el) => validarNumerico(el, 'ejemplares-error', 100, 'Ejemplares');
const validarVolumen = (el) => validarNumerico(el, 'volumen-error', 100, 'Volumen');

function validarIsbn(input) {
    const error = document.getElementById('isbn-error');
    const clean = input.value.toUpperCase().replace(/[\s\-]/g, '');
    let msg = "";

    if (input.value.trim() === "") {
        input.setCustomValidity("");
    } else if (tieneNumerosRepetidosInvalidos(clean)) {
        msg = "El ISBN contiene demasiados números repetidos.";
    } else if (clean.length === 10) {
        if (!/^\d{9}[\dX]$/.test(clean)) msg = "ISBN-10 inválido.";
    } else if (clean.length === 13) {
        if (!/^\d{13}$/.test(clean)) msg = "ISBN-13 inválido.";
    } else {
        msg = "El ISBN debe tener 10 o 13 dígitos.";
    }

    input.setCustomValidity(msg);
    actualizarEstadoInput(input, error, msg);
}

function validarCota(input) {
    const error = document.getElementById('cota-error');
    
    // Patrón optimizado: Soporta letras o números iniciales (Dewey), seguidos de espacio/guion/punto y el código de autor flexible
    const cotaPattern = /^(?:[A-Za-z]{1,4}[\s\-][A-Za-z0-9]{1,6}|\d{3}(?:\.\d+)?[\s\-][A-Za-z0-9]{1,6})$/;
    let msg = "";

    if (input.value.trim() === "") {
        input.setCustomValidity("");
    } else if (input.value.length > 30) {
        msg = "Máximo 30 caracteres.";
    } else if (!cotaPattern.test(input.value.trim())) {
        msg = "Formato de cota incorrecto (Ej: 900 B222, 400 R288 o NH-234).";
    } else {
        input.setCustomValidity("");
    }

    input.setCustomValidity(msg);
    actualizarEstadoInput(input, error, msg);
}

function validarObservaciones(input) {
    const error = document.getElementById('observaciones-error');
    const regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s\.,;:\-]+$/;
    let msg = "";

    if (input.value.trim() !== "") {
        if (!regex.test(input.value)) msg = "Contiene caracteres no permitidos.";
        else if (tieneLetrasRepetidasInvalidos(input.value)) msg = "Contiene repeticiones de caracteres inválidas.";
    }

    input.setCustomValidity(msg);
    actualizarEstadoInput(input, error, msg);
}

/**
 * CONTROL DE ENTRADA POR TECLADO
 */
function isNumberKey(evt) {
    const charCode = (evt.which) ? evt.which : evt.keyCode;
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
}

function formatearIsbn(input) {
    input.value = input.value.toUpperCase().replace(/[^0-9\s\-X]/g, '');
}

// ============================================================================
// 7. INICIALIZADOR DE EVENTOS GLOBALES
// ============================================================================
document.addEventListener("DOMContentLoaded", function () {
    const inputsFormulario = document.querySelectorAll('#form-registro-libro input, #form-registro-libro textarea');
    
    inputsFormulario.forEach(input => {
        if (CAMPOS_NUMERICOS.includes(input.id) || CAMPOS_ALFABETICOS.includes(input.id) || CAMPOS_DIRECCION.includes(input.id)) {
            aplicarFiltrosSanitizacion(input);
            normalizarYFormatearCampos(input);
        }
    });
});