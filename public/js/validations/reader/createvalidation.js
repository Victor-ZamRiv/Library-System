// --- CONSTANTES ---
const CAMPO_CARNET_ID = 'carnet-reg';
const CAMPO_CEDULA_ID = 'cedula-reg'; 
const CAMPO_SEXO_ID = 'sexo-reg';

const CAMPO_TELEFONO_REG_ID = 'telefono-reg';
const CAMPO_TELEFONO_PROFESION_ID = 'telefono-profesion-reg'; 
const CAMPO_TELEFONO_LEGAL_ID = 'telefono-referencia-legal-reg';
const CAMPO_TELEFONO_PERSONAL_ID = 'telefono-referencia-personal-reg';

const CAMPOS_TELEFONO = [
    CAMPO_TELEFONO_REG_ID, CAMPO_TELEFONO_PROFESION_ID, 
    CAMPO_TELEFONO_LEGAL_ID, CAMPO_TELEFONO_PERSONAL_ID
];

const CAMPO_DIRECCION_REG_ID = 'direccion-reg';
const CAMPO_DIRECCION_PROFESION_ID = 'direccion-profesion-reg'; 

// USAR SPREAD (...) PARA EVITAR ARRAYS ANIDADOS
const CAMPOS_SOLO_NUMEROS = [
    CAMPO_CARNET_ID, 
    CAMPO_CEDULA_ID, 
    ...CAMPOS_TELEFONO, 
];

const CAMPOS_CAPITALIZACION = [
    'nombre-reg', 'apellido-reg' 
];

const CAMPOS_INPUT_VALIDACION = [
    ...CAMPOS_SOLO_NUMEROS, 
    CAMPO_DIRECCION_REG_ID, 
    CAMPO_DIRECCION_PROFESION_ID, 
    'profesion-reg', 
    'referencia-legal-personal-reg', 
    'referencia-personal-reg',
    ...CAMPOS_CAPITALIZACION
];

// --- FUNCIONES DE RESTRICCIÓN Y LIMPIEZA ---

function isNumberKey(evt) {
    const charCode = (evt.which) ? evt.which : evt.keyCode;
    const isNumber = charCode >= 48 && charCode <= 57;
    const isControlKey = charCode === 8 || charCode === 9 || charCode === 13 || 
                         charCode === 37 || charCode === 39 || charCode === 46;

    if (isNumber || isControlKey) return true; 

    evt.preventDefault();
    return false;
}

// Limpia caracteres no numéricos en tiempo real
const forzarNumeros = (input) => {
    input.value = input.value.replace(/[^0-9]/g, '');
};

// --- FUNCIONES AUXILIARES DE FEEDBACK ---

function manejarFeedback(inputElement, esValido) {
    const errorId = inputElement.id.endsWith('-reg') 
        ? inputElement.id.replace('-reg', '-error') 
        : inputElement.id + '-error'; 
        
    const errorDiv = document.getElementById(errorId);
    
    const valorVacio = inputElement.value.trim() === '';
    if (!inputElement.required && valorVacio) {
         inputElement.classList.remove('is-invalid', 'is-valid');
         if (errorDiv) errorDiv.style.display = 'none';
         return true;
    }

    if (esValido) {
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        if (errorDiv) errorDiv.style.display = 'none';
    } else {
        inputElement.classList.add('is-invalid');
        inputElement.classList.remove('is-valid');
        if (errorDiv) errorDiv.style.display = 'block'; 
    }
}

// --- VALIDACIONES ESPECÍFICAS ---

// Detecta valores imposibles: Solo ceros o menores a 800,000
const esPatronInvalido = (valor) => {
    if (valor === "") return false;
    const soloCeros = /^0+$/.test(valor);
    const valorNumerico = parseInt(valor, 10);
    const esMenorAlMinimo = valorNumerico < 800000;
    
    return soloCeros || esMenorAlMinimo;
};

// Validación de Cédula Unificada
function validarCedula(inputElement) {
    forzarNumeros(inputElement);

    const valor = inputElement.value;
    const regexCedula = /^[0-9]{6,8}$/;
    
    // Busca "dni-error" o el ID dinámico basado en el input
    const errorDiv = document.getElementById("dni-error") || 
                     document.getElementById(inputElement.id.replace('-reg', '-error'));

    const cumpleRegex = regexCedula.test(valor);
    const patronInvalido = esPatronInvalido(valor);
    const esValido = cumpleRegex && !patronInvalido;

    if (!esValido && valor !== "") {
        inputElement.classList.remove("is-valid");
        inputElement.classList.add("is-invalid");
        if (errorDiv) {
            // Mensaje específico si es menor a 800.000
            if (cumpleRegex && patronInvalido) {
                errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> La Cédula es inválida, Ingrese una Cédula válida (6-8 dígitos).';
            } else {
                errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> La Cédula es inválida, Ingrese una Cédula válida (6-8 dígitos).';
            }
            errorDiv.style.display = "block";
        }
        inputElement.setCustomValidity("Cédula inválida");
        return false;
    } else {
        // Si está vacío y es requerido, lo maneja manejarFeedback
        if (valor === "") {
            const ok = !inputElement.required;
            manejarFeedback(inputElement, ok);
            return ok;
        }
        // Caso exitoso
        inputElement.classList.remove("is-invalid");
        inputElement.classList.add("is-valid");
        if (errorDiv) errorDiv.style.display = "none";
        inputElement.setCustomValidity("");
        return true;
    }
}

