/**
 * Sistema de Notificaciones Toast
 * Library_System
 */

/**
 * Cierra un toast específico activando la animación de salida.
 * @param {string} id - El ID único del elemento toast.
 */
const cerrarToats = (id) => {
    const elemento = document.getElementById(id);
    if (elemento) {
        // Añadimos la clase que dispara la animación @keyframes cierre en CSS
        elemento.classList.add('cerrando');
    }
}

/**
 * Crea y muestra una nueva notificación en pantalla.
 * @param {Object} opciones - Configuración de la notificación.
 */
const agregarToast = ({ tipo, titulo, descripcion, autoCierre = true }) => {
    const contenedorToast = document.getElementById('contenedor-toast');
    
    // Si el contenedor no existe en el HTML, cancelamos para evitar errores
    if (!contenedorToast) return;

    // Crear el elemento base del toast
    const nuevoToast = document.createElement('div');
    nuevoToast.classList.add('toast', tipo);
    
    // Si tiene autocierre, añadimos la clase para que el CSS muestre la barra de progreso
    if (autoCierre) {
        nuevoToast.classList.add('autoCierre');
    }
    
    // Generar un ID único para poder cerrarlo específicamente
    const toastId = "toast-" + Date.now() + Math.floor(Math.random() * 100);
    nuevoToast.id = toastId;

    // Diccionario de iconos (FontAwesome 7.0.1)
    const iconos = {
        exito: `<i class="fa-solid fa-circle-check fa-2x"></i>`,
        error: `<i class="fa-solid fa-circle-xmark fa-2x"></i>`,
        info: `<i class="fa-solid fa-circle-info fa-2x"></i>`,
        warning: `<i class="fa-solid fa-triangle-exclamation fa-2x"></i>`,
    };

    // Construir la estructura interna
    // El botón de cerrar llama directamente a la función global cerrarToats
    nuevoToast.innerHTML = `
        <div class="contenido">
            <div class="iconos">
                ${iconos[tipo] || iconos['info']}
            </div>
            <div class="texto">
                <p class="titulo">${titulo}</p>
                <p class="descripcion">${descripcion}</p>
            </div>
        </div>
        <button class="btn-cerrar" onclick="cerrarToats('${toastId}')" title="Cerrar">
            <div class="icono"><i class="fa-solid fa-x"></i></div>
        </button>
    `;

    // Agregar al contenedor en el DOM
    contenedorToast.appendChild(nuevoToast);

    // Programar el cierre automático tras 5 segundos (coincide con la barra de progreso)
    if (autoCierre) {
        setTimeout(() => {
            cerrarToats(toastId);
        }, 5000);
    }

    /**
     * Evento para eliminar físicamente el elemento del DOM 
     * una vez que la animación de "cierre" termina.
     */
    nuevoToast.addEventListener('animationend', (e) => {
        if (e.animationName === 'cierre') {
            nuevoToast.remove();
        }
    });
};

// Inicialización de eventos internos (opcional)
document.addEventListener('DOMContentLoaded', () => {
    // Si tuvieras botones manuales con data-tipo en la página, esto los controlaría
    const contenedorBotones = document.getElementById('contenedor-botones');
    if (contenedorBotones) {
        contenedorBotones.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-tipo]');
            if (btn) {
                const tipo = btn.dataset.tipo;
                agregarToast({ 
                    tipo: tipo, 
                    titulo: tipo.charAt(0).toUpperCase() + tipo.slice(1), 
                    descripcion: `Esta es una notificación de prueba de tipo ${tipo}` 
                });
            }
        });
    }
});