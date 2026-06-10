<!DOCTYPE html>
<html lang="es">
<title>Gestión de Visitas</title>
<?php include VIEW_PATH . "/component/heat.php"; ?>
<style>
        .grafica-interactiva {
            transition: all 0.25s ease-in-out;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        }
        .grafica-interactiva:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15), 0 6px 6px rgba(0,0,0,0.10);
        }
        .panel-body .kpi-number {
            font-size: 28px;
            font-weight: bold;
            margin: 5px 0 0 0;
            display: block;
        }
    </style>
<body>
    <?php include VIEW_PATH . "/component/sidebar.php"; ?>
    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-users"></i> Gestión de Visitas</h1>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-xs-6">
                    <div class="panel panel-info text-center">
                        <div class="panel-heading">Niños</div>
                        <div class="panel-body">
                            <span class="kpi-number text-info " id="total-ninos"><?= $totales['ninos'] ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="panel panel-primary text-center">
                        <div class="panel-heading ">Adolescentes</div>
                        <div class="panel-body">
                            <span class="kpi-number text-primary" id="total-adolescentes"><?= $totales['adolescentes'] ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="panel panel-success text-center">
                        <div class="panel-heading">Adultos</div>
                        <div class="panel-body">
                            <span class="kpi-number text-success" id="total-adultos"><?= $totales['adultos'] ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-6">
                    <div class="panel panel-danger text-center">
                        <div class="panel-heading">Total Obras</div>
                        <div class="panel-body">
                            <span class="kpi-number text-danger" id="total-obras"><?= $totalObras ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body" style="position: relative;">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa-solid fa-chart-line"></i> Flujo de Consultas</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12">
                                        <div class="thumbnail grafica-interactiva" id="contenedor-grafica-visitas" style="padding: 15px; position: relative; border-radius: 4px; cursor: pointer;" title="Haga clic en cualquier parte del recuadro para ver detalles ampliados">
                                            <div class="row">
                                                <div class="col-xs-12 col-md-6">
                                                    <h5 class="text-titles" style="font-weight: bold;">Flujo de Consultas (Obras)</h5>
                                                </div>
                                                <div class="col-xs-12 col-md-6 text-right" style="margin-top: 10px;">
                                                    <div class="btn-group" style="position: relative; z-index: 20;">
                                                        <button type="button" class="btn btn-xs btn-default" data-periodo="semana">Semana</button>
                                                        <button type="button" class="btn btn-xs btn-default" data-periodo="mes">Mes</button>
                                                        <button type="button" class="btn btn-xs btn-default" data-periodo="trimestre">Trimestre</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="chartConsultasVisitor"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <form method="GET" id="filterForm" class="form-inline pull-right" style="margin-bottom: 15px;">
                        <div class="form-group">
                            <label>Desde:</label>
                            <input type="date" id="fecha_desde" name="desde" class="form-control" value="<?= htmlspecialchars($filtroDesde ?? '') ?>">
                        </div>
                        <div class="form-group" style="margin-left: 10px;">
                            <label>Hasta:</label>
                            <input type="date" id="fecha_hasta" name="hasta" class="form-control" value="<?= htmlspecialchars($filtroHasta ?? '') ?>">
                        </div>
                        <button type="submit" class="btn btn-primary" style="margin-left: 10px;">Filtrar</button>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6">
                                    <h3 class="panel-title" style="line-height: 30px;"><i class="fa-solid fa-list"></i> Listado de Registros</h3>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <button type="button" id="TablaVisitas" onclick="descargarPDF('TablaVisitas')" class="btn btn-sm btn-raised btn-primary">
                                        <i class="fa-solid fa-print"></i> IMPRIMIR REPORTE
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="tabla-registros-visitas" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Turno</th>
                                            <th>Distribución (N/A/A)</th>
                                            <th>Sala</th>
                                            <th>Total</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($registros['datos'])): ?>
                                            <tr><td colspan="6">No hay registros de visitas en el período.</td></tr>
                                        <?php else: ?>
                                            <?php foreach ($registros['datos'] as $reg): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($reg['fecha']) ?></td>
                                                <td><span class="label label-info"><?= htmlspecialchars($reg['turno']) ?></span></td>
                                                <td><?= htmlspecialchars($reg['distribucion']) ?></td>
                                                <td><?= htmlspecialchars($reg['sala']) ?></td>
                                                <td><strong><?= $reg['total'] ?></strong></td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="<?= BASE_URL ?>/visitantes/show?id=<?= $reg['id'] ?>" class="btn btn-info btn-raised btn-xs"><i class="fa-solid fa-eye"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php if ($registros['ultimaPagina'] > 1): ?>
                            <nav class="text-center">
                                <ul class="pagination pagination-sm">
                                    <?php if ($registros['pagina'] > 1): ?>
                                        <li><a href="?page=<?= $registros['pagina']-1 ?>&desde=<?= $filtroDesde ?>&hasta=<?= $filtroHasta ?>">«</a></li>
                                    <?php else: ?>
                                        <li class="disabled"><a href="#">«</a></li>
                                    <?php endif; ?>
                                    <li class="active"><a href="#"><?= $registros['pagina'] ?></a></li>
                                    <?php if ($registros['pagina'] < $registros['ultimaPagina']): ?>
                                        <li><a href="?page=<?= $registros['pagina']+1 ?>&desde=<?= $filtroDesde ?>&hasta=<?= $filtroHasta ?>">»</a></li>
                                    <?php else: ?>
                                        <li class="disabled"><a href="#">»</a></li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/modal/modal-indicator/visitor-graph.php"; ?>
    <?php include VIEW_PATH . "/modal/confirmation-delete-visitor.php"; ?>
    <?php include VIEW_PATH . "/component/scripts.php"; ?>

    <script src="<?php echo PUBLIC_PATH; ?>/js/chart-ConsultasVisitor.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jsPDF.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jspdf-autotable.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/html2canvas.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf-generator.js"></script>

    <script>