function validarCarnet(inputElement) {
    const valorPuro = inputElement.value.trim();
    const longitudRequerida = 10;
    const esValido = valorPuro.length === longitudRequerida;
    
    inputElement.setCustomValidity(esValido ? '' : "Error de longitud del Carnet.");
    manejarFeedback(inputElement, esValido);
    return esValido;
}

function validarTelefono(inputElement) {
    const valorPuro = inputElement.value.trim();
    const longitudRequerida = 11;

    if (valorPuro === '') {
        return manejarFeedback(inputElement, !inputElement.required);
    }
    
    const esValido = valorPuro.length === longitudRequerida;
    inputElement.setCustomValidity(esValido ? '' : "Error de longitud de Teléfono.");
    manejarFeedback(inputElement, esValido);
    return esValido;
}

// --- VALIDACIONES GENÉRICAS Y EVENTOS ---

function validarCampoInput(inputElement) {
    if (inputElement.required && inputElement.value.trim() === '') {
        inputElement.setCustomValidity("Este campo es obligatorio."); 
    } else {
        inputElement.setCustomValidity(''); 
        if (!inputElement.required && inputElement.value.trim() === '') {
            return manejarFeedback(inputElement, true);
        }
    }

    const esValido = inputElement.checkValidity(); 
    manejarFeedback(inputElement, esValido);
    return esValido;
}

function capitalizarNombre(inputElement) {
    let value = inputElement.value.trim();
    if (value.length > 0) {
        value = value.toLowerCase().split(' ').map(word => 
            word.charAt(0).toUpperCase() + word.slice(1)
        ).join(' ');
        inputElement.value = value;
    }
}

function validarSelect(selectElement) {
    const esValido = selectElement.value !== '' && selectElement.value !== null; 
    manejarFeedback(selectElement, esValido); 
    return esValido;
}

function manejarEnvioFormulario(evt) {
    let formularioValido = true;
    
    CAMPOS_INPUT_VALIDACION.forEach(id => {
        const inputElement = document.getElementById(id);
        if (!inputElement) return;

        let esCampoValido = false;
        if (id === CAMPO_CEDULA_ID) {
            esCampoValido = validarCedula(inputElement);
        } else if (id === CAMPO_CARNET_ID) {
            esCampoValido = validarCarnet(inputElement);
        } else if (CAMPOS_TELEFONO.includes(id)) {
            esCampoValido = validarTelefono(inputElement);
        } else {
            esCampoValido = validarCampoInput(inputElement);
        }
        
        if (!esCampoValido) formularioValido = false;
    });

    const selectSexo = document.getElementById(CAMPO_SEXO_ID);
    if (selectSexo && !validarSelect(selectSexo)) formularioValido = false;

    if (!formularioValido) {
        evt.preventDefault();
        alert('Por favor, corrige los campos marcados antes de enviar.');
        document.querySelector('.is-invalid')?.focus();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-registro-lector'); 
    if (!form) return;

    CAMPOS_INPUT_VALIDACION.forEach(id => {
        const inputElement = document.getElementById(id);
        if (!inputElement) return;

        if (CAMPOS_SOLO_NUMEROS.includes(id)) {
            inputElement.addEventListener('keypress', isNumberKey); 
        }

        const handler = () => {
            if (id === CAMPO_CEDULA_ID) validarCedula(inputElement);
            else if (id === CAMPO_CARNET_ID) validarCarnet(inputElement);
            else if (CAMPOS_TELEFONO.includes(id)) validarTelefono(inputElement);
            else validarCampoInput(inputElement);
        };

        inputElement.addEventListener('input', handler);
        inputElement.addEventListener('blur', () => {
            handler();
            if (CAMPOS_CAPITALIZACION.includes(id)) capitalizarNombre(inputElement);
        });
    });

    const selectSexo = document.getElementById(CAMPO_SEXO_ID);
    if (selectSexo) {
        selectSexo.addEventListener('change', () => validarSelect(selectSexo));
    }

    form.addEventListener('submit', manejarEnvioFormulario);
});