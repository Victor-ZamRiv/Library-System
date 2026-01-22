/**
 * Script para manejar el Modal de Confirmación de Cierre de Sesión (Logout).
 */

// Función para mostrar el modal de confirmación de logout
function mostrarModalLogout() {
    // Requiere que el modal tenga el ID 'confirmLogoutModal'
    // Asume que estás usando jQuery/Bootstrap 4+
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