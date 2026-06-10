/**
 * --- CONTROLADORES DE INTERFAZ DE USUARIO (SALA, ÁREA Y OBSERVACIONES) ---
 */

document.addEventListener("DOMContentLoaded", function () {
    // Selectores de SALA
    const itemsSala = document.querySelectorAll(`#dropdown-sala li a`);
    const salaHidden = document.getElementById('salaSelect');
    const salaDisplay = document.getElementById('sala-display');
    const salaError = document.getElementById('sala-error'); 
    
    // Selectores de ÁREA
    const areaSelect = document.getElementById('areaSelect');
    const areaDisplayContainer = document.getElementById('area-display-container');
    const labelArea = document.getElementById('label-area');
    const areaTextContent = document.getElementById('area-text-content');
    const areaError = document.getElementById('area-error');
    const dropdownAreaMenu = document.getElementById('dropdown-area');

    // INTEGRACIÓN: Selectores de DESCRIPCIÓN / OBSERVACIONES
    const observacionesInput = document.getElementById('observaciones-reg');
    const observacionesError = document.getElementById('observaciones-error');

    // Variable de control para los 2 segundos del mensaje
    let timeoutMensajeArea = null;

    /**
     * Comprueba si un selector oculto está vacío y gestiona dinámicamente las clases de error nativas
     */
    function validarCampoObligatorio(inputOculto, elementoError, mensajeTexto) {
        if (!inputOculto) return true;

        const formGroup = inputOculto.closest('.form-group');

        if (inputOculto.disabled) {
            if (elementoError) elementoError.style.display = 'none';
            if (formGroup) formGroup.classList.remove('has-error', 'is-invalid');
            inputOculto.setCustomValidity('');
            return true;
        }

        if (inputOculto.value.trim() === "") {
            if (elementoError) {
                elementoError.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${mensajeTexto}`;
                elementoError.style.display = 'block';
            }
            if (formGroup) {
                formGroup.classList.add('has-error');
            }
            inputOculto.setCustomValidity(mensajeTexto);
            return false;
        } else {
            if (elementoError) {
                elementoError.style.display = 'none';
                elementoError.innerHTML = '';
            }
            if (formGroup) {
                formGroup.classList.remove('has-error', 'is-invalid');
            }
            inputOculto.setCustomValidity('');
            return true;
        }
    }

    /**
     * INTEGRACIÓN: Valida la estructura y caracteres permitidos en la Descripción
     */
    function validarDescripcion(inputElement, elementoError) {
        if (!inputElement) return true;

        const formGroup = inputElement.closest('.form-group');
        const valor = inputElement.value.trim();
        
        // Expresión regular institucional: Letras, números, espacios y signos de puntuación básicos
        const regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s\.,;:\-]+$/;

        if (valor !== "") {
            if (!regex.test(valor)) {
                const mensajeError = "Contiene caracteres no permitidos (solo se admiten letras, números y puntuación básica).";
                
                if (elementoError) {
                    elementoError.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${mensajeError}`;
                    elementoError.style.display = 'block';
                }
                if (formGroup) {
                    formGroup.classList.add('has-error');
                }
                inputElement.setCustomValidity(mensajeError);
                return false;
            }
        }

        // Si el campo está vacío (es opcional) o si pasa el patrón Regex con éxito
        if (elementoError) {
            elementoError.style.display = 'none';
            elementoError.innerHTML = '';
        }
        if (formGroup) {
            formGroup.classList.remove('has-error', 'is-invalid');
        }
        inputElement.setCustomValidity('');
        return true;
    }

    /**
     * Sincroniza los estados lógicos y visuales del Área Infantil (Código 'X')
     */
    function gestionarEstadoArea(valorSala) {
        const formGroupArea = areaDisplayContainer ? areaDisplayContainer.closest('.form-group') : null;

        if (timeoutMensajeArea) clearTimeout(timeoutMensajeArea);
        if (areaError) {
            areaError.style.display = 'none';
            areaError.innerHTML = '';
        }
        if (formGroupArea) {
            formGroupArea.classList.remove('has-error', 'is-invalid');
        }

        if (valorSala === "X") {
            if (areaDisplayContainer) areaDisplayContainer.style.opacity = "1";
            if (areaSelect) {
                areaSelect.disabled = false;
                areaSelect.required = true;
            }
            
            if (dropdownAreaMenu) {
                dropdownAreaMenu.style.setProperty('display', '', 'important');
                dropdownAreaMenu.style.pointerEvents = "auto";
            }

            if (formGroupArea) {
                if (areaSelect && areaSelect.value !== "") {
                    formGroupArea.classList.remove('is-empty');
                } else {
                    formGroupArea.classList.add('is-empty');
                }
            }
            
            if (labelArea && !labelArea.querySelector('.text-danger')) {
                const span = document.createElement('span');
                span.className = 'text-danger';
                span.textContent = '* ';
                labelArea.prepend(span);
            }
        } else {
            if (areaDisplayContainer) areaDisplayContainer.style.opacity = "0.5";
            if (areaSelect) {
                areaSelect.disabled = true;
                areaSelect.required = false;
                areaSelect.value = ""; 
                areaSelect.setCustomValidity(''); 
            }
            
            if (dropdownAreaMenu) {
                dropdownAreaMenu.style.setProperty('display', 'none', 'important');
                dropdownAreaMenu.style.pointerEvents = "none";
            }

            if (areaTextContent) {
                areaTextContent.innerHTML = "&nbsp;"; 
            }
            
            if (formGroupArea) {
                formGroupArea.classList.add('is-empty');
            }
            
            if (labelArea) {
                const asterisk = labelArea.querySelector('.text-danger');
                if (asterisk) asterisk.remove();
            }
        }
    }

    /**
     * Muestra el mensaje de error usando las clases nativas de la plantilla por 2 segundos
     */
    function mostrarAdvertenciaTemporal() {
        if (!areaError) return;
        const formGroupArea = areaDisplayContainer ? areaDisplayContainer.closest('.form-group') : null;

        if (timeoutMensajeArea) clearTimeout(timeoutMensajeArea);

        areaError.innerHTML = `<i class="fas fa-info-circle"></i> Para seleccionar un área, la sala debe ser "Infantil".`;
        areaError.style.display = 'block';

        if (formGroupArea) {
            formGroupArea.classList.add('has-error');
        }

        timeoutMensajeArea = setTimeout(() => {
            areaError.style.display = 'none';
            areaError.innerHTML = '';
            if (formGroupArea) {
                formGroupArea.classList.remove('has-error');
            }
            validarCampoObligatorio(areaSelect, areaError, "El área infantil es un campo obligatorio.");
        }, 2000);
    }

    // Cambiar la SALA
    itemsSala.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const valor = this.getAttribute('data-value');
            
            if (salaDisplay) salaDisplay.value = valor;
            if (salaHidden) salaHidden.value = valor;
            
            const formGroupSala = salaDisplay ? salaDisplay.closest('.form-group') : null;
            if (formGroupSala) {
                formGroupSala.classList.remove('is-empty');
            }
            
            validarCampoObligatorio(salaHidden, salaError, "La sala es un campo obligatorio.");
            gestionarEstadoArea(valor);

            if (valor === "X") {
                validarCampoObligatorio(areaSelect, areaError, "El área infantil es un campo obligatorio.");
            }
        });
    });

    // Seleccionar una opción de ÁREA INFANTIL
    const itemsArea = document.querySelectorAll(`#dropdown-area li a`);
    itemsArea.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            if (areaSelect && areaSelect.disabled) return;

            const valorReal = this.getAttribute('data-value');
            if (areaTextContent) areaTextContent.innerHTML = this.innerHTML;
            if (areaSelect) areaSelect.value = valorReal;
            
            const formGroupArea = areaDisplayContainer ? areaDisplayContainer.closest('.form-group') : null;
            if (formGroupArea) {
                formGroupArea.classList.remove('is-empty');
            }

            validarCampoObligatorio(areaSelect, areaError, "El área infantil es un campo obligatorio.");
        });
    });

    /**
     * Interceptamos el click en el área deshabilitada
     */
    if (areaDisplayContainer) {
        areaDisplayContainer.addEventListener('click', function (e) {
            const salaActual = salaHidden ? salaHidden.value : "";
            if (salaActual !== "X") {
                e.preventDefault();
                mostrarAdvertenciaTemporal();
            }
        });
    }

    // INTEGRACIÓN: Escuchadores en tiempo real para la Descripción
    if (observacionesInput) {
        observacionesInput.addEventListener('input', function () {
            validarDescripcion(observacionesInput, observacionesError);
        });
        observacionesInput.addEventListener('blur', function () {
            validarDescripcion(observacionesInput, observacionesError);
        });
    }

    // --- INTERCEPCIÓN DE SEGURIDAD EN EL ENVÍO (SUBMIT) ---
    const formulario = salaHidden ? salaHidden.closest('form') : null;
    if (formulario) {
        formulario.addEventListener('submit', function (e) {
            // Ejecutar todas las validaciones lógicas
            const salaValida = validarCampoObligatorio(salaHidden, salaError, "La sala es un campo obligatorio.");
            const areaValida = validarCampoObligatorio(areaSelect, areaError, "El área infantil es un campo obligatorio.");
            const descripcionValida = validarDescripcion(observacionesInput, observacionesError);

            // Si alguna de las tres falla, frenamos en seco el flujo de guardado o la apertura del modal
            if (!salaValida || !areaValida || !descripcionValida) {
                e.preventDefault();
                e.stopPropagation();

                // Scroll fluido automático al primer contenedor con la clase de error para guiar al usuario
                const primerError = document.querySelector('.has-error');
                if (primerError) {
                    primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    }

    // Carga inicial (Para edición de registros existentes)
    if (salaHidden) {
        gestionarEstadoArea(salaHidden.value);
        if (salaHidden.value !== "") {
            validarCampoObligatorio(salaHidden, salaError, "La sala es un campo obligatorio.");
        }
    }
    // Evaluación inicial de la descripción si ya posee contenido al cargar la página
    if (observacionesInput && observacionesInput.value.trim() !== "") {
        validarDescripcion(observacionesInput, observacionesError);
    }
});