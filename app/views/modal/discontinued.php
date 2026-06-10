<!-- modal/discontinued.php -->
<div class="modal fade" id="modalDescatalogados" tabindex="-1" role="dialog" aria-labelledby="modalDescatalogadosLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalDescatalogadosLabel"><i class="zmdi zmdi-delete"></i> Ejemplares Descatalogados de: <strong><?= htmlspecialchars($libro->getTitulo()) ?></strong></h4>
            </div>
            <div class="modal-body">
                <?php if (empty($descatalogados)): ?>
                    <div class="alert alert-info text-center">No hay ejemplares descatalogados para este libro.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover text-center" id="tabla-descatalogados-imprimir">
                            <thead>
                                <tr>
                                    <th class="text-center"># Ejemplar</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Fecha de Descatalogación</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($descatalogados as $ejemplar): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($ejemplar->getNumeroEjemplar()) ?></strong></td>
                                        <td><span class="label label-danger">Descatalogado</span></td>
                                        <td><span class="text-muted">--</span> <!-- puedes poner fecha si la tienes -->
                                        <td>
                                            <form method="POST" action="<?= BASE_URL ?>/libros/ejemplar/reactivar" style="display:inline;">
                                                <input type="hidden" name="id" value="<?= $ejemplar->getIdEjemplar() ?>">
                                                <input type="hidden" name="id_libro" value="<?= $libro->getIdLibro() ?>">
                                                <button type="submit" class="btn btn-xs btn-success btn-raised">
                                                    <i class="fa-solid fa-undo"></i> Reactivar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-raised" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success btn-raised" onclick="descargarPDF('EjemplaresDescatalogados')">
                    <i class="fa-solid fa-print"></i> IMPRIMIR REPORTE
                </button>
            </div>
        </div>
    </div>
</div>