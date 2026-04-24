<div class="modal fade" id="modalEliminarVisitante" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    <i class="fa-solid fa-users-slash text-danger"></i> Eliminar Registro de Visita
                </h4>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar el registro de visitantes seleccionado?</p>
                <div class="well">
                    <strong>Fecha:</strong> <span id="spanFecha"></span><br>
                    <strong>Turno:</strong> <span id="spanTurno"></span>
                </div>
                <p class="text-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i> 
                    <strong>Atención:</strong> Esta acción afectará las estadísticas y gráficas de flujo.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a href="#" id="btnConfirmarEliminarVisitante" class="btn btn-danger btn-raised">
                    Confirmar Eliminación
                </a>
            </div>
        </div>
    </div>
</div>