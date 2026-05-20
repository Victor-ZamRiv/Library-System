<!DOCTYPE html>
<html lang="es">

<head>
    <title>Detalle de Actividad - Historial</title>
    <?php include VIEW_PATH . "/component/heat.php" ?>
    <style>
        /* Forzar a que las tarjetas tengan la misma altura */
        .equal-height-row {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
        }
        .equal-height-row [class*='col-'] {
            display: flex;
            flex-direction: column;
        }
        .equal-height-row .panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }
        .equal-height-row .panel-body {
            flex: 1;
        }
    </style>
</head>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php" ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php" ?>

        <!-- Cabecera de la Página -->
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"> Historial <small>Detalle de Modificación</small></h1>
            </div>
        </div>

        <div class="container-fluid">
            <!-- Información General del Log (Con más separación abajo) -->
            <div class="well well-sm" style="margin-bottom: 30px;">
                <p style="margin: 0;">
                    <strong>Usuario responsable:</strong> operador_01 &nbsp;|&nbsp; 
                    <strong>Módulo:</strong> Libros &nbsp;|&nbsp; 
                    <strong>Acción:</strong> Actualización &nbsp;|&nbsp; 
                    <strong>Fecha/Hora:</strong> 23/01/2026 - 09:40 AM
                </p>
            </div>

            <!-- Contenedor de Comparación de Datos (Tarjetas del mismo tamaño) -->
            <div class="row equal-height-row">
                <!-- PANEL IZQUIERDO: Datos Antiguos -->
                <div class="col-xs-12 col-sm-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="zmdi zmdi-time"></i> &nbsp; DATOS ANTERIORES (ANTES)</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group" style="margin-bottom: 0;">
                                <li class="list-group-item"><strong>Título del Libro:</strong> El Psicoanalista</li>
                                <li class="list-group-item"><strong>Autor:</strong> John Katzenbach</li>
                                <li class="list-group-item"><strong>Stock / Cantidad:</strong> 5 ejemplares</li>
                                <li class="list-group-item"><strong>Ubicación:</strong> Estante B - Pasillo 2</li>
                                <li class="list-group-item"><strong>Estado del Libro:</strong> Disponible</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- PANEL DERECHO: Datos Actualizados -->
                <div class="col-xs-12 col-sm-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; DATOS ACTUALIZADOS (AHORA)</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group" style="margin-bottom: 0;">
                                <li class="list-group-item"><strong>Título del Libro:</strong> El Psicoanalista (Edición Especial)</li>
                                <li class="list-group-item"><strong>Autor:</strong> John Katzenbach</li>
                                <li class="list-group-item text-danger"><strong>Stock / Cantidad:</strong> 3 ejemplares</li>
                                <li class="list-group-item"><strong>Ubicación:</strong> Estante B - Pasillo 2</li>
                                <li class="list-group-item text-danger"><strong>Estado del Libro:</strong> En mantenimiento</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DIV ÚNICO PARA BOTONES (Centrados y con espacio superior) -->
            <div class="text-center" style="margin-top: 15px; margin-bottom: 25px;">
                <a href="javascript:history.back();" class="btn btn-default btn-raised">
                    <i class="zmdi zmdi-arrow-left"></i> &nbsp; VOLVER
                </a>
                <button type="button" class="btn btn-danger btn-raised" onclick="window.print();">
                    <i class="zmdi zmdi-file-text"></i> &nbsp; GENERAR REPORTE PDF
                </button>
            </div>
        </div>
        
    </section>
    

    <?php include VIEW_PATH . "/component/scripts.php" ?>
</body>
</html>