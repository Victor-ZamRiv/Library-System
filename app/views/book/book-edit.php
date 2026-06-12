<?php
if (isset($_SESSION['error'])) {
    var_dump($_SESSION['error']);
    echo "<script>alert('" . $_SESSION['error'] . "');</script>";
    unset($_SESSION['error']);
}

$autores = $libro->getAutores();
$editorial = $libro->getEditorial() ?? '';
$ejemplares = $libro->getEjemplares();

// CORRECCIÓN 1: Contar los ejemplares reales que vienen de la BD
$totalEjemplares = is_array($ejemplares) ? count($ejemplares) : 0;

// CORRECCIÓN 2: Obtener y mapear la Sala
$salaCode = method_exists($libro, 'getIdSala') ? $libro->getIdSala() : '';
$salaText = 'Seleccione una sala';
if ($salaCode == 'G') $salaText = 'Sala General';
if ($salaCode == 'R') $salaText = 'Sala de Referencia';
if ($salaCode == 'SE') $salaText = 'Sala Estatal';
if ($salaCode == 'X') $salaText = 'Sala Infantil';

// CORRECCIÓN 3: Obtener el Área (validando el nombre del método por seguridad)
$areaCode = method_exists($libro, 'getIdArea') ? $libro->getIdArea() : (method_exists($libro, 'getAreaInfantil') ? $libro->getAreaInfantil() : '');
$areaText = !empty($areaCode) ? $areaCode : 'Seleccione un área infantil';
?>

<!DOCTYPE html>
<html lang="es">
<?php include VIEW_PATH . "/component/heat.php"; ?>
<title>Editar Libro</title>
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
        opacity: 0;
        pointer-events: none;
    }
</style>

<body>

    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">

        <?php include VIEW_PATH . "/component/navbar.php"; ?>

        <div class="container-fluid">
            <div class="page-header">
<<<<<<< HEAD

