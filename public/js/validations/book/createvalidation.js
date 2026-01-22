document.addEventListener('DOMContentLoaded', function () {
    // 1. Obtener los elementos select por su ID
    const salaSelect = document.getElementById('salaSelect');
    const areaSelect = document.getElementById('areaSelect');

    // 2. Obtener la etiqueta (label) del select de Área Infantil
    const areaLabel = areaSelect.closest('.form-group').querySelector('.control-label');

    // Función para añadir el asterisco al lado izquierdo de la etiqueta
    function addAsterisk() {
        // Asegurarse de que el asterisco no se añada dos veces
        if (!areaLabel.querySelector('.text-danger')) {
            const asteriskSpan = document.createElement('span');
            asteriskSpan.className = 'text-danger';
            // El espacio se pone después del asterisco para separarlo del texto
            asteriskSpan.textContent = '* ';

            // UTILIZAR PREPEND PARA INSERTAR EL ELEMENTO AL PRINCIPIO
            areaLabel.prepend(asteriskSpan);
        }
    }

    // Función para quitar el asterisco de la etiqueta
    function removeAsterisk() {
        const asteriskSpan = areaLabel.querySelector('.text-danger');
        if (asteriskSpan) {
            areaLabel.removeChild(asteriskSpan);
        }
    }

    // 3. Escuchar el evento 'change' en el select de la Sala
    salaSelect.addEventListener('change', function () {
        const salaSeleccionada = this.value;

        // 4. Comprobar si la opción es "Sala Infantil"
        if (salaSeleccionada === 'Sala Infantil') {
            // Habilitar el select
            areaSelect.disabled = false;
            // AÑADIR la propiedad required
            areaSelect.required = true;
            addAsterisk();
        } else {
            // Deshabilitar el select
            areaSelect.disabled = true;
            // QUITAR la propiedad required
            areaSelect.required = false;
            areaSelect.value = ""; // Restablecer el valor
            removeAsterisk();
        }
    });
});


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
function validarEdicion(input) {
    const valor = input.value.trim();
    const errorDiv = document.getElementById('edicion-error');
    const valorNumerico = parseInt(valor, 10);
    let esValido = true;

    // Ocultar error por defecto
    errorDiv.style.display = 'none';
    input.classList.remove('is-invalid');

    // 1. Verifica si está vacío
    if (valor === "") {
        esValido = false;
        errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Por favor, ingrese un valor de Edición.';
    }
    // 2. Verifica si el valor contiene caracteres que NO son dígitos
    else if (!/^\d+$/.test(valor)) {
        esValido = false;
        errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Solo se permiten números.';
    }
    // 3. Verifica el rango numérico y los ceros iniciales
    // 'valor.length > 1 && valor.startsWith("0")' comprueba si hay ceros a la izquierda (ej. "01")
    else if (
        isNaN(valorNumerico) || // No es un número válido
        valorNumerico < 1 ||    // Es 0 o negativo
        valorNumerico > 999 ||  // Excede el límite de 999
        (valor.length > 1 && valor.startsWith("0")) // Tiene más de un dígito y empieza con '0' (ej. 01, 001)
    ) {
        esValido = false;
        errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> La Edición debe ser un número entero entre 1 y 999 (sin ceros a la izquierda).';
    }

    // Aplicar la clase de error si no es válido
    if (!esValido) {
        input.classList.add('is-invalid');
        errorDiv.style.display = 'block';
    }

    return esValido;
}



/**
 * Función para validar el campo de Año, asegurando que:
 * 1. No sea superior al año actual.
 * 2. Sea mayor a 1700.
 * @param {HTMLInputElement} inputElement - El elemento input a validar.
 */
