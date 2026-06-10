<!-- MODAL DE CONFIRMACIÓN MÁS ESPECÍFICO (CORREGIDO) -->
    <div class="modal fade" id="confirmSaveIndicadoresModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa-solid fa-triangle-exclamation text-primary"></i> Confirmar Configuración de Dashboard
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <strong>¡Atención!</strong> Esta configuración determinará exactamente qué indicadores aparecerán en el dashboard principal.
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <h5><i class="fa-solid fa-eye text-success"></i> <strong>VISIBLES</strong> <span id="contadorVisibles" class="badge badge-success">0</span></h5>
                            <div id="indicadoresVisibles" class="mb-3"></div>
                        </div>
                        <div class="col-sm-6">
                            <h5><i class="fa-solid fa-eye-slash text-danger"></i> <strong>OCULTOS</strong> <span id="contadorOcultos" class="badge badge-danger">0</span></h5>
                            <div id="indicadoresOcultos"></div>
                        </div>
                    </div>
                    <hr>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formIndicadores" class="btn btn-primary btn-raised">
                        <i class="fa-solid fa-floppy-disk"></i> Confirmar y Guardar
                    </button>
                </div>
            </div>
        </div>
    </div>