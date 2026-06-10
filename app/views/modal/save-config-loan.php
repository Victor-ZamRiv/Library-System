<!-- MODAL DE CONFIRMACIÓN PARA GUARDAR CONFIGURACIÓN DE PRÉSTAMOS -->
    <div class="modal fade" id="confirmSavePrestamosModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa-solid fa-triangle-exclamation text-success"></i> Confirmar Guardado
                    </h4>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de que desea <strong>guardar los cambios</strong> en la configuración de préstamos?</p>
                    <div class="alert alert-info">
                        <ul>
                            <li>Días de préstamo general: <strong id="diasPrestamoResumen"></strong> días</li>
                            <li>Días de préstamo novelas: <strong id="diasNovelasResumen"></strong> días</li>
                            <li>Monto multa por día: <strong id="montoMultaResumen"></strong></li>
                            <li>Límite préstamos simultáneos: <strong id="maxPrestamosResumen"></strong></li>
                            <li>Máximo renovaciones: <strong id="maxRenovacionesResumen"></strong></li>
                        </ul>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formPrestamos" class="btn btn-success btn-raised">
                        <i class="fa-solid fa-floppy-disk"></i> Sí, Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>