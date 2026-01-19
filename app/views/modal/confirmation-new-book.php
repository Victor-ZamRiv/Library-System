<div class="modal fade" id="modalConfirmacion" tabindex="-1" role="dialog" aria-labelledby="modalConfirmacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalConfirmacionLabel">
                    <i class="fas fa-check-circle text-success" style="margin-right: 5px;"></i>
                    Confirmación de Registro de Libro
                </h4>
            </div>

            <div class="modal-body">
                <p class="lead text-center mb-4">
                Por favor, revise cuidadosamente los datos a continuación antes de confirmar el registro.
                </p>

                <div id="resumen-datos-libro" class="p-3 border rounded">
                    <p class="text-center text-muted">Cargando datos...</p>
                </div>

            </div>
            
            <div class="modal-footer justify-content-between">
                
                <button type="button" class="btn btn-default" data-dismiss="modal">
                 Cancelar / Editar
                </button>

                <button type="button" class="btn btn-success btn-raised btn-lg" id="btn-confirmar-envio">
                 Confirmar Registro
                </button>
            </div>

        </div>
    </div>
</div>