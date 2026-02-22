/**
 * SCRIPT DE VALIDACIÓN PARA CREACIÓN DE USUARIOS
 */

// 1. Limpiar caracteres no numéricos en tiempo real
const forzarNumeros = (input) => {
    input.value = input.value.replace(/[^0-9]/g, '');
};

// 2. Detectar valores lógicamente imposibles (ej. "000000")
const esPatronInvalido = (valor) => {
    return /^0+$/.test(valor);
};

// 3. Función para poner en mayúscula la primera letra de cada palabra
const capitalizarFrase = (input) => {
    let valor = input.value;
    input.value = valor.toLowerCase().replace(/^(.)|\s+(.)/g, (match) => {
        return match.toUpperCase();
    });
};

/**
 * 4. Lógica de Vocal y Consonante
 */
function tieneVocalYConsonante(texto) {
    if (!texto.trim()) return true;

    const palabras = texto.trim().split(/\s+/);
    const vocalRegex = /[aeiouáéíóúüAEIOUÁÉÍÓÚÜ]/;
    const consonanteRegex = /[bcdfghjklmnñpqrstvwxyzBCDFGHJKLMNÑPQRSTVWXYZ]/;

    return palabras.every(palabra => {
        const palabraLimpia = palabra.replace(/[.,;:]/g, "");
        if (/^(y|o|e|u)$/i.test(palabraLimpia)) return true;
        if (!/[a-zA-ZáéíóúÁÉÍÓÚñÑ]/.test(palabraLimpia)) return true;
        return vocalRegex.test(palabraLimpia) && consonanteRegex.test(palabraLimpia);
    });
}

// 5. Validación de Cédula (Se mantiene con validación en tiempo real)
const validarCedula = (input) => {
    forzarNumeros(input);
    const regexCedula = /^[0-9]{6,8}$/;
    const errorElement = document.getElementById("dni-error");
    const valor = input.value;

    if (!regexCedula.test(valor) || esPatronInvalido(valor)) {
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        if (errorElement) errorElement.style.display = "block";
        return false;
    } else {
        input.classList.remove("is-invalid");
        input.classList.add("is-valid");
        if (errorElement) errorElement.style.display = "none";
        return true;
    }
};

// 6. Validación de Teléfono
const validarTelefono = (input) => {
    forzarNumeros(input);
    const regexTelf = /^[0-9]{11}$/;
    const errorElement = document.getElementById("tel-error");
    const valor = input.value;

    if (valor === "") {
        input.classList.remove("is-invalid", "is-valid");
        if (errorElement) errorElement.style.display = "none";
        return false;
    }

    if (!regexTelf.test(valor) || esPatronInvalido(valor)) {
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        if (errorElement) errorElement.style.display = "block";
        return false;
    } else {
        input.classList.remove("is-invalid");
        input.classList.add("is-valid");
        if (errorElement) errorElement.style.display = "none";
        return true;
    }
};

// 7. Validación de Texto General (Mantiene el error hasta corrección)
const validarTexto = (input, errorId, esUsuario = false) => {
    if (!esUsuario) capitalizarFrase(input);

    const errorElement = document.getElementById(errorId);
    const valor = input.value;

    const cumpleReglasLogicas = tieneVocalYConsonante(valor);
    const cumplePattern = input.checkValidity();

    // Si el valor está vacío y es requerido, o no cumple las reglas
    if (valor === "" || !cumplePattern || !cumpleReglasLogicas) {
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");

        if (errorElement) {
            errorElement.style.display = "block";
            // Si la falla es por vocal/consonante, sobreescribimos el mensaje
            if (!cumpleReglasLogicas && valor !== "") {
                errorElement.innerHTML = '<i class="fas fa-exclamation-circle"></i> Cada palabra debe tener vocal y consonante.';
            } else if (valor === "") {
                errorElement.innerHTML = '<i class="fas fa-exclamation-circle"></i> Este campo es obligatorio.';
            }
        }
        return false;
    } else {
        // Solo aquí se oculta el error y se marca como válido
        input.classList.remove("is-invalid");
        input.classList.add("is-valid");
        if (errorElement) errorElement.style.display = "none";
        return true;
    }
};

// 8. Comparación de Contraseñas
function validarPasswordsUnificadas(inputConfirm) {
    const pass1 = document.getElementById('password1-reg').value;
    const errorDiv = document.getElementById('pass2-error');

    if (inputConfirm.value !== pass1 || inputConfirm.value === "") {
        inputConfirm.classList.add('is-invalid');
        inputConfirm.classList.remove('is-valid');
        if (errorDiv) errorDiv.style.display = 'block';
    } else {
        inputConfirm.classList.remove('is-invalid');
        inputConfirm.classList.add('is-valid');
        if (errorDiv) errorDiv.style.display = 'none';
    }
}

/**
 * 9. Vinculación de Eventos
 */
document.addEventListener("DOMContentLoaded", () => {
    const inputs = {
        "dni-reg": (e) => validarCedula(e.target),
        "telf-reg": (e) => validarTelefono(e.target),
        "nombre-reg": (e) => validarTexto(e.target, "nombre-error"),
        "apellido-reg": (e) => validarTexto(e.target, "apellido-error"),
        "usuario-reg": (e) => validarTexto(e.target, "user-error", true),
        "pregunta-resp-reg": (e) => validarTexto(e.target, "resp-error"),
        "password2-reg": (e) => validarPasswordsUnificadas(e.target)
    };

    // Aplicar eventos de input y blur para persistencia
    Object.keys(inputs).forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener("input", inputs[id]);
            el.addEventListener("blur", inputs[id]);
        }
    });
});