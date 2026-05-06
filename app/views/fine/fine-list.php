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
                <h1 class="text-titles"><i class="fa-solid fa-bookmark"></i> Multas <small>Listado de Multas</small></h1>
            </div>
        </div>


        <div class="container-fluid">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE MULTAS</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>

                                    <th class="text-center">N° PRÉSTAMO</th>
                                    <th class="text-center">MONTO</th>
                                    <th class="text-center">ESTADO</th>
                                    <th class="text-center">FECHA DE CANCELACIÓN</th>
                                    <th class="text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <?php if (empty($multas)): ?>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="text-center">No hay multas registradas.</td>
                                    </tr>
                                </tbody>
                            <?php else: ?>
                                <?php foreach ($multas as $multa): ?>
                                <tbody>
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
                                </tbody>
                                <?php endforeach; ?>
                            <?php endif; ?>
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
    <script>
document.addEventListener("DOMContentLoaded", function() {
    $('.btn-preparar-pago').on('click', function() {
        // Obtenemos los datos del botón que fue clickeado
        var idMulta = $(this).data('id');
        var numPrestamo = $(this).data('numero');

        // Actualizamos el texto del modal
        $('#numPrestamoModal').text(numPrestamo);
        // Guardamos el ID de la multa en el campo oculto del formulario
        $('#idMultaInput').val(idMulta);
    });
});
</script>
</body>

</html>