document.addEventListener("DOMContentLoaded", function() {
    // --- MANEJO DEL BOTÓN DE IMPRESIÓN ---
    const btnImprimir = document.getElementById('btn-imprimir-tabla');
    if (btnImprimir) {
        btnImprimir.addEventListener('click', function() {
            // Llama a la función global de pdf-generator.js usando el caso de visitas
            if (typeof descargarPDF === 'function') {
                descargarPDF('DetalleVisita');
            } else {
                console.error("La función descargarPDF no está disponible.");
                alert("Error: El generador de reportes no se ha cargado correctamente.");
            }
        });
    }

    // --- MANEJO DEL CLIC EN EL CONTENEDOR DE LA GRÁFICA ---
    const contenedorGrafica = document.getElementById('contenedor-grafica-visitas');
    if (contenedorGrafica) {
        contenedorGrafica.addEventListener('click', function(e) {
            if (e.target.tagName === 'BUTTON' || e.target.closest('.btn-group')) {
                return;
            }
            $('#modalDetalleConsultasGrafico').modal('show');
        });
    }

    // --- RESTRICCIONES DE FECHAS ---
    const desdeInput = document.getElementById('fecha_desde');
    const hastaInput = document.getElementById('fecha_hasta');
    const hoy = new Date().toLocaleDateString('en-CA');

    function aplicarRestricciones() {
        const desdeVal = desdeInput.value;
        const hastaVal = hastaInput.value;

        hastaInput.setAttribute('max', hoy);

        if (hastaVal) {
            desdeInput.setAttribute('max', hastaVal);
        } else {
            desdeInput.setAttribute('max', hoy);
        }

        if (desdeVal) {
            hastaInput.setAttribute('min', desdeVal);
        } else {
            hastaInput.removeAttribute('min');
        }
    }

    desdeInput.addEventListener('input', aplicarRestricciones);
    hastaInput.addEventListener('input', aplicarRestricciones);
    desdeInput.addEventListener('blur', aplicarRestricciones);
    hastaInput.addEventListener('blur', aplicarRestricciones);

    document.getElementById('filterForm').addEventListener('submit', function(e) {
        const desdeVal = desdeInput.value;
        const hastaVal = hastaInput.value;

        if (hastaVal > hoy) {
            e.preventDefault();
            hastaInput.value = hoy;
            aplicarRestricciones();
        }

        if (desdeVal && hastaVal && desdeVal > hastaVal) {
            e.preventDefault();
            desdeInput.value = hastaVal;
            aplicarRestricciones();
        }
    });

    aplicarRestricciones();
});
</script>
</body>
</html>