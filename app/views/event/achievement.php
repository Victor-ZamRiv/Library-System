<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Logros</title>
    <?php include "../component/heat.php"; ?>
</head>

<body>

    <?php include "../component/sidebar.php"; ?>
    
    <section class="full-box dashboard-contentPage">
        <?php include "../component/navbar.php"; ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles">
                    <i class="fa-solid fa-calendar"></i> Eventos
                    <small> Registro Logros</small>
                </h1>
            </div>
        </div>

        <div class="container-fluid text-center" style="max-width: 900px;">
            <div class="card shadow-lg p-3 mb-4 bg-white rounded text-left">
                <div class="card-body">
                    <h3 class="text-center text-titles">Nuevo Logro Alcanzado</h3>
                    <hr>
                    
                    <form action="controlador_registro_logros.php" method="POST">
                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Fecha del Logro:</label>
                                    <input type="date" class="form-control" name="fecha_logro" required>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Involucrados:</label>
                                    <input type="text" class="form-control" name="involucrados" placeholder="Ej: Equipo de Mantenimiento, Juan Pérez..." required>
                                    <small class="text-muted">Personas o departamentos que participaron.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Descripción del Logro:</label>
                            <textarea class="form-control" name="descripcion_logro" rows="5" placeholder="Describa detalladamente el éxito o meta alcanzada..." required></textarea>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-info btn-raised">
                                 Registrar Logro
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
    </section>

    <?php include "../component/scripts.php"; ?>
</body>
</html>