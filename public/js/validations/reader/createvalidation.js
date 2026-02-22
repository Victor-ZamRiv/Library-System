// --- CONSTANTES ---
const CAMPO_CARNET_ID = 'carnet-reg';
const CAMPO_CEDULA_ID = 'cedula-reg';
const CAMPO_SEXO_ID = 'sexo-reg';

const IDS_INPUT_NUM_TEL = ['num-reg', 'num-prof', 'num-ref-l', 'num-ref-p'];

const CAMPOS_REQUERIDOS = [
    CAMPO_CARNET_ID, 
    CAMPO_CEDULA_ID, 
    'nombre-reg', 
    'apellido-reg', 
    'direccion-reg', 
    CAMPO_SEXO_ID,
    'num-reg' 
];

const CAMPOS_SOLO_NUMEROS = [CAMPO_CARNET_ID, CAMPO_CEDULA_ID, ...IDS_INPUT_NUM_TEL];
const CAMPOS_TEXTO_ESTRICTO = [
    'direccion-reg', 'direccion-profesion-reg', 'profesion-reg', 
    'referencia-legal-personal-reg', 'referencia-personal-reg',
    'nombre-reg', 'apellido-reg'
];

const CAMPOS_INPUT_VALIDACION = [...new Set([...CAMPOS_SOLO_NUMEROS, ...CAMPOS_TEXTO_ESTRICTO])];

// --- FUNCIONES AUXILIARES ---

function validarEstructuraPalabra(texto) {
    const valor = texto.trim();
    if (valor === "") return true;
    const palabras = valor.split(/\s+/);
    const conectores = ['y', 'e', 'o', 'u'];
    return palabras.every(palabra => {
        if (conectores.includes(palabra.toLowerCase())) return true;
        return /[aeiouáéíóúü]/i.test(palabra) && /[bcdfghjklmnñpqrstvwxyz]/i.test(palabra);
    });
}