function validarAnio(inputElement) {
    const errorDisplay = document.getElementById('year-error');
    const valorAnio = parseInt(inputElement.value, 10);
    const anioActual = new Date().getFullYear();
    const ANIO_MINIMO = 1700; // Límite inferior requerido

    // 1. Validez nativa (4 dígitos y requerido)
    // 2. No debe ser futuro (valorAnio <= anioActual)
    // 3. Debe ser posterior al límite (valorAnio > ANIO_MINIMO)
    const esValido = inputElement.checkValidity() && (valorAnio <= anioActual) && (valorAnio > ANIO_MINIMO);

    if (!esValido) {
        // El campo NO es válido
        inputElement.classList.add('is-invalid');
        inputElement.classList.remove('is-valid');
        if (errorDisplay) {
            let mensajeError = '';
            
            if (valorAnio > anioActual) {
                // Caso 1: Año futuro
                mensajeError = 'El año no puede ser superior al año actual (' + anioActual + ').';
            } else if (valorAnio <= ANIO_MINIMO) {
                // Caso 2: Año demasiado antiguo (1700 o menos)
                mensajeError = 'El año debe ser posterior a ' + ANIO_MINIMO;
            } else {
                // Caso 3: Formato no válido, vacío, o cualquier otra cosa que falle checkValidity()
                mensajeError = 'Por favor, ingrese un Año válido de 4 dígitos (ejemplo: ' + anioActual + ').';
            }

            errorDisplay.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + mensajeError;
            errorDisplay.style.display = 'block';
        }
    } else {
        // El campo SÍ es válido
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        if (errorDisplay) {
            errorDisplay.style.display = 'none';
        }
    }
}


/**
 * Función para validar el campo de Ejemplares.
 * Se llama desde el evento onblur del input con `onblur="validarEjemplares(this)"`.
 * @param {HTMLInputElement} inputElement - El elemento input a validar.
 */
function validarEdicion(input) {
    const valor = input.value.trim();
    const errorDiv = document.getElementById('edicion-error');
    const valorNumerico = parseInt(valor, 10);
    let esValido = true;

    // Ocultar error por defecto
    errorDiv.style.display = 'none';
    input.classList.remove('is-invalid');

    // 1. Verifica si está vacío
    if (valor === "") {
        esValido = false;
        errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Por favor, ingrese un valor de Edición.';
    }
    // 2. Verifica el rango numérico (entre 1 y 999) y los ceros iniciales
    // Nota: La expresión regular /^\d+$/.test(valor) ya no es tan crucial aquí
    // porque isNumberKey ya impide letras, pero es una buena defensa
    else if (
        isNaN(valorNumerico) || // No es un número válido
        valorNumerico < 1 ||    // Es 0 o negativo
        valorNumerico > 999 ||  // Excede el límite de 999
        (valor.length > 1 && valor.startsWith("0")) // Evita "01", "001", etc.
    ) {
        esValido = false;
        errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> La Edición debe ser un número entero entre 1 y 999 (sin ceros a la izquierda).';
    }

    // Aplicar la clase de error si no es válido
    if (!esValido) {
        input.classList.add('is-invalid');
        errorDiv.style.display = 'block';
    }

    return esValido;
}

