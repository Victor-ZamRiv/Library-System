<!-- Modal de Devolución -->
<div class="modal fade" id="modalDevolucion" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa-solid fa-clipboard-check text-primary"></i> Confirmar Devolución</h4>
            </div>
            
            <form action="procesar_devolucion.php" method="POST">
                <div class="modal-body">
                    <!-- Alerta de Multa (Se puede mostrar u ocultar con lógica PHP/JS) -->
                    <div class="alert alert-danger">
                        <h4 class="alert-heading"><i class="fa-solid fa-triangle-exclamation"></i> ¡Préstamo Atrasado!</h4>
                        <p>Este préstamo tiene 3 días de retraso. La multa total acumulada es de: <strong>$5.00</strong></p>
                    </div>

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
                                <!-- Libro 1 -->
                                <tr>
                                    <td>
                                        <strong>Libro 1:</strong> LIB001 <br>
                                        <small>Cálculo de Stewart</small>
                                    </td>
                                    <td>
                                        <select name="estado_libro1" class="form-control" required>
                                            <option value="bueno">Buen Estado</option>
                                            <option value="danado">Dañado / Deteriorado</option>
                                            <option value="extraviado">Extraviado</option>
                                        </select>
                                    </td>
                                </tr>
                                <!-- Libro 2 (Si existe) -->
                                <tr>
                                    <td>
                                        <strong>Libro 2:</strong> LIB005 <br>
                                        <small>Física Universitaria</small>
                                    </td>
                                    <td>
                                        <select name="estado_libro2" class="form-control">
                                            <option value="bueno">Buen Estado</option>
                                            <option value="danado">Dañado / Deteriorado</option>
                                            <option value="extraviado">Extraviado</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Observaciones adicionales (opcional):</label>
                        <textarea class="form-control" name="observaciones" rows="2"></textarea>
                    </div>
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