<!DOCTYPE html>
<html lang="es">

<title>Editar Actividad</title>
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
                    <i class="fa-solid fa-calendar-check"></i> Eventos
                    <small> Editar Actividad</small>
                </h1>
            </div>
        </div>

        <div class="container-fluid text-center" style="max-width: 900px;">
            <div class="card shadow-lg p-3 mb-4 bg-white rounded text-left">
                <div class="card-body">
                    <h3 class="text-center text-titles">Actualizar Formulario</h3>
                    <hr>

                    <form action="?c=Actividad&m=update" method="POST" id="form-editar-actividad">
                        <!-- CAMPO OCULTO PARA EL ID -->
                        <input type="hidden" name="id_actividad" value="<?= $actividad->id_actividad ?>">

                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label"><span class="text-danger">*</span> Fecha del Evento:</label>
                                    <!-- VALUE CON LA FECHA -->
                                    <input type="date" class="form-control" name="fecha" id="fecha" 
                                           value="<?= $actividad->fecha ?>" onkeydown="return false" required>
                                    <div class="invalid-feedback bg-danger text-danger rounded-pill" id="fecha-error" style="display: none; padding: 5px 10px; font-size: 12px; margin-top: 5px;">
                                        <i class="fas fa-exclamation-circle"></i> Fecha fuera de rango.
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
                                            <option value="<?= $cat ?>" <?= ($actividad->categoria == $cat) ? 'selected' : '' ?>>
                                                <?= ($cat == "Reunión") ? "Reunión / Asamblea" : $cat ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Número de Asistentes:</label>
                                    <input type="number" class="form-control" name="asistentes" id="asistentes" 
                                           value="<?= $actividad->asistentes ?>" placeholder="0">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Estado:</label>
                                    <select class="form-control" name="estado" id="estado">
                                        <?php 
                                        $estados = ["Completado", "En Proceso", "Pendiente", "Cancelado"];
                                        foreach($estados as $est): ?>
                                            <option value="<?= $est ?>" <?= ($actividad->estado == $est) ? 'selected' : '' ?>>
                                                <?= $est ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group label-floating">
                            <label class="control-label"><span class="text-danger">*</span> Descripción:</label>
                            <!-- EL TEXTAREA NO USA VALUE, SE PONE DENTRO DE LAS ETIQUETAS -->
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="4" required><?= $actividad->descripcion ?></textarea>
                        </div>

                        <div class="form-group text-right">
                            <a href="?c=Actividad" class="btn btn-default btn-raised">Cancelar</a>
                            <button type="submit" class="btn btn-success btn-raised">Actualizar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
    </section>

    <!-- Puedes usar el mismo JS si las validaciones son idénticas -->
    <script src="<?= PUBLIC_PATH ?>/js/validations/event/actividad.js"></script>
    <?php
    include VIEW_PATH . "/component/scripts.php";
    ?>
</body>
</html>