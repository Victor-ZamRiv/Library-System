<!DOCTYPE html>
<html lang="es">
<head>
    <title>Datos de Usuario</title>
    <?php include "../component/heat.php" ?>
    
</head>
<body>
    <?php include "../component/sidebar.php" ?>

    <section class="full-box dashboard-contentPage">
        <?php include "../component/navbar.php" ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"><i class="fa-solid fa-users-gear fa-fw"></i> Usuarios <small>Información de Usuario</small></h1>
            </div>
        </div>

        <?php include "../component/userbar.php" ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <div class="panel panel-info">
                        <div class="panel-body text-center">
                            
                            <h3 class="text-center">First Admin</h3>
                            <p class="text-center text-muted">Nombre de Usuario: <strong>Admin</strong></p>
                            <span class="label label-success">Estado Activo</span>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa-solid fa-address-card"></i> &nbsp; DATOS PERSONALES Y ROL</h3>
                        </div>
                        <div class="panel-body">
                            <form action="../controller/updatePrivilege.php" method="POST">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <strong><i class="fa-solid fa-id-card fa-fw"></i> Cédula:</strong> 
                                        <span class="pull-right">0</span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong><i class="fa-solid fa-user-tag fa-fw"></i> Usuario:</strong> 
                                        <span class="pull-right">Admin</span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong><i class="fa-solid fa-signature fa-fw"></i> Nombres:</strong> 
                                        <span class="pull-right">First Admin</span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong><i class="fa-solid fa-phone fa-fw"></i> Teléfono:</strong> 
                                        <span class="pull-right">N/A</span>
                                    </li>
                                    
                                    <li class="list-group-item" style="padding-bottom: 20px; padding-top: 15px; background-color: #f9f9f9;">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <strong><i class="fa-solid fa-shield-halved fa-fw"></i> Nivel de Privilegios:</strong>
                                            </div>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="privilegio_usuario">
                                                    <option value="1">Nivel 1 (Control Total)</option>
                                                    <option value="2">Nivel 2 (Edición)</option>
                                                    <option value="3">Nivel 3 (Solo Lectura)</option>
                                                </select>
                                                <small class="text-muted">Cambie el nivel para actualizar permisos.</small>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                
                                <div class="text-right" style="margin-top: 20px;">
                                    <a href="user-list.php" class="btn btn-default btn-raised"><i class="fa-solid fa-arrow-left"></i> Volver</a>
                                    <button type="submit" class="btn btn-info btn-raised"><i class="fa-solid fa-floppy-disk"></i> Guardar Cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include "../component/scripts.php" ?>
</body>
</html>