function manejarFeedback(inputElement, esValido, mensajeManual = "") {
    let errorId = inputElement.id.replace('-reg', '-error');
    if (inputElement.id.startsWith('num-')) {
        errorId = inputElement.id.replace('num-', 'telefono-') + '-error';
    }
    
    const errorDiv = document.getElementById(errorId);
    if (!errorDiv) return;

    if (esValido) {
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        errorDiv.style.display = 'none';
    } else {
        inputElement.classList.add('is-invalid');
        inputElement.classList.remove('is-valid');
        errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${mensajeManual}`;
        errorDiv.style.display = 'block';
    }
}

// --- LÓGICA DE VALIDACIÓN POR CAMPO ---

function ejecutarValidacion(inputElement) {
    const id = inputElement.id;
    const valor = inputElement.value.trim();
    const esRequerido = CAMPOS_REQUERIDOS.includes(id);

    if (valor === "" && esRequerido) {
        manejarFeedback(inputElement, false, "Este campo es obligatorio");
        return;
    }

    if (valor === "" && !esRequerido) {
        inputElement.classList.remove('is-invalid', 'is-valid');
        let errorIdBase = id.replace('-reg', '-error');
        if (id.startsWith('num-')) errorIdBase = id.replace('num-', 'telefono-') + '-error';
        const errDiv = document.getElementById(errorIdBase);
        if (errDiv) errDiv.style.display = 'none';
        return;
    }

    // --- Lógica Específica ---
    if (id === CAMPO_CEDULA_ID) {
        const esValido = /^[0-9]{6,8}$/.test(valor);
        manejarFeedback(inputElement, esValido, "Debe tener entre 6 y 8 números");
    } 
    else if (IDS_INPUT_NUM_TEL.includes(id)) {
        const esValido = valor.length === 7;
        manejarFeedback(inputElement, esValido, "Debe tener 7 dígitos");
    }
    else if (id === CAMPO_CARNET_ID) {
        // VALIDACIÓN AVANZADA DE CARNET
        const regexCarnet = /^[0-9]{8}\/([0-9]{2})$/;
        const match = valor.match(regexCarnet);
        
        if (!match) {
            manejarFeedback(inputElement, false, "Formato: 00000000/00");
        } else {
            const anioIngresado = parseInt(match[1], 10);
            const anioActual = parseInt(new Date().getFullYear().toString().slice(-2), 10);
            if (anioIngresado > anioActual) {
                manejarFeedback(inputElement, false, `El año no puede ser mayor a ${anioActual}`);
            } else {
                manejarFeedback(inputElement, true);
            }
        }
    }
    else if (CAMPOS_TEXTO_ESTRICTO.includes(id)) {
        const esValido = validarEstructuraPalabra(valor);
        manejarFeedback(inputElement, esValido, "Formato de texto no válido (mezcla letras)");
    }
}

// --- INICIALIZACIÓN ---

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-registro-lector');
    if (!form) return;

    CAMPOS_INPUT_VALIDACION.forEach(id => {
        const inputElement = document.getElementById(id);
        if (!inputElement) return;

        // 1. EVENTO KEYPRESS: Bloqueo de teclas
        inputElement.addEventListener('keypress', (evt) => {
            const charCode = (evt.which) ? evt.which : evt.keyCode;
            if ([8, 9, 13, 37, 39, 46].includes(charCode)) return true;

            if (CAMPOS_SOLO_NUMEROS.includes(id)) {
                // En el carnet solo permitimos números (la barra se pone sola al salir)
                if (charCode < 48 || charCode > 57) evt.preventDefault();
            }
            if (CAMPOS_TEXTO_ESTRICTO.includes(id)) {
                if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]$/.test(evt.key)) evt.preventDefault();
            }
        });

        // 2. EVENTO FOCUS: Especial para Carnet
        if (id === CAMPO_CARNET_ID) {
            inputElement.addEventListener('focus', () => {
                inputElement.value = inputElement.value.replace('/', '');
                inputElement.maxLength = 10; 
            });
        }

        // 3. EVENTO BLUR: Formateo y Validación
        inputElement.addEventListener('blur', () => {
            // Caso Carnet: Poner barra
            if (id === CAMPO_CARNET_ID) {
                let v = inputElement.value.replace(/[^0-9]/g, '');
                if (v.length === 10) {
                    inputElement.maxLength = 11;
                    inputElement.value = v.substring(0, 8) + '/' + v.substring(8, 10);
                }
            }
            
            // Caso Nombres: Capitalización
            if (['nombre-reg', 'apellido-reg'].includes(id) && inputElement.value !== "") {
                inputElement.value = inputElement.value.trim().toLowerCase()
                    .split(' ').filter(w => w !== "").map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
            }

            ejecutarValidacion(inputElement);
        });

        // 4. EVENTO INPUT: Re-validar si ya tenía error
        inputElement.addEventListener('input', () => {
            if (inputElement.classList.contains('is-invalid')) {
                ejecutarValidacion(inputElement);
            }
        });
    });

    // Eventos para el select de Sexo
    const selectSexo = document.getElementById(CAMPO_SEXO_ID);
    if(selectSexo) {
        selectSexo.addEventListener('change', () => ejecutarValidacion(selectSexo));
        selectSexo.addEventListener('blur', () => ejecutarValidacion(selectSexo));
    }

    // --- SUBMIT FINAL ---
    form.addEventListener('submit', (evt) => {
        let formularioValido = true;

        CAMPOS_INPUT_VALIDACION.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                ejecutarValidacion(el);
                if (el.classList.contains('is-invalid')) formularioValido = false;
            }
        });
        
        if(selectSexo) {
            ejecutarValidacion(selectSexo);
            if (selectSexo.classList.contains('is-invalid')) formularioValido = false;
        }

        // Mapeo de teléfonos ocultos
        const mapeo = [
            { n: 'num-reg', p: 'pref-reg', h: 'telefono-reg' },
            { n: 'num-prof', p: 'pref-prof', h: 'telefono-profesion-reg' },
            { n: 'num-ref-l', p: 'pref-ref-l', h: 'telefono-referencia-legal-reg' },
            { n: 'num-ref-p', p: 'pref-ref-p', h: 'telefono-referencia-personal-reg' }
        ];

        mapeo.forEach(t => {
            const nEl = document.getElementById(t.n);
            const pEl = document.getElementById(t.p);
            const hEl = document.getElementById(t.h);
            if(nEl && pEl && hEl) {
                hEl.value = (nEl.value.length === 7) ? pEl.value + nEl.value : "";
            }
        });

        if (!formularioValido) {
            evt.preventDefault();
            swal({ title: "¡Atención!", text: "Corrija los campos marcados en rojo antes de continuar.", type: "error" });
        }
    });
});