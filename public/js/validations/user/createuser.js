// ============================================================================
// 1. CONFIGURACIÓN Y REGLAS DE NEGOCIO (Single Source of Truth)
// ============================================================================

const CONFIG_VALIDACION_USUARIOS = {
    'dni-reg': {
        requerido: true,
        tipo: 'numero',
        regex: /^[0-9]{6,8}$/,
        minValor: 800000,
        errorId: 'dni-error',
        mensaje: "Debe ser una cédula válida entre 6 y 8 dígitos (mayor a 800.000)."
    },
    'nombre-reg': {
        requerido: true,
        tipo: 'texto_estricto',
        regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/,
        errorId: 'nombre-error',
        mensaje: "El nombre ingresado no es válido. Solo se permiten letras."
    },
    'apellido-reg': {
        requerido: true,
        tipo: 'texto_estricto',
        regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/,
        errorId: 'apellido-error',
        mensaje: "El apellido ingresado no es válido. Solo se permiten letras."
    },
    'num-reg': { 
        requerido: true,
        tipo: 'telefono',
        regex: /^[0-9]{7}$/,
        errorId: 'telefono-error',
        mensaje: "El número de teléfono debe contener exactamente 7 dígitos numéricos."
    },
    'usuario-reg': {
        requerido: true,
        tipo: 'usuario',
        regex: /^[a-zA-Z0-9_]{4,15}$/,
        errorId: 'user-error',
        mensaje: "El usuario debe tener entre 4 and 15 caracteres (letras, números o '_')."
    },
    'pregunta-resp-reg': {
        requerido: true,
        tipo: 'texto_estricto',
        regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/,
        errorId: 'resp-error',
        mensaje: "La respuesta de seguridad no es válida. Solo se permiten letras."
    },
    'password1-reg': {
        requerido: true, // Se modificará dinámicamente si es edición
        tipo: 'password',
        errorId: 'pass1-error',
        textFalta: "La contraseña es obligatoria en modo registro.",
        mensaje: "La contraseña debe tener mínimo 8 caracteres."
    },
    'password2-reg': {
        requerido: true, // Se modificará dinámicamente si es edición
        tipo: 'confirmar_password',
        errorId: 'pass2-error',
        mensaje: "Las contraseñas ingresadas no coinciden o el campo está vacío."
    }
};

const CAMPOS_NUMERICOS = ['dni-reg', 'num-reg'];
const CAMPOS_ALFABETICOS = ['nombre-reg', 'apellido-reg', 'pregunta-resp-reg'];

// ============================================================================
// 2. FILTROS Y SANITIZACIÓN EN TIEMPO REAL
// ============================================================================

function aplicarFiltrosSanitizacion(inputElement) {
    const id = inputElement.id;
    inputElement.addEventListener('input', () => {
        let valorOriginal = inputElement.value;
        if (CAMPOS_NUMERICOS.includes(id)) {
            inputElement.value = valorOriginal.replace(/[^0-9]/g, '');
        } 
        else if (CAMPOS_ALFABETICOS.includes(id)) {
            inputElement.value = valorOriginal.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        }
    });
}

// ============================================================================
// 3. PROCESADORES DE TEXTO Y NORMALIZADORES
// ============================================================================

function capitalizarTexto(texto) {
    return texto.toLowerCase()
        .split(' ')
        .map(palabra => palabra.charAt(0).toUpperCase() + palabra.slice(1))
        .join(' ');
}

function normalizarYFormatearCampos(inputElement) {
    const id = inputElement.id;
    inputElement.addEventListener('blur', () => {
        let valor = inputElement.value.trim();
        if (valor === "") return;

        valor = valor.replace(/\s+/g, ' ');
        
        if ((CAMPOS_ALFABETICOS.includes(id)) && id !== 'pregunta-resp-reg') {
            inputElement.value = capitalizarTexto(valor);
        } else {
            inputElement.value = valor;
        }
    });
}

// ============================================================================
// 4. FUNCIONES AUXILIARES DE VALIDACIÓN SEMÁNTICA
// ============================================================================

function esPatronInvalido(valor) {
    return /^0+$/.test(valor);
}

function validarEstructuraPalabra(texto) {
    const valor = texto.trim();
    if (valor === "") return true;
    const palabras = valor.split(/\s+/);
    const conectores = ['y', 'e', 'o', 'u'];
    return palabras.every(palabra => {
        const palabraLimpia = palabra.replace(/[.,;:]/g, "");
        if (conectores.includes(palabraLimpia.toLowerCase())) return true;
        return /[aeiouáéíóúü]/i.test(palabraLimpia) && /[bcdfghjklmnñpqrstvwxyz]/i.test(palabraLimpia);
    });
}

