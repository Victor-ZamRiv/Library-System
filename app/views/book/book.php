<!DOCTYPE html>
<html lang="es">
<title>Nuevo Libro</title>
<style>
    .visually-hidden {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
        /* Esto es clave: permite que el navegador lo encuentre pero no lo muestre */
        opacity: 0;
        pointer-events: none;
    }
</style>

<?php include VIEW_PATH . '/component/heat.php'; ?>

<body>

    <?php include VIEW_PATH . '/component/sidebar.php'; ?>

    <!-- Content page-->
    <section class="full-box dashboard-contentPage">

        <!-- NavBar -->
        <?php include VIEW_PATH . '/component/navbar.php'; ?>

        <!-- Content page -->
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-book"></i> Nuevo Libro</h1>
            </div>
        </div>

        <div class="container-fluid">

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">&nbsp; REGISTRAR NUEVO LIBRO</h3>
                </div>
                <div class="panel-body">
                    <form action="<?php if (isset($libro)) {
                                        echo '/library_system/libros/nueva-edicion/store';
                                    } else {
                                        echo '/library_system/libros';
                                    } ?>" method="POST" enctype="multipart/form-data" id="form-registro-libro">
                        <fieldset>
                            <legend> &nbsp; Información del Libro</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Sala <i class="fa-solid fa-angle-down"></i></label>
                                            <div class="dropdown">
                                                <input type="text"
                                                    id="sala-display"
                                                    class="form-control"
                                                    readonly
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"
                                                    style="cursor: pointer; background-color: transparent;"
                                                    placeholder="Seleccione una sala">
                                                <ul class="dropdown-menu" id="dropdown-sala" style="width: 100%;">
                                                    <li><a href="#!" data-value="G">Sala General</a></li>
                                                    <li><a href="#!" data-value="R">Sala de Referencia</a></li>
                                                    <li><a href="#!" data-value="SE">Sala Estatal</a></li>
                                                    <li><a href="#!" data-value="X">Sala Infantil</a></li>
                                                </ul>
                                            </div>
                                            <!-- Campo oculto -->
                                            <input type="text" name="sala-reg" id="salaSelect" class="visually-hidden" required>
                                            <!-- Mensaje de error -->
                                            <div class="invalid-feedback bg-danger text-danger p-1 rounded" id="sala-error" style="display: none; margin-top: 5px;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, seleccione una sala.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" id="label-area">Área infantil <span class="text-danger" id="asterisk-area" style="display: none;">*</span> <i class="fa-solid fa-angle-down"></i></label>
                                            <div class="dropdown">
                                                <div id="area-display-container"
                                                    class="form-control"
                                                    data-toggle="dropdown"
                                                    style="cursor: pointer; height: 34px; padding-top: 7px; pointer-events: none; opacity: 0.5;"
                                                    placeholder="Seleccione un área">
                                                    <span id="area-text-content">Seleccione un área infantil</span>
                                                </div>
                                                <ul class="dropdown-menu" id="dropdown-area" style="width: 100%;">
                                                    <li>
                                                        <a href="#!" data-value="Cuento infantil">
                                                            <span style="height: 10px; width: 10px; background-color: #e91e63; display: inline-block; border-radius: 50%; margin-right: 4px;"></span>
                                                            <span style="height: 10px; width: 10px; background-color: #9c27b0; display: inline-block; border-radius: 50%; margin-right: 8px;"></span>
                                                            Cuento infantil
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#!" data-value="Educativo">
                                                            <span style="height: 10px; width: 10px; background-color: #00bcd4; display: inline-block; border-radius: 50%; margin-right: 4px;"></span>
                                                            <span style="height: 10px; width: 10px; background-color: #4caf50; display: inline-block; border-radius: 50%; margin-right: 8px;"></span>
                                                            Educativo
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#!" data-value="Ficción juvenil">
                                                            <span style="height: 10px; width: 10px; background-color: #ff9800; display: inline-block; border-radius: 50%; margin-right: 4px;"></span>
                                                            <span style="height: 10px; width: 10px; background-color: #ff5722; display: inline-block; border-radius: 50%; margin-right: 8px;"></span>
                                                            Ficción juvenil
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- Campo oculto -->
                                            <input type="text" name="area-reg" id="areaSelect" class="visually-hidden">
                                            <!-- Mensaje de error -->
                                            <div class="invalid-feedback bg-danger text-danger p-1 rounded" id="area-error" style="display: none; margin-top: 5px;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, seleccione un área infantil.
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-8">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="titulo-reg"><span class="text-danger">*</span> Título:</label>
                                            <input class="form-control mdl-textfield__input" type="text" name="titulo" id="titulo-reg" maxlength="50"
                                                pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]+"
                                                title="Solo se permiten letras, números y espacios"
                                                <?php if (isset($libro)): ?>
                                                value="<?= htmlspecialchars($libro->getTitulo()) ?>"
                                                readonly
                                                <?php else: ?>
                                                value="<?= htmlspecialchars($old['titulo'] ?? '') ?>"
                                                required
                                                <?php endif; ?>
                                                aria-describedby="titulo-error"
                                                onblur="validarTitulo(this)">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="titulo-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese un título válido (letras, números y espacios, máximo 50 caracteres).
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-4">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="cota"><span class="text-danger">*</span> Cota:</label>
                                            <input
                                                pattern="[a-zA-Z0-9-]{1,30}"
                                                class="form-control"
                                                type="text"
                                                name="cota"
                                                id="cota"
                                                maxlength="30"
                                                title="Ej: NH 234 o 120 A563."
                                                <?php if (isset($libro)): ?>
                                                value="<?= htmlspecialchars($libro->getCota()) ?>"
                                                readonly
                                                <?php else: ?>
                                                value="<?= htmlspecialchars($old['cota'] ?? '') ?>"
                                                required
                                                <?php endif; ?>

                                                aria-describedby="cota-error"
                                                onblur="validarCota(this)">

                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="cota-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> La Cota debe tener máximo 30 caracteres y un formato válido (Ej: NH 234 o 120 A563).
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="autor-reg"><span class="text-danger">*</span> Autor:</label>
                                            <input type="text"
                                                class="form-control"
                                                name="autores"
                                                id="autor-reg"
                                                maxlength="50"
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios"
                                                <?php if (isset($libro)): ?>
                                                <?php foreach ($libro->getAutores() as $autor): ?>
                                                value="<?= htmlspecialchars($autor->getNombre()) . ' ' ?>"
                                                <?php endforeach; ?>
                                                readonly
                                                <?php else: ?>
                                                value="<?= htmlspecialchars($old['autores'] ?? '') ?>"
                                                required
                                                <?php endif; ?>
                                                aria-describedby="autor-error"
                                                onblur="formatearAutor(this); if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('autor-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('autor-error').style.display = 'none'; }">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="autor-error" style="display: none;">
                                                Por favor, ingrese un nombre de autor válido (solo letras y espacios, máximo 50 caracteres).
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="ciudad-reg"><span class="text-danger">*</span> Ciudad:</label>

                                            <input
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}"
                                                class="form-control"
                                                type="text"
                                                name="ciudad"
                                                id="ciudad"
                                                maxlength="20"
                                                <?php if (isset($libro)): ?>
                                                value="<?= htmlspecialchars($libro->getCiudad()) ?>"
                                                readonly
                                                <?php else: ?>
                                                value="<?= htmlspecialchars($old['ciudad'] ?? '') ?>"
                                                required
                                                <?php endif; ?>
                                                title="Solo se permiten letras y espacios, máximo 20 caracteres"
                                                aria-describedby="ciudad-error"

                                                onblur="validarCiudad(this)">

                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="ciudad-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese una ciudad válida (solo letras y espacios, máximo 20 caracteres).
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="edicion-reg"><span class="text-danger">*</span> Edición:</label>

                                            <input
                                                pattern="[0-9]{1,3}"
                                                class="form-control"
                                                type="text"
                                                inputmode="numeric"
                                                name="edicion"
                                                id="edicion" maxlength="3"
                                                value="<?= htmlspecialchars($old['edicion'] ?? '') ?>"
                                                required title="Solo se permiten números (del 1 al 999)"
                                                aria-describedby="edicion-error"
                                                onblur="validarEdicion(this)"
                                                onkeypress="return isNumberKey(event)">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="edicion-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese un valor de Edición válido (solo números, Ejemplo: 2).
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="year-reg"><span class="text-danger">*</span> Año:</label>
                                            <input
                                                pattern="[0-9]{4}"
                                                class="form-control"
                                                type="text"
                                                inputmode="numeric" name="year"
                                                id="year-reg" maxlength="4"
                                                value="<?= htmlspecialchars($old['year'] ?? '') ?>"
                                                required title="Solo se permiten 4 dígitos numéricos" aria-describedby="year-error"
                                                onblur="validarAnio(this)"
                                                onkeypress="return isNumberKey(event)">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="year-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese un Año válido de 4 dígitos (ejemplo: 2023).
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="ejemplares-reg"><span class="text-danger">*</span> Ejemplares:</label>

                                            <input
                                                pattern="[0-9]{1,5}"
                                                class="form-control"
                                                type="text"
                                                inputmode="numeric"
                                                name="ejemplares"
                                                id="ejemplares-reg"
                                                maxlength="2"
                                                value="<?= htmlspecialchars($old['ejemplares'] ?? '') ?>"
                                                required
                                                title="Solo se permiten números, entre 1 y 2 dígitos"
                                                aria-describedby="ejemplares-error"
                                                onblur="validarEjemplares(this)"
                                                onkeypress="return isNumberKey(event)">

                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="ejemplares-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese el número de ejemplares (entre 1 y 2 dígitos).
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="paginas-reg"><span class="text-danger">*</span> Páginas:</label>

                                            <input
                                                pattern="[0-9]{1,5}"
                                                class="form-control"
                                                type="text" inputmode="numeric" name="paginas"
                                                id="paginas-reg" maxlength="4"
                                                <?php if (isset($libro)): ?>
                                                value="<?= htmlspecialchars($libro->getPaginas()) ?>"
                                                <?php else: ?>
                                                value="<?= htmlspecialchars($old['paginas'] ?? '') ?>"
                                                <?php endif; ?>
                                                required title="Solo se permiten números, entre 1 y 4 dígitos" aria-describedby="paginas-error" onblur="validarPaginas(this)" onkeypress="return isNumberKey(event)">

                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="paginas-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese el número de páginas (entre 1 y 4 dígitos).
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="editorial-reg"><span class="text-danger">*</span> Editorial:</label>

                                            <input
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,70}"
                                                class="form-control"
                                                type="text"
                                                name="editorial"
                                                id="editorial-reg" maxlength="70"
                                                <?php if (isset($libro)): ?>
                                                value="<?= htmlspecialchars($libro->getEditorial() ? $libro->getEditorial()->getNombre() : '') ?>"
                                                <?php else: ?>
                                                value="<?= htmlspecialchars($old['editorial'] ?? '') ?>"
                                                <?php endif; ?>
                                                required title="Solo se permiten letras y espacios, máximo 70 caracteres" aria-describedby="editorial-error" onblur="validarEditorial(this)">

                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="editorial-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese el nombre de la Editorial (solo letras y espacios, máximo 70 caracteres).
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="isbn"><span class="text-danger">*</span> ISBN:</label>
                                            <input
                                                class="form-control"
                                                type="text"
                                                inputmode="numeric"
                                                name="ISBN"
                                                id="isbn"
                                                maxlength="17"
                                                value="<?= htmlspecialchars($old['ISBN'] ?? '') ?>"
                                                required
                                                aria-describedby="isbn-error"
                                                title="Ingrese un ISBN válido (10 o 13 caracteres)."
                                                oninput="formatearIsbn(this)"
                                                onblur="validarIsbn(this)">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="isbn-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese un ISBN válido (10 o 13 caracteres).
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset>
                            <legend> &nbsp; Observaciones</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="observaciones-reg">Observaciones:</label>

                                            <textarea
                                                name="observaciones"
                                                class="form-control"
                                                id="observaciones-reg"
                                                rows="4"
                                                maxlength="400"
                                                onblur="validarObservaciones(this)"><?= htmlspecialchars($old['observaciones'] ?? '') ?></textarea>

                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="observaciones-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese observaciones válidas (solo letras, números y espacios).
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>



                        <div class="row" style="margin-top: 30px; margin-bottom: 20px;">
                            <div class="col-xs-12 text-center" style="display: flex; justify-content: center; align-items: center; gap: 25px; flex-wrap: wrap;">

                                <div class="form-group" style="margin: 0; padding: 0;">
                                    <div class="checkbox">
                                        <label class="text-warning" style="font-weight: 700; font-size: 16px; cursor: pointer;">
                                            <input type="checkbox" name="marcar-reserva" id="reserva-reg">
                                            <span class="checkbox-material"><span class="check"></span></span>
                                            <i class="fa-solid fa-bookmark" style="margin-left: 5px;"></i> Marcar como reserva
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success btn-raised btn-lg" id="btn-enviar-libro" style="margin: 0;">
                                    <i class="fa-solid fa-floppy-disk"></i> Guardar
                                </button>
                            </div>

                            <div class="col-xs-12 text-center" style="margin-top: 20px;">
                                <div class="invalid-feedback" id="reserva-error" style="display: none; transition: all 0.3s ease;">
                                    <span class="bg-danger text-danger" style="display: inline-block; padding: 8px 20px; font-weight: 500; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                        <i class="fas fa-exclamation-circle"></i> El siguiente libro será marcado como reserva. Esto evitará el préstamo del libro en el futuro.
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>

    <?php include VIEW_PATH . '/modal/confirmation-new-book.php' ?>


    <!--====== Scripts -->
    <?php include VIEW_PATH . "/component/scripts.php"; ?>

    <script src="<?php echo PUBLIC_PATH; ?>/js/validations/book/helpers-book.js"></script>
    <script src="<?php echo PUBLIC_PATH; ?>/js/validations/book/init-book-form.js"></script>

    <script src=" <?= PUBLIC_PATH ?> /js/modal/confirmation-new-book.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form-registro-libro");
    const btnConfirmarEnvio = document.getElementById("btn-confirmar-envio");
    const resumenContainer = document.getElementById("resumen-datos-libro");
    
    // Elementos para la automatización de ejemplares
    const ejemplaresInput = document.getElementById("ejemplares-reg");
    const checkboxReserva = document.getElementById("reserva-reg");
    const dropdownSala = document.getElementById("dropdown-sala");

    if (!form) return;

    // ============================================================================
    // LÓGICA DE AUTOMATIZACIÓN EN TIEMPO REAL (Ejemplares = 1 si es Reserva)
    // ============================================================================
    function verificarYForzarEjemplares() {
        const sala = document.getElementById("sala-display").value || "";
        
        // Es reserva si el checkbox existe y está marcado, O si la sala es de Referencia
        const esReserva = (checkboxReserva && checkboxReserva.checked) || sala.toLowerCase().includes("referencia");

        if (esReserva && ejemplaresInput) {
            ejemplaresInput.value = "1";
            // Ejecutar la validación semántica nativa si existe para limpiar estados de error previos
            if (typeof validarEjemplares === "function") {
                validarEjemplares(ejemplaresInput);
            }
        }
    }

    // 1. Escuchar cambios si usas un checkbox nativo para marcar la reserva
    if (checkboxReserva) {
        checkboxReserva.addEventListener("change", verificarYForzarEjemplares);
    }

    // 2. Escuchar clics en el dropdown de salas (por si cambia a Sala de Referencia)
    if (dropdownSala) {
        dropdownSala.querySelectorAll("a").forEach(opcion => {
            opcion.addEventListener("click", () => {
                // Le damos un pequeño delay (50ms) para permitir que el script original cargue el texto en #sala-display
                setTimeout(verificarYForzarEjemplares, 50);
            });
        });
    }

    // 3. Si el usuario intenta cambiar manualmente el número de ejemplares siendo reserva, se fuerza a 1 de nuevo
    if (ejemplaresInput) {
        ejemplaresInput.addEventListener("input", () => {
            const sala = document.getElementById("sala-display").value || "";
            const esReserva = (checkboxReserva && checkboxReserva.checked) || sala.toLowerCase().includes("referencia");
            if (esReserva) {
                ejemplaresInput.value = "1";
            }
        });
    }

    // ============================================================================
    // MANEJADOR DEL ENVÍO Y CONSTRUCCIÓN DEL MODAL
    // ============================================================================
    form.addEventListener("submit", function (e) {
        // Asegurar una última verificación antes de abrir el modal
        verificarYForzarEjemplares();

        // Validar que el formulario de HTML5 y tus validaciones personalizadas pasen
        if (!form.checkValidity()) {
            return; 
        }

        // Frenar el envío automático del formulario para poder mostrar el modal
        e.preventDefault();

        // Capturar los valores ingresados en los campos
        const sala = document.getElementById("sala-display").value || "No seleccionada";
        const areaInput = document.getElementById("areaSelect").value;
        const area = areaInput ? areaInput : "No aplica";
        const titulo = document.getElementById("titulo-reg").value;
        const cota = document.getElementById("cota").value;
        const autor = document.getElementById("autor-reg").value;
        const ciudad = document.getElementById("ciudad").value;
        const edicion = document.getElementById("edicion").value;
        const anio = document.getElementById("year-reg").value;
        const ejemplares = ejemplaresInput ? ejemplaresInput.value : "1";
        const paginas = document.getElementById("paginas-reg").value;
        const editorial = document.getElementById("editorial-reg").value;
        const isbn = document.getElementById("isbn").value;
        const observaciones = document.getElementById("observaciones-reg").value || "Ninguna";

        // Determinar el estado final de reserva para el diseño del modal
        const esReservaFinal = (checkboxReserva && checkboxReserva.checked) || sala.toLowerCase().includes("referencia");

        // Construcción de la fila de reserva en rojo si está marcado
        const filaReserva = esReservaFinal 
            ? `<tr><th>Estado de Reserva:</th><td><span style="color: #d9534f; font-weight: bold;"><i class="fas fa-lock"></i> SÍ (Marcado como Libro de Reserva - Solo Consulta en Sala)</span></td></tr>`
            : `<tr><th>Estado de Reserva:</th><td>No (Circulante / Préstamo Exterior)</td></tr>`;

        // Construir la estructura visual (HTML) dentro del contenedor del modal
        resumenContainer.innerHTML = `
            <table class="table table-striped table-bordered" style="margin-bottom: 0;">
                <tbody>
                    <tr><th width="30%">Sala:</th><td>${sala}</td></tr>
                    <tr><th>Área Infantil:</th><td>${area}</td></tr>
                    <tr><th>Título:</th><td><strong>${titulo}</strong></td></tr>
                    <tr><th>Cota:</th><td>${cota}</td></tr>
                    <tr><th>Autor:</th><td>${autor}</td></tr>
                    <tr><th>Ciudad:</th><td>${ciudad}</td></tr>
                    <tr><th>Edición:</th><td>${edicion}ª ed.</td></tr>
                    <tr><th>Año:</th><td>${anio}</td></tr>
                    <tr><th>Ejemplares:</th><td><strong>${ejemplares}</strong></td></tr>
                    <tr><th>Páginas:</th><td>${paginas}</td></tr>
                    <tr><th>Editorial:</th><td>${editorial}</td></tr>
                    <tr><th>ISBN:</th><td>${isbn}</td></tr>
                    <tr><th>Observaciones:</th><td>${observaciones}</td></tr>
                    ${filaReserva}
                </tbody>
            </table>
        `;

        // Levantar el modal de Bootstrap de forma programática
        $('#modalConfirmacion').modal('show');
    });

    // Escuchar el clic del botón "Confirmar Registro" dentro del modal
    if (btnConfirmarEnvio) {
        btnConfirmarEnvio.addEventListener("click", function () {
            btnConfirmarEnvio.disabled = true;
            btnConfirmarEnvio.textContent = "Guardando...";
            form.submit();
        });
    }
});
</script>



</body>

</html>