<!DOCTYPE html>
<html lang="es">

<head>
    <title>Gestión de Multas - Listado</title>
    <?php include VIEW_PATH . "/component/heat.php" ?>
</head>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php" ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php" ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-bookmark"></i> Listado de Multas</h1>
            </div>
        </div>

        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">
                            <h3 class="panel-title" style="line-height: 40px;">
                                <i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE MULTAS
                            </h3>
                        </div>
                        <div class="col-xs-6 text-right">
                            <button type="button" onclick="descargarPDF('TablaMultas')" class="btn btn-sm btn-raised btn-success">
                                <i class="fa-solid fa-print"></i> IMPRIMIR REPORTE
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="tabla-multas" class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">N° PRÉSTAMO</th>
                                    <th class="text-center">MONTO</th>
                                    <th class="text-center">ESTADO</th>
                                    <th class="text-center">FECHA DE CANCELACIÓN</th>
                                    <th class="text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-multas-cuerpo">
                            <?php if (empty($multas)): ?>
                                <tr>
                                    <td colspan="5" class="text-center">No hay multas registradas.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($multas as $multa): ?>
                                    <tr>
                                        <td><?php echo $multa->getIdPrestamo(); ?></td>
                                        <td>$<?php echo number_format($multa->getMonto(), 2); ?></td>
                                        <?php if ($multa->getFechaCancelacion()): ?>
                                            <td><span class="label label-success">Pagada</span></td>
                                        <?php else: ?>
                                            <td><span class="label label-danger">Pendiente</span></td>
                                        <?php endif; ?>
                                        <td><?= $multa->getFechaCancelacion() ? date('d/m/Y', strtotime($multa->getFechaCancelacion())) : 'Pendiente' ?></td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-success btn-raised btn-xs btn-preparar-pago"
                                                title="Cancelar Multa"
                                                data-toggle="modal"
                                                data-target="#modalConfirmarPago"
                                                data-id="<?php echo $multa->getIdMulta(); ?>"
                                                data-numero="<?php echo $multa->getIdPrestamo(); ?>">
                                                Cancelar multa
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <nav class="text-center">
                        <ul class="pagination pagination-sm">
                            <li class="disabled"><a href="javascript:void(0)">«</a></li>
                            <li class="active"><a href="javascript:void(0)">1</a></li>
                            <li><a href="javascript:void(0)">2</a></li>
                            <li><a href="javascript:void(0)">3</a></li>
                            <li><a href="javascript:void(0)">»</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/component/scripts.php" ?>
    <?php include VIEW_PATH . "/modal/pay-fine.php" ?>

    <script src="<?= PUBLIC_PATH ?>/js/pdf/jsPDF.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jspdf-autotable.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/html2canvas.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf-generator.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        $('.btn-preparar-pago').on('click', function() {
            var idMulta = $(this).data('id');
            var numPrestamo = $(this).data('numero');

            $('#numPrestamoModal').text(numPrestamo);
            $('#idMultaInput').val(idMulta);
        });
    });
    </script>
</body>

</html>