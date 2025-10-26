<!DOCTYPE html>
<html lang="es">

<head>
    <title>Gestión de Multas</title>
    <?php include "../component/heat.php" ?>
</head>
<body>
    <?php include "../component/sidebar.php" ?>


    <section class="full-box dashboard-contentPage">
        <?php include "../component/navbar.php" ?>
        <?php include "../component/finebar.php" ?>

        <div class="container-fluid">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="zmdi zmdi-money-off"></i> &nbsp; GESTIÓN DE MULTAS</h3>
                </div>
                <div class="panel-body">
                    <form>
                        <fieldset>
                            <legend><i class="zmdi zmdi-search"></i> &nbsp; Buscar Préstamo / Usuario</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-8">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Código de Préstamo o Cédula del Usuario</label>
                                            <input pattern="[a-zA-Z0-9-]{1,50}" class="form-control" type="text" name="busqueda-multa" required="" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-4">
                                        <p class="text-center" style="margin-top: 20px;">
                                            <button type="button" class="btn btn-primary btn-raised btn-sm"><i class="zmdi zmdi-search"></i> Buscar</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        
                        <fieldset>
                            <legend><i class="zmdi zmdi-alert-octagon"></i> &nbsp; Detalles de la Multa</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Monto a Pagar ($)</label>
                                            <input pattern="[0-9.]{1,10}" class="form-control" type="number" step="0.01" name="monto-multa" required="" maxlength="10">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Concepto de la Multa</label>
                                            <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9,. ]{1,100}" class="form-control" type="text" name="concepto-multa" required="" maxlength="100">
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Observaciones (Opcional)</label>
                                            <textarea name="observaciones-multa" class="form-control" rows="2" maxlength="150"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <br>

                        <fieldset>
                            <legend><i class="zmdi zmdi-check-circle"></i> &nbsp; Estado de Pago</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="estado-pago" id="pago-pendiente" value="pendiente" checked="">
                                                <i class="zmdi zmdi-time-restore"></i> &nbsp; Pendiente de Pago
                                            </label>
                                        </div>
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="estado-pago" id="pago-realizado" value="pagado">
                                                <i class="zmdi zmdi-check-circle"></i> &nbsp; Pago Realizado
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        
                        <p class="text-center" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Registrar Multa</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
        
    </section>

    <?php include "../component/scripts.php" ?>

</body>
</html>