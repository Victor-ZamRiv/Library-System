$(document).ready(function() {
    // --- CONFIGURACIÓN Y CONSTANTES ---
    const CARNET_REGEX = /^[0-9]{8}\/[0-9]{2}$/;
    const MAX_LENGTH_COTA = 30;
    const COTA_REGEX = /^(?:[A-Za-z]{1,2}\s[A-Za-z0-9]{1,4}|\d{3}.*\s[A-Za-z0-9]{4})$/;
    const $carnetInput = $('#carnet-reg');
    const cotasSelectors = ['#libro1', '#libro2', '#libro3'];

    // --- 1. VALIDACIÓN EN TIEMPO REAL CON MÁSCARA FLUIDA (CARNET) ---
    
    $carnetInput.on('input', function() {
        // Extraer únicamente los dígitos ingresados
        let soloNumeros = $(this).val().replace(/[^0-9]/g, '');
        
        // Limitar la entrada estricta a 10 dígitos numéricos
        if (soloNumeros.length > 10) {
            soloNumeros = soloNumeros.substring(0, 10);
        }

        // Construcción dinámica de la máscara física en el input
        if (soloNumeros.length > 8) {
            // Toma los primeros 8 números, inyecta la barra y concatena el resto (máximo 2 más)
            $(this).val(soloNumeros.substring(0, 8) + '/' + soloNumeros.substring(8));
        } else {
            $(this).val(soloNumeros);
        }

        // Validación visual inmediata al completar los 10 dígitos requeridos
        if (soloNumeros.length === 10) {
            validarCarnetCompleto($(this));
        } else {
            // Mientras no esté completo, mantenemos el estado neutral si no ha salido del input
            $(this).removeClass('is-valid is-invalid');
            $('#carnet-error').hide();
        }
    });

    // Evento al perder el foco (blur): Asegura la consistencia estructural del dato
    $carnetInput.on('blur', function() {
        let valor = $(this).val().trim();
        
        if (valor === "") {
            $(this).removeClass('is-valid is-invalid');
            $('#carnet-error').hide();
            deshabilitarTodosLosLibros();
            return;
        }

        // Re-evaluar por completo las reglas semánticas y de negocio
        validarCarnetCompleto($(this));
    });

    // Función centralizada para evaluar las reglas del negocio del Carnet
    function validarCarnetCompleto($input) {
        const valor = $input.val().trim();
        const numerosPuros = valor.replace('/', '');
        const $errorDiv = $('#carnet-error');
        let mensajeError = "";

        if (numerosPuros.length < 10) {
            mensajeError = "El carnet debe tener exactamente 10 dígitos (8 identificadores / 2 del año).";
        } else if (parseInt(numerosPuros, 10) === 0) {
            mensajeError = "El número de carnet no es válido. No puede estar compuesto únicamente por ceros.";
        } else {
            const match = valor.match(CARNET_REGEX);
            if (match) {
                const partes = valor.split('/');
                const anioIngresado = parseInt(partes[1], 10);
                const anioActual = parseInt(new Date().getFullYear().toString().slice(-2), 10);

                if (anioIngresado > anioActual) {
                    mensajeError = `El año indicado (${partes[1]}) es inválido. No puede ser mayor al año actual (${anioActual}).`;
                }
            } else {
                mensajeError = "Formato requerido: 8 números seguidos de los 2 dígitos del año (Ej: 00123456/26)";
            }
        }

        // Manejo del estado visual en la UI aplicando clases de Bootstrap
        if (mensajeError !== "") {
            $input.addClass('is-invalid').removeClass('is-valid');
            if ($errorDiv.length) {
                $errorDiv.html(`<i class="fas fa-exclamation-circle"></i> ${mensajeError}`).show();
            }
            deshabilitarTodosLosLibros();
            return false;
        } else {
            $input.addClass('is-valid').removeClass('is-invalid');
            $errorDiv.hide();
            // Habilita el flujo secuencial de cotas
            $('#libro1').prop('disabled', false);
            return true;
        }
    }

    function deshabilitarTodosLosLibros() {
        $('.cota-input').each(function() {
            $(this).prop('disabled', true).val('').removeClass('is-valid is-invalid');
            $('#error-' + $(this).attr('id')).hide();
        });
    }

    // --- 2. VALIDACIÓN EN TIEMPO REAL (COTAS) ---

    window.validarCota = function(inputElement) {
        const $input = $(inputElement);
        const $errorDisplay = $('#error-' + $input.attr('id'));
        const valor = $input.val().trim();
        let mensajeError = '';

        if ($input.prop('required') && valor === "") {
            mensajeError = 'Campo requerido.';
        } else if (valor.length > 0) {
            if (valor.length > MAX_LENGTH_COTA) {
                mensajeError = `Máximo ${MAX_LENGTH_COTA} caracteres.`;
            } else if (!COTA_REGEX.test(valor)) {
                mensajeError = 'Formato incorrecto (Ej: NH H234).';
            }
        }

        if (mensajeError !== '') {
            $input.addClass('is-invalid').removeClass('is-valid');
            $errorDisplay.html(`<i class="fas fa-exclamation-circle"></i> ${mensajeError}`).show();
        } else {
            $input.removeClass('is-invalid');
            if (valor !== "") $input.addClass('is-valid');
            $errorDisplay.hide();
        }

        gestionarBloqueoSecuencial();
    };

    function gestionarBloqueoSecuencial() {
        cotasSelectors.forEach((selector, index) => {
            const $el = $(selector);
            if (index < cotasSelectors.length - 1) {
                const $siguiente = $(cotasSelectors[index + 1]);
                const esValido = $el.val() !== "" && $el.hasClass('is-valid');
                
                $siguiente.prop('disabled', !esValido);
                if (!esValido) {
                    $siguiente.val('').removeClass('is-valid is-invalid');
                    $('#error-' + $siguiente.attr('id')).hide();
                }
            }
        });
    }

    // --- 3. LÓGICA DE ENVÍO Y PRÉSTAMO (AJAX) ---

    $('form').on('submit', function(e) {
        e.preventDefault();

        if (!validarCarnetCompleto($carnetInput)) {
            mostrarError('carnet', 'Por favor, corrija el formato del carnet.');
            return;
        }

        const carnet = $carnetInput.val().trim();
        let inputsValidos = true;

        // Comprobación visual previa
        $('.cota-input').each(function() {
            if ($(this).val().trim() !== "" && $(this).hasClass('is-invalid')) {
                inputsValidos = false;
            }
        });

        // Contar cotas reales escritas
        const totalCotas = $('.cota-input').filter(function() {
            return $(this).val().trim() !== "";
        }).length;

        if (totalCotas === 0 || !inputsValidos) {
            alert('Debe ingresar al menos una cota válida y corregir los errores.');
            return;
        }

        const $btn = $('button[type="submit"]');
        const originalText = $btn.text();
        $btn.text('Validando...').prop('disabled', true);

        // AJAX 1: Validar Lector
        $.ajax({
            url: BASE_URL + '/prestamos/check-lector',
            type: 'POST',
            data: { carnet: carnet },
            dataType: 'json',
            success: function(resLector) {
                if (!resLector.success) {
                    restaurarBoton($btn, originalText);
                    mostrarError('carnet', resLector.message);
                    return;
                }

                const lectorData = {
                    id: resLector.idLector,
                    nombre: resLector.nombreCompleto,
                    prestamosActivos: resLector.prestamosActivos,
                    limite: resLector.limite
                };

                // AJAX 2: Modificado para mapear directamente los objetos Input del DOM
                let librosData = [];
                let erroresContados = 0;

                let peticiones = $('.cota-input').filter(function() {
                    return $(this).val().trim() !== "";
                }).map(function() {
                    const $currentInput = $(this);
                    const cotaValor = $currentInput.val().trim();
                    const inputId = $currentInput.attr('id');

                    return $.ajax({
                        url: BASE_URL + '/prestamos/check-libro',
                        type: 'POST',
                        data: { cota: cotaValor },
                        dataType: 'json'
                    }).done(resLibro => {
                        if (resLibro.success) {
                            $currentInput.addClass('is-valid').removeClass('is-invalid');
                            $('#error-' + inputId).hide();

                            librosData.push({
                                cota: cotaValor,
                                titulo: resLibro.titulo,
                                ejemplares: resLibro.ejemplares
                            });
                        } else {
                            // AQUÍ SE MUESTRA ABAJO: En vez de un alert, inyectamos la alerta rosada usando tu div de error
                            $currentInput.addClass('is-invalid').removeClass('is-valid');
                            $('#error-' + inputId).html(`<i class="fas fa-exclamation-circle"></i> ${resLibro.message}`).show();
                            erroresContados++;
                        }
                    }).fail(() => {
                        $currentInput.addClass('is-invalid').removeClass('is-valid');
                        $('#error-' + inputId).html(`<i class="fas fa-exclamation-circle"></i> Error de conexión al validar la cota.`).show();
                        erroresContados++;
                    });
                }).get();

                // Esperamos que terminen todas las peticiones asíncronas de los libros
                $.when.apply($, peticiones).always(function() {
                    // Restauramos el botón "Siguiente" para que no se quede congelado en "VALIDANDO..."
                    restaurarBoton($btn, originalText);

                    if (erroresContados > 0) {
                        gestionarBloqueoSecuencial();
                    } else {
                        mostrarSegundoPaso(lectorData, librosData, $btn, originalText);
                    }
                });
            },
            error: function() {
                restaurarBoton($btn, originalText);
                alert('Error de comunicación con el servidor al validar el lector.');
            }
        });
    });

    // --- 4. MODAL Y REGISTRO FINAL ---

    function mostrarSegundoPaso(lector, libros, $btn, texto) {
        let formHtml = `
            <form id="formRegistroPrestamo" method="POST" action="${BASE_URL}/prestamos/store">
                <input type="hidden" name="idLector" value="${lector.id}">
        `;

        libros.forEach((lib, i) => {
            formHtml += `
                <div class="form-group">
                    <label>Libro ${i+1}: ${lib.titulo} (Cota: ${lib.cota})</label>
                    <select class="form-control" name="ids_ejemplares[]" required>
                        <option value="">Seleccione un ejemplar...</option>
                        ${lib.ejemplares.map(ej => `<option value="${ej.id}">Ejemplar #${ej.numero}</option>`).join('')}
                    </select>
                </div>
            `;
        });

        formHtml += `
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar Préstamo</button>
                </div>
            </form>
        `;

        const modalHtml = `
            <div class="modal fade" id="modalConfirmarPrestamo" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirmar Préstamo</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Lector:</strong> ${lector.nombre} <br>
                            <small>Préstamos activos: ${lector.prestamosActivos}/${lector.limite}</small></p>
                            <hr>
                            ${formHtml}
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('#modalConfirmarPrestamo').remove();
        $('body').append(modalHtml);
        $('#modalConfirmarPrestamo').modal('show');

        restaurarBoton($btn, texto);
    }

    function mostrarError(campoId, mensaje) {
        let $errorDiv = (campoId === 'carnet') ? $('#carnet-error') : $('#error-' + campoId);
        $errorDiv.html(`<i class="fas fa-exclamation-circle"></i> ${mensaje}`).show();
        setTimeout(() => $errorDiv.fadeOut(), 6000);
    }

    function restaurarBoton($btn, texto) {
        $btn.text(texto).prop('disabled', false);
    }
});