=======
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
                <h1 class="text-titles"><i class="fa-solid fa-book"></i> Editar Libro</h1>
            </div>
        </div>

        <div class="container-fluid">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"> &nbsp; EDITAR LIBRO </h3>
                </div>
                <div class="panel-body">
                    <form action="<?= BASE_URL ?>/libros/update" method="POST" id="form-registro-libro">
                        <fieldset>
                            <input type="hidden" name="idLibro" value="<?= $libro->getIdLibro() ?>">
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
                                                    placeholder="Seleccione una sala"
                                                    value="<?= htmlspecialchars($salaCode) ?>">
                                                <ul class="dropdown-menu" id="dropdown-sala" style="width: 100%;">
                                                    <li><a href="#!" data-value="G">Sala General</a></li>
                                                    <li><a href="#!" data-value="R">Sala de Referencia</a></li>
                                                    <li><a href="#!" data-value="SE">Sala Estatal</a></li>
                                                    <li><a href="#!" data-value="X">Sala Infantil</a></li>
                                                </ul>
                                            </div>
                                            <input type="text" name="sala-reg" id="salaSelect" class="visually-hidden"
                                                value="<?= htmlspecialchars($salaCode) ?>"
                                                data-original="<?= htmlspecialchars($salaCode) ?>" required>
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
                                                    style="cursor: pointer; height: 34px; padding-top: 7px; <?php echo ($salaCode !== 'X') ? 'pointer-events: none; opacity: 0.5;' : ''; ?>"
                                                    placeholder="Seleccione un área">
                                                    <span id="area-text-content"><?= htmlspecialchars($areaText) ?></span>
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
                                            <input type="text" name="area-reg" id="areaSelect" class="visually-hidden"
                                                value="<?= htmlspecialchars($areaCode) ?>"
                                                data-original="<?= htmlspecialchars($areaCode) ?>">
                                            <div class="invalid-feedback bg-danger text-danger p-1 rounded" id="area-error" style="display: none; margin-top: 5px;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, seleccione un área infantil.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-8">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="titulo-reg"><span class="text-danger">*</span> Título:</label>
                                            <input class="form-control mdl-textfield__input" type="text" name="titulo-reg" id="titulo-reg" maxlength="50"
                                                pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]+"
                                                title="Solo se permiten letras, números y espacios"
                                                value="<?= htmlspecialchars($libro->getTitulo() ?? '') ?>"
                                                data-original="<?= htmlspecialchars($libro->getTitulo() ?? '') ?>"
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
                                                data-original="<?= htmlspecialchars($libro->getCota() ?? '') ?>"
                                                required
                                                aria-describedby="cota-error"
                                                onblur="validarCota(this)">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="cota-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> La Cota debe tener máximo 30 caracteres y un formato válido.
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
                                                data-original="<?= htmlspecialchars($autor->getNombre()) ?>"
                                                <?php endforeach; ?>
                                                required
                                                aria-describedby="autor-error"
                                                onblur="formatearAutor(this)">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="autor-error" style="display: none;">
                                                Por favor, ingrese un nombre de autor válido.
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
                                                id="ciudad-reg"
                                                maxlength="20"
                                                value="<?= htmlspecialchars($libro->getCiudad() ?? '') ?>"
                                                data-original="<?= htmlspecialchars($libro->getCiudad() ?? '') ?>"
                                                required
                                                title="Solo se permiten letras y espacios, máximo 20 caracteres"
                                                aria-describedby="ciudad-error"
                                                onblur="validarCiudad(this)">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="ciudad-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese una ciudad válida.
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
                                                id="edicion-reg" maxlength="3"
                                                value="<?= htmlspecialchars($libro->getEdicion() ?? '') ?>"
                                                data-original="<?= htmlspecialchars($libro->getEdicion() ?? '') ?>"
                                                required title="Solo se permiten números (del 1 al 999)"
                                                aria-describedby="edicion-error"
                                                onblur="validarEdicion(this)"
                                                onkeypress="return isNumberKey(event)">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="edicion-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese un valor de Edición válido.
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
                                                data-original="<?= htmlspecialchars($libro->getAnioPublicacion() ?? '') ?>"
                                                required title="Solo se permiten 4 dígitos numéricos" aria-describedby="year-error"
                                                onblur="validarAnio(this)"
                                                onkeypress="return isNumberKey(event)">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="year-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese un Año válido de 4 dígitos.
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
                                                value="<?= $totalEjemplares ?>"
                                                data-original="<?= $totalEjemplares ?>">
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
                                                data-original="<?= $libro->getPaginas() ?>"
                                                required title="Solo se permiten números, entre 1 y 4 dígitos" aria-describedby="paginas-error" onblur="validarPaginas(this)" onkeypress="return isNumberKey(event)">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="paginas-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese el número de páginas.
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
                                                value="<?= is_object($editorial) ? htmlspecialchars($editorial->getNombre()) : '' ?>"
                                                data-original="<?= is_object($editorial) ? htmlspecialchars($editorial->getNombre()) : '' ?>"
                                                required title="Solo se permiten letras y espacios, máximo 70 caracteres" aria-describedby="editorial-error" onblur="validarEditorial(this)">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="editorial-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese el nombre de la Editorial.
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
                                                data-original="<?= htmlspecialchars($libro->getIsbn() ?? '') ?>"
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
                            <div id="ejemplares-hidden-fields">
                                <input type="hidden" name="nuevos_ejemplares" id="nuevos_ejemplares" value="0">
                            </div>
                            <legend><i class="fa-solid fa-copy"></i> &nbsp;Ejemplares</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <p class="text-right">
                                            <button type="button" class="btn btn-primary btn-raised" id="add-ejemplar-btn" onclick="agregarNuevoEjemplar()">
                                                <i class="fa-solid fa-plus"></i> Agregar Ejemplar
                                            </button>
                                            <button type="button" class="btn btn-success btn-raised" data-toggle="modal" data-target="#modalDescatalogados" style="margin: 0;">
                                                <i class="fa-solid fa-ban"></i> Ejemplares Descatalogados
                                            </button>
                                        </p>

                                        <div class="table-responsive">
                                            <table class="table table-hover text-center" id="ejemplares-table">
                                                <?php if (empty($ejemplares)): ?>
                                                    <p>No hay ejemplares registrados para este libro.</p>
                                                <?php else: ?>
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
                                                                        data-id="<?= $ejemplar->getIdEjemplar() ?>"
                                                                        data-original="<?= $ejemplar->getEstado() ?>">
                                                                        <option value="Dañado" <?= $ejemplar->getEstado() === 'Dañado' ? 'selected' : '' ?>>Dañado</option>
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
                                                data-original="<?= htmlspecialchars($libro->getObservaciones() ?? '') ?>"
                                                maxlength="400" title="Solo se permiten letras, números y espacios. Máximo 400 caracteres." aria-describedby="observaciones-error" onblur="validarObservaciones(this)"><?= htmlspecialchars($libro->getObservaciones() ?? '') ?></textarea>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="observaciones-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese observaciones válidas (solo letras, números y espacios).
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <p class="text-center " style="margin-top: 20px">
                            <a href="<?= BASE_URL ?>/libros/show?id=<?= $libro->getIdLibro() ?>" class="btn btn-secondary btn-raised">Volver</a>
                            <button type="submit" class="btn btn-success btn-raised btn-lg" style="background-color: #5cb85c; border-color: #5cb85c;" id="btn-enviar-libro"> Actualizar</button>
                        </p>
                    </form>

                </div>
            </div>
        </div>

    </section>

    <div class="modal fade" id="modalConfirmacionActualizacion" tabindex="-1" role="dialog" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalConfirmacionLabel">
                        <i class="fas fa-exclamation-triangle text-info" style="margin-right: 5px;"></i>
                        Confirmar Actualización de Datos del Libro
                    </h4>
                </div>
                <div class="modal-body">
                    <p class="lead text-center mb-4" id="modal-descripcion-cambios">
                        Por favor, verifique las modificaciones antes de guardar de forma permanente.
                    </p>
                    <div id="resumen-cambios-libro" class="p-3 table-responsive">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar / Seguir Editando</button>
                    <button type="button" class="btn btn-info btn-raised" id="btn-confirmar-update" style="display:none;">Confirmar y Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <?php include VIEW_PATH . "/modal/confirmation_delete_copy.php"; ?>
    <?php include VIEW_PATH . "/modal/discontinued.php"; ?>
    <?php include VIEW_PATH . "/component/scripts.php"; ?>
