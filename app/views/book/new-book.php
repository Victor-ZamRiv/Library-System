<!DOCTYPE html>
<html lang="es">

<head>
    <title>Gestión de Libros</title>
    <?php include VIEW_PATH . "/component/heat.php"; ?>
    
</head>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-book-open"></i> Libros <small>Registro de Libros</small></h1>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa-solid fa-plus"></i> REGISTRO COMPLETO</h3>
                        </div>
                        <div class="panel-body text-center">
                            <p>Utilice esta opción para registrar un libro que <b>no existente</b> en el catálogo.</p>
                            <br>
                            <i class="fa-solid fa-book-medical fa-5x" style="color: #4caf50;"></i>
                            <br><br>
                            <a href="<?= BASE_URL ?>/libros/create" class="btn btn-success btn-raised btn-lg">
                                REGISTRAR NUEVO LIBRO
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa-solid fa-copy"></i> AGREGAR EDICIÓN</h3>
                        </div>
                        <div class="panel-body">
                            <p class="text-center">Si el libro ya existe, solo ingrese la <b>Cota</b> para añadir una nueva edición del mismo.</p>

                            <form action="<?= BASE_URL ?>/libros/nueva-edicion" method="POST" id="form-ejemplar">
                                <div class="form-group label-floating">
                                    <label class="control-label" for="cota-ejemplar">
                                        <span class="text-danger">*</span> Cota del Libro:
                                    </label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="cota-reg"
                                        id="cota-ejemplar"
                                        maxlength="30"
                                        required
                                        aria-describedby="cota-error"
                                        onblur="validarCota(this)"
                                        oninput="this.value = this.value.toUpperCase()">
                                    <div class="invalid-feedback bg-danger text-danger rounded-pill" id="cota-error" style="display: none;">
                                        <i class="fas fa-exclamation-circle"></i> La Cota debe tener máximo 30 caracteres y un formato válido (Ej: NH 234 o 120 A563).
                                    </div>
                                    <div>
                                        <?php if ($error): ?>
                                            <span class="text-danger"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <p class="help-block">Ej: NH 234 o 120 A563</p>
                                </div>

                                <p class="text-center">
                                    <button type="submit" class="btn btn-info btn-raised">
                                        AÑADIR EJEMPLAR
                                    </button>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/component/scripts.php"; ?>

    <script>
        /**
         * Lógica de UI para mostrar/ocultar errores
         */
        function actualizarEstadoInput(input, errorElement, mensaje) {
            const esValido = input.checkValidity();

            if (!esValido) {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                if (errorElement) {
                    errorElement.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${mensaje}`;
                    errorElement.style.display = 'block';
                }
            } else {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                if (errorElement) {
                    errorElement.style.display = 'none';
                }
            }
        }

        /**
         * Validación de Cota estricta
         */
        function validarCota(input) {
            const errorDisplay = document.getElementById('cota-error');
            const valor = input.value.trim();

            // Regex para: N H234 o 120 A563 (incluyendo variantes con puntos)
            const cotaPattern = /^(?:[A-Za-z]{1,2}\s[A-Za-z0-9]{1,4}|\d{3}.*\s[A-Za-z0-9]{4})$/;

            let mensaje = "";

            if (valor === "") {
                mensaje = "La cota es obligatoria.";
            } else if (valor.length > 30) {
                mensaje = "La extensión máxima es de 30 caracteres.";
            } else if (!cotaPattern.test(valor)) {
                mensaje = "Formato de cota incorrecto. Ejemplos válidos: 'N H234' o '120 A563'.";
            }

            input.setCustomValidity(mensaje);
            actualizarEstadoInput(input, errorDisplay, mensaje);
        }

        /**
         * Validación ligera mientras el usuario escribe
         */
        function validarCotaInput(input) {
            if (input.value.length > 30) {
                input.setCustomValidity("Máximo 30 caracteres.");
            } else {
                input.setCustomValidity("");
            }
        }

        // Evitar envío del formulario si hay errores
        document.getElementById('form-ejemplar').addEventListener('submit', function(e) {
            const inputCota = document.getElementById('cota-ejemplar');
            validarCota(inputCota);

            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                alert("Por favor, corrija el formato de la Cota antes de continuar.");
            }
        });
    </script>
</body>

</html>