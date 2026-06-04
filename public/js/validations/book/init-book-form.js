/**
 * --- CONTROLADORES DE INTERFAZ DE USUARIO (SALA Y ÁREA) ---
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
    const dropdownAreaMenu = document.getElementById('dropdown-area');

    // Variable de control para los 2 segundos del mensaje
    let timeoutMensajeArea = null;

    /**
     * Sincroniza los estados lógicos y visuales del Área Infantil (Código 'X')
     */
    function gestionarEstadoArea(valorSala) {
        const formGroupArea = areaDisplayContainer ? areaDisplayContainer.closest('.form-group') : null;

        // Limpiar cualquier alerta previa al cambiar de sala
        if (timeoutMensajeArea) clearTimeout(timeoutMensajeArea);
        if (areaError) {
            areaError.style.display = 'none';
            areaError.innerHTML = '';
        }
        if (formGroupArea) {
            formGroupArea.classList.remove('has-error', 'is-invalid');
        }

        if (valorSala === "X") {
            // === CASO: SALA INFANTIL (HABILITAR) ===
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
            
            // Añadir asterisco (*) obligatorio
            if (labelArea && !labelArea.querySelector('.text-danger')) {
                const span = document.createElement('span');
                span.className = 'text-danger';
                span.textContent = '* ';
                labelArea.prepend(span);
            }
        } else {
            // === CASO: OTRAS SALAS (BLOQUEAR COMPLETAMENTE) ===
            if (areaDisplayContainer) areaDisplayContainer.style.opacity = "0.5";
            if (areaSelect) {
                areaSelect.disabled = true;
                areaSelect.required = false;
                areaSelect.value = ""; 
            }
            
            if (dropdownAreaMenu) {
                dropdownAreaMenu.style.setProperty('display', 'none', 'important');
                dropdownAreaMenu.style.pointerEvents = "none";
            }

            // Espacio vacío para que el label baje sin sobreponerse
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

        // Reiniciar el temporizador si vuelven a clickear
        if (timeoutMensajeArea) clearTimeout(timeoutMensajeArea);

        // Inyectar el texto en tu div nativo #area-error
        areaError.innerHTML = `<i class="fas fa-info-circle"></i> Para seleccionar un área, la sala debe ser "Infantil".`;
        areaError.style.display = 'block';

        // Forzar a la plantilla a pintar el estado de error (igual que en la cédula)
        if (formGroupArea) {
            formGroupArea.classList.add('has-error');
        }

        // Remover el mensaje y el estado de error exactamente a los 2 segundos
        timeoutMensajeArea = setTimeout(() => {
            areaError.style.display = 'none';
            areaError.innerHTML = '';
            if (formGroupArea) {
                formGroupArea.classList.remove('has-error');
            }
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
            
            gestionarEstadoArea(valor);
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
        });
    });

    /**
     * Interceptamos el click en el área deshabilitada
     * Quitamos el stopPropagation para dejar que los estilos se apliquen fluidamente
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

    // Carga inicial
    if (salaHidden) {
        gestionarEstadoArea(salaHidden.value);
    }
});