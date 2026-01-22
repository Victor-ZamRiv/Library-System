        const formRegistroLibro = document.getElementById('form-registro-libro');
        const btnConfirmarEnvio = document.getElementById('btn-confirmar-envio');
        const resumenDatosLibro = document.getElementById('resumen-datos-libro');
        const portadaReg = document.getElementById('portada-reg');
        const fileNameSpan = document.getElementById('file-name');

        // 1. Detener el envío y mostrar el modal
        formRegistroLibro.addEventListener('submit', function(event) {
            // Detener el envío por defecto
            event.preventDefault();

            // Comprobar la validez del formulario completo
            if (formRegistroLibro.checkValidity()) {

                // --- 2. Recopilar y Formatear los Datos ---
                const sala = document.getElementById('salaSelect').value;
                const area = document.getElementById('areaSelect').value;
                const titulo = document.getElementById('titulo-reg').value;
                const cota = document.getElementById('cota').value;
                const autor = document.getElementById('autor-reg').value;
                const ciudad = document.getElementById('ciudad-reg').value;
                const edicion = document.getElementById('edicion-reg').value;
                const anio = document.getElementById('year-reg').value;
                const ejemplares = document.getElementById('ejemplares-reg').value;
                const paginas = document.getElementById('paginas-reg').value;
                const editorial = document.getElementById('editorial-reg').value;
                const isbn = document.getElementById('isbn').value;
                const observaciones = document.getElementById('observaciones-reg').value;

                // Nombre del archivo de portada (si existe)
                const nombrePortada = portadaReg.files.length > 0 ? portadaReg.files[0].name : 'No seleccionada';


                // --- 3. Construir la Tabla de Resumen ---
                let htmlResumen = `
            <table class="table table-sm table-striped">
                <tbody>
                    <tr><th>Sala:</th><td>${sala}</td></tr>
                    ${area ? `<tr><th>Área Infantil:</th><td>${area}</td></tr>` : ''}
                    <tr><th>Título:</th><td><strong>${titulo}</strong></td></tr>
                    <tr><th>Autor:</th><td>${autor}</td></tr>
                    <tr><th>Cota:</th><td>${cota}</td></tr>
                    <tr><th>Editorial:</th><td>${editorial}</td></tr>
                    <tr><th>ISBN:</th><td>${isbn}</td></tr>
                    <tr><th>Ciudad:</th><td>${ciudad}</td></tr>
                    <tr><th>Edición:</th><td>${edicion}</td></tr>
                    <tr><th>Año:</th><td>${anio}</td></tr>
                    <tr><th>Ejemplares:</th><td>${ejemplares}</td></tr>
                    <tr><th>Páginas:</th><td>${paginas}</td></tr>
                    <tr><th>Observaciones:</th><td>${observaciones || 'Ninguna'}</td></tr>
                    <tr><th>Portada:</th><td>${nombrePortada}</td></tr>
                </tbody>
            </table>
        `;

                // Insertar el resumen en el cuerpo del modal
                resumenDatosLibro.innerHTML = htmlResumen;

                // Mostrar el modal de confirmación
                $('#modalConfirmacion').modal('show');

            } else {
                // Si la validación falla (ej. campos requeridos vacíos), forzamos la validación visual de Bootstrap
                formRegistroLibro.classList.add('was-validated');
            }
        });


        // 4. Manejar la acción de "Confirmar" dentro del modal
        btnConfirmarEnvio.addEventListener('click', function() {
            // Ocultar el modal
            $('#modalConfirmacion').modal('hide');

            // Quitar temporalmente el listener de submit para permitir el envío
            // **Importante:** Necesitamos que el formulario se envíe con un método nativo
            // para que también incluya el archivo de la portada (enctype="multipart/form-data").

            // Crear un nuevo evento de submit sin propagación
            const event = new Event('submit', {
                cancelable: true
            });

            // Eliminar el listener temporalmente (para evitar bucle)
            formRegistroLibro.removeEventListener('submit', arguments.callee);

            // Enviar el formulario programáticamente
            formRegistroLibro.submit();

            // Nota: Si usaras AJAX (fetch o XHR) para enviar la data,
            // NO usarías formRegistroLibro.submit();. En su lugar, ejecutarías aquí la lógica AJAX.
        });


        // Opcional: Script para mostrar el nombre del archivo seleccionado en el campo de Portada
        portadaReg.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileNameSpan.textContent = this.files[0].name;
            } else {
                fileNameSpan.textContent = 'No se ha seleccionado archivo';
            }
        });