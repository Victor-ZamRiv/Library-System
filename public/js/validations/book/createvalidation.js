/**
 * --- VALIDACIONES DE TEXTO ---
 */

// Verifica que cada palabra contenga al menos una vocal y una consonante
function tieneVocalYConsonante(texto) {
    if (!texto.trim()) return true;

    const palabras = texto.trim().split(/\s+/);
    const vocalRegex = /[aeiouáéíóúüAEIOUÁÉÍÓÚÜ]/;
    const consonanteRegex = /[bcdfghjklmnñpqrstvwxyzBCDFGHJKLMNÑPQRSTVWXYZ]/;

    return palabras.every(palabra => {
        // Ignorar números o caracteres especiales aislados
        if (!/[a-zA-ZáéíóúÁÉÍÓÚñÑ]/.test(palabra)) return true;
        return vocalRegex.test(palabra) && consonanteRegex.test(palabra);
    });
}

/**
 * --- LOGICA DE UI Y DOM ---
 */

document.addEventListener("DOMContentLoaded", function () {
    // Selectores de SALA
    const itemsSala = document.querySelectorAll(`#dropdown-sala li a`);
    const salaHidden = document.getElementById('salaSelect');
    const salaDisplay = document.getElementById('sala-display');
    
    // Selectores de ÁREA
    const areaSelect = document.getElementById('areaSelect');
    const areaDisplayContainer = document.getElementById('area-display-container');
    const labelArea = document.getElementById('label-area');
    const areaTextContent = document.getElementById('area-text-content');
    const areaError = document.getElementById('area-error');

    /**
     * Función que habilita o deshabilita el campo Área Infantil
     */
    function gestionarEstadoArea(valorSala) {
        if (valorSala === "Sala Infantil") {
            // HABILITAR
            areaDisplayContainer.style.pointerEvents = "auto";
            areaDisplayContainer.style.opacity = "1";
            areaSelect.disabled = false;
            areaSelect.required = true;
            
            // Añadir asterisco si no existe
            if (!labelArea.querySelector('.text-danger')) {
                const span = document.createElement('span');
                span.className = 'text-danger';
                span.textContent = '* ';
                labelArea.prepend(span);
            }
        } else {
            // DESHABILITAR
            areaDisplayContainer.style.pointerEvents = "none";
            areaDisplayContainer.style.opacity = "0.5";
            areaSelect.disabled = true;
            areaSelect.required = false;
            
            // Limpiar valores y errores
            areaSelect.value = "";
            areaTextContent.innerHTML = "";
            if (areaError) areaError.style.display = 'none';
            
            // Quitar asterisco
            const asterisk = labelArea.querySelector('.text-danger');
            if (asterisk) asterisk.remove();
            
            areaDisplayContainer.closest('.form-group').classList.add('is-empty');
            areaDisplayContainer.closest('.form-group').classList.remove('is-invalid');
        }
    }

    // Eventos para Dropdown de SALA
    itemsSala.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const valor = this.getAttribute('data-value');
            salaDisplay.value = valor;
            salaHidden.value = valor;
            
            salaDisplay.closest('.form-group').classList.remove('is-empty');
            gestionarEstadoArea(valor);
        });
    });

    // Eventos para Dropdown de ÁREA
    const itemsArea = document.querySelectorAll(`#dropdown-area li a`);
    itemsArea.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            if (areaSelect.disabled) return;

            const valorReal = this.getAttribute('data-value');
            areaTextContent.innerHTML = this.innerHTML;
            areaSelect.value = valorReal;
            areaDisplayContainer.closest('.form-group').classList.remove('is-empty');
        });
    });

    // Inicialización por defecto
    gestionarEstadoArea(salaHidden.value);
});

/**
 * --- VALIDACIONES ESPECÍFICAS DE CAMPOS ---
 */

