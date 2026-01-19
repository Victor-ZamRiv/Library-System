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

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-bookmark"></i> Multas <small>Nueva Multa</small></h1>
            </div>
        </div>

        <?php include "../component/finebar.php" ?>

        <div class="container-fluid">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; CREAR MULTA</h3>
                </div>
                <div class="panel-body">
                    <form action="" method="POST" autocomplete="off" id="form-multa">

                        <fieldset>
                            <legend><i class="zmdi zmdi-search"></i> &nbsp; Buscar Préstamo</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-9">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="busqueda-multa"><span class="text-danger">*</span> Número de Préstamo (Solo números)</label>
                                            <input 
                                                pattern="[0-9]{1,15}" 
                                                class="form-control" 
                                                type="text" 
                                                name="busqueda-multa" 
                                                id="busqueda-multa" 
                                                required
                                                title="Ingrese solo números (máximo 15 dígitos)"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('busqueda-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('busqueda-error').style.display = 'none'; }">
                                            
                                            <div class="invalid-feedback bg-danger text-white p-1 rounded" id="busqueda-error" style="display: none; color:red; margin-top: 5px;">
                                                <i class="fa-solid fa-circle-exclamation"></i> Ingrese un número de préstamo válido (solo números).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-3">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-info btn-raised btn-block">
                                                BUSCAR
                                            </button>
                                        </div>
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
                                            <label class="control-label" for="monto"><span class="text-danger">*</span> Monto a Pagar (Ejem. 15.25)</label>
                                            <input 
                                                pattern="^[0-9]+(\.[0-9]{1,2})?$" 
                                                class="form-control" 
                                                type="text" 
                                                name="monto-multa" 
                                                id="monto" 
                                                required 
                                                placeholder="0.00"
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('monto-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('monto-error').style.display = 'none'; }">
                                            
                                            <div class="invalid-feedback bg-danger text-white p-1 rounded" id="monto-error" style="display: none; color:red; margin-top: 5px;">
                                                <i class="fa-solid fa-circle-exclamation"></i> El monto debe ser mayor a 0 y usar punto para decimales (Ejem: 10.50).
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="concepto"><span class="text-danger">*</span> Concepto de la Multa</label>
                                            <input 
                                                pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{5,100}" 
                                                class="form-control" 
                                                type="text" 
                                                name="concepto-multa" 
                                                id="concepto" 
                                                required
                                                onblur="if (!this.checkValidity()) { this.classList.add('is-invalid'); this.classList.remove('is-valid'); document.getElementById('concepto-error').style.display = 'block'; } else { this.classList.remove('is-invalid'); this.classList.add('is-valid'); document.getElementById('concepto-error').style.display = 'none'; }">
                                            
                                            <div class="invalid-feedback bg-danger text-white p-1 rounded" id="concepto-error" style="display: none; color:red; margin-top: 5px;">
                                                <i class="fa-solid fa-circle-exclamation"></i> Ingrese un concepto válido (mínimo 5 caracteres, solo letras).
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <br>

                        <fieldset>
                            <legend><i class="zmdi zmdi-check-circle"></i> &nbsp; Estado de Pago</legend>
                            <div class="container-fluid">
                                <div class="row text-center">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="estado-pago" value="pendiente" checked="">
                                                <span class="circle"></span><span class="check"></span>
                                                <i class="zmdi zmdi-time-restore"></i> &nbsp; Pendiente
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="estado-pago" value="pagado">
                                                <span class="circle"></span><span class="check"></span>
                                                <i class="zmdi zmdi-check-circle"></i> &nbsp; Pagado
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <p class="text-center" style="margin-top: 40px;">
                            <button type="submit" class="btn btn-info btn-raised btn-lg">
                                <i class="zmdi zmdi-floppy"></i> &nbsp; GUARDAR REGISTRO
                            </button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include "../component/scripts.php" ?>
    <script src="../../../public/js/validations/fine/createfine.js"></script>
   
</body>

</html>