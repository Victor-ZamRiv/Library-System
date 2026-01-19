<div class="modal fade" id="confirmLogoutModal" tabindex="-1" role="dialog" aria-labelledby="confirmLogoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="confirmLogoutModalLabel"><i class="fa-solid fa-right-from-bracket text-primary"></i> Confirmar Cierre de Sesión</h4>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea **cerrar su sesión**?</p>
                <p class="text-info">Asegúrese de haber guardado todos los cambios antes de salir.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-raised btn-lg" id="confirm-logout-btn" onclick="ejecutarLogout()">Cerrar Sesión</button>
            </div>
        </div>
    </div>
</div>

<script>
    /**
 * Script para manejar el Modal de Confirmación de Cierre de Sesión (Logout).
 */

// Función para mostrar el modal de confirmación de logout
function mostrarModalLogout() {
    // AÑADE ESTA LÍNEA CLAVE:
    $('.modal-backdrop').remove(); 
    
    // Y remueve cualquier clase 'modal-open' residual del body, si persiste el problema
    $('body').removeClass('modal-open'); 

    // Muestra el modal
    $('#confirmLogoutModal').modal('show');
}

// Función que se ejecuta al confirmar el cierre de sesión en el modal
function ejecutarLogout() {
    // 1. Ocultar el modal inmediatamente
    $('#confirmLogoutModal').modal('hide');

    // 2. Lógica real para el logout (¡AJUSTA ESTA LÍNEA A TU SISTEMA!)
    
    // --- OPCIÓN MÁS COMÚN (Redirección a la ruta de logout) ---
    window.location.href = '/ruta-a-tu-logout'; 
    
    // --- OPCIÓN ALTERNATIVA (Si necesitas enviar una solicitud POST al servidor) ---
    /*
    fetch('/ruta-a-tu-logout', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': 'TuTokenCSRFAqui' // Si usas tokens de seguridad
        }
    })
    .then(response => {
        if (response.ok) {
            window.location.href = '/login'; // O la página de destino
        } else {
            alert('Error al cerrar sesión. Intente de nuevo.');
        }
    })
    .catch(error => console.error('Error:', error));
    */
}

// Cómo usarlo: Llama a 'mostrarModalLogout()' desde el botón o enlace de cerrar sesión:
// <a href="#" onclick="mostrarModalLogout()">Cerrar Sesión</a>
</script>