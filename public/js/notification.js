const contenedorBotones = document.getElementById('contenedor-botones');
const contenedorToast = document.getElementById('contenedor-toast');

// Event listener para detectar click en los botones
contenedorBotones.addEventListener('click', (e) => {
    e.preventDefault();
    const tipo = (e.target.dataset.tipo);

    if (tipo === 'exito') {
        
        agregarToast({ tipo: 'exito', titulo: 'Exito', descripcion: 'La operacion fue exitosa' });
    }
    if (tipo === 'error') {
        agregarToast({ tipo: 'error', titulo: 'Error', descripcion: 'La operacion tuvo un error' });
    }
    if (tipo === 'info') {
        
        agregarToast({ tipo: 'info', titulo: 'info', descripcion: 'Este notificacion es de información' });
    }
    if (tipo === 'warning') {
        agregarToast({ tipo: 'warning', titulo: 'warning', descripcion: 'Ten cuidado' });
    }
});

//Event listener para cerrar los toats
contenedorToast.addEventListener('click', (e) => {
    const toastId = e.target.closest('div.toast').id;

    if(e.target.closest('button.btn-cerrar')){
        cerrarToats(toastId);
    }
    
});

//funcion parea cerrar toats
const cerrarToats = (id) =>{
    document.getElementById(id)?.classList.add('cerrando');
}

// Funcion para agregar toast
const agregarToast = ({ tipo, titulo, descripcion, autoCierre }) => {
    // Crear toast
    const nuevoToast = document.createElement('div');

    // agregar clases al toast
    nuevoToast.classList.add('toast');
    nuevoToast.classList.add(tipo);

    // agregar id del toast
    const numeroAlAzar = Math.floor(Math.random() * 100);
    const fecha = Date.now();
    const toastId = fecha + numeroAlAzar;
    nuevoToast.id = toastId

    // iconos 
    const iconos = {
        exito: `<i class="fa-solid fa-circle-check fa-2x"></i>`,
        error: `<i class="fa-solid fa-circle-xmark fa-2x"></i>`,
        info: `<i class="fa-solid fa-circle-info fa-2x"></i>`,
        warning: `<i class="fa-solid fa-triangle-exclamation fa-2x"></i>`,
    }

    //plantilla del toast
    const toast = `
            <div class="contenido">
            <div class="iconos">
                ${iconos[tipo]}
                </div class="iconos">
                <div class="texto">
                    <p class="titulo">${titulo}</p>
                    <p class="descripcion">${descripcion}</p>
                </div>
            </div>
            <button class="btn-cerrar">
                <div class="icono">
                    <i class="fa-solid fa-x"></i>
                </div>
            </button>
        `;

    // Agregar la plantilla al nuevo toast
    nuevoToast.innerHTML = toast;

    //agregar toast al contenedor
    contenedorToast.appendChild(nuevoToast);

    //funcion para manejar el cierre del toast
    const handleAnimacionCierre = (e) =>{
        if(e.animationName === 'cierre'){
            nuevoToast.removeEventListener('animationend', handleAnimacionCierre);
            nuevoToast.remove();
        }
    };

    //event para eliminar el toast
    nuevoToast.addEventListener('animationend', handleAnimacionCierre);
}

