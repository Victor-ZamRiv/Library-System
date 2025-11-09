/**
 * Función para validar el campo de título.
 * Se llama desde el evento onblur del input.
 * @param {HTMLInputElement} inputElement - El elemento input a validar.
 */
function validarTitulo(inputElement) {
    // Referencia al elemento que muestra el mensaje de error
    const errorDisplay = document.getElementById('titulo-error');

    // Usa el método nativo de HTML5 para verificar si el campo es válido
    if (!inputElement.checkValidity()) {
        // El campo NO es válido
        inputElement.classList.add('is-invalid');
        inputElement.classList.remove('is-valid'); // Asegura que no tenga el estilo 'válido'
        if (errorDisplay) {
            errorDisplay.style.display = 'block'; // Muestra el mensaje de error
        }
    } else {
        // El campo SÍ es válido
        inputElement.classList.remove('is-invalid');
        // Opcional: añade 'is-valid' para un feedback positivo (si se usan clases de Bootstrap u otro framework CSS)
        inputElement.classList.add('is-valid');
        if (errorDisplay) {
            errorDisplay.style.display = 'none'; // Oculta el mensaje de error
        }
    }
}


/**
* Función para capitalizar la primera letra de cada palabra del nombre del autor.
* Similar a la función 'formatearNombres' del ejemplo.
*/
function formatearAutor(input) {
    let valor = input.value;
    // Divide el valor en palabras, las convierte a minúsculas
    let palabras = valor.toLowerCase().split(' ');

    let autorFormateado = palabras.map(palabra => {
        if (palabra.length > 0) {
            // Capitaliza la primera letra y concatena el resto de la palabra
            return palabra.charAt(0).toUpperCase() + palabra.slice(1);
        } else {
            return ''; // Mantiene los espacios múltiples si existen
        }
    }).join(' ');

    // Asigna el valor formateado al campo de input, eliminando espacios iniciales/finales
    input.value = autorFormateado.trim();
}


/**
 * Función para validar el campo de Ciudad.
 * Se llama desde el evento onblur del input con `onblur="validarCiudad(this)"`.
 * @param {HTMLInputElement} inputElement - El elemento input a validar.
 */
function validarCiudad(inputElement) {
    // Referencia al elemento que muestra el mensaje de error para la ciudad
    const errorDisplay = document.getElementById('ciudad-error');

    // Comprueba la validez basada en el atributo 'pattern' y 'required'
    if (!inputElement.checkValidity()) { 
        // El campo NO es válido
        inputElement.classList.add('is-invalid'); 
        inputElement.classList.remove('is-valid'); 
        if (errorDisplay) {
            errorDisplay.style.display = 'block'; // Muestra el mensaje de error
        }
    } else { 
        // El campo SÍ es válido
        inputElement.classList.remove('is-invalid'); 
        inputElement.classList.add('is-valid'); 
        if (errorDisplay) {
            errorDisplay.style.display = 'none'; // Oculta el mensaje de error
        }
    }
}


/**
 * Función para validar el campo de Edición.
 * Se llama desde el evento onblur del input con `onblur="validarEdicion(this)"`.
 * @param {HTMLInputElement} inputElement - El elemento input a validar.
 */
function validarEdicion(inputElement) {
    // Referencia al elemento que muestra el mensaje de error para Edición
    const errorDisplay = document.getElementById('edicion-error');

    // Comprueba la validez basada en los atributos 'pattern', 'maxlength' y 'required'
    if (!inputElement.checkValidity()) {
        // El campo NO es válido
        inputElement.classList.add('is-invalid');
        inputElement.classList.remove('is-valid');
        if (errorDisplay) {
            errorDisplay.style.display = 'block'; // Muestra el mensaje de error
        }
    } else {
        // El campo SÍ es válido
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        if (errorDisplay) {
            errorDisplay.style.display = 'none'; // Oculta el mensaje de error
        }
    }
}


