// ============================================================================
// 1. CONFIGURACIÓN Y REGLAS DE NEGOCIO (Single Source of Truth)
// ============================================================================

const CAMPO_SEXO_ID = 'sexo-reg';

const CONFIG_VALIDACION = {
    'carnet-reg': {
        requerido: true,
        tipo: 'carnet',
        regex: /^[0-9]{8}\/[0-9]{2}$/, 
        mensaje: "Formato requerido: 8 números seguidos de los 2 dígitos del año (Ej: 00123456/24)"
    },
    'cedula-reg': {
        requerido: true,
        tipo: 'numero',
        regex: /^[0-9]{6,8}$/,
        minValor: 800000,
        mensaje: "Debe ser un número válido entre 6 y 8 dígitos (mayor a 800.000)"
    },
    'nombre-reg': {
        requerido: true,
        tipo: 'texto_estricto',
        regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/,
        mensaje: "El nombre ingresado no es válido. Solo se permiten letras y no debe contener más de 2 caracteres idénticos consecutivos."
    },
    'apellido-reg': {
        requerido: true,
        tipo: 'texto_estricto',
        regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/,
        mensaje: "El apellido ingresado no es válido. Solo se permiten letras y no debe contener más de 2 caracteres idénticos consecutivos."
    },
    'direccion-reg': {
        requerido: true,
        tipo: 'direccion',
        regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s.,#\-]+$/,
        mensaje: "La dirección contiene caracteres no permitidos. Solo se acepta texto, números y los signos (. , # -)"
    },
    [CAMPO_SEXO_ID]: {
        requerido: true,
        tipo: 'select',
        mensaje: "Debe seleccionar una opción"
    },
    'num-reg': {
        requerido: true,
        tipo: 'telefono',
        regex: /^[0-9]{7}$/,
        mensaje: "El teléfono debe tener exactamente 7 dígitos"
    },
    // ---- CAMPOS OPCIONALES (No requeridos, pero si tienen datos se validan) ----
    'profesion-reg': {
        requerido: false,
        tipo: 'texto_estricto',
        regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/,
        mensaje: "La profesión ingresada no es válida. Solo se permiten letras y no debe contener más de 2 caracteres idénticos consecutivos."
    },
    'direccion-profesion-reg': {
        requerido: false,
        tipo: 'direccion',
        regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s.,#\-]+$/,
        mensaje: "La dirección contiene caracteres no permitidos. Solo se acepta texto, números y los signos (. , # -)"
    },
    'num-prof': {
        requerido: false,
        tipo: 'telefono',
        regex: /^[0-9]{7}$/,
        mensaje: "El teléfono debe tener exactamente 7 dígitos"
    },
    'referencia-legal-personal-reg': {
        requerido: false,
        tipo: 'texto_estricto',
        regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/,
        mensaje: "El nombre de la referencia legal no es válido. Solo se permiten letras y no debe contener más de 2 caracteres idénticos consecutivos."
    },
    'num-ref-l': {
        requerido: false,
        tipo: 'telefono',
        regex: /^[0-9]{7}$/,
        mensaje: "El teléfono debe tener exactamente 7 dígitos"
    },
    'referencia-personal-reg': {
        requerido: false,
        tipo: 'texto_estricto',
        regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/,
        mensaje: "El nombre de la referencia personal no es válido. Solo se permiten letras y no debe contener más de 2 caracteres idénticos consecutivos."
    },
    'num-ref-p': {
        requerido: false,
        tipo: 'telefono',
        regex: /^[0-9]{7}$/,
        mensaje: "El teléfono debe tener exactamente 7 dígitos"
    }
};

const CAMPOS_NUMERICOS = ['cedula-reg', 'num-reg', 'num-prof', 'num-ref-l', 'num-ref-p'];
const CAMPOS_ALFABETICOS = ['nombre-reg', 'apellido-reg', 'profesion-reg', 'referencia-legal-personal-reg', 'referencia-personal-reg'];
const CAMPOS_DIRECCION = ['direccion-reg', 'direccion-profesion-reg'];


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
            inputElement.value = valorOriginal.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        }
        else if (CAMPOS_DIRECCION.includes(id)) {
            inputElement.value = valorOriginal.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s.,#\-]/g, '');
        }
        else if (id === 'carnet-reg') {
            let soloNumeros = valorOriginal.replace(/[^0-9]/g, '');
            
            if (soloNumeros.length > 10) {
                soloNumeros = soloNumeros.substring(0, 10);
            }

            if (soloNumeros.length > 8) {
                inputElement.value = soloNumeros.substring(0, 8) + '/' + soloNumeros.substring(8);
            } else {
                inputElement.value = soloNumeros;
            }
        }
    });
}


