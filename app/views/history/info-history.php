<!DOCTYPE html>
<html lang="es">
<?php //var_dump($old); var_dump($new); 
?>

<head>
    <title>Detalle de Operación</title>
    <?php include VIEW_PATH . "/component/heat.php" ?>

    <style>
        .equal-height-row {
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

        .cambio {
            color: #d9534f;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <?php include VIEW_PATH . "/component/sidebar.php" ?>

    <section class="full-box dashboard-contentPage">

        <?php include VIEW_PATH . "/component/navbar.php" ?>

        <!-- Cabecera -->
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"> Detalle de Modificación</h1>
            </div>
        </div>

        <div class="container-fluid">

            <!-- Información general -->
            <div class="well well-sm" style="margin-bottom: 30px;">
                <p style="margin: 0;">
                    <strong>Usuario responsable:</strong> <?= htmlspecialchars($usuario) ?> &nbsp;|&nbsp;
                    <strong>Módulo:</strong> <?= ucfirst($modulo) ?> &nbsp;|&nbsp;
                    <strong>Acción:</strong> <?= htmlspecialchars($registro['Tipo_Cambio']) ?> &nbsp;|&nbsp;
                    <strong>Fecha/Hora:</strong> <?= date('d/m/Y - h:i A', strtotime($registro['Fecha_Cambio'])) ?>
                </p>
            </div>

            <!-- Cargar diccionario de labels -->
            <?php
            $archivoLabels = VIEW_PATH . "/historial/labels/{$modulo}.php";
            $labels = file_exists($archivoLabels) ? include $archivoLabels : [];
            ?>

            <!-- Paneles ANTES / AHORA -->
            <div class="row equal-height-row">

                <!-- ANTES -->
                <div class="col-xs-12 col-sm-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="zmdi zmdi-time"></i> &nbsp; DATOS ANTERIORES (ANTES)</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group" style="margin-bottom: 0;">

                                <?php foreach ($old_data as $campo => $valor): ?>
                                    <?php
                                    $etiqueta = $labels[$campo] ?? ucfirst($campo);
                                    $nuevoValor = $new[$campo] ?? null;
                                    $cambio = ($nuevoValor !== $valor);
                                    ?>
                                    <li class="list-group-item <?= $cambio ? 'cambio' : '' ?>">
                                        <strong><?= htmlspecialchars($etiqueta) ?>:</strong>
                                        <?= htmlspecialchars($valor) ?>
                                    </li>
                                <?php endforeach; ?>

                            </ul>
                        </div>
                    </div>
                </div>

                <!-- AHORA -->
                <div class="col-xs-12 col-sm-6">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; DATOS ACTUALIZADOS (AHORA)</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group" style="margin-bottom: 0;">


                                <?php foreach ($new as $campo => $valor): ?>
                                    <?php
                                    $etiqueta = $labels[$campo] ?? ucfirst($campo);
                                    $viejoValor = $old[$campo] ?? null;
                                    $cambio = ($viejoValor !== $valor);
                                    ?>
                                    <li class="list-group-item <?= $cambio ? 'cambio' : '' ?>">
                                        <strong><?= htmlspecialchars($etiqueta) ?>:</strong>
                                        <?= htmlspecialchars($valor) ?>
                                    </li>
                                <?php endforeach; ?>

                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Botones -->
            <div class="text-center" style="margin-top: 15px; margin-bottom: 25px;">
                <a href="javascript:history.back();" class="btn btn-default btn-raised">
                    <i class="zmdi zmdi-arrow-left"></i> &nbsp; VOLVER
                </a>

                <button type="button" class="btn btn-success btn-raised" onclick="descargarPDF('DetalleModificacion');">
                    <i class="zmdi zmdi-file-text"></i> &nbsp; IMPRIMIR REPORTE
                </button>
            </div>

        </div>

    </section>
    <?php include VIEW_PATH . "/component/scripts.php" ?>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jsPDF.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jspdf-autotable.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/html2canvas.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf-generator.js"></script>

</body>

</html>