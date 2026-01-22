document.addEventListener("DOMContentLoaded", function() {
    const formSearch = document.getElementById('form-search-user');
    const inputSearch = document.getElementById('inputSearch');
    const errorContainer = document.getElementById('search-error');

    // Criterio: Alfanumérico para Cédula, Usuario, Nombre y Carnet
    const regexValida = /^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ]+$/;

    function mostrarError(mensaje) {
        inputSearch.parentElement.classList.add('has-error');
        errorContainer.innerHTML = `<i class="fas fa-exclamation-triangle"></i> ${mensaje}`;
        errorContainer.style.display = 'block';
    }

    function limpiarError() {
        inputSearch.parentElement.classList.remove('has-error');
        errorContainer.style.display = 'none';
    }

    function validarBusqueda() {
        const valor = inputSearch.value.trim();

        if (valor === "") {
            mostrarError("Por favor, ingrese un criterio (Cédula, Usuario, Nombre o Carnet).");
            return false;
        }

        if (!regexValida.test(valor)) {
            mostrarError("Solo se permiten letras, números y espacios.");
            return false;
        }

        if (valor.length < 3) {
            mostrarError("Ingrese al menos 3 caracteres para buscar.");
            return false;
        }

        limpiarError();
        return true;
    }

    // Validación en tiempo real
    inputSearch.addEventListener('input', function() {
        if (inputSearch.value.length > 0) {
            validarBusqueda();
        } else {
            limpiarError();
        }
    });

    // Validación al enviar
    formSearch.addEventListener('submit', function(e) {
        if (!validarBusqueda()) {
            e.preventDefault();
        }
    });
});