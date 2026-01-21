<!DOCTYPE html>
<html lang="es">
    <title>Gestión de Visitantes</title>
<?php include VIEW_PATH . "/component/heat.php"; ?>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-users"></i>  Visitantes <small> Gestión de Visitantes</small></h1>
                
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                    <div class="panel panel-info text-center">
                        <div class="panel-heading">Niños</div>
                        <div class="panel-body"><h4><strong>45</strong></h4></div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-primary text-center">
                        <div class="panel-heading">Adolescentes</div>
                        <div class="panel-body"><h4><strong>32</strong></h4></div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-success text-center">
                        <div class="panel-heading">Adultos</div>
                        <div class="panel-body"><h4><strong>128</strong></h4></div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="panel panel-danger text-center">
                        <div class="panel-heading">Total Obras</div>
                        <div class="panel-body"><h4><strong>210</strong></h4></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default shadow-lg">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa-solid fa-chart-area"></i> Flujo de Visitantes (Últimos 7 días)</h3>
                        </div>
                        <div class="panel-body">
                            <div style="height: 300px;">
                                <canvas id="graficaEvolucion"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-6"><h3 class="panel-title">Listado de Registros</h3></div>
                                <div class="col-xs-6 text-right">
                                    <button class="btn btn-xs btn-default"><i class="fa-solid fa-print"></i> Imprimir</button>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Turno</th>
                                            <th>Distribución (N/A/A)</th>
                                            <th>Total</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>2026-01-10</td>
                                            <td><span class="label label-info">Mañana</span></td>
                                            <td>10 / 5 / 15</td>
                                            <td><strong>30</strong></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button class="btn btn-info btn-raised btn-xs"><i class="fa-solid fa-eye"></i></button>
                                                    <button class="btn btn-danger btn-raised btn-xs"><i class="fa-solid fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/component/scripts.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('graficaEvolucion').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'],
                datasets: [{
                    label: 'Visitantes Totales',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    fill: true,
                    backgroundColor: 'rgba(3, 169, 244, 0.1)',
                    borderColor: '#03a9f4',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>