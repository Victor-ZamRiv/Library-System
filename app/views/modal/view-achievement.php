<!-- MODAL LOGROS -->
    <div class="modal fade" id="modalLogros" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa-solid fa-trophy text-warning"></i> Lista de Logros
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Involucrados</th>
                                    <th class="text-center">Descripción</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($logros) && !empty($logros)): ?>
                                    <?php foreach ($logros as $logro): ?>
                                    <tr>
                                        <td style="vertical-align: middle;"><?= htmlspecialchars($logro->getFecha()) ?></td>
                                        <td style="vertical-align: middle;"><?= htmlspecialchars($logro->getInvolucrados()) ?></td>
                                        <td style="vertical-align: middle;"><?= htmlspecialchars($logro->getDescripcion()) ?></td>
                                        <td style="vertical-align: middle;">
                                            <div class="d-flex justify-content-center">
                                                <a href="#!" class="btn btn-success btn-raised btn-sm">
                                                    <i class="fa-solid fa-pen-to-square"></i> EDITAR
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No hay logros registrados</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>