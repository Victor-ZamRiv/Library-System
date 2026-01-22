document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('form-busqueda');
    const inputSearch = document.getElementById('search_book_init');
    const errorSearch = document.getElementById('search-error');

    // Regla: Letras, números y espacios
    const regexAlfaNumerico = /^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ]+$/;

    function toggleError(input, errorElement, show, mensaje) {
        if (show) {
            input.parentElement.classList.add('has-error');
            errorElement.innerHTML = `<i class="fa-solid fa-circle-exclamation"></i> ${mensaje}`;
            errorElement.style.display = 'block';
        } else {
            input.parentElement.classList.remove('has-error');
            errorElement.style.display = 'none';
        }
    }

    function validarBusqueda() {
        const valor = inputSearch.value.trim();
        
        if (valor === "") {
            toggleError(inputSearch, errorSearch, true, "Ingrese un término de búsqueda.");
            return false;
        }
        if (!regexAlfaNumerico.test(valor)) {
            toggleError(inputSearch, errorSearch, true, "Solo se permiten letras, números y espacios.");
            return false;
        }

        toggleError(inputSearch, errorSearch, false);
        return true;
    }

    inputSearch.addEventListener('input', validarBusqueda);

    form.addEventListener('submit', function(e) {
        if (!validarBusqueda()) {
            e.preventDefault();
        }
    });
});