<?php
    if (isset($_SESSION['error'])) { 
        var_dump($_SESSION['error']);
        echo "<script>alert('" . $_SESSION['error'] . "');</script>"; 
        unset($_SESSION['error']);
    }
    $autores = $libro->getAutores();
    $editorial = $libro->getEditorial() ?? '';
    $ejemplares = $libro->getEjemplares();
?>

<!DOCTYPE html>
<html lang="es">
<?php include VIEW_PATH . "/component/heat.php";
?>

<body>

    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage" ;>

        <?php include VIEW_PATH . "/component/navbar.php"; ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-book"></i> Catálago <small>Editar Libro</small></h1>
            </div>
        </div>

        <div class="container-fluid">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"> &nbsp; EDITAR LIBRO</h3>
                </div>
                <div class="panel-body">
                    <form action="<?= BASE_URL ?>/libros/update" method="POST">
                        <fieldset>
                            <input type="hidden" name="idLibro" value="<?= $libro->getIdLibro() ?>">
                            <legend> &nbsp; Información del Libro</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label"><span class="text-danger">*</span> Sala <i class="fa-solid fa-angle-down"></i></label>
                                            <div class="dropdown">
                                                <input type="text" id="sala-display" class="form-control" readonly data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer; background-color: transparent;">
                                                <ul class="dropdown-menu" id="dropdown-sala" style="width: 100%;">
                                                    <li><a href="#!" data-value="Sala General">Sala General</a></li>
                                                    <li><a href="#!" data-value="Sala de Referencia">Sala de Referencia</a></li>
                                                    <li><a href="#!" data-value="Sala Estatal">Sala Estatal</a></li>
                                                    <li><a href="#!" data-value="Sala Infantil">Sala Infantil</a></li>
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
                                            <input class="form-control mdl-textfield__input" type="text" name="titulo-reg" id="titulo-reg" maxlength="50"
                                                pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]+"
                                                title="Solo se permiten letras, números y espacios"
                                                value ="<?= htmlspecialchars($libro->getTitulo() ?? '') ?>"
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
                                                name="cota-reg"
                                                id="cota"
                                                maxlength="30"
                                                value="<?= htmlspecialchars($libro->getCota() ?? '') ?>"
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
                                                name="autor-reg"
                                                id="autor-reg"
                                                maxlength="50"
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios"
                                                <?php foreach ($libro->getAutores() as $autor) : ?>
                                                    value="<?= htmlspecialchars($autor->getNombre()) ?>"
                                                <?php endforeach; ?>
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
                                                pattern="[a-zA-ZáéíóúÁÉÓÚñÑ ]{1,50}"
                                                class="form-control"
                                                type="text"
                                                name="ciudad-reg"
                                                id="ciudad"
                                                maxlength="20"
                                                value="<?= htmlspecialchars($libro->getCiudad() ?? '') ?>"
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
                                                name="edicion-reg"
                                                id="edicion" maxlength="3"
                                                value="<?= htmlspecialchars($libro->getEdicion() ?? '') ?>"
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
                                                inputmode="numeric" name="year-reg"
                                                id="year-reg" maxlength="4"
                                                value="<?= htmlspecialchars($libro->getAnioPublicacion() ?? '') ?>"
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
                                            <label class="control-label" for="ejemplares-reg"><span class="text-danger">*</span> Ejemplares Total:</label>

                                            <input
                                                class="form-control"
                                                type="text"
                                                name="ejemplares-reg"
                                                id="ejemplares-reg"
                                                readonly
                                                value="1">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="ejemplares-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Este campo se actualiza automáticamente.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="paginas-reg"><span class="text-danger">*</span> Páginas:</label>

                                            <input
                                                pattern="[0-9]{1,5}"
                                                class="form-control"
                                                type="text" inputmode="numeric" name="paginas-reg"
                                                id="paginas-reg" maxlength="4"
                                                value="<?= $libro->getPaginas() ?>"
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
                                                value="<?= $editorial->getNombre() ?>"
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
                                                name="isbn"
                                                id="isbn"
                                                maxlength="17"
                                                required
                                                aria-describedby="isbn-error"
                                                title="Ingrese un ISBN válido (10 o 13 caracteres)."
                                                value="<?= htmlspecialchars($libro->getIsbn() ?? '') ?>"
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

                        <hr>

                        <fieldset>
                            <!-- Contenedor para inputs dinámicos de ejemplares -->
                            <div id="ejemplares-hidden-fields">
                            <!-- Array de IDs a descatalogar -->
                            <!-- Se irán agregando <input type="hidden" name="ejemplares_descatalogar[]" value="ID"> desde JS -->
                            
                            <!-- Cantidad de nuevos ejemplares -->
                            <input type="hidden" name="nuevos_ejemplares" id="nuevos_ejemplares" value="0">

                            <!-- Estados de ejemplares existentes (pares ID->Estado) -->
                            <!-- Se irán agregando <input type="hidden" name="estado_ejemplar[ID]" value="Disponible"> desde JS -->
                            </div>
                            <legend><i class="fa-solid fa-copy"></i> &nbsp;Ejemplares</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <p class="text-right">
                                            <button type="button" class="btn btn-primary btn-raised" id="add-ejemplar-btn" onclick="agregarNuevoEjemplar()">
                                                <i class="fa-solid fa-plus"></i> Agregar Nuevo Ejemplar
                                            </button>
                                        </p>

                                        <div class="table-responsive">
                                            <table class="table table-hover text-center" id="ejemplares-table">
                                                <?php if (empty($ejemplares)): ?>
                                                    <p>No hay ejemplares registrados para este libro.</p>
                                                <?php else:?>
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Numero Ejemplar</th>
                                                        <th class="text-center">Estado</th>
                                                        <th class="text-center">Último Préstamo</th>
                                                        <th class="text-center">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($ejemplares as $ejemplar): ?>
                                                    <tr data-ejemplar-id="<?= $ejemplar->getIdEjemplar() ?>">
                                                        <td>EJ-<?= $ejemplar->getNumeroEjemplar() ?></td>
                                                        <td>
                                                            <select class="form-control estado-ejemplar" width=auto display=block
                                                                    data-id="<?= $ejemplar->getIdEjemplar() ?>">
                                                            <option value="Dañado"     <?= $ejemplar->getEstado() === 'Dañado' ? 'selected' : '' ?>>Dañado</option>
                                                            <option value="Disponible" <?= $ejemplar->getEstado() === 'Disponible' ? 'selected' : '' ?>>Disponible</option>
                                                            <option value="En Reparación" <?= $ejemplar->getEstado() === 'En Reparación' ? 'selected' : '' ?>>En Reparación</option>
                                                            </select>
                                                        </td>
                                                        <td>N/A</td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-xs" title="Descatalogar"
                                                                    onclick="mostrarModalEliminar(<?= $ejemplar->getIdEjemplar() ?>, 'EJ-<?= $ejemplar->getNumeroEjemplar() ?>', this)">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </td>
                                                        </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                                <?php endif; ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <hr>
                        <br>
                        <fieldset>
                            <legend> &nbsp; Observaciones</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="observaciones-reg">Observaciones:</label>

                                            <textarea
                                                name="observaciones-reg"
                                                class="form-control"
                                                id="observaciones-reg" rows="4"
                                                value="<?= htmlspecialchars($libro->getObservaciones() ?? '') ?>"
                                                maxlength="400" title="Solo se permiten letras, números y espacios. Máximo 400 caracteres." aria-describedby="observaciones-error" onblur="validarObservaciones(this)"></textarea>

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
                            <button type="submit" class="btn btn-success btn-raised btn-lg" style="background-color: #5cb85c; border-color: #5cb85c;" id="btn-enviar-libro"> Enviar</button>
                        </p>
                    </form>

                </div>
            </div>
        </div>

    </section>
    <?php include VIEW_PATH . "/modal/confirmation_delete_copy.php"; ?>
    <?php include VIEW_PATH . "/component/scripts.php"; ?>
    <script src="<?php echo PUBLIC_PATH; ?>/js/validations/book/createvalidation.js"></script>
    <script src="<?php echo PUBLIC_PATH; ?>/js/modal/specimens.js"></script>
</body>

</html>
