<!DOCTYPE html>
<html lang="es">
<head>
    <title>Préstamo</title>
    <?php include VIEW_PATH . "/component/heat.php"; ?>
</head>
<body>

    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>

        <div class="container-fluid ">
            <div class="page-header">
                <h1 class="text-titles"> </h1>
                <h1 class="text-titles"><i class="fa-solid fa-bookmark"></i> Lista de Préstamos</h1>
            </div>
        </div>

        <div class="container-fluid text-center" style="max-width: 600px;">
            <div class="d-inline-block" style=" width: 100%;">
                <div class="card shadow-lg p-3 mb-4 bg-white rounded">
                    <div class="card-body p-0">
                        <form method="GET" action="" id="form-filtro-prestamos">
                            <div class="d-flex justify-content-center align-items-center p-0 gap-0">

                                <div class="flex-grow-1">
                                    <input type="text" class="form-control" placeholder="Buscar préstamo" name="busqueda" id="busqueda" value="<?= htmlspecialchars($termino) ?>">
                                </div>

                                <div class="btn-group" id="grupo-criterio-busqueda">
                                    <button type="button" id="btn-criterio-dropdown" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 50px 0 0 50px; min-width: 100px;">
                                        <?php 
                                            // Mantiene visualmente el criterio seleccionado tras filtrar
                                            $textoBtn = 'Criterio';
                                            if($criterio == 'id') $textoBtn = 'ID Préstamo';
                                            if($criterio == 'carnet') $textoBtn = 'Carnet';
                                            if($criterio == 'cota') $textoBtn = 'Cota';
                                            echo $textoBtn;
                                        ?> <i class="fa-solid fa-caret-down"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" data-criterio="id">ID Préstamo</a></li>
                                        <li><a href="#" data-criterio="carnet">Carnet</a></li>
                                        <li><a href="#" data-criterio="cota">Cota</a></li>
                                    </ul>
                                </div>
                                <input type="hidden" name="criterio" id="criterio" value="<?= htmlspecialchars($criterio) ?>">

                                <button class="btn btn-success" id="btn-filtrar" type="submit" style="border-radius: 0 50px 50px 0; min-width: 80px;">
                                    Filtrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><br>

        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">
                            <h3 class="panel-title" style="line-height: 30px;">
                                <i class="fa-solid fa-list"></i> &nbsp; LISTA DE PRÉSTAMOS
                            </h3>
                        </div>
                        <div class="col-xs-6 text-right">
                            <button type="button" onclick="descargarPDF('TablaPrestamos')" class="btn btn-sm btn-raised btn-success">
                                <i class="fa-solid fa-print"></i> IMPRIMIR REPORTE
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="tabla-prestamos" class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">Carnet de usuario</th>
                                    <th class="text-center">Responsable</th>
                                    <th class="text-center">Cota</th>
                                    <th class="text-center">Emisión</th>
                                    <th class="text-center">Devolución</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Ver más</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($prestamos)): ?>
                                    <tr><td colspan="7">No hay préstamos que coincidan con la búsqueda.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($prestamos as $p): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($p['carnetLector']) ?></td>
                                            <td><?= htmlspecialchars($p['administrador']) ?></td>
                                            <td><?= htmlspecialchars($p['cota']) ?> (Ejemplar #<?= $p['numeroEjemplar'] ?>)</td>
                                            <td><?= htmlspecialchars($p['fechaEmision']) ?></td>
                                            <td><?= htmlspecialchars($p['fechaDevolucion']) ?></td>
                                            <td>
                                                <?php
                                                $badge = '';
                                                switch ($p['estado']) {
                                                    case 'Pendiente': $badge = 'warning'; break;
                                                    case 'Devuelto': $badge = 'success'; break;
                                                    case 'Vencido': $badge = 'danger'; break;
                                                    default: $badge = 'secondary';
                                                }
                                                ?>
                                                <span class="badge badge-<?= $badge ?>"><?= $p['estado'] ?></span>
                                            </td>
                                            <td>
                                                <a href="<?= BASE_URL ?>/prestamos/show?id=<?= $p['idPrestamo'] ?>" class="btn btn-success btn-raised btn-xs" title="Ver más">
                                                    <i class="fa-solid fa-info"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($paginacion['ultima'] > 1): ?>
        <nav class="text-center">
            <ul class="pagination pagination-sm">
                <?php if ($paginacion['actual'] > 1): ?>
                    <li><a href="?page=1&criterio=<?= urlencode($criterio) ?>&busqueda=<?= urlencode($termino) ?>">«</a></li>
                    <li><a href="?page=<?= $paginacion['actual']-1 ?>&criterio=<?= urlencode($criterio) ?>&busqueda=<?= urlencode($termino) ?>">‹</a></li>
                <?php else: ?>
                    <li class="disabled"><a href="javascript:void(0)">«</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $paginacion['ultima']; $i++): ?>
                    <?php if ($i == $paginacion['actual']): ?>
                        <li class="active"><a href="javascript:void(0)"><?= $i ?></a></li>
                    <?php else: ?>
                        <li><a href="?page=<?= $i ?>&criterio=<?= urlencode($criterio) ?>&busqueda=<?= urlencode($termino) ?>"><?= $i ?></a></li>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($paginacion['actual'] < $paginacion['ultima']): ?>
                    <li><a href="?page=<?= $paginacion['actual']+1 ?>&criterio=<?= urlencode($criterio) ?>&busqueda=<?= urlencode($termino) ?>">›</a></li>
                    <li><a href="?page=<?= $paginacion['ultima'] ?>&criterio=<?= urlencode($criterio) ?>&busqueda=<?= urlencode($termino) ?>">»</a></li>
                <?php else: ?>
                    <li class="disabled"><a href="javascript:void(0)">›</a></li>
                    <li class="disabled"><a href="javascript:void(0)">»</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <?php endif; ?>
    </section>

    <?php include VIEW_PATH . "/component/scripts.php"; ?>
    
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jsPDF.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jspdf-autotable.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/html2canvas.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf-generator.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Limitamos la captura de enlaces exclusivamente al dropdown de Criterio
        const dropdownItems = document.querySelectorAll('#grupo-criterio-busqueda .dropdown-menu li a');
        const criterioInput = document.getElementById('criterio');
        const dropdownButton = document.getElementById('btn-criterio-dropdown');

        dropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const criterioSeleccionado = this.getAttribute('data-criterio');
                const textoSeleccionado = this.textContent;

                criterioInput.value = criterioSeleccionado;
                dropdownButton.innerHTML = `${textoSeleccionado} <i class="fa-solid fa-caret-down"></i>`;
            });
        });
    });
    </script>
</body>
</html>