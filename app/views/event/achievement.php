<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Logros</title>
    <?php 
    $old = $_SESSION['old'] ?? [];
    $error = $_SESSION['error'] ?? null;
    unset($_SESSION['old'], $_SESSION['error']);
    include VIEW_PATH . "/component/heat.php"; ?>
</head>

<body>

    <?php include VIEW_PATH . "/component/sidebar.php"; ?>
    
    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles">
                    <i class="fa-solid fa-calendar"></i> Eventos
                    <small> Registro Logros</small>
                </h1>
            </div>
        </div>

        <div class="container-fluid text-center" style="max-width: 900px;">
            <div class="card shadow-lg p-3 mb-4 bg-white rounded text-left">
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>
                    <h3 class="text-center text-titles">Nuevo Logro Alcanzado</h3>
                    <hr>
                    
                    <form action="<?= BASE_URL ?>/logro/store" method="POST">
                        <input type="hidden" name="idAdmin" value="<?= $_SESSION['administrador']['id'] ?>">                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Fecha del Logro:</label>
                                    <input type="date" value="<?= htmlspecialchars($old['fecha'] ?? '') ?>" class="form-control" name="fecha" required>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Involucrados:</label>
                                    <input type="text" value="<?= htmlspecialchars($old['involucrados'] ?? '') ?>" class="form-control" name="involucrados" placeholder="Ej: Equipo de Mantenimiento, Bibliotecarios..." required>
                                    <small class="text-muted">Personas o departamentos que participaron.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Descripción del Logro:</label>
                            <textarea class="form-control" name="descripcion" rows="5" placeholder="Describa el éxito o meta alcanzada..." required><?= htmlspecialchars($old['descripcion'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-info btn-raised">
                                 Registrar Logro
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
    </section>

    <?php include VIEW_PATH . "/component/scripts.php"; ?>
</body>
</html>