/**
         * Función para validar el campo de Páginas.
         * Se llama desde el evento onblur del input con `onblur="validarPaginas(this)"`.
         * @param {HTMLInputElement} input - El elemento input a validar.
         */
        function validarPaginas(input) {
            const valor = input.value.trim();
            // El ID del error div es 'paginas-error' según el HTML proporcionado
            const errorDiv = document.getElementById('paginas-error'); 
            const valorNumerico = parseInt(valor, 10);
            let esValido = true;

            // Ocultar error por defecto
            errorDiv.style.display = 'none';
            input.classList.remove('is-invalid');

            // 1. Verifica si está vacío
            if (valor === "") {
                esValido = false;
                errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Por favor, ingrese el número de páginas.';
            }
            // 2. Verifica el rango numérico (entre 1 y 9999) y los ceros iniciales
            // El límite superior se ajusta a 9999 (4 dígitos, como indica maxlength="4")
            else if (
                isNaN(valorNumerico) || // No es un número válido
                valorNumerico < 1 ||    // Es 0 o negativo
                valorNumerico > 9999 || // Excede el límite de 9999
                (valor.length > 1 && valor.startsWith("0")) // Evita "01", "001", etc.
            ) {
                esValido = false;
                // Mensaje ajustado al rango de Páginas (1 a 9999)
                errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> El número de Páginas debe ser un número entero entre 1 y 9999 (sin ceros a la izquierda).';
            }

            // Aplicar la clase de error si no es válido
            if (!esValido) {
                input.classList.add('is-invalid');
                errorDiv.style.display = 'block';
            }

            return esValido;
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
 * Limpia el valor del campo de entrada para eliminar guiones y espacios
 * y asegurar que solo queden caracteres válidos (dígitos y 'X').
 * Esta función es llamada en 'oninput'.
 * @param {HTMLInputElement} input - El elemento de entrada del ISBN.
 */
function formatearIsbn(input) {
    let value = input.value.toUpperCase(); // Convertir a mayúsculas

    // 1. Eliminar cualquier carácter que no sea dígito, guion, espacio o 'X'
    value = value.replace(/[^0-9\s\-X]/g, '');

    // 2. Controlar la posición de la 'X': Si ya hay 10 o más caracteres limpios, no permitir más 'X'.
    // Esta parte es más compleja de hacer en 'oninput' sin limpiar primero.
    // La validación principal de formato (longitud y posición de 'X') se hará en 'onblur'.

    input.value = value;
}


/**
 * Valida el ISBN. Ignora espacios y guiones, y verifica que la longitud sea
 * 10 o 13 caracteres, y que el formato (incluida la 'X') sea correcto.
 * Esta función es llamada en 'onblur'.
 * @param {HTMLInputElement} input - El elemento de entrada del ISBN.
 */
function validarIsbn(input) {
    // 1. Obtener el valor y estandarizar a mayúsculas
    const rawIsbn = input.value.toUpperCase();

    // 2. Limpiar el ISBN: Eliminar espacios y guiones para obtener la longitud real de los dígitos
    const cleanIsbn = rawIsbn.replace(/[\s\-]/g, '');

    const feedbackElement = document.getElementById('isbn-error');
    const length = cleanIsbn.length;
    let isValid = false;
    let message = '<i class="fas fa-exclamation-circle"></i> Por favor, ingrese un ISBN válido (10 o 13 caracteres, ignorando guiones/espacios).';

    if (length === 10) {
        // Validación de ISBN-10: 9 dígitos + (dígito 1-9 o 'X')
        // La expresión regular verifica que la cadena *limpia* tenga 9 dígitos y termine en [1-9X].
        const regexIsbn10 = /^\d{9}([1-9X])$/;

        if (regexIsbn10.test(cleanIsbn)) {
            isValid = true;
        } else {
            message = '<i class="fas fa-exclamation-circle"></i> ISBN-10 inválido. Debe ser 9 dígitos seguidos de un dígito (1-9) o "X".';
        }

    } else if (length === 13) {
        // Validación de ISBN-13: 13 dígitos. No debe contener 'X'.
        const regexIsbn13 = /^\d{13}$/; // Exactamente 13 dígitos

        if (regexIsbn13.test(cleanIsbn)) {
            isValid = true;
        } else {
            message = '<i class="fas fa-exclamation-circle"></i> ISBN-13 inválido. Debe ser exactamente 13 dígitos.';
        }
    }

    // 3. Aplicar estilos y mensajes de validación
    if (isValid) {
        input.setCustomValidity('');
        feedbackElement.style.display = 'none';
        // Opcional: Puedes limpiar el input de guiones/espacios si deseas almacenarlo limpio,
        // pero lo mantendremos como lo ingresó el usuario para mejor UX, solo si es válido.
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    } else {
        // Si no es válido, asegúrate de que el campo de entrada refleje el error
        input.setCustomValidity(message);
        feedbackElement.innerHTML = message;
        feedbackElement.style.display = 'block';
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
    }
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
});

// --- Lógica de verificación de formato---

/**
 * Función auxiliar para verificar el formato básico del ISBN (10 o 13).
 * @param {string} isbn - El valor a validar.
 * @returns {boolean} true si el formato es válido, false en caso contrario.
 */
