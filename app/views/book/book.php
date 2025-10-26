<!DOCTYPE html>
<html lang="es">
<?php include "../component/heat.php";
?>

<body>

    <?php include "../component/sidebar.php"; ?>

    <!-- Content page-->
    <section class="full-box dashboard-contentPage">

        <!-- NavBar -->
        <?php include "../component/navbar.php"; ?>

        <!-- Content page -->
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-book"></i> CATÁLOGO <small>NUEVO LIBRO</small></h1>
            </div>
        </div>
            
        <div class="container-fluid">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; REGISTRAR NUEVO LIBRO</h3>
                </div>
                <div class="panel-body">
                    <form>
                        <fieldset>
                            <legend><i class="zmdi zmdi-library"></i> &nbsp; Información del Libro</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Sala </label>
                                            <select name="sala-reg" class="form-control">
                                                <option value="" disabled selected>Seleccione la Sala</option>
                                                <option value="Sala General">Sala General</option>
                                                <option value="Sala de Referencia">Sala de Referencia</option>
                                                <option value="Hemeroteca">Hemeroteca</option>
                                            </select>
                                        </div>
                                    </div>
                                        
                                    <div class="col-xs-12 col-sm-6" >
                                        <div class="form-group label-floating">
                                            <label class="control-label">Area infantil</label>
                                            <select name="area-reg" class="form-control">
                                                <option value="" disabled selected>Seleccione el Área <i class="fa-solid fa-arrow-down"></i></option>

                                                <option class="" value="Cuento infantil">Cuento infantil</option>
                                                <option class="" value="Educativo">Educativo</option>
                                                <option class="" value="Ficción juvenil">Ficción juvenil</option>
                                            </select>
                                        </div>
                                    </div>

                                    
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="titulo-reg">Título:</label>
                                            <input class="form-control mdl-textfield__input" type="text" name="titulo-reg" id="titulo-reg" maxlength="50"
                                                pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9\s]+"
                                                title="Solo se permiten letras, números y espacios"
                                                required
                                                aria-describedby="titulo-error"
                                                onblur="validarTitulo(this)">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="titulo-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese un título válido (letras, números y espacios, máximo 50 caracteres).
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Cota:</label>
                                            <input pattern="[a-zA-Z0-9-]{1,30}" class="form-control" type="text" name="cota-reg" maxlength="30">
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="autor-reg">Autor:</label>
                                            <input type="text"
                                                class="form-control"
                                                name="autor-reg"
                                                id="autor-reg"
                                                maxlength="50"
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios"
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
                                            <label class="control-label" for="ciudad-reg">Ciudad:</label>

                                            <input
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}"
                                                class="form-control"
                                                type="text"
                                                name="ciudad-reg"
                                                id="ciudad-reg"
                                                maxlength="20"
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
                                            <label class="control-label" for="edicion-reg">Edición:</label>

                                            <input
                                                pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}"
                                                class="form-control"
                                                type="text"
                                                name="edicion-reg"
                                                id="edicion-reg" maxlength="30"
                                                required title="Solo se permiten letras, números y espacios, máximo 30 caracteres" aria-describedby="edicion-error" onblur="validarEdicion(this)">

                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="edicion-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese un valor de Edición válido (letras, números y espacios, máximo 30 caracteres).
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="year-reg">Año:</label>

                                            <input
                                                pattern="[0-9]{4}"
                                                class="form-control"
                                                type="text"
                                                name="year-reg"
                                                id="year-reg" maxlength="4"
                                                required title="Solo se permiten 4 dígitos numéricos" aria-describedby="year-error" onblur="validarAnio(this)">

                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="year-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese un Año válido de 4 dígitos (ejemplo: 2023).
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="ejemplares-reg">Ejemplares:</label>

                                            <input
                                                pattern="[0-9]{1,5}"
                                                class="form-control"
                                                type="text"
                                                inputmode="numeric"
                                                name="ejemplares-reg"
                                                id="ejemplares-reg"
                                                maxlength="2"
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
                                            <label class="control-label" for="paginas-reg">Páginas:</label>

                                            <input
                                                pattern="[0-9]{1,5}"
                                                class="form-control"
                                                type="text" inputmode="numeric" name="paginas-reg"
                                                id="paginas-reg" maxlength="4"
                                                required title="Solo se permiten números, entre 1 y 4 dígitos" aria-describedby="paginas-error" onblur="validarPaginas(this)" onkeypress="return isNumberKey(event)">

                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="paginas-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese el número de páginas (entre 1 y 4 dígitos).
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="editorial-reg">Editorial:</label>

                                            <input
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,70}"
                                                class="form-control"
                                                type="text"
                                                name="editorial-reg"
                                                id="editorial-reg" maxlength="70"
                                                required title="Solo se permiten letras y espacios, máximo 70 caracteres" aria-describedby="editorial-error" onblur="validarEditorial(this)">

                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="editorial-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese el nombre de la Editorial (solo letras y espacios, máximo 70 caracteres).
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="isbn-reg">ISBN:</label>

                                            <input
                                                pattern="[0-9]{10,13}" class="form-control"
                                                type="text"
                                                inputmode="numeric"
                                                name="isbn-reg"
                                                id="isbn-reg"
                                                maxlength="13" required
                                                title="Solo se permiten números, entre 10 y 13 dígitos" aria-describedby="isbn-error"
                                                onblur="validarIsbn(this)"
                                                onkeypress="return isNumberKey(event)">

                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="isbn-error" style="display: none;">
                                                <i class="fas fa-exclamation-circle"></i> Por favor, ingrese un ISBN válido (solo números, 10 a 13 dígitos).
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset>
                            <legend><i class="zmdi zmdi-comment-text-alt"></i> &nbsp; Observaciones</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="observaciones-reg">Observaciones:</label>

                                            <textarea
                                                name="observaciones-reg"
                                                class="form-control"
                                                id="observaciones-reg" rows="4"
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
                                    required
                                    title="Seleccione un archivo de imagen (JPG o PNG) para la portada."
                                    aria-describedby="portada-error"
                                    onchange="validarPortada(this)"
                                    style="display: none;">

                                <label for="portada-reg" class="btn btn-info btn-raised">
                                    <i class="zmdi zmdi-upload"></i> &nbsp; Seleccionar Portada
                                </label>
                                <span id="file-name" style="margin-left: 10px; color: #555;">No se ha seleccionado archivo</span>

                                <div class="invalid-feedback bg-danger text-danger rounded-pill" id="portada-error" style="display: none;">
                                    <i class="fas fa-exclamation-circle"></i> Por favor, seleccione una portada válida (formato JPG o PNG, máximo 5MB).
                                </div>
                            </div>
                        </div>


                        <p class="text-center " style="margin-top: 20px">
                            <button type="submit" class="btn btn-success btn-raised btn-lg" style="background-color: #5cb85c; border-color: #5cb85c;"><i class="zmdi zmdi-floppy"></i> Enviar</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>

    </section>

    <!--====== Scripts -->
    <?php include "../component/scripts.php"; ?>
    <script src="../../../public/js/validations/book/createvalidation.js"></script>
</body>

</html>