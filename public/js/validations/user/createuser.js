// 1. Función para limpiar caracteres no numéricos en tiempo real
const forzarNumeros = (input) => {
    // Reemplaza cualquier cosa que NO sea un número [0-9] con un string vacío
    input.value = input.value.replace(/[^0-9]/g, '');
};

// 2. Función para detectar valores lógicamente imposibles
const esPatronInvalido = (valor) => {
    return /^0+$/.test(valor);
};

// 3. Validación de Cédula
const validarCedula = (input) => {
    // Primero nos aseguramos de que solo haya números
    forzarNumeros(input);

    const regexCedula = /^[0-9]{6,8}$/;
    const errorElement = document.getElementById("dni-error");
    const valor = input.value;

    if (!regexCedula.test(valor) || esPatronInvalido(valor)) {
        input.classList.remove("is-valid");
        input.classList.add("is-invalid");
        if (errorElement) {
            errorElement.innerHTML = '<i class="fas fa-exclamation-circle"></i> La Cédula es inválida, Ingrese una Cédula válida (6-8 dígitos).';
            errorElement.style.display = "block";
        }
        return false;
    } else {
        input.classList.remove("is-invalid");
        input.classList.add("is-valid");
        if (errorElement) errorElement.style.display = "none";
        return true;
    }
};

// 4. Validación de Teléfono (Optimizada)
const validarTelefono = (input) => {
    forzarNumeros(input);

    // Regex para 11 dígitos exactos
    const regexTelf = /^[0-9]{11}$/;
    const errorElement = document.getElementById("telf-error");
    const valor = input.value;

    // Reiniciamos estados visuales
    input.classList.remove("is-valid", "is-invalid");

    if (valor === "") {
        if (errorElement) errorElement.style.display = "none";
        return false;
    }

    if (!regexTelf.test(valor) || esPatronInvalido(valor)) {
        input.classList.add("is-invalid");
        if (errorElement) {
            errorElement.innerHTML = '<i class="fas fa-exclamation-circle"></i> Ingrese un número de 11 dígitos.';
            errorElement.style.display = "block";
        }
        return false;
    } else {
        input.classList.add("is-valid");
        if (errorElement) errorElement.style.display = "none";
        return true;
    }
};

// 5. Función para poner en mayúscula la primera letra de cada palabra
const capitalizarFrase = (input) => {
    let valor = input.value;

    // Convertimos todo a minúsculas primero y luego transformamos
    // La regex busca la primera letra de la frase y cualquier letra después de un espacio
    input.value = valor.toLowerCase().replace(/^(.)|\s+(.)/g, (match) => {
        return match.toUpperCase();
    });
};

// 6. Validación de Nombres/Apellidos
const validarTexto = (input, errorId) => {
    // Aplicamos el formato de mayúsculas automáticamente
    capitalizarFrase(input);

    const errorElement = document.getElementById(errorId);

    // checkValidity() usa el pattern que ya tienes en tu HTML
    if (!input.checkValidity()) {
        input.classList.add("is-invalid");
        if (errorElement) errorElement.style.display = "block";
        return false;
    } else {
        input.classList.remove("is-invalid");
        input.classList.add("is-valid");
        if (errorElement) errorElement.style.display = "none";
        return true;
    }
};

// 7. Vincular Eventos
const inputDni = document.getElementById("dni-reg");
const inputTelf = document.getElementById("telf-reg"); // ID de tu campo de teléfono

if (inputDni) {
    // Usamos 'input' porque detecta cambios inmediatos, incluso pegar texto
    inputDni.addEventListener("input", () => validarCedula(inputDni));
    inputDni.addEventListener("blur", () => validarCedula(inputDni));
}

if (inputTelf) {
    inputTelf.addEventListener("input", () => validarTelefono(inputTelf));
    inputTelf.addEventListener("blur", () => validarTelefono(inputTelf));
}

const inputNombre = document.getElementById("nombre-reg");
const inputApellido = document.getElementById("apellido-reg");

if (inputNombre) {
    inputNombre.addEventListener("input", () => validarTexto(inputNombre, "nombre-error"));
}

if (inputApellido) {
    inputApellido.addEventListener("input", () => validarTexto(inputApellido, "apellido-error"));
}

// 8. Función específica para comparar contraseñas siguiendo tu nueva lógica
function validarPasswordsUnificadas(inputConfirm) {
    const pass1 = document.getElementById('password1-reg').value;
    const errorDiv = document.getElementById('pass2-error');

    if (inputConfirm.value !== pass1 || inputConfirm.value === "") {
        inputConfirm.classList.add('is-invalid');
        inputConfirm.classList.remove('is-valid');
        errorDiv.style.display = 'block';
    } else {
        inputConfirm.classList.remove('is-invalid');
        inputConfirm.classList.add('is-valid');
        errorDiv.style.display = 'none';
    }
}

