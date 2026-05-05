<!DOCTYPE html>
<html lang="es">
<head>
    <title>Configuración de Préstamos</title>
    <?php include VIEW_PATH . "/component/heat.php"; ?>
</head>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>

        <div class="container-fluid" style="padding-top: 20px;">
            <div class="page-header">
                <h2 class="text-titles text-center">
                    <i class="fa-solid fa-gears"></i> Configuración de Parámetros de Préstamo
                </h2>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-10 col-md-offset-1">
                    <form action="<?= BASE_URL ?>/configuracion/prestamos/update" method="POST">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa-solid fa-clock"></i> Valores y Límites del Sistema</h3>
                            </div>
                            <div class="panel-body">
                                <p class="text-muted">Ajuste los valores globales para el control de préstamos, multas y renovaciones.</p>
                                
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Días de Préstamo (General)</label>
                                            <input class="form-control" type="number" name="dias_prestamo" value="<?= $configuracion->getDiasPrestamo() ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Días de Préstamo (Novelas)</label>
                                            <input class="form-control" type="number" name="dias_prestamo_novelas" value="<?= $configuracion->getDiasPrestamoNovelas() ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Monto Multa por Día ($)</label>
                                            <input class="form-control" type="number" step="0.01" name="monto_multa_dia" value="<?= $configuracion->getMontoMultaDia() ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Límite de Préstamos Simultáneos</label>
                                            <input class="form-control" type="number" name="maximo_prestamos" value="<?= $configuracion->getLimitePrestamosSimultaneos() ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Máximo de Renovaciones Permitidas</label>
                                            <input class="form-control" type="number" name="max_renovaciones" value="<?= $configuracion->getMaxRenovaciones() ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="panel-footer text-right">
                                <button type="submit" class="btn btn-success btn-raised">
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
</body>
</html>