<<<<<<< HEAD

    <script src="<?php echo PUBLIC_PATH; ?>/js/validations/book/helpers-book.js"></script>
    <script src="<?php echo PUBLIC_PATH; ?>/js/validations/book/init-book-form.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const formulario = document.getElementById("form-registro-libro");
            const modal = $("#modalConfirmacionActualizacion");
            const contenedorResumen = document.getElementById("resumen-cambios-libro");
            const btnConfirmar = document.getElementById("btn-confirmar-update");
            const descripcionCambios = document.getElementById("modal-descripcion-cambios");

            // Activamos las validaciones en tiempo real para todos los campos de texto
            if (typeof aplicarFiltrosSanitizacion === 'function') {
                const inputsSanitizar = document.querySelectorAll('input[type="text"], textarea');
                inputsSanitizar.forEach(input => {
                    aplicarFiltrosSanitizacion(input);
                    normalizarYFormatearCampos(input);
                });
            }

            // Diccionario con los IDs amigables corregidos para el resumen (Incluyendo Sala y Área)
            const diccionarioCampos = {
                "titulo-reg": "Título del Libro",
                "cota": "Cota",
                "autor-reg": "Autor",
                "edicion-reg": "Edición",
                "ciudad-reg": "Ciudad",
                "editorial-reg": "Editorial",
                "year-reg": "Año de Publicación",
                "paginas-reg": "Páginas",
                "ejemplares-reg": "Ejemplares",
                "isbn": "ISBN",
                "observaciones-reg": "Observaciones",
                "salaSelect": "Sala",
                "sala-reg": "Sala",
                "areaSelect": "Área Infantil",
                "area-reg": "Área Infantil"
            };

            if (formulario) {
                formulario.addEventListener("submit", function(e) {

                    // FIX PRINCIPAL: Evitar que siga adelante si HTML5 o los JS determinan que es inválido
                    if (!formulario.checkValidity()) {
                        return; // Dejamos que el navegador muestre los globitos rojos
                    }

                    // Evitamos el envío si todo está bien para evaluar los cambios
                    e.preventDefault();

                    let cambios = [];

                    const elementos = formulario.querySelectorAll("[data-original]");

                    elementos.forEach(elem => {
                        const valorOriginal = elem.getAttribute("data-original").trim();
                        const valorActual = elem.value.trim();

                        if (valorOriginal !== valorActual) {
                            // Buscamos el nombre amigable por ID o por Name en el diccionario
                            const nombreCampo = diccionarioCampos[elem.id] || diccionarioCampos[elem.name];

                            // MEJORA: Si no está mapeado, se salta por completo (elimina "Campo Desconocido")
                            if (!nombreCampo) {
                                return;
                            }

                            cambios.push({
                                campo: nombreCampo,
                                anterior: valorOriginal === "" ? '<span class="text-muted">Ninguno</span>' : valorOriginal,
                                nuevo: valorActual === "" ? '<span class="text-muted">Vaciado</span>' : valorActual
                            });
                        }
                    });

                    if (cambios.length > 0) {
                        // MEJORA: El encabezado ahora dice exclusivamente "Campos"
                        let tablaHTML = `
                            <table class="table table-striped table-bordered text-center">
                                <thead>
                                    <tr class="info">
                                        <th class="text-center">Campos</th>
                                        <th class="text-center">Valor Anterior</th>
                                        <th class="text-center">Valor Nuevo</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;

                        cambios.forEach(c => {
                            tablaHTML += `
                                <tr>
                                    <td><strong>${c.campo}</strong></td>
                                    <td class="text-danger">${c.anterior}</td>
                                    <td class="text-success"><strong>${c.nuevo}</strong></td>
                                </tr>
                            `;
                        });

                        tablaHTML += `</tbody></table>`;

                        descripcionCambios.innerHTML = "Por favor, verifique las modificaciones antes de guardar de forma permanente.";
                        contenedorResumen.innerHTML = tablaHTML;
                        btnConfirmar.style.display = "inline-block";
                    } else {
                        descripcionCambios.innerHTML = "";
                        contenedorResumen.innerHTML = `
                            <div class="alert alert-warning text-center" style="margin: 0;">
                                <i class="fas fa-info-circle"></i> No has realizado ninguna modificación en los datos del libro.
                            </div>
                        `;
                        btnConfirmar.style.display = "none";
                    }

                    modal.modal("show");
                });
            }

            if (btnConfirmar) {
                btnConfirmar.addEventListener("click", function() {
                    if (formulario) {
                        // Enviamos el formulario limpio
                        formulario.submit();
                    }
                });
            }
        });
    </script>
=======
    <script src="<?php echo PUBLIC_PATH; ?>/js/validations/book/helper-book.js"></script>
    <script src="<?php echo PUBLIC_PATH; ?>/js/validations/book/init-book-form.js"></script>
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
    <script src="<?php echo PUBLIC_PATH; ?>/js/modal/specimens.js"></script>
</body>

</html>