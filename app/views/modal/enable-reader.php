<div class="modal fade" id="disabledReadersModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document"> 
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="fa-solid fa-user-slash text-danger"></i> Lectores Inhabilitados
                </h4>
            </div>
            <div class="modal-body">
<<<<<<< HEAD
                <p class="text-muted">
                    <?php if (!empty($search)): ?>
                        Resultados de búsqueda para "<strong><?= htmlspecialchars($search) ?></strong>" en lectores inactivos.
                    <?php else: ?>
                        A continuación se muestran los lectores que actualmente tienen el servicio suspendido.
                    <?php endif; ?>
                </p>
=======
                <p class="text-muted">A continuación se muestran los lectores que actualmente tienen el servicio suspendido.</p>
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>N° CARNET</th>
                                <th>CÉDULA</th>
                                <th>NOMBRE COMPLETO</th>
                                <th>TELÉFONO</th>
<<<<<<< HEAD
=======
                                <th>PROFESIÓN</th>
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaLectoresInhabilitados">
<<<<<<< HEAD
                            <?php if (empty($inactivos)): ?>
                                <tr>
                                    <td colspan="5" class="text-center">No hay lectores inactivos registrados.\(td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($inactivos as $lector): 
                                    $persona = $lector->getPersona();
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($lector->getCarnet()) ?></td>
                                        <td><?= htmlspecialchars($persona->getCedula()) ?></td>
                                        <td><?= htmlspecialchars($persona->getNombre() . ' ' . $persona->getApellido()) ?></td>
                                        <td><?= htmlspecialchars($persona->getTelefono()) ?></td>
                                        <td class="text-right">
                                            <form method="POST" action="<?= BASE_URL ?>/lectores/reactivar" style="display:inline;">
                                                <input type="hidden" name="id" value="<?= $lector->getIdLector() ?>">
                                                <input type="hidden" name="search" value="<?= htmlspecialchars($search ?? '') ?>">
                                                <input type="hidden" name="page" value="<?= $paginacion['actual'] ?? 1 ?>">
                                                <button type="submit" class="btn btn-xs btn-success btn-raised">
                                                    <i class="fa-solid fa-user-check"></i> Habilitar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
=======
                            <tr>
                                <td><strong>87654321/24</strong></td>
                                <td>25909345</td>
                                <td>Juan Pérez Gómez</td>
                                <td>04128973452</td>
                                <td>Arquitecto</td>
                                <td class="text-right">
                                    <button class="btn btn-xs btn-success btn-raised btn-habilitar" data-id="1">
                                        <i class="fa-solid fa-user-check"></i> Habilitar
                                    </button>
                                </td>
                            </tr>
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
<<<<<<< HEAD
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" onclick="descargarPDF('LectoresInhabilitados');" class="btn btn-danger btn-raised btn-sm">
                    <i class="fa-solid fa-file-pdf"></i> Imprimir Suspendidos
                </button>
=======
                <!-- Botón institucional añadido para PDF de suspendidos -->
                 <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" onclick="descargarPDF('LectoresInhabilitados');" class="btn btn-danger btn-raised btn-sm">
                    <i class="fa-solid fa-file-pdf"></i> Imprimir Suspendidos
                </button>
                
>>>>>>> b092d1a81195f22f2d1e2473952b4cd4755b7908
            </div>
        </div>
    </div>
</div>