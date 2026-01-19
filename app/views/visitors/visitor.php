<!DOCTYPE html>
<html lang="es">

<title>Registro de Visitantes</title>
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
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-users"></i> Visitantes <small> Registro de Visitantes</small></h1>
            </div>
        </div>

        <div class="container-fluid text-center" style="max-width: 900px;">
            <div class="card shadow-lg p-3 mb-4 bg-white rounded text-left">
                <div class="card-body">
                    <h3 class="text-center text-titles">Formulario de Visitantes</h3>
                    <hr>
                    <form action="#!" method="POST">
                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Fecha:</label>
                                    <input type="date" class="form-control" name="fecha" required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Turno:</label>
                                    <select class="form-control" name="turno">
                                        <option value="Mañana">Mañana</option>
                                        <option value="Tarde">Tarde</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <br>
                        <h4 class="text-titles"><i class="fa-solid fa-person-walking"></i> Distribución de Visitantes</h4>
                        <div class="row text-center bg-light p-2 rounded">
                            <div class="col-xs-12 col-sm-4 border-right">
                                <strong>Niños</strong>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="ninos_f" placeholder="Femenino (F)">
                                    <input type="number" class="form-control mt-2" name="ninos_m" placeholder="Masculino (M)">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 border-right">
                                <strong>Adolescentes</strong>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="adol_f" placeholder="Femenino (F)">
                                    <input type="number" class="form-control mt-2" name="adol_m" placeholder="Masculino (M)">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <strong>Adultos</strong>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="adultos_f" placeholder="Femenino (F)">
                                    <input type="number" class="form-control mt-2" name="adultos_m" placeholder="Masculino (M)">
                                </div>
                            </div>
                        </div>

                        <br>
                        <h4 class="text-titles"><i class="fa-solid fa-book"></i> Obras (Clasificación)</h4>
                        <div class="row">
                            <?php 
                            $categorias = ["000", "100", "200", "300", "400", "500", "600", "700", "800", "900", "Biog"];
                            foreach($categorias as $cat): ?>
                            <div class="col-xs-4 col-sm-2">
                                <div class="form-group">
                                    <label><small><?php echo $cat; ?></small></label>
                                    <input type="number" class="form-control p-1" name="obra_<?php echo $cat; ?>" value="0">
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <hr>
                        

                        <div class="form-group">
                            <label class="control-label">Observaciones:</label>
                            <textarea class="form-control" name="observaciones" rows="2"></textarea>
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
        <br>
    </section>

    <?php
    include "../component/scripts.php";
    ?>
</body>
</html>