<!DOCTYPE html>
<html lang="es">
<head>
    <title>Configuración de Salas</title>
    <?php include VIEW_PATH . "/component/heat.php"; ?>
</head>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "component/navbar.php"; ?>

        <div class="container-fluid" style="padding-top: 20px;">
            <div class="page-header">
                <h2 class="text-titles text-center">
                     Configuración de Salas
                </h2>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <form method="POST" action="<?= BASE_URL ?>/configuracion/sala/update" id="formSalas">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa-solid fa-sliders"></i> Control de Acceso a Salas</h3>
                            </div>
                            <div class="panel-body">
                                <p class="text-muted">Active o desactive las salas disponibles. Los cambios se aplicarán al presionar el botón de guardado.</p>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover text-center">
                                        <thead>
                                            <tr>
                                                <th class="text-center">SALA</th>
                                                <th class="text-center">CAPACIDAD</th>
                                                <th class="text-center">ESTADO</th>
                                                <th class="text-center">INTERRUPTOR</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>SALA GENERAL</strong></td>
                                                <td>
                                                    <input type="number" class="form-control input-sm text-center" name="capacidad_general" value="<?= $salas['G']->getCapacidad() ?>" min="1" max="500" style="width: 80px;">
                                                </td>
                                                <td><span class="label label-success">Siempre Activa</span></td>
                                                <td>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" checked disabled>
                                                            <span class="text-muted">Fijo</span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>SALA DE REFERENCIA</td>
                                                <td>
                                                    <input type="number" class="form-control input-sm text-center" name="capacidad_referencia" value="<?= $salas['R']->getCapacidad() ?>" min="1" max="200" style="width: 80px;">
                                                </td>
                                                <?php if ($salas['R']->getDisponible()): ?>
                                                    <td><span class="label label-success">Activa</span></td>
                                                <?php else: ?>
                                                    <td><span class="label label-danger">Inactiva</span></td>
                                                <?php endif; ?>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="sala_referencia" <?= $salas['R']->getDisponible() ? 'checked' : '' ?>>
                                                            Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>SALA ESTATAL</td>
                                                <td>
                                                    <input type="number" class="form-control input-sm text-center" name="capacidad_estatal" value="<?= $salas['E']->getCapacidad() ?>" min="1" max="300" style="width: 80px;">
                                                </td>
                                                <?php if ($salas['E']->getDisponible()): ?>
                                                    <td><span class="label label-success">Activa</span></td>
                                                <?php else: ?>
                                                    <td><span class="label label-danger">Inactiva</span></td>
                                                <?php endif; ?>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="sala_estatal" <?= $salas['E']->getDisponible() ? 'checked' : '' ?>>
                                                            Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>SALA INFANTIL</td>
                                                <td>
                                                    <input type="number" class="form-control input-sm text-center" name="capacidad_infantil" value="<?= $salas['I']->getCapacidad() ?>" min="1" max="100" style="width: 80px;">
                                                </td>
                                                <?php if ($salas['I']->getDisponible()): ?>
                                                    <td><span class="label label-success">Activa</span></td>
                                                <?php else: ?>
                                                    <td><span class="label label-danger">Inactiva</span></td>
                                                <?php endif; ?>
                                                <td>
                                                    <div class="toggle">
                                                        <label>
                                                            <input type="checkbox" name="sala_infantil" <?= $salas['I']->getDisponible() ? 'checked' : '' ?>>
                                                            Habilitar
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="panel-footer text-right">
                                <button type="button" class="btn btn-primary btn-raised" id="btnGuardarCambios">
                                    <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    

    <?php include VIEW_PATH . "/component/scripts.php"; ?>
    <?php include VIEW_PATH . "/modal/save-config-hall.php"; ?>

    <script>
    $(document).ready(function() {
        // Abrir modal al hacer clic en Guardar
        $('#btnGuardarCambios').on('click', function() {
            $('#confirmSaveModal').modal('show');
        });
    });
    </script>

</body>
</html>