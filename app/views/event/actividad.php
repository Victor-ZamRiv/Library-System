<!DOCTYPE html>
<html lang="es">

<title>Registro de Actividad</title>
<?php
include VIEW_PATH . "/component/heat.php";
?>

<body>

    <?php
    include VIEW_PATH . "/component/sidebar.php";
    ?>

    <section class="full-box dashboard-contentPage">
        <?php
        include VIEW_PATH . "/component/navbar.php";
        ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles">
                    <i class="fa-solid fa-calendar"></i> Eventos
                    <small> Registro de Actividades</small>
                </h1>
            </div>
        </div>

        <div class="container-fluid text-center" style="max-width: 900px;">
            <div class="card shadow-lg p-3 mb-4 bg-white rounded text-left">
                <div class="card-body">
                    <h3 class="text-center text-titles">Formulario de Actividades</h3>
                    <hr>

                    <form action="?" method="POST" id="form-registro-actividad">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label"><span class="text-danger">*</span> Fecha del Evento:</label>
                                    <input type="date" class="form-control" name="fecha" id="fecha" onkeydown="return false" required>
                                    <div class="invalid-feedback bg-danger text-danger rounded-pill" id="fecha-error" style="display: none; padding: 5px 10px; font-size: 12px; margin-top: 5px;">
                                        <i class="fas fa-exclamation-circle"></i> Fecha fuera de rango (1 semana atrás hasta 2 meses adelante).
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label"><span class="text-danger">*</span> Categoría:</label>
                                    <select class="form-control" name="categoria" id="categoria" required>
                                        <option value="" disabled selected>Seleccione</option>
                                        <option value="Cultural">Cultural</option>
                                        <option value="Educativa">Educativa</option>
                                        <option value="Mantenimiento">Mantenimiento</option>
                                        <option value="Reunión">Reunión / Asamblea</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Número de Asistentes:</label>
                                    <input type="number" class="form-control" name="asistentes" id="asistentes" placeholder="0">
                                    <div class="invalid-feedback bg-danger text-danger rounded-pill" id="asist-error" style="display: none; padding: 5px 10px; font-size: 12px; margin-top: 5px;">
                                        <i class="fas fa-exclamation-circle"></i> Máximo 1000 asistentes.
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Estado:</label>
                                    <select class="form-control" name="estado" id="estado">
                                        <option value="Completado">Completado</option>
                                        <option value="En Proceso">En Proceso</option>
                                        <option value="Pendiente">Pendiente</option>
                                        <option value="Cancelado">Cancelado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group label-floating">
                            <label class="control-label"><span class="text-danger">*</span> Descripción:</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="4" required></textarea>
                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="desc-error" style="display: none; padding: 5px 10px; font-size: 12px; margin-top: 5px;">
                                <i class="fas fa-exclamation-circle"></i> Solo letras, números y espacios.
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-info btn-raised">Guardar Actividad</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
    </section>

    <script src="<?= PUBLIC_PATH ?>/js/validations/event/actividad.js"></script>
    <?php
    include  VIEW_PATH . "/component/scripts.php";
    ?>
</body>

</html>