// ============================================================================
// 3. PROCESADORES DE TEXTO Y NORMALIZADORES (Formateo)
// ============================================================================

function capitalizarTexto(texto) {
    return texto.toLowerCase()
        .split(' ')
        .map(palabra => palabra.charAt(0).toUpperCase() + palabra.slice(1))
        .join(' ');
}

function normalizarYFormatearCampos(inputElement) {
    const id = inputElement.id;

    if (id === 'carnet-reg') {
        inputElement.addEventListener('focus', () => {
            let soloNumeros = inputElement.value.replace('/', '');
            inputElement.value = soloNumeros;
        });
    }

    inputElement.addEventListener('blur', () => {
        let valor = inputElement.value.trim();
        if (valor === "") return;

        valor = valor.replace(/\s+/g, ' ');

        if (id === 'carnet-reg') {
            let soloNumeros = valor.replace(/[^0-9]/g, '');
            if (soloNumeros.length === 10) {
                inputElement.value = soloNumeros.substring(0, 8) + '/' + soloNumeros.substring(8, 10);
            } else {
                inputElement.value = soloNumeros; 
            }
        } 
        else if (CAMPOS_ALFABETICOS.includes(id) || CAMPOS_DIRECCION.includes(id)) {
            inputElement.value = capitalizarTexto(valor);
        } else {
            inputElement.value = valor;
        }
    });
}


// ============================================================================
// 4. FUNCIONES AUXILIARES DE VALIDACIÓN SEMÁNTICA
// ============================================================================

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

function tieneLetrasRepetidasInvalidos(texto) {
    const regexLetrasRepetidas = /([a-zA-ZáéíóúÁÉÍÓÚñÑ])\1{2,}/i;
    return regexLetrasRepetidas.test(texto);
}

function tieneNumerosRepetidosInvalidos(texto) {
    const regexNumerosRepetidas = /([0-9])\1{4,}/;
    return regexNumerosRepetidas.test(texto);
}


// ============================================================================
// 5. MOTOR CENTRAL DE VALIDACIÓN
// ============================================================================