function actualizarEstadoInput(input, errorElement, mensaje) {
    const esValido = input.checkValidity();
    input.classList.toggle('is-invalid', !esValido);
    input.classList.toggle('is-valid', esValido);

    if (errorElement) {
        if (!esValido) {
            errorElement.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${mensaje || input.validationMessage}`;
            errorElement.style.display = 'block';
        } else {
            errorElement.style.display = 'none';
        }
    }
}

function validarTitulo(input) {
    const error = document.getElementById('titulo-error');
    const msg = "Cada palabra debe contener al menos una vocal y una consonante.";
    input.setCustomValidity(!tieneVocalYConsonante(input.value) ? msg : "");
    actualizarEstadoInput(input, error, input.validationMessage);
}

function formatearAutor(input) {
    let palabras = input.value.toLowerCase().split(' ');
    input.value = palabras.map(p => p.charAt(0).toUpperCase() + p.slice(1)).join(' ').trim();
    
    const error = document.getElementById('autor-error');
    const msg = "Cada nombre/apellido debe tener vocal y consonante.";
    input.setCustomValidity(!tieneVocalYConsonante(input.value) ? msg : "");
    actualizarEstadoInput(input, error, input.validationMessage);
}

function validarCiudad(input) {
    const error = document.getElementById('ciudad-error');
    input.setCustomValidity(!tieneVocalYConsonante(input.value) ? "Ciudad inválida (falta vocal o consonante)." : "");
    actualizarEstadoInput(input, error, input.validationMessage);
}

function validarEditorial(input) {
    const error = document.getElementById('editorial-error');
    input.setCustomValidity(!tieneVocalYConsonante(input.value) ? "Editorial inválida (falta vocal o consonante)." : "");
    actualizarEstadoInput(input, error, input.validationMessage);
}

function validarAnio(input) {
    const error = document.getElementById('year-error');
    const valor = parseInt(input.value, 10);
    const actual = new Date().getFullYear();
    const MIN = 1800;

    let msg = "";
    if (valor > actual) msg = `El año no puede ser superior a ${actual}.`;
    else if (valor <= MIN) msg = `El año debe ser posterior a ${MIN}.`;
    else if (!/^\d{4}$/.test(input.value)) msg = "Ingrese un año válido de 4 dígitos.";

    input.setCustomValidity(msg);
    actualizarEstadoInput(input, error, msg);
}

function validarNumerico(input, errorId, max, campo) {
    const valor = input.value.trim();
    const errorDiv = document.getElementById(errorId);
    const num = parseInt(valor, 10);
    let msg = "";

    if (valor === "") msg = `Por favor, ingrese el valor de ${campo}.`;
    else if (!/^\d+$/.test(valor)) msg = "Solo se permiten números.";
    else if (num < 1 || num > max || (valor.length > 1 && valor.startsWith("0"))) {
        msg = `${campo} debe estar entre 1 y ${max} (sin ceros a la izquierda).`;
    }

    input.setCustomValidity(msg);
    actualizarEstadoInput(input, errorDiv, msg);
}

// Alias para validaciones numéricas
const validarEdicion = (el) => validarNumerico(el, 'edicion-error', 999, 'Edición');
const validarPaginas = (el) => validarNumerico(el, 'paginas-error', 9999, 'Páginas');
const validarEjemplares = (el) => validarNumerico(el, 'ejemplares-error', 100, 'Ejemplares');
const validarVolumen = (el) => validarNumerico(el, 'volumen-error', 100, 'Volumen');

function validarIsbn(input) {
    const error = document.getElementById('isbn-error');
    const clean = input.value.toUpperCase().replace(/[\s\-]/g, '');
    let msg = "";

    if (clean.length === 10) {
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
    const cotaPattern = /^(?:[A-Za-z]{1,2}\s[A-Za-z0-9]{1,4}|\d{3}.*\s[A-Za-z0-9]{4})$/;
    let msg = "";

    if (input.value.length > 30) msg = "Máximo 30 caracteres.";
    else if (!cotaPattern.test(input.value.trim())) msg = "Formato de cota incorrecto (Ej: N H234).";

    input.setCustomValidity(msg);
    actualizarEstadoInput(input, error, msg);
}

function validarObservaciones(input) {
    const error = document.getElementById('observaciones-error');
    const regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s\.,;:\-]+$/;
    let msg = "";

    if (input.value.trim() !== "") {
        if (!regex.test(input.value)) msg = "Contiene caracteres no permitidos.";
        else if (!tieneVocalYConsonante(input.value)) msg = "Falta vocal o consonante en las palabras.";
    }

    input.setCustomValidity(msg);
    actualizarEstadoInput(input, error, msg);
}

function validarPortada(input) {
    const error = document.getElementById('portada-error');
    const nameDisp = document.getElementById('file-name');
    const file = input.files[0];
    let msg = "";

    if (nameDisp) nameDisp.textContent = file ? file.name : 'No seleccionado';

    if (file) {
        if (file.size > 5 * 1024 * 1024) msg = "Máximo 5MB.";
        else if (!['image/jpeg', 'image/png'].includes(file.type)) msg = "Solo JPG o PNG.";
    }

    input.setCustomValidity(msg);
    actualizarEstadoInput(input, error, msg);
}

// Helpers de teclado
function isNumberKey(evt) {
    const charCode = (evt.which) ? evt.which : evt.keyCode;
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
}

function formatearIsbn(input) {
    input.value = input.value.toUpperCase().replace(/[^0-9\s\-X]/g, '');
}