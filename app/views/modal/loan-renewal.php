<div class="modal fade" id="modalRenovacion" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa-solid fa-calendar-plus text-warning"></i> Renovar Préstamo</h4>
            </div>
            
            <form action="<?= BASE_URL ?>/prestamos/renovar" method="POST">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <p><i class="fa-solid fa-circle-info"></i> La renovación extenderá la fecha de entrega según las políticas de la biblioteca.</p>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Fecha Actual de Vencimiento:</label>
                                <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($prestamo->getFechaRecepcionEstipulada())) ?>" readonly disabled>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Nueva Fecha de Vencimiento:</label>
                                <input type="text" class="form-control" value="Se calculará automáticamente" readonly disabled>
                                <small class="text-muted">Se sumarán los días correspondientes según el tipo de libro, omitiendo fines de semana.</small>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?= $prestamo->getIdPrestamo() ?>">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning btn-raised">
                        <i class="fa-solid fa-check"></i> Confirmar Renovación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>