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
                <p class="text-muted">A continuación se muestran los usuarios y administradores que actualmente tienen revocado el acceso al sistema.</p>
                
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
                            
                            <?php if (empty($usuariosSuspendidos)): ?>
                                <tr>
                                    <td colspan="6">No hay usuarios suspendidos en este momento.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($usuariosSuspendidos as $suspendido): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($suspendido->getNombreUsuario()) ?></strong></td>
                                        <td><?= htmlspecialchars($suspendido->getPersona()->getCedula()) ?></td>
                                        <td><?= htmlspecialchars($suspendido->getPersona()->getNombre()) ?></td>
                                        <td><?= htmlspecialchars($suspendido->getPersona()->getApellido()) ?></td>
                                        <td><?= htmlspecialchars($suspendido->getPersona()->getTelefono()) ?></td>
                                        <td>
                                            <a href="<?= BASE_URL ?>/administradores/habilitar?id=<?= $suspendido->getIdAdministrador() ?>" class="btn btn-xs btn-success btn-raised">
                                                <i class="fa-solid fa-user-check"></i> Reactivar
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                
                <button type="button" onclick="descargarPDF('UsuariosInhabilitados');" class="btn btn-danger btn-raised btn-sm">
                    <i class="fa-solid fa-file-pdf"></i> Imprimir Suspendidos
                </button>
            </div>
        </div>
    </div>
</div>