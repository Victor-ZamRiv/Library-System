<!DOCTYPE html>
<html lang="es">

<head>
    <title>Nuevo Préstamo</title>
    <?php include VIEW_PATH . "/component/heat.php"; ?>
</head>

<body>

    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>

        <div class="container-fluid ">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-bookmark"></i> Préstamo <small> Registrar Nuevo Préstamo</small></h1>
            </div>
        </div>

        <div class="container-fluid text-center" style="max-width: 600px;">
            <div class="d-inline-block" style=" width: 100%;">
                <div class="card shadow-lg p-3 mb-4 bg-white rounded">
                    <div class="card-body">
                        <h3 class="text-center text-titles">Registrar Nuevo Préstamo</h3>
                        <form action="#!" method="POST">

                            <!-- CARNET DEL SOLICITANTE -->
                            <div class="form-group">
                                <label for="carnet-reg" class="control-label text-left" style="display: block;">
                                    Carnet del solicitante <span style="color: red;">*</span>:
                                </label>
                                <input type="text" class="form-control" name="carnet_solicitante" id="carnet-reg" maxlength="10" required>

                                <div class="invalid-feedback bg-danger text-danger rounded-pill" id="carnet-error" style="display: none; padding: 2px 10px; margin-top: 5px;">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                            </div>

                            <div class="row">
                                <!-- LIBRO 1 -->
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="libro1" class="control-label text-left" style="display: block;">
                                            Libro 1 <span style="color: red;">*</span>:
                                        </label>
                                        <input type="text" class="form-control cota-input" name="libro1" id="libro1"
                                            placeholder="Cota" maxlength="30" required disabled oninput="validarCota(this)">

                                        <div class="invalid-feedback bg-danger text-danger rounded-pill" id="error-libro1" style="display: none; padding: 2px 10px; margin-top: 5px;">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- LIBRO 2 -->
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="libro2" class="control-label text-left" style="display: block;">Libro 2:</label>
                                        <input type="text" class="form-control cota-input" name="libro2" id="libro2"
                                            placeholder="Cota" maxlength="30" disabled oninput="validarCota(this)">

                                        <div class="invalid-feedback bg-danger text-danger rounded-pill" id="error-libro2" style="display: none; padding: 2px 10px; margin-top: 5px;">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- LIBRO 3 -->
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="libro3" class="control-label text-left" style="display: block;">Libro 3:</label>
                                        <input type="text" class="form-control cota-input" name="libro3" id="libro3"
                                            placeholder="Cota" maxlength="30" disabled oninput="validarCota(this)">

                                        <div class="invalid-feedback bg-danger text-danger rounded-pill" id="error-libro3" style="display: none; padding: 2px 10px; margin-top: 5px;">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-right" style="margin-top: 20px;">
                                <button type="submit" class="btn btn-success btn-raised">
                                    Siguiente
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </section>

    <!--====== Scripts -->
    <?php include VIEW_PATH . "/component/scripts.php"; ?>
    <script>
        // Una sola constante base para que el JS concatene los endpoints
        const BASE_URL = '<?= BASE_URL ?>';
    </script>
    <script src="<?php echo PUBLIC_PATH; ?>/js/validations/loan/createloan.js"></script>

    <!-- Modal de Confirmación de Préstamo -->
    <div class="modal fade" id="modalConfirmar" tabindex="-1" role="dialog" aria-labelledby="modalConfirmarLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalConfirmarLabel">Confirmar Préstamo</h4>
                </div>
                <div class="modal-body">
                    <p><strong>Lector:</strong> <span id="res-nombre-lector"></span></p>
                    <div id="contenedor-libros-confirmacion">
                        <!-- Aquí se cargarán los libros y sus selectores de ejemplares -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn-confirmar-final" class="btn btn-primary">Confirmar Préstamo</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>