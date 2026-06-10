<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Actividad</title>
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
                    <i class="fa-solid fa-calendar-check"></i> Editar Actividad
                </h1>
            </div>
        </div>

        <div class="container-fluid text-center" style="max-width: 900px;">
            <div class="card shadow-lg p-3 mb-4 bg-white rounded text-left">
                <div class="card-body">
                    <h3 class="text-center text-titles">Actualizar Formulario</h3>
                    <hr>

                    <form action="<?= BASE_URL ?>/actividad/update" method="POST" id="form-editar-actividad">
                        <input type="hidden" name="id" value="<?= $actividad->getIdActividad() ?>">

                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label"><span class="text-danger">*</span> Fecha del Evento:</label>
                                    <input type="date" class="form-control" name="fecha" id="fecha" 
                                           value="<?= $actividad->getFecha() ?>" onkeydown="return false" required>
                                    <div class="invalid-feedback bg-danger text-danger rounded-pill" id="fecha-error" style="display: none; padding: 5px 15px; font-size: 12px; margin-top: 5px;">
                                        <i class="fas fa-exclamation-circle"></i> La fecha del evento es obligatoria.
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label"><span class="text-danger">*</span> Categoría:</label>
                                    <select class="form-control" name="categoria" id="categoria" required>
                                        <?php 
                                        $categorias = ["Cultural", "Educativa", "Mantenimiento", "Reunión", "Otro"];
                                        foreach($categorias as $cat): ?>
                                            <option value="<?= $cat ?>" <?= ($actividad->getCategoria() == $cat) ? 'selected' : '' ?>>
                                                <?= ($cat == "Reunión") ? "Reunión / Asamblea" : $cat ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback bg-danger text-danger rounded-pill" id="cat-error" style="display: none; padding: 5px 15px; font-size: 12px; margin-top: 5px;">
                                        <i class="fas fa-exclamation-circle"></i> Debe seleccionar una categoría de forma obligatoria.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label"><span class="text-danger">*</span> Número de Asistentes:</label>
                                    <input type="number" class="form-control" name="asistentes" id="asistentes" 
                                           value="<?= $actividad->getAsistentes() ?>" placeholder="0" min="1" max="1000" required>
                                    <div class="invalid-feedback bg-danger text-danger rounded-pill" id="asist-error" style="display: none; padding: 5px 15px; font-size: 12px; margin-top: 5px;">
                                        <i class="fas fa-exclamation-circle"></i> El número de asistentes es obligatorio.
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Estado:</label>
                                    <select class="form-control" name="estado" id="estado">
                                        <?php 
                                        $estados = ["Completado", "En Proceso", "Pendiente", "Cancelado"];
                                        foreach($estados as $est): ?>
                                            <option value="<?= $est ?>" <?= ($actividad->getEstado() == $est) ? 'selected' : '' ?>>
                                                <?= $est ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label"><span class="text-danger">*</span> Organizador:</label>
                                    <input type="text" class="form-control" name="organizador" id="organizador" 
                                           value="<?= method_exists($actividad, 'getOrganizador') ? $actividad->getOrganizador() : '' ?>" placeholder="Nombre del organizador" required>
                                    <div class="invalid-feedback bg-danger text-danger rounded-pill" id="org-error" style="display: none; padding: 5px 15px; font-size: 12px; margin-top: 5px;">
                                        <i class="fas fa-exclamation-circle"></i> El campo organizador es obligatorio.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group label-floating">
                            <label class="control-label"><span class="text-danger">*</span> Descripción:</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="4" placeholder="Detalles de la actividad..." required><?= $actividad->getDescripcion() ?></textarea>
                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="desc-error" style="display: none; padding: 5px 15px; font-size: 12px; margin-top: 5px;">
                                <i class="fas fa-exclamation-circle"></i> La descripción de la actividad es obligatoria.
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <a href="<?= BASE_URL ?>/eventos" class="btn btn-default btn-raised">Cancelar</a>
                            <button type="submit" class="btn btn-success btn-raised">Actualizar Cambios</button>
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