function tieneLetrasRepetidasInvalidos(texto) {
    return /([a-zA-ZáéíóúÁÉÍÓÚñÑ])\1{2,}/i.test(texto);
}

function actualizarTelefonoOculto() {
    const prefEl = document.getElementById('pref-reg');
    const numEl = document.getElementById('num-reg');
    const hiddenEl = document.getElementById('telefono-reg');
    if (prefEl && numEl && hiddenEl) {
        hiddenEl.value = numEl.value.trim() !== "" ? prefEl.value + numEl.value.trim() : "";
    }
}

// ============================================================================
// 5. MOTOR CENTRAL DE VALIDACIÓN
// ============================================================================

function validarCampoUsuario(inputElement) {
    const id = inputElement.id;
    const regla = CONFIG_VALIDACION_USUARIOS[id];
    if (!regla) return true;

    const valor = inputElement.value.trim();
    
    // Si el campo está vacío
    if (valor === "") {
        if (regla.requerido) {
            // INTEGRADO: Pasa el mensaje unificado requerido estándar
            asignarUIFeedback(inputElement, false, "Este campo es obligatorio.");
            return false;
        } else {
            // Si no es requerido (caso contraseñas en edición) limpiamos los errores
            limpiarUIFeedback(inputElement);
            
            if (id === 'password1-reg') {
                const pass2El = document.getElementById('password2-reg');
                if (pass2El && pass2El.value.trim() === "") {
                    limpiarUIFeedback(pass2El);
                }
            }
            return true;
        }
    }

    if (CAMPOS_NUMERICOS.includes(id) && esPatronInvalido(valor)) {
        asignarUIFeedback(inputElement, false, "El número ingresado no es válido. No puede estar compuesto únicamente por ceros.");
        return false;
    }

    if (id === 'dni-reg') {
        if (regla.minValor && parseInt(valor, 10) < regla.minValor) {
            asignarUIFeedback(inputElement, false, `La cédula no puede ser menor a ${regla.minValor.toLocaleString()}.`);
            return false;
        }
    }

    if (regla.regex && !regla.regex.test(valor)) {
        asignarUIFeedback(inputElement, false, regla.mensaje);
        return false;
    }

    if (CAMPOS_ALFABETICOS.includes(id)) {
        if (!validarEstructuraPalabra(valor)) {
            let sujeto = "El nombre de pila";
            if (id === 'apellido-reg') sujeto = "El apellido";
            if (id === 'pregunta-resp-reg') sujeto = "La respuesta de seguridad";
            
            asignarUIFeedback(inputElement, false, `${sujeto} ingresado contiene una combinación de letras inverosímil.`);
            return false;
        }
        if (tieneLetrasRepetidasInvalidos(valor)) {
            let sujetoContexto = id === 'nombre-reg' ? `El nombre "${valor}"` : `El apellido "${valor}"`;
            if (id === 'pregunta-resp-reg') sujetoContexto = `La respuesta "${valor}"`;
            
            asignarUIFeedback(inputElement, false, `${sujetoContexto} es inválido debido a un exceso de caracteres idénticos seguidos.`);
            return false;
        }
    }

    // LÓGICA DE CONTRASEÑAS UNIFICADAS
    if (id === 'password1-reg' || id === 'password2-reg') {
        const pass1El = document.getElementById('password1-reg');
        const pass2El = document.getElementById('password2-reg');
        
        if (pass1El && pass2El) {
            const val1 = pass1El.value;
            const val2 = pass2El.value;

            if (!CONFIG_VALIDACION_USUARIOS['password1-reg'].requerido) {
                if (val1 !== "" || val2 !== "") {
                    if (val1.length < 8) {
                        asignarUIFeedback(pass1El, false, "La contraseña debe tener mínimo 8 caracteres.");
                        if (id === 'password1-reg') return false;
                    } else {
                        asignarUIFeedback(pass1El, true);
                    }
                }
            } else {
                if (val1.length < 8) {
                    asignarUIFeedback(pass1El, false, "La contraseña debe tener mínimo 8 caracteres.");
                    if (id === 'password1-reg') return false;
                }
            }

            if (val1 !== val2) {
                asignarUIFeedback(pass2El, false, CONFIG_VALIDACION_USUARIOS['password2-reg'].mensaje);
                return false;
            } else if (val1 === val2 && val1 !== "") {
                asignarUIFeedback(pass1El, true);
                asignarUIFeedback(pass2El, true);
            }
        }
    }

    asignarUIFeedback(inputElement, true);
    return true;
}

