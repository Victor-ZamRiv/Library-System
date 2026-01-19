<!DOCTYPE html>
<html lang="es">

<title>Registro de Actividad</title>
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
                <h1 class="text-titles">
                    <i class="fa-solid fa-calendar"></i> Eventos
                    <small> Registro de Actividades</small>
                </h1>
            </div>
        </div>

        <div class="container-fluid text-center" style="max-width: 900px;">
            <div class="card shadow-lg p-3 mb-4 bg-white rounded text-left">
                <div class="card-body">
                    <h3 class="text-center text-titles">Formulario de Actividades</h3>
                    <hr>
                    
                    <form action="tu_controlador_logros.php" method="POST">
                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Fecha del Evento:</label>
                                    <input type="date" class="form-control" name="fecha" required>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Categoría:</label>
                                    <select class="form-control" name="categoria" required>
                                        <option value="" disabled selected>Seleccione una categoría</option>
                                        <option value="Cultural">Cultural</option>
                                        <option value="Educativa">Educativa</option>
                                        <option value="Mantenimiento">Mantenimiento</option>
                                        <option value="Reunión">Reunión / Asamblea</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Número de Asistentes:</label>
                                    <input type="number" class="form-control" name="asistentes" placeholder="0" min="0">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Estado:</label>
                                    <select class="form-control" name="estado">
                                        <option value="Completado">Completado</option>
                                        <option value="En Proceso">En Proceso</option>
                                        <option value="Pendiente">Pendiente</option>
                                        <option value="Cancelado">Cancelado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Descripción de la Actividad / Logro:</label>
                            <textarea class="form-control" name="descripcion" rows="4" placeholder="Detalle aquí lo realizado..." required></textarea>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-info btn-raised">
                                <i class="fa-solid fa-floppy-disk"></i> Guardar Actividad
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