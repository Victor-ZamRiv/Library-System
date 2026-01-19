<!DOCTYPE html>
<html lang="es">

<?php
include "../component/heat.php";
?>

<body>

    <?php
    include "../component/sidebar.php";
    ?>
    <section class="full-box dashboard-contentPage">
        <?php
        include "../component/navbar.php";
        ?>
        <div class="container-fluid ">
            <div class="page-header">
                <h1 class="text-titles"> </h1>
                <h1 class="text-titles"><i class="fa-solid fa-bookmark"></i> Préstamo <small> Registrar Nuevo Préstamo</small></h1>
            </div>
        </div>

        <div class="container-fluid text-center" style="max-width: 600px;">
            <div class="d-inline-block" style=" width: 100%;">
                <div class="card shadow-lg p-3 mb-4 bg-white rounded">
                    <div class="card-body">
                        <h3 class="text-center text-titles">Registrar Nuevo Préstamo</h3>
                        <form action="#!" method="POST">

                            <div class="form-group">
                                <label for="carnet_solicitante" class="control-label text-left" style="display: block;">Carnet del solicitante:</label>
                                <input type="text" pattern="[a-zA-Z0-9-]{1,100}" class="form-control" name="carnet_solicitante" id="carnet_solicitante" maxlength="100" required="">
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="libro1" class="control-label text-left" style="display: block;">Libro 1:</label>
                                        <input type="text" pattern="[a-zA-Z0-9- .]{1,50}" class="form-control" name="libro1" id="libro1" placeholder="Cota" maxlength="50" required="">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="libro2" class="control-label text-left" style="display: block;">Libro 2:</label>
                                        <input type="text" pattern="[a-zA-Z0-9- .]{1,50}" class="form-control" name="libro2" id="libro2" maxlength="50">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="libro3" class="control-label text-left" style="display: block;">Libro 3:</label>
                                        <input type="text" pattern="[a-zA-Z0-9- .]{1,50}" class="form-control" name="libro3" id="libro3" maxlength="50">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-right">
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

    <?php
    include "../component/scripts.php";
    ?>
</body>

</html>