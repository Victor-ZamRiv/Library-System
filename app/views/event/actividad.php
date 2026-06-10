<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Actividad</title>
    <?php
    include VIEW_PATH . "/component/heat.php";
    ?>
</head>

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
                    <i class="fa-solid fa-calendar"></i> Registro de Actividades
                </h1>
            </div>
        </div>

        <div class="container-fluid text-center" style="max-width: 900px;">
            <div class="card shadow-lg p-3 mb-4 bg-white rounded text-left">
                <div class="card-body">
                    <h3 class="text-center text-titles">Formulario de Actividades</h3>
                    <hr>

                    <form action="<?= BASE_URL ?>/actividad/store" method="POST" id="form-registro-actividad">
                        <input type="hidden" name="idAdmin" value="<?= $_SESSION['administrador']['id'] ?>">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label"><span class="text-danger">*</span> Fecha del Evento:</label>
                                    <input type="date" class="form-control" name="fecha" id="fecha" onkeydown="return false" required>
                                    <div class="invalid-feedback bg-danger text-danger rounded-pill" id="fecha-error" style="display: none; padding: 5px 15px; font-size: 12px; margin-top: 5px;"></div>
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
                                    <div class="invalid-feedback bg-danger text-danger rounded-pill" id="cat-error" style="display: none; padding: 5px 15px; font-size: 12px; margin-top: 5px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label"><span class="text-danger">*</span> Número de Asistentes:</label>
                                    <input type="number" class="form-control" name="asistentes" id="asistentes" placeholder="0" min="1" max="1000" required>
                                    <div class="invalid-feedback bg-danger text-danger rounded-pill" id="asist-error" style="display: none; padding: 5px 15px; font-size: 12px; margin-top: 5px;"></div>
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
                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label"><span class="text-danger">*</span> Organizador:</label>
                                    <input type="text" class="form-control" name="organizador" id="organizador" placeholder="Nombre del organizador" required>
                                    <div class="invalid-feedback bg-danger text-danger rounded-pill" id="org-error" style="display: none; padding: 5px 15px; font-size: 12px; margin-top: 5px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group label-floating">
                            <label class="control-label"><span class="text-danger">*</span> Descripción:</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="4" placeholder="Detalles de la actividad..." required></textarea>
                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="desc-error" style="display: none; padding: 5px 15px; font-size: 12px; margin-top: 5px;"></div>
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
    include VIEW_PATH . "/component/scripts.php";
    ?>
</body>

</html>