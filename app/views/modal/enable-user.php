<div class="modal fade" id="disabledUsersModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document"> 
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="fa-solid fa-user-slash text-danger"></i> Usuarios Suspendidos
                </h4>
            </div>
            <div class="modal-body">
<<<<<<< HEAD
                <p class="text-muted">
                    <?php if (!empty($search)): ?>
                        Resultados de búsqueda para "<strong><?= htmlspecialchars($search) ?></strong>" en usuarios inactivos.
                    <?php else: ?>
                        A continuación se muestran los usuarios y administradores que actualmente tienen revocado el acceso al sistema.
                    <?php endif; ?>
                </p>
=======
                <p class="text-muted">A continuación se muestran los usuarios y administradores que actualmente tienen revocado el acceso al sistema.</p>
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover text-center">
                        <thead>
                            <tr>
                                <th class="text-center">USUARIO</th>
                                <th class="text-center">CÉDULA</th>
                                <th class="text-center">NOMBRES</th>
                                <th class="text-center">APELLIDOS</th>
                                <th class="text-center">TELÉFONO</th>
                                <th class="text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody id="tablaUsuariosInhabilitados">
<<<<<<< HEAD
                            <?php if (empty($inactivos)): ?>
                                <tr>
                                    <td colspan="6">No hay usuarios suspendidos en este momento.\(td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($inactivos as $suspendido): ?>
=======
                            
                            <?php if (empty($usuariosSuspendidos)): ?>
                                <tr>
                                    <td colspan="6">No hay usuarios suspendidos en este momento.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($usuariosSuspendidos as $suspendido): ?>
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
                                    <tr>
                                        <td><strong><?= htmlspecialchars($suspendido->getNombreUsuario()) ?></strong></td>
                                        <td><?= htmlspecialchars($suspendido->getPersona()->getCedula()) ?></td>
                                        <td><?= htmlspecialchars($suspendido->getPersona()->getNombre()) ?></td>
                                        <td><?= htmlspecialchars($suspendido->getPersona()->getApellido()) ?></td>
                                        <td><?= htmlspecialchars($suspendido->getPersona()->getTelefono()) ?></td>
                                        <td>
<<<<<<< HEAD
                                            <form method="POST" action="<?= BASE_URL ?>/administradores/reactivar" style="display:inline;">
                                                <input type="hidden" name="id" value="<?= $suspendido->getIdAdministrador() ?>">
                                                <input type="hidden" name="search" value="<?= htmlspecialchars($search ?? '') ?>">
                                                <input type="hidden" name="page" value="<?= $paginacion['actual'] ?? 1 ?>">
                                                <button type="submit" class="btn btn-xs btn-success btn-raised">
                                                    <i class="fa-solid fa-user-check"></i> Reactivar
                                                </button>
                                            </form>
=======
                                            <a href="<?= BASE_URL ?>/administradores/habilitar?id=<?= $suspendido->getIdAdministrador() ?>" class="btn btn-xs btn-success btn-raised">
                                                <i class="fa-solid fa-user-check"></i> Reactivar
                                            </a>
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
<<<<<<< HEAD
=======
                            
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
<<<<<<< HEAD
=======
                
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
                <button type="button" onclick="descargarPDF('UsuariosInhabilitados');" class="btn btn-danger btn-raised btn-sm">
                    <i class="fa-solid fa-file-pdf"></i> Imprimir Suspendidos
                </button>
            </div>
        </div>
    </div>
</div>