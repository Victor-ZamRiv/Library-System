<!DOCTYPE html>
<html lang="es">
<head>
    <title>Listado de Visitas</title>
    <?php include VIEW_PATH . "/component/heat.php"; ?>
</head>
<body>
    <?php include VIEW_PATH . "/component/sidebar.php"; ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-list-check"></i> Visitas <small> Historial de Registros</small></h1>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card shadow-lg p-3 mb-4 bg-white rounded">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h3 class="text-titles">Registros Recientes</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?= BASE_URL ?>/visitantes/create" class="btn btn-success btn-raised">
                                <i class="fa-solid fa-plus"></i> Nuevo Registro
                            </a>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr class="bg-info text-white">
                                    <th>Fecha</th>
                                    <th>Sala</th>
                                    <th>Turno</th>
                                    <th>Total Visitantes</th>
                                    <th>Total Obras</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($visitantes)): ?>
                                    <?php foreach($visitantes as $v): 
                                        // Sumatoria rápida de visitantes
                                        $total_v = $v->ninos_f + $v->ninos_m + $v->adol_f + $v->adol_m + $v->adultos_f + $v->adultos_m;
                                        // Sumatoria rápida de obras (ajusta según los nombres de tu objeto/array)
                                        $total_o = $v->obra_000 + $v->obra_100 + $v->obra_200 + $v->obra_300 + $v->obra_400 + $v->obra_500 + $v->obra_600 + $v->obra_700 + $v->obra_800 + $v->obra_900 + $v->obra_Biog;
                                    ?>
                                    <tr>
                                        <td><?= date("d/m/Y", strtotime($v->fecha)) ?></td>
                                        <td><span class="label label-default"><?= $v->sala ?></span></td>
                                        <td><?= $v->turno ?></td>
                                        <td><strong><?= $total_v ?></strong></td>
                                        <td><strong><?= $total_o ?></strong></td>
                                        <td>
                                            <button class="btn btn-info btn-xs" title="Ver Detalles" data-toggle="modal" data-target="#modal-<?= $v->id ?>">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                            <a href="<?= BASE_URL ?>/visitantes/edit/<?= $v->id ?>" class="btn btn-warning btn-xs" title="Editar">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    
                                    <?php include VIEW_PATH . "/visitantes/modal_detalle.php"; ?>

                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No hay registros disponibles.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/component/scripts.php"; ?>
</body>
</html>