function validarCampo(inputElement) {
    const id = inputElement.id;
    const regla = CONFIG_VALIDACION[id];
    if (!regla) return true;

    const valor = inputElement.value.trim();
    
    if (valor === "") {
        if (regla.requerido) {
            asignarUIFeedback(inputElement, false, "Este campo es obligatorio.");
            return false;
        } else {
            limpiarUIFeedback(inputElement);
            return true;
        }
    }

    // 2. Control específico avanzado para el Carnet
    if (id === 'carnet-reg') {
        const numerosPuros = valor.replace('/', '');

        if (numerosPuros.length < 10) {
            asignarUIFeedback(
                inputElement, 
                false, 
                "El carnet debe tener 10 dígitos: los primeros 8 son tu identificador y los últimos 2 corresponden al año."
            );
            return false;
        }

        if (parseInt(numerosPuros, 10) === 0) {
            asignarUIFeedback(
                inputElement, 
                false, 
                "El número de carnet no es válido. No puede estar compuesto únicamente por ceros."
            );
            return false;
        }

        const match = valor.match(regla.regex);
        if (match) {
            const partes = valor.split('/');
            const anioIngresado = parseInt(partes[1], 10);
            const anioActual = parseInt(new Date().getFullYear().toString().slice(-2), 10);

            if (anioIngresado > anioActual) {
                asignarUIFeedback(
                    inputElement, 
                    false, 
                    `El año indicado (${partes[1]}) es inválido. No puede ser mayor al año actual (${anioActual}).`
                );
                return false;
            }
        } else {
            asignarUIFeedback(inputElement, false, regla.mensaje);
            return false;
        }
    }

    // 3. Expresiones Regulares generales declaradas en el mapa
    if (regla.regex && !regla.regex.test(valor)) {
        asignarUIFeedback(inputElement, false, regla.mensaje);
        return false;
    }

    // 4. Reglas Avanzadas para Campos de Texto Estricto
    if (CAMPOS_ALFABETICOS.includes(id)) {
        if (!validarEstructuraPalabra(valor)) {
            let sujeto = "El texto";
            if (id.includes('nombre')) sujeto = "El nombre";
            if (id.includes('apellido')) sujeto = "El apellido";
            if (id.includes('profesion')) sujeto = "La profesión";
            if (id.includes('legal')) sujeto = "El nombre del contacto legal";
            if (id.includes('referencia-personal')) sujeto = "El nombre del contacto de referencia";

            asignarUIFeedback(inputElement, false, `${sujeto} ingresado contiene una combinación de letras invalida.`);
            return false;
        }

        if (tieneLetrasRepetidasInvalidos(valor)) {
            let identificadorMensaje = "El valor";
            if (id === 'nombre-reg') identificadorMensaje = `El nombre "${valor}"`;
            if (id === 'apellido-reg') identificadorMensaje = `El apellido "${valor}"`;
            if (id === 'profesion-reg') identificadorMensaje = `La profesión "${valor}"`;
            if (id === 'referencia-legal-personal-reg') identificadorMensaje = `La referencia legal "${valor}"`;
            if (id === 'referencia-personal-reg') identificadorMensaje = `La referencia personal "${valor}"`;

            asignarUIFeedback(
                inputElement, 
                false, 
                `${identificadorMensaje} es inválido debido a un exceso de caracteres idénticos seguidos.`
            );
            return false;
        }
    }

    // 5. Reglas Avanzadas para Campos de Dirección
    if (CAMPOS_DIRECCION.includes(id)) {
        let identificadorMensaje = "La dirección";
        if (id === 'direccion-reg') identificadorMensaje = `La dirección personal "${valor}"`;
        if (id === 'direccion-profesion-reg') identificadorMensaje = `La dirección laboral "${valor}"`;

        if (tieneLetrasRepetidasInvalidos(valor)) {
            asignarUIFeedback(
                inputElement, 
                false, 
                `${identificadorMensaje} contiene un error de tipeo. No se permiten más de 2 letras iguales seguidas.`
            );
            return false;
        }

        if (tieneNumerosRepetidosInvalidos(valor)) {
            asignarUIFeedback(
                inputElement, 
                false, 
                `${identificadorMensaje} contiene un número de inmueble inválido. No se permiten más de 4 números idénticos consecutivos.`
            );
            return false;
        }
    }

    // 6. Restricciones matemáticas para la Cédula
    if (id === 'cedula-reg' && regla.minValor) {
        if (parseInt(valor, 10) < regla.minValor) {
            asignarUIFeedback(inputElement, false, `La cédula no puede ser menor a ${regla.minValor.toLocaleString()}.`);
            return false;
        }
    }

    asignarUIFeedback(inputElement, true);
    return true;
}


// ============================================================================
// 6. CAPA VISUAL Y MANIPULACIÓN DEL DOM (Bootstrap UI)
// ============================================================================

function obtenerErrorDivId(inputId) {
    const mapeoErroresDirectos = {
        'num-reg': 'telefono-error',
        'num-prof': 'telefono-profesion-error',
        'num-ref-l': 'telefono-ref-legal-error',
        'num-ref-p': 'telefono-ref-personal-error'
    };

    if (mapeoErroresDirectos[inputId]) {
        return mapeoErroresDirectos[inputId];
    }
    return inputId.replace('-reg', '-error');
}