/**
 * Función para validar el campo de Año, asegurando que no sea superior al año actual.
 * Se llama desde el evento onblur del input con `onblur="validarAnio(this)"`.
 * @param {HTMLInputElement} inputElement - El elemento input a validar.
 */
function validarAnio(inputElement) {
    const errorDisplay = document.getElementById('year-error');
    const valorAnio = parseInt(inputElement.value, 10);
    const anioActual = new Date().getFullYear();
    
    // 1. Verificar la validez nativa (pattern="[0-9]{4}" y required)
    // 2. Verificar que el valor del año no sea superior al año actual
    const esValido = inputElement.checkValidity() && (valorAnio <= anioActual);

    if (!esValido) {
        // El campo NO es válido (o es mayor al año actual)
        inputElement.classList.add('is-invalid');
        inputElement.classList.remove('is-valid');
        if (errorDisplay) {
            // Se actualiza el mensaje de error para ser más específico si es necesario
            if (valorAnio > anioActual) {
                errorDisplay.innerHTML = '<i class="fas fa-exclamation-circle"></i> El año no puede ser superior al año actual (' + anioActual + ').';
            } else {
                errorDisplay.innerHTML = '<i class="fas fa-exclamation-circle"></i> Por favor, ingrese un Año válido de 4 dígitos (ejemplo: ' + anioActual + ').';
            }
            errorDisplay.style.display = 'block'; // Muestra el mensaje de error
        }
    } else {
        // El campo SÍ es válido y no es futuro
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        if (errorDisplay) {
            errorDisplay.style.display = 'none'; // Oculta el mensaje de error
        }
    }
}



/**
 * Función para validar el campo de Ejemplares.
 * Se llama desde el evento onblur del input con `onblur="validarEjemplares(this)"`.
 * @param {HTMLInputElement} inputElement - El elemento input a validar.
 */
function validarEjemplares(inputElement) {
    // Referencia al elemento que muestra el mensaje de error para Ejemplares
    const errorDisplay = document.getElementById('ejemplares-error');

    // Comprueba la validez basada en los atributos 'pattern', 'required', 'min', y 'max'
    if (!inputElement.checkValidity()) {
        // El campo NO es válido
        inputElement.classList.add('is-invalid');
        inputElement.classList.remove('is-valid');
        if (errorDisplay) {
            errorDisplay.style.display = 'block'; // Muestra el mensaje de error
        }
    } else {
        // El campo SÍ es válido
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        if (errorDisplay) {
            errorDisplay.style.display = 'none'; // Oculta el mensaje de error
        }
    }
}


/**
 * Función para permitir solo la entrada de números (0-9) y teclas de control.
 * Se utiliza en el evento onkeypress.
 * @param {Event} evt - El evento de teclado.
 * @returns {boolean} - true para aceptar la tecla, false para rechazarla.
 */
function isNumberKey(evt) {
    const charCode = (evt.which) ? evt.which : evt.keyCode;
    
    // 48 es el código ASCII para '0'
    // 57 es el código ASCII para '9'
    // Permite números
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false; // Rechaza cualquier cosa que no sea un número
    }
    return true; // Acepta el número
}

// ... (La función validarEjemplares(inputElement) que ya tienes) ...
function validarEjemplares(inputElement) {
    const errorDisplay = document.getElementById('ejemplares-error');

    // checkValidity() verifica el pattern="[0-9]{1,5}" y required
    if (!inputElement.checkValidity()) {
        inputElement.classList.add('is-invalid');
        inputElement.classList.remove('is-valid');
        if (errorDisplay) {
            errorDisplay.style.display = 'block';
        }
    } else {
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        if (errorDisplay) {
            errorDisplay.style.display = 'none';
        }
    }
}


/**
 * Función para permitir solo la entrada de números (0-9) y teclas de control.
 * Se utiliza en el evento onkeypress.
 */