function verificarFormatoIsbn(isbn) {
    // Limpiar el string: Solo dejamos dígitos y 'X' (para el ISBN-10).
    const cleanIsbn = isbn.trim().replace(/[\s-]/g, '');

    // Regex para 10 y 13 dígitos (solo formato, sin checksum)
    const isbn10_simple = /^\d{9}[\dXx]$/;
    const isbn13_simple = /^\d{13}$/;

    if (cleanIsbn.length === 10) {
        return isbn10_simple.test(cleanIsbn);
    } else if (cleanIsbn.length === 13) {
        return isbn13_simple.test(cleanIsbn);
    }

    // Si la longitud no es 10 ni 13, no es válido.
    return false;
}


// --- Función principal que imita el comportamiento de validarTitulo ---

/**
 * Función para validar el campo de ISBN.
 * Se llama desde el evento onblur del input.
 * @param {HTMLInputElement} inputElement - El elemento input a validar (por ejemplo, 'this' del onblur).
 */
function validarIsbn(inputElement) {
    // 1. Referencia al elemento que muestra el mensaje de error
    const errorDisplay = document.getElementById('isbn-error');

    // 2. Usar la función auxiliar para determinar si el formato es válido.
    const esValido = verificarFormatoIsbn(inputElement.value);

    // Configuramos un mensaje de error personalizado para el setCustomValidity.
    // Esto es necesario para que reportValidity() y checkValidity() funcionen correctamente.
    if (!esValido) {
        inputElement.setCustomValidity('El ISBN no es válido. Debe tener 10 o 13 dígitos.');
    } else {
        inputElement.setCustomValidity('');
    }

    // 3. Usar el método nativo checkValidity() y setCustomValidity() 
    // para aplicar las clases de feedback y mostrar/ocultar el mensaje.
    if (!inputElement.checkValidity()) {
        // El campo NO es válido (ya sea por 'required' o por la validación del setCustomValidity)
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
 * Función para validar el campo de Cota.
 * Se llama desde el evento onblur del input.
 * @param {HTMLInputElement} inputElement - El elemento input a validar.
 */
function validarCota(inputElement) {
    // 1. Referencia al elemento que muestra el mensaje de error
    const errorDisplay = document.getElementById('cota-error');
    const cotaValue = inputElement.value;

    // 2. Patrón Regex que quieres aplicar para el formato de Cota
    // ^(?:[A-Za-z]{1,2} [A-Za-z0-9]{1,4}|\d{3}.*\s[A-Za-z0-9]{4})$
    const cotaPattern = /^(?:[A-Za-z]{1,2}\s[A-Za-z0-9]{1,4}|\d{3}.*\s[A-Za-z0-9]{4})$/;

    let mensajeError = '';

    // --- Lógica de Validación (Longitud y Formato) ---

    // a) Validación de longitud máxima (Tú querías máximo 30, aunque el HTML tiene maxlength="30")
    if (cotaValue.length > 30) {
        mensajeError = 'La extensión máxima permitida es de 30 caracteres.';

        // b) Validación de formato usando la Regex
    } else if (!cotaPattern.test(cotaValue)) {
        mensajeError = 'Formato de cota incorrecto. Ejemplo: NH H234 o 120 A563.';
    }

    // 3. Aplicar el resultado al sistema de validación nativo (checkValidity)
    if (mensajeError) {
        // El campo NO es válido
        inputElement.setCustomValidity(mensajeError);

        // Actualiza el texto visible del error para reflejar el problema específico (opcional)
        if (errorDisplay) {
            errorDisplay.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + mensajeError;
        }

    } else {
        // El campo SÍ es válido
        inputElement.setCustomValidity('');
    }

    // 4. Aplicar estilos de feedback (Igual que en validarTitulo)
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
            // Restablece el mensaje de error genérico cuando es válido (se ocultará de todas formas)
            errorDisplay.innerHTML = '<i class="fas fa-exclamation-circle"></i> La Cota debe tener máximo 20 caracteres y un formato válido (Ej: NH 234 o 120 A563).';
            errorDisplay.style.display = 'none'; // Oculta el mensaje de error
        }
    }
}

function validarVolumen(input) {
    const errorDiv = document.getElementById('volumen-error');
    
    // Verifica si el valor cumple con el pattern [0-9]{1,2} y no está vacío
    if (!input.checkValidity()) {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
        errorDiv.style.display = 'block';
    } else {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        errorDiv.style.display = 'none';
    }
}





