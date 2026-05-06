<!-- Modal de Devolución -->
<div class="modal fade" id="modalDevolucion" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa-solid fa-clipboard-check text-primary"></i> Confirmar Devolución</h4>
            </div>
            
            <form action="<?= BASE_URL ?>/prestamos/devolver" method="POST">
                <div class="modal-body">
                    <!-- Alerta de Multa (solo si hay retraso) -->
                    <?php if ($diasRetraso > 0): ?>
                    <div class="alert alert-danger">
                        <h4 class="alert-heading"><i class="fa-solid fa-triangle-exclamation"></i> ¡Préstamo Atrasado!</h4>
                        <p>Este préstamo tiene <?= $diasRetraso ?> días de retraso. La multa total acumulada es de: <strong>$<?= number_format($montoMulta, 2) ?></strong></p>
                    </div>
                    <?php endif; ?>

                    <p class="text-muted">Por favor, verifique el estado físico de cada ejemplar antes de procesar la devolución:</p>
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Libro</th>
                                    <th style="width: 250px;">Estado de Entrega</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ejemplares as $item): 
                                    $libro = $item['libro'];
                                    $ejemplar = $item['ejemplar'];
                                ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($libro->getTitulo()) ?></strong><br>
                                        <small>Cota: <?= htmlspecialchars($libro->getCota()) ?> | Ejemplar #<?= $ejemplar->getNumeroEjemplar() ?><br>
                                    </td>
                                    <td>
                                        <select name="estados[<?= $ejemplar->getIdEjemplar() ?>]" class="form-control" required>
                                            <option value="Disponible">Buen Estado</option>
                                            <option value="Dañado">Dañado / Deteriorado</option>
                                        </select>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Campo oculto con el ID del préstamo -->
                    <input type="hidden" name="id" value="<?= $prestamo->getIdPrestamo() ?>">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success btn-raised">
                        <i class="fa-solid fa-check-double"></i> Confirmar Devolución Completa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>