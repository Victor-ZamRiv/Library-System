<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Logro</title>
    <?php 
    // Priorizamos los datos "old" de la sesión (por si hubo error de validación) 
    // sobre los datos que vienen de la base de datos ($logro)
    include VIEW_PATH . "/component/heat.php"; 
    ?>
</head>

<body>

    <?php include VIEW_PATH . "/component/sidebar.php"; ?>
    
    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php"; ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles">
                    <i class="fa-solid fa-trophy"></i> Eventos
                    <small> Editar Logro</small>
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

                    <h3 class="text-center text-titles">Actualizar Logro</h3>
                    <hr>
                    
                    <!-- Cambiamos la ruta a /update -->
                    <form action="<?= BASE_URL ?>/logro/update" method="POST">
                        
                        <!-- ID del Logro (Oculto) -->
                        <input type="hidden" name="id_logro" value="<?= $logro->id_logro ?>">
                        
                        <!-- ID del Administrador (Oculto) -->
                        <input type="hidden" name="idAdmin" value="<?= $_SESSION['administrador']['id'] ?>">                        
                        
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Fecha del Logro:</label>
                                    <input type="date" 
                                           value="<?= htmlspecialchars($old['fecha'] ?? $logro->fecha) ?>" 
                                           class="form-control" name="fecha" required>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Involucrados:</label>
                                    <input type="text" 
                                           value="<?= htmlspecialchars($old['involucrados'] ?? $logro->involucrados) ?>" 
                                           class="form-control" name="involucrados" 
                                           placeholder="Ej: Equipo de Mantenimiento..." required>
                                    <small class="text-muted">Personas o departamentos que participaron.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Descripción del Logro:</label>
                            <textarea class="form-control" name="descripcion" rows="5" 
                                      placeholder="Describa el éxito alcanzado..." 
                                      required><?= htmlspecialchars($old['descripcion'] ?? $logro->descripcion) ?></textarea>
                        </div>

                        <div class="form-group text-right">
                            <a href="<?= BASE_URL ?>/logro" class="btn btn-default btn-raised">Cancelar</a>
                            <button type="submit" class="btn btn-success btn-raised">
                                Guardar Cambios
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