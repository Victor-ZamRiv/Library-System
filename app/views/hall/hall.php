<!DOCTYPE html>
<html lang="es">
<head>
    <title>Configuración de Salas</title>
    <?php include VIEW_PATH . "/component/heat.php"; ?>
    
</head>

<body>
    <?php include VIEW_PATH .  "/component/sidebar.php"; ?>
    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH .  "component/navbar.php"; ?>

        <div class="container-fluid" style="padding-top: 20px;">
            <div class="page-header">
                <h2 class="text-titles text-center">
                     Configuración de Salas
                </h2>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-10 col-md-offset-1">
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
                                            <th class="text-center">ESTADO</th>
                                            <th class="text-center">INTERRUPTOR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>SALA GENERAL</strong></td>
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
                                            <td><span class="label label-success">Activa</span></td>
                                            <td>
                                                <div class="toggle">
                                                    <label>
                                                        <input type="checkbox" name="sala_referencia" checked>
                                                        Habilitar
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>SALA ESTATAL</td>
                                            <td><span class="label label-danger">Inactiva</span></td>
                                            <td>
                                                <div class="toggle">
                                                    <label>
                                                        <input type="checkbox" name="sala_estatal">
                                                        Habilitar
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>SALA INFANTIL</td>
                                            <td><span class="label label-success">Activa</span></td>
                                            <td>
                                                <div class="toggle">
                                                    <label>
                                                        <input type="checkbox" name="sala_infantil" checked>
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
                            <button type="submit" class="btn btn-primary btn-raised">
                                <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </section>

    <?php include VIEW_PATH . "/component/scripts.php"; ?>
</body>
</html>