<!DOCTYPE html>
<html lang="es">
<head>
    <title>Detalle del Registro de Visitas</title>
    <?php include VIEW_PATH . "/component/heat.php"; ?>
    <style>
        .detail-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background: #fff;
        }
        .consultas-table th, .consultas-table td {
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-clipboard-list"></i> Detalle del Registro</h1>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card shadow-lg p-4 bg-white rounded">
                <div class="card-body">
                    <!-- Botón volver -->
                    <div class="text-right mb-3">
                        <a href="<?= BASE_URL ?>/visitantes" class="btn btn-secondary btn-raised">
                            <i class="fa-solid fa-arrow-left"></i> Volver al listado
                        </a>
                    </div>

                    <!-- Datos del Visitante -->
                    <div class="detail-card">
                        <h3 class="text-titles">Información del Registro</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>Fecha:</strong> <?= date('d/m/Y', strtotime($visitante->getFecha())) ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Sala:</strong> <?= htmlspecialchars($visitante->getIdSala()) ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Turno:</strong> <?= htmlspecialchars($visitante->getTurno()) ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p><strong>Registrado por:</strong> <?= htmlspecialchars($administrador->getPersona()->getNombre()) ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Distribución de visitantes -->
                    <div class="detail-card">
                        <h3 class="text-titles">Distribución de Visitantes</h3>
                        <hr>
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="panel panel-info">
                                    <div class="panel-heading">Niños</div>
                                    <div class="panel-body">
                                        <p>Hombres: <?= $visitante->getNinosHombres() ?></p>
                                        <p>Mujeres: <?= $visitante->getNinosMujeres() ?></p>
                                        <p><strong>Total: <?= $visitante->getNinosHombres() + $visitante->getNinosMujeres() ?></strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Adolescentes</div>
                                    <div class="panel-body">
                                        <p>Hombres: <?= $visitante->getAdolescentesHombres() ?></p>
                                        <p>Mujeres: <?= $visitante->getAdolescentesMujeres() ?></p>
                                        <p><strong>Total: <?= $visitante->getAdolescentesHombres() + $visitante->getAdolescentesMujeres() ?></strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-success">
                                    <div class="panel-heading">Adultos</div>
                                    <div class="panel-body">
                                        <p>Hombres: <?= $visitante->getAdultosHombres() ?></p>
                                        <p>Mujeres: <?= $visitante->getAdultosMujeres() ?></p>
                                        <p><strong>Total: <?= $visitante->getAdultosHombres() + $visitante->getAdultosMujeres() ?></strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Consultas por área -->
                    <div class="detail-card">
                        <h3 class="text-titles">Consultas de Obras (Clasificación)</h3>
                        <hr>
                        <?php if (empty($consultas)): ?>
                            <p class="text-muted">No se registraron consultas para este día/turno.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover consultas-table">
                                    <thead>
                                        <tr class="bg-info">
                                            <th>Área (Clasificación)</th>
                                            <th>Cantidad de Obras</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($consultas as $consulta): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($consulta->getIdArea()) ?></td>
                                                <td><?= $consulta->getCantidadConsultada() ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="active">
                                            <th class="text-right">TOTAL OBRAS:</th>
                                            <th><?= array_sum(array_map(fn($c) => $c->getCantidadConsultada(), $consultas)) ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Acciones adicionales (opcional) -->
                    <div class="text-right mt-3">
                        <a href="<?= BASE_URL ?>/visitantes" class="btn btn-default btn-raised">Cerrar</a>
                        <!-- Botón para imprimir 
                        <button onclick="window.print();" class="btn btn-primary btn-raised"><i class="fa-solid fa-print"></i> Imprimir</button> -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/component/scripts.php"; ?>
</body>
</html>