function isNumberKey(evt) {
    const charCode = (evt.which) ? evt.which : evt.keyCode;
    
    // 48 a 57 son los códigos ASCII para '0' a '9'
    // 31 es para teclas de control (tab, retroceso, etc.)
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false; // Rechaza cualquier cosa que no sea un número
    }
    return true; // Acepta el número
}



/**
 * Función para validar el campo de Editorial al perder el foco.
 * Se llama desde el evento onblur del input con `onblur="validarEditorial(this)"`.
 * @param {HTMLInputElement} inputElement - El elemento input a validar.
 */
function validarEditorial(inputElement) {
    // Referencia al elemento que muestra el mensaje de error para Editorial
    const errorDisplay = document.getElementById('editorial-error');

    // Comprueba la validez basada en los atributos 'pattern' y 'required'
    if (!inputElement.checkValidity()) {
        // El campo NO es válido
        inputElement.classList.add('is-invalid');
        inputElement.classList.remove('is-valid');
        if (errorDisplay) {
            errorDisplay.style.display = 'block'; // Muestra el mensaje de error
        }
    } else {
        // El campo SÍ es válido
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        if (errorDisplay) {
            errorDisplay.style.display = 'none'; // Oculta el mensaje de error
        }
    }
}

/**
 * Función para permitir solo la entrada de números (0-9).
 * Se utiliza en el evento onkeypress.
 */
function isNumberKey(evt) {
    const charCode = (evt.which) ? evt.which : evt.keyCode;
    
    // Permite números (48-57) y teclas de control (charCode <= 31)
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false; // Rechaza cualquier cosa que no sea un número
    }
    return true; // Acepta el número
}

/**
 * Función para validar el campo de ISBN al perder el foco.
 */
function validarIsbn(inputElement) {
    const errorDisplay = document.getElementById('isbn-error');

    // checkValidity() verifica el nuevo pattern="[0-9]{10,13}" y required
    if (!inputElement.checkValidity()) {
        inputElement.classList.add('is-invalid');
        inputElement.classList.remove('is-valid');
        if (errorDisplay) {
            errorDisplay.style.display = 'block';
        }
    } else {
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        if (errorDisplay) {
            errorDisplay.style.display = 'none';
        }
    }
}
// Asegúrate de que esta función y validarIsbn() estén disponibles globalmente

/**
 * Función para validar el campo de Observaciones al perder el foco.
 * Verifica que solo contenga letras, números, y espacios, además de ser obligatorio.
 * @param {HTMLTextAreaElement} inputElement - El elemento textarea a validar.
 */
function validarObservaciones(inputElement) {
    const errorDisplay = document.getElementById('observaciones-error');
    const valor = inputElement.value.trim();
    
    // 1. Patrón que permite letras (con y sin tildes, Ñ/ñ), números y espacios.
    // El 'g' es global (opcional aquí), la 'i' es insensible a mayúsculas/minúsculas.
    const regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$/; 

    // Inicialmente asumimos que es inválido
    let esValido = false;

    if (inputElement.hasAttribute('required') && valor === '') {
        // Es requerido y está vacío
        esValido = false;
        // Opcional: Puedes sobrescribir el mensaje de error aquí si está vacío
        errorDisplay.innerHTML = '<i class="fas fa-exclamation-circle"></i> Este campo es obligatorio.';
    } else if (valor === '') {
         // No es requerido y está vacío, es válido
        esValido = true;
    } else if (regex.test(valor)) {
        // Contiene contenido y coincide con el patrón de letras/números/espacios
        esValido = true;
    } else {
        // Contiene contenido pero tiene caracteres no permitidos
        esValido = false;
        errorDisplay.innerHTML = '<i class="fas fa-exclamation-circle"></i> Solo se permiten letras, números y espacios en las observaciones.';
    }

    // Aplicar estilos y mostrar/ocultar el mensaje
    if (!esValido) {
        inputElement.classList.add('is-invalid');
        inputElement.classList.remove('is-valid');
        if (errorDisplay) {
            errorDisplay.style.display = 'block';
        }
    } else {
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        if (errorDisplay) {
            errorDisplay.style.display = 'none';
        }
    }
}

// ... (código previo) ...

function validarPortada(inputElement) {
    const errorDisplay = document.getElementById('portada-error');
    const fileNameDisplay = document.getElementById('file-name'); // NUEVO
    const file = inputElement.files[0];
    const MAX_SIZE = 5 * 1024 * 1024; // 5 MB en bytes
    let esValido = true;

    // Actualiza el nombre del archivo
    fileNameDisplay.textContent = file ? file.name : 'No se ha seleccionado archivo';

    // ... (resta de la lógica de validación de tipo y tamaño) ...
    
    if (inputElement.hasAttribute('required') && !file) {
        esValido = false;
    } 
    
    // ... (resto de la validación del archivo) ...

    // Aplicar estilos
    if (!esValido) {
        // ... (código para error) ...
    } else {
        // ... (código para éxito) ...
    }
}
/**
 * Escucha el evento 'input' en el campo ISBN para validación en tiempo real.
 */
document.getElementById('isbn').addEventListener('input', function (e) {
    const isbn = e.target.value.replace(/[\ |-]/g, ''); // Elimina espacios y guiones para la validación
    // Expresión regular para ISBN-10 (10 dígitos, el último puede ser X)
    // El patrón permite el formato con separadores, pero lo limpiamos antes de validar la longitud y el formato.
    const isbn10 = /^\d{9}[\d|X]$/i; // Ahora solo valida la cadena limpia (sin guiones)
    // Expresión regular para ISBN-13 (13 dígitos)
    const isbn13 = /^\d{13}$/; // Ahora solo valida la cadena limpia (sin guiones)

    // Solo verificamos si tiene un valor antes de aplicar la validación de formato
    if (isbn.length > 0) {
        if (!isbn10.test(isbn) && !isbn13.test(isbn)) {
            // Establece un mensaje de error personalizado
            e.target.setCustomValidity('El ISBN no es valido. Debe tener 10 (con dígito de control) o 13 dígitos.');
        } else {
            // Borra el mensaje de error personalizado si es válido
            e.target.setCustomValidity('');
        }
    } else {
        // Si está vacío, se borra el mensaje de error personalizado (la validación 'required' lo manejará si aplica)
        e.target.setCustomValidity('');
    }

    // Nota: Es mejor llamar a e.target.reportValidity() para mostrar el error, pero
    // si usas el método validarIsbn en onblur, este se encargará de mostrar el error.
});

/**
 * Escucha el evento 'input' en el campo Cota para validación en tiempo real.
 */
document.getElementById('cota').addEventListener('input', function (e) {
    const valor = e.target.value;

    if (valor.length > 20) {
        e.target.setCustomValidity('Extension máxima 20 caracteres.');
    }
    // Patrón para Cota. Ejemplo: N H234 (1 o 2 letras, espacio, 1 a 4 letras/números) o 120 A563 (3 dígitos, punto, asterisco, espacio, 4 letras/números)
    // Simplificando: dos patrones separados por OR |
    else if (!/^(?:[A-Za-z]{1,2}\s[A-Za-z0-9]{1,4}|(?:\d{3}[.]?|\d{3}.*)\s[A-Za-z0-9]{4})$/.test(valor)) {
         // Se mejoró el patrón para ser más flexible: (?:[A-Za-z]{1,2}\s[A-Za-z0-9]{1,4} -> N H234) O ( (?:\d{3}[.]?|\d{3}.*)\s[A-Za-z0-9]{4} -> 120 A563, permitiendo el punto y otros caracteres después de los 3 dígitos)
        e.target.setCustomValidity('Formato de cota incorrecto. Ejemplos: N H234 o 120 A563');
    } else {
        e.target.setCustomValidity('');
    }
     // Nota: Para Cota, la validación del evento onblur deberá ser implementada si se requiere feedback visual con clases is-invalid/is-valid.
});