// ============================================================================
// 6. CAPA VISUAL Y MANIPULACIÓN DEL DOM (Bootstrap UI)
// ============================================================================

function asignarUIFeedback(inputElement, esValido, mensaje = "") {
    const id = inputElement.id;
    const regla = CONFIG_VALIDACION_USUARIOS[id];
    const errorId = regla ? regla.errorId : `${id}-error`;
    const errorDiv = document.getElementById(errorId);
    const formGroup = inputElement.closest('.form-group'); // Localiza el contenedor del framework

    if (esValido) {
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        
        // CORRECCIÓN NATIVA: Remueve la clase de error de la plantilla para limpiar el label
        if (formGroup) {
            formGroup.classList.remove('has-error');
        }
        
        if (errorDiv) {
            errorDiv.style.display = 'none';
            errorDiv.innerHTML = '';
        }
    } else {
        inputElement.classList.add('is-invalid');
        inputElement.classList.remove('is-valid');
        
        // CORRECCIÓN NATIVA: Activa el color rojo en el label y la línea inferior mediante CSS en cascada
        if (formGroup) {
            formGroup.classList.add('has-error');
        }
        
        if (errorDiv) {
            errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${mensaje}`;
            errorDiv.style.display = 'block';
        }
    }
}

function limpiarUIFeedback(inputElement) {
    const id = inputElement.id;
    const regla = CONFIG_VALIDACION_USUARIOS[id];
    const errorId = regla ? regla.errorId : `${id}-error`;
    const errorDiv = document.getElementById(errorId);
    const formGroup = inputElement.closest('.form-group');

    inputElement.classList.remove('is-invalid', 'is-valid');
    
    // CORRECCIÓN NATIVA: Quita el color rojo del label al limpiar el campo
    if (formGroup) {
        formGroup.classList.remove('has-error');
    }
    
    if (errorDiv) {
        errorDiv.style.display = 'none';
        errorDiv.innerHTML = '';
    }
}

// ============================================================================
// 7. CONTROLADOR CENTRAL DE EVENTOS (Orquestador DOM)
// ============================================================================

document.addEventListener('DOMContentLoaded', () => {
    const formUsuarios = document.getElementById('form-registro-usuario') || document.getElementById('form-editar-usuario');
    if (!formUsuarios) return;

    if (formUsuarios.id === 'form-editar-usuario') {
        CONFIG_VALIDACION_USUARIOS['password1-reg'].requerido = false;
        CONFIG_VALIDACION_USUARIOS['password2-reg'].requerido = false;
    }

    const prefEl = document.getElementById('pref-reg');
    const numEl = document.getElementById('num-reg');
    if (prefEl && numEl) {
        prefEl.addEventListener('change', actualizarTelefonoOculto);
        numEl.addEventListener('input', actualizarTelefonoOculto);
    }

    Object.keys(CONFIG_VALIDACION_USUARIOS).forEach(id => {
        const inputElement = document.getElementById(id);
        if (!inputElement) return;

        aplicarFiltrosSanitizacion(inputElement);
        normalizarYFormatearCampos(inputElement);

        inputElement.addEventListener('blur', () => {
            validarCampoUsuario(inputElement);
        });

        inputElement.addEventListener('input', () => {
            if (inputElement.classList.contains('is-invalid') || id === 'password1-reg' || id === 'password2-reg') {
                validarCampoUsuario(inputElement);
            }
        });
    });

    formUsuarios.addEventListener('submit', (evt) => {
        let formularioValido = true;
        actualizarTelefonoOculto();

        Object.keys(CONFIG_VALIDACION_USUARIOS).forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                const resultado = validarCampoUsuario(el);
                if (!resultado) formularioValido = false;
            }
        });

        if (!formularioValido) {
            evt.preventDefault();
            if (typeof swal === 'function') {
                swal({ 
                    title: "¡Formulario Incompleto!", 
                    text: "Por favor, revise y corrija los campos de usuario resaltados en rojo.", 
                    type: "error" 
                });
            } else {
                alert("Por favor, corrija los errores del formulario antes de continuar.");
            }
        }
    });
});