function asignarUIFeedback(inputElement, esValido, mensaje = "") {
    const errorId = obtenerErrorDivId(inputElement.id);
    const errorDiv = document.getElementById(errorId);

    if (esValido) {
        inputElement.classList.remove('is-invalid');
        inputElement.classList.add('is-valid');
        if (errorDiv) {
            errorDiv.style.display = 'none';
            errorDiv.innerHTML = '';
        }
    } else {
        inputElement.classList.add('is-invalid');
        inputElement.classList.remove('is-valid');
        if (errorDiv) {
            errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${mensaje}`;
            errorDiv.style.display = 'block';
        }
    }
}

function limpiarUIFeedback(inputElement) {
    const errorId = obtenerErrorDivId(inputElement.id);
    const errorDiv = document.getElementById(errorId);

    inputElement.classList.remove('is-invalid', 'is-valid');
    if (errorDiv) {
        errorDiv.style.display = 'none';
        errorDiv.innerHTML = '';
    }
}


// ============================================================================
// 7. CONTROLADOR CENTRAL DE EVENTOS (Orquestador Único del DOM)
// ============================================================================

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('form-registro-lector');
    if (!form) return;

    // Variables de control para el flujo de actualización modal
    const modalUpdate = $("#modalConfirmacionActualizacion"); 
    const btnConfirmarUpdate = document.getElementById("btn-confirmar-update");
    let formularioValidoYProcesado = false; 

    // Limpieza inicial de estilos Material Design para teléfonos
    function removerMaterialFloatingEnTelefonos() {
        document.querySelectorAll('.phone-group').forEach(group => {
            const parentFormGroup = group.closest('.form-group');
            if(parentFormGroup) {
                parentFormGroup.classList.remove('label-floating');
            }
        });
    }
    removerMaterialFloatingEnTelefonos();

    // 1. Inicialización de inputs y asignación de Filtros, Formatos y Eventos directos
    Object.keys(CONFIG_VALIDACION).forEach(id => {
        const inputElement = document.getElementById(id);
        if (!inputElement) return;

        aplicarFiltrosSanitizacion(inputElement);
        normalizarYFormatearCampos(inputElement);

        inputElement.addEventListener('blur', () => validarCampo(inputElement));

        inputElement.addEventListener('input', () => {
            if (inputElement.classList.contains('is-invalid')) {
                validarCampo(inputElement);
            }
        });
    });

    const selectSexo = document.getElementById(CAMPO_SEXO_ID);
    if (selectSexo) {
        selectSexo.addEventListener('change', () => validarCampo(selectSexo));
    }

    // Validación proactiva en caso de campos precargados (edición)
    Object.keys(CONFIG_VALIDACION).forEach(id => {
        const el = document.getElementById(id);
        if (el && el.value.trim() !== "") validarCampo(el);
    });


    // 2. Procesamiento y sincronización continua de Teléfonos
    function procesarTelefonos() {
        const tiposTel = [
            { pref: 'pref-reg', num: 'num-reg', hidden: 'telefono-reg' },
            { pref: 'pref-prof', num: 'num-prof', hidden: 'telefono-profesion-reg' },
            { pref: 'pref-ref-l', num: 'num-ref-l', hidden: 'telefono-ref-legal-reg' },
            { pref: 'pref-ref-p', num: 'num-ref-p', hidden: 'telefono-ref-personal-reg' }
        ];

        tiposTel.forEach(tel => {
            const prefEl = document.getElementById(tel.pref);
            const numEl = document.getElementById(tel.num);
            const hiddenEl = document.getElementById(tel.hidden);

            if (prefEl && numEl && hiddenEl) {
                const numVal = numEl.value.trim();
                if (numVal.length === 7) {
                    hiddenEl.value = prefEl.value + numVal; // 11 dígitos limpios
                } else {
                    hiddenEl.value = ""; 
                }
            }
        });
    }


    // 3. Evaluación de Cambios en tiempo real para la Ventana Modal
    function evaluarYMostrarCambios() {
        const campos = [
            { id: 'carnet-reg', label: 'N° de Carnet' },
            { id: 'cedula-reg', label: 'Cédula' },
            { id: 'nombre-reg', label: 'Nombres' },
            { id: 'apellido-reg', label: 'Apellidos' },
            { id: 'sexo-reg', label: 'Sexo', mapear: val => val === 'm' ? 'Masculino' : 'Femenino' },
            { id: 'direccion-reg', label: 'Dirección' },
            { id: 'telefono-reg', label: 'Teléfono Personal' },
            { id: 'profesion-reg', label: 'Profesión' },
            { id: 'direccion-profesion-reg', label: 'Dirección Laboral' },
            { id: 'telefono-profesion-reg', label: 'Teléfono Profesión' },
            { id: 'referencia-legal-personal-reg', label: 'Referencia Legal' },
            { id: 'telefono-ref-legal-reg', label: 'Teléfono Ref. Legal' },
            { id: 'referencia-personal-reg', label: 'Referencia Personal' },
            { id: 'telefono-ref-personal-reg', label: 'Teléfono Ref. Personal' }
        ];

        let cambiosHtml = `
            <table class="table table-bordered table-striped table-cambios">
                <thead>
                    <tr>
                        <th>Campo Modificado</th>
                        <th>Valor Anterior</th>
                        <th>Valor Nuevo</th>
                    </tr>
                </thead>
                <tbody>`;
        
        let contadorCambios = 0;

        campos.forEach(campo => {
            const el = document.getElementById(campo.id);
            if (!el) return;

            let valorOriginal = (el.getAttribute('data-original') || '').trim();
            let valorActual = el.value.trim();

            if (valorOriginal !== valorActual) {
                contadorCambios++;
                
                if (campo.mapear) {
                    valorOriginal = campo.mapear(valorOriginal);
                    valorActual = campo.mapear(valorActual);
                }

                const vOrigText = valorOriginal === "" ? '<i class="text-muted">Ninguno</i>' : valorOriginal;
                const vActText = valorActual === "" ? '<i class="text-muted">Eliminado</i>' : valorActual;

                cambiosHtml += `
                    <tr>
                        <td><strong>${campo.label}</strong></td>
                        <td class="text-old">${vOrigText}</td>
                        <td class="text-new">${vActText}</td>
                    </tr>`;
            }
        });

        cambiosHtml += `</tbody></table>`;

        const contenedor = document.getElementById("resumen-cambios-lector");
        const descripcion = document.getElementById("modal-descripcion-cambios");

        if (contadorCambios > 0) {
            if (descripcion) descripcion.innerHTML = `Se detectaron <strong>${contadorCambios}</strong> modificación(es). Por favor verifique el resumen antes de procesar:`;
            if (contenedor) contenedor.innerHTML = cambiosHtml;
            if (btnConfirmarUpdate) btnConfirmarUpdate.style.display = "inline-block";
        } else {
            if (descripcion) descripcion.innerHTML = `<span class="text-warning"><i class="fas fa-info-circle"></i> No has realizado ningún cambio en los datos del lector.</span>`;
            if (contenedor) contenedor.innerHTML = "";
            if (btnConfirmarUpdate) btnConfirmarUpdate.style.display = "none";
        }
    }


    // ========================================================================
    // INTERCEPCIÓN E INTEGRACIÓN DEL EVENTO SUBMIT (Inserción / Actualización)
    // ========================================================================
    form.addEventListener('submit', (evt) => {
        if (formularioValidoYProcesado) {
            return; // Permite el envío nativo definitivo si el modal dio luz verde
        }

        evt.preventDefault(); // Frenamos temporalmente para validar
        procesarTelefonos(); // Sincroniza combos y entradas telefónicas

        // Disparamos el Motor Central de validación sobre todos los campos configurados
        let formularioValido = true;
        Object.keys(CONFIG_VALIDACION).forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                const resultado = validarCampo(el);
                if (!resultado) formularioValido = false;
            }
        });

        // En caso de fallar, SweetAlert detiene el proceso de inmediato
        if (!formularioValido) {
            swal({ 
                title: "¡Formulario Incompleto!", 
                text: "Por favor, revise y corrija los campos resaltados en rojo.", 
                type: "error" 
            });
            return;
        }

        // Si el formulario es totalmente válido y existe la estructura modal de Modificación...
        if (modalUpdate.length > 0) {
            evaluarYMostrarCambios();
            modalUpdate.modal('show');
        } else {
            // Si no es un formulario de edición (no existe modal), se asume inserción directa y limpia
            formularioValidoYProcesado = true;
            form.submit();
        }
    });

    // Evento de confirmación definitivo del Modal (Luz verde)
    if (btnConfirmarUpdate) {
        btnConfirmarUpdate.addEventListener("click", function() {
            formularioValidoYProcesado = true; 
            modalUpdate.modal('hide');
            form.submit(); 
        });
    }
});