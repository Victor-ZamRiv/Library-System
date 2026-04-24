<!DOCTYPE html>
<html lang="es">

<title>Registro de Visitantes</title>
<?php  include VIEW_PATH . "/component/heat.php"; ?>

<body>

    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-users"></i> Visitas <small> Registro de Visitas</small></h1>
            </div>
        </div>

        <div class="container-fluid text-center" style="max-width: 900px;">
            <div class="card shadow-lg p-3 mb-4 bg-white rounded text-left">
                <div class="card-body">
                    <h3 class="text-center text-titles">Formulario de Visitas</h3>
                    <hr>
                    <form action="<?= BASE_URL ?>/visitantes/store" method="POST" id="form-registro-visitantes">

                        <div class="row">
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label"><span class="text-danger">*</span> Fecha:</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        name="fecha"
                                        id="fecha-reg"
                                        required
                                        onkeydown="return false">
                                    <div class="invalid-feedback bg-danger text-danger rounded-pill" id="fecha-error" style="display: none;">
                                        <i class="fas fa-exclamation-circle"></i> La fecha debe ser hoy o máximo 3 días atrás.
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label"><span class="text-danger">*</span> Sala:</label>
                                    <select class="form-control" name="sala">
                                        <option selected disabled>Seleccione una Sala</option>
                                        <option value="Sala General">Sala General</option>
                                        <option value="Sala de Referencia">Sala de Referencia</option>
                                        <option value="Sala Estatal">Sala Estatal</option>
                                        <option value="Sala Infantil">Sala Infantil</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label"><span class="text-danger">*</span> Turno:</label>
                                    <select class="form-control" name="turno">
                                        <option selected disabled>Seleccione un Turno</option>
                                        <option value="Mañana">Mañana</option>
                                        <option value="Tarde">Tarde</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <br>
                        <h4 class="text-titles"><i class="fa-solid fa-person-walking"></i> Distribución de Visitantes</h4>
                        <div class="row text-center bg-light p-2 rounded">
                            <?php
                            $grupos = ['ninos' => 'Niños', 'adol' => 'Adolescentes', 'adultos' => 'Adultos'];
                            foreach ($grupos as $key => $label): ?>
                                <div class="col-xs-12 col-sm-4 border-right">
                                    <div class="form-group label-floating">
                                        <strong><?php echo $label; ?></strong>
                                        <br>
                                        <input type="number" class="form-control input-numerico"
                                            name="<?php echo $key; ?>_f" id="<?php echo $key; ?>_f"
                                            placeholder="Femenino (F)" min="0" required>

                                        <input type="number" class="form-control mt-2 input-numerico"
                                            name="<?php echo $key; ?>_m" id="<?php echo $key; ?>_m"
                                            placeholder="Masculino (M)" min="0" required>

                                        <div class="invalid-feedback bg-danger text-danger rounded-pill error-msg" style="display: none;">
                                            <i class="fas fa-exclamation-circle"></i> Solo números positivos.
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <br>
                        <h4 class="text-titles"><i class="fa-solid fa-book"></i> Obras (Clasificación)</h4>
                        <div class="row">
                            <?php
                            $categorias = ["000", "100", "200", "300", "400", "500", "600", "700", "800", "900", "Biog"];
                            foreach ($categorias as $cat): ?>
                                <div class="col-xs-4 col-sm-2">
                                    <div class="form-group label-floating">
                                        <label><small><?php echo $cat; ?></small></label>
                                        <input type="number" class="form-control p-1 input-numerico" name="obra_<?php echo $cat; ?>" id="obra_<?php echo $cat; ?>" value="0" min="0" required>
                                        <div class="invalid-feedback bg-danger text-danger rounded-pill error-msg" style="display: none; font-size: 0.7em;">
                                            <i class="fas fa-exclamation-circle"></i> Error.
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <hr>
                        <div class="form-group label-floating">
                            <label class="control-label">Observaciones:</label>
                            <textarea
                                class="form-control input-validar"
                                name="observaciones"
                                id="observaciones"
                                rows="2"
                                pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s]+$"></textarea>
                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="obs-error" style="display: none;">
                                <i class="fas fa-exclamation-circle"></i> Solo se permiten letras, números y espacios en las observaciones.
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-info btn-raised">
                                <i class="fa-solid fa-floppy-disk"></i> Guardar Registro
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    
    <script src="<?= PUBLIC_PATH ?>/js/validations/visitor/createvisitor.js"></script>
    <?php include VIEW_PATH . "/component/scripts.php"; ?>
    
</body>

</html>