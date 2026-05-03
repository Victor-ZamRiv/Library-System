$(document).ready(function() {
    // --- CONFIGURACIÓN Y CONSTANTES ---
    const LONGITUD_CARNET = 10;
    const MAX_LENGTH_COTA = 30;
    const COTA_REGEX = /^(?:[A-Za-z]{1,2}\s[A-Za-z0-9]{1,4}|\d{3}.*\s[A-Za-z0-9]{4})$/;
    const $carnetInput = $('#carnet-reg');
    const cotasSelectors = ['#libro1', '#libro2', '#libro3'];

    // --- 1. VALIDACIÓN EN TIEMPO REAL (CARNET) ---
    
    // Restricción: Solo números
    $carnetInput.on('keypress', function(evt) {
        const charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) evt.preventDefault();
    });

    $carnetInput.on('input blur', function() {
        let valor = $(this).val().replace(/[^0-9]/g, '');
        $(this).val(valor);
        
        const esValido = valor.length === LONGITUD_CARNET;
        const $errorDiv = $('#carnet-error');

        if (esValido) {
            $(this).addClass('is-valid').removeClass('is-invalid');
            $errorDiv.hide();
            $('#libro1').prop('disabled', false);
        } else {
            $(this).addClass('is-invalid').removeClass('is-valid');
            if ($errorDiv.length) {
                $errorDiv.html(`<i class="fas fa-exclamation-circle"></i> El carnet debe tener exactamente ${LONGITUD_CARNET} dígitos.`).show();
            }
            deshabilitarTodosLosLibros();
        }
    });

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

        // Aplicar estado visual
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

    const carnet = $carnetInput.val().trim();
    
    if (carnet.length !== LONGITUD_CARNET) {
        mostrarError('carnet', 'Carnet inválido.');
        return;
    }

    let cotasIngresadas = [];
    let inputsValidos = true;

    // Solo tomamos las cotas de inputs que no están vacíos
    $('.cota-input').each(function() {
        const val = $(this).val().trim();
        if (val !== "") {
            if ($(this).hasClass('is-invalid')) {
                inputsValidos = false;
            } else {
                cotasIngresadas.push(val);
            }
        }
    });

    if (cotasIngresadas.length === 0 || !inputsValidos) {
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

            // AJAX 2: Validar cada cota

        let librosData = [];
        let erroresLibros = [];

        let peticiones = cotasIngresadas.map((cota, idx) => {
            return $.ajax({
                url: BASE_URL + '/prestamos/check-libro',
                type: 'POST',
                data: { cota: cota },
                dataType: 'json'
            }).done(resLibro => {
                if (resLibro.success) {
                    librosData.push({
                        cota: cota,
                        titulo: resLibro.titulo,
                        ejemplares: resLibro.ejemplares
                    });
                } else {
                    erroresLibros.push(`Libro "${cota}": ${resLibro.message}`);
                }
            }).fail((jqXHR, textStatus) => {
                erroresLibros.push(`Error de conexión al validar la cota: ${cota}`);
            });
        });

        // Esperar a que todas terminen
        $.when.apply($, peticiones).always(function() {
            if (erroresLibros.length > 0) {
                restaurarBoton($btn, originalText);
                alert("Errores encontrados:\n" + erroresLibros.join('\n'));
            } else {
                mostrarSegundoPaso(lectorData, librosData, $btn, originalText);
            }
        });
    }
    });

    // --- 4. MODAL Y REGISTRO FINAL ---

    function mostrarSegundoPaso(lector, libros, $btn, texto) {
        // Construir el formulario dinámicamente
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

        // Insertar el formulario dentro del body del modal
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

        // Eliminar modal existente si lo hay
        $('#modalConfirmarPrestamo').remove();
        $('body').append(modalHtml);

        // Mostrar modal
        $('#modalConfirmarPrestamo').modal('show');

        // Restaurar el botón "Siguiente"
        restaurarBoton($btn, texto);
    }

    // Funciones auxiliares
    function mostrarError(campoId, mensaje) {
        let $errorDiv = (campoId === 'carnet') ? $('#carnet-error') : $('#error-' + campoId);
        $errorDiv.text(mensaje).show();
        setTimeout(() => $errorDiv.fadeOut(), 5000);
    }

    function restaurarBoton($btn, texto) {
        $btn.text(texto).prop('disabled', false);
    }
    });
});