<!DOCTYPE html>
<html lang="es">

<head>
    <title>Historial del Sistema</title>
    <?php include VIEW_PATH . "/component/heat.php" ?>

    <style>
        @media print {
            .sidebar-wrapper, .dashboard-sideBar, .dashboard-contentPage > .navbar,
            .form-horizontal, .panel-body form, .btn, .zmdi {
                display: none !important;
            }

            section, .container-fluid, .panel, .panel-body {
                padding: 0 !important;
                margin: 0 !important;
                border: none !important;
                box-shadow: none !important;
            }

            table th:last-child,
            table td:last-child {
                display: none !important;
            }

            .table {
                width: 100% !important;
                border-collapse: collapse;
            }

            .page-header::after {
                content: " Reporte de Historial Generado el <?= date('d/m/Y') ?>";
                font-size: 14px;
            }

            .label {
                border: 1px solid #333;
                color: #000 !important;
                background: none !important;
            }
        }
    </style>
</head>

<body>

<?php include VIEW_PATH . "/component/sidebar.php" ?>

<section class="full-box dashboard-contentPage">

<?php include VIEW_PATH . "/component/navbar.php" ?>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"> Configuración <small>Historial</small></h1>
    </div>
</div>

<div class="container-fluid">

    <!-- PANEL DE FILTROS -->
    <div class="panel panel-default">
        <div class="panel-body">
            <form action="" method="GET" class="row">

                <!-- Filtro Usuario -->
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Seleccionar Usuario</label>
                        <select class="form-control" name="filtro-usuario">
                            <option value="">Todos los usuarios</option>

                            <?php foreach ($usuarios as $u): ?>
                                <option value="<?= $u['id'] ?>"
                                    <?= ($filtros['usuario'] == $u['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($u['nombre']) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>

                <!-- Filtro Acción -->
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Tipo de Acción</label>
                        <select class="form-control" name="filtro-accion">
                            <option value="">Todas las acciones</option>
                            <option value="INSERT" <?= $filtros['accion'] == 'INSERT' ? 'selected' : '' ?>>Creación</option>
                            <option value="UPDATE" <?= $filtros['accion'] == 'UPDATE' ? 'selected' : '' ?>>Actualización</option>
                            <option value="DELETE" <?= $filtros['accion'] == 'DELETE' ? 'selected' : '' ?>>Eliminación</option>
                        </select>
                    </div>
                </div>

                <!-- Filtro Módulo -->
                <div class="col-xs-12 col-sm-3">
                    <div class="form-group">
                        <label class="control-label">Módulo del Sistema</label>
                        <select class="form-control" name="filtro-modulo">
                            <option value="">Todos los módulos</option>

                            <?php foreach ($modulos as $clave => $tabla): ?>
                                <option value="<?= $clave ?>"
                                    <?= ($filtros['modulo'] == $clave) ? 'selected' : '' ?>>
                                    <?= ucfirst($clave) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>

                <!-- Botones -->
                <div class="col-xs-12 col-sm-3 text-center" style="margin-top: 25px;">
                    <button type="submit" class="btn btn-primary btn-raised btn-sm">
                        <i class="zmdi zmdi-search"></i> &nbsp; BUSCAR
                    </button>

                    <button type="button" class="btn btn-danger btn-raised btn-sm" onclick="window.print();">
                        <i class="zmdi zmdi-print"></i> &nbsp; PDF
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- TABLA DE HISTORIAL -->
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-time-restore"></i> &nbsp; LOGS DE ACTIVIDAD</h3>
        </div>

        <div class="panel-body">
            <div class="table-responsive">

                <table class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th class="text-center">USUARIO</th>
                            <th class="text-center">MÓDULO</th>
                            <th class="text-center">FECHA / HORA</th>
                            <th class="text-center">ACCIÓN</th>
                            <th class="text-center">DESCRIPCIÓN</th>
                            <th class="text-center">OPCIONES</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if (empty($registros)): ?>
                        <tr>
                            <td colspan="6">No hay registros para mostrar</td>
                        </tr>
                    <?php else: ?>

                        <?php foreach ($registros as $r): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($r['usuario']) ?></strong></td>

                                <td>
                                    <span class="label label-default">
                                        <?= htmlspecialchars($r['modulo']) ?>
                                    </span>
                                </td>

                                <td><?= date('d/m/Y - h:i A', strtotime($r['fecha'])) ?></td>

                                <td>
                                    <?php
                                        $clase = [
                                            'INSERT' => 'label-success',
                                            'UPDATE' => 'label-info',
                                            'DELETE' => 'label-danger'
                                        ][$r['accion']] ?? 'label-default';
                                    ?>
                                    <span class="label <?= $clase ?>">
                                        <?= htmlspecialchars($r['accion']) ?>
                                    </span>
                                </td>

                                <td><?= htmlspecialchars($r['descripcion']) ?></td>

                                <td>
                                    <a href="<?= BASE_URL ?>/historial/show?modulo=<?= urlencode($filtros['modulo']) ?>&id=<?= $r['id'] ?>"
                                       class="btn btn-info btn-raised btn-xs" title="Más Información">
                                        <i class="zmdi zmdi-info-outline"></i> &nbsp; Más info
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

</section>

<?php include VIEW_PATH . "/component/scripts.php" ?>

</body>
</html>
