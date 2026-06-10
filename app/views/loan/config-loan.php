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
                    <form action="<?= BASE_URL ?>/configuracion/prestamos/update" method="POST" id="formPrestamos">
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
                                            <input class="form-control" type="number" name="dias_prestamo" value="<?= $configuracion->getDiasPrestamo() ?>" min="1" max="99" required>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Días de Préstamo (Novelas)</label>
                                            <input class="form-control" type="number" name="dias_prestamo_novelas" value="<?= $configuracion->getDiasPrestamoNovelas() ?>" min="1" max="99" required>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Monto Multa por Día ($)</label>
                                            <input class="form-control" type="number" step="0.01" name="monto_multa_dia" value="<?= $configuracion->getMontoMultaDia() ?>" min="0.01" max="99.99" required>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Límite de Préstamos Simultáneos</label>
                                            <input class="form-control" type="number" name="maximo_prestamos" value="<?= $configuracion->getLimitePrestamosSimultaneos() ?>" min="1" max="99" required>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label">Máximo de Renovaciones Permitidas</label>
                                            <input class="form-control" type="number" name="max_renovaciones" value="<?= $configuracion->getMaxRenovaciones() ?>" min="1" max="99" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="panel-footer text-right">
                                <button type="button" class="btn btn-success btn-raised" id="btnGuardarPrestamos">
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
    <?php include VIEW_PATH . "/modal/save-config-loan.php"; ?>

    <script>
$(document).ready(function() {
    
    /**
     * VALIDACIÓN GLOBAL (En tiempo real)
     * Controla: > 0, máximo 2 dígitos enteros y máximo 2 dígitos decimales.
     */
    $('#formPrestamos').on('input', 'input[type="number"]', function() {
        let elemento = $(this);
        let valorActual = elemento.val();
        
        // Regla 1: No permitir números menores o iguales a 0
        if (parseFloat(valorActual) <= 0) {
            elemento.val(''); 
            return;
        }

        // Regla 2: Límites de dígitos (2 enteros y máximo 2 decimales)
        if (valorActual.includes('.')) {
            let partes = valorActual.split('.');
            
            // Validar la parte entera (máximo 2 dígitos)
            if (partes[0].length > 2) {
                partes[0] = partes[0].slice(0, 2);
            }
            
            // Validar la parte decimal (máximo 2 dígitos)
            if (partes[1].length > 2) {
                partes[1] = partes[1].slice(0, 2);
            }
            
            // Reconstruir el número con los recortes aplicados
            elemento.val(partes.join('.'));
        } else {
            // Si no tiene punto decimal, solo validamos que el entero no pase de 2 dígitos
            if (valorActual.length > 2) {
                elemento.val(valorActual.slice(0, 2));
            }
        }
    });

    /**
     * CONTROL DEL MODAL Y VALIDACIÓN FINAL
     */
    $('#btnGuardarPrestamos').on('click', function() {
        let formulario = document.getElementById('formPrestamos');
        
        // Valida los atributos nativos de HTML5 (min, max, required) antes de proceder
        if (!formulario.checkValidity()) {
            formulario.reportValidity(); // Dispara los globos de texto nativos del navegador
            return; // Bloquea la apertura del modal si hay errores
        }
        
        // Si todo está correcto, actualiza el resumen del modal con los valores validados
        $('#diasPrestamoResumen').text($('input[name="dias_prestamo"]').val());
        $('#diasNovelasResumen').text($('input[name="dias_prestamo_novelas"]').val());
        $('#montoMultaResumen').text($('input[name="monto_multa_dia"]').val());
        $('#maxPrestamosResumen').text($('input[name="maximo_prestamos"]').val());
        $('#maxRenovacionesResumen').text($('input[name="max_renovaciones"]').val());
        
        // Abre el modal de confirmación de manera segura
        $('#confirmSavePrestamosModal').modal('show');
    });
});
</script>

</body>
</html>