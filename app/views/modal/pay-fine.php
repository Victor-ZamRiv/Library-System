<!-- MODAL PARA CANCELAR MULTA -->
<div class="modal fade" id="modalConfirmarPago" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="fa-solid fa-dollar-sign text-success"></i> Confirmar Pago de Multa
                </h4>
            </div>
        <form method="POST" action="<?= BASE_URL ?>/multas/pagar">
            <div class="modal-body">
                <p>¿Está seguro de que desea marcar como pagada esta multa?</p>
                <p class="text-muted">Préstamo N°: <strong id="numPrestamoModal"></strong></p>
                <p class="text-success">Se registrará el ingreso del monto correspondiente.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success btn-raised">
                    <i class="fa-solid fa-check"></i> Confirmar Pago
                </button>
            </div>
            <!-- Campo oculto para enviar el ID de la multa a pagar -->
            <input type="hidden" name="idMulta" id="idMultaInput" value="">
        </form>
        </div>
    </div>
</div>