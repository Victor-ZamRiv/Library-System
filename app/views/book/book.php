<!DOCTYPE html>
<html lang="es">
<title>Nuevo Libro</title>
<body>

    <?php include VIEW_PATH . '/component/sidebar.php'; ?>

    <!-- Content page-->
    <section class="full-box dashboard-contentPage">

        <!-- NavBar -->
        <?php include VIEW_PATH . '/component/navbar.php'; ?>

        <!-- Content page -->
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-book"></i> Catálogo <small>Nuevo Libro</small></h1>
            </div>
        </div>

        <div class="container-fluid">
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <strong>Error:</strong> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">&nbsp; REGISTRAR NUEVO LIBRO</h3>
                </div>
                <div class="panel-body">
                    <form action="/library_system/libros" method="POST" enctype="multipart/form-data" id="form-registro-libro">
                        <fieldset>
                            <legend> &nbsp; Información del Libro</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Sala <i class="fa-solid fa-angle-down"></i></label>
                                            <div class="dropdown">
                                                <input type="text" id="sala-display" class="form-control" readonly data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer; background-color: transparent;" required>
                                                <ul class="dropdown-menu" id="dropdown-sala" style="width: 100%;">
                                                    <li><a href="#!" data-value="G">Sala General</a></li>
                                                    <li><a href="#!" data-value="R">Sala de Referencia</a></li>
                                                    <li><a href="#!" data-value="SE">Sala Estatal</a></li>
                                                    <li><a href="#!" data-value="X">Sala Infantil</a></li>
                                                </ul>
                                            </div>
                                            <input type="hidden" name="sala-reg" id="salaSelect" required>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" id="label-area">Área infantil</label>
                                            <div class="dropdown">
                                                <div id="area-display-container" class="form-control" data-toggle="dropdown"
                                                    style="cursor: pointer; height: 34px; padding-top: 7px;">
                                                    <span id="area-text-content"></span>
                                                </div>

                                                <ul class="dropdown-menu " id="dropdown-area">
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
                                            <input type="hidden" name="area-reg" id="areaSelect">
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-8">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="titulo-reg"><span class="text-danger">*</span> Título:</label>
                                            <input class="form-control mdl-textfield__input" type="text" name="titulo" id="titulo-reg" maxlength="50"
                                                pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]+"
                                                title="Solo se permiten letras, números y espacios"
                                                value="<?= htmlspecialchars($old['titulo'] ?? '') ?>"
                                                required
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
                                                value="<?= htmlspecialchars($old['cota'] ?? '') ?>"
                                                required
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
                                                value="<?= htmlspecialchars($old['autores'] ?? '') ?>"
                                                required
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
                                                value="<?= htmlspecialchars($old['ciudad'] ?? '') ?>"
                                                required
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
                                                value="<?= htmlspecialchars($old['paginas'] ?? '') ?>"
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
                                                value="<?= htmlspecialchars($old['editorial'] ?? '') ?>"
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

                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group label-floating">
                                <label class="control-label" for="portada-reg">Portada del Libro:</label>

                                <input
                                    class="form-control"
                                    type="file"
                                    name="portada-reg"
                                    id="portada-reg"
                                    accept="image/jpeg, image/png"

                                    title="Seleccione un archivo de imagen (JPG o PNG) para la portada."
                                    aria-describedby="portada-error"
                                    onchange="validarPortada(this)"
                                    style="display: none;">

                                <label for="portada-reg" class="btn btn-info btn-raised">
                                    &nbsp; Seleccionar Portada
                                </label>
                                <span id="file-name" style="margin-left: 10px; color: #555;">No se ha seleccionado archivo</span>

                                <div class="invalid-feedback bg-danger text-danger rounded-pill" id="portada-error" style="display: none;">
                                    <i class="fas fa-exclamation-circle"></i> Por favor, seleccione una portada válida (formato JPG o PNG, máximo 5MB).
                                </div>
                            </div>
                        </div>


                        <p class="text-center " style="margin-top: 20px">
                            <button type="submit" class="btn btn-success btn-raised btn-lg" id="btn-enviar-libro"> Guardar</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>

    </section>

    <?php include VIEW_PATH . '/modal/confirmation-new-book.php' ?>


    <!--====== Scripts -->

    <?php include VIEW_PATH . '/component/scripts.php' ?>
    <script src= "<?= PUBLIC_PATH ?> /js/validations/book/createvalidation.js"></script>
    <script src=" <?= PUBLIC_PATH ?> /js/modal/confirmation-new-book.js"></script>


</body> 

</html>