const formRegistroLibro = document.getElementById('form-registro-libro');
const btnConfirmarEnvio = document.getElementById('btn-confirmar-envio');
const resumenDatosLibro = document.getElementById('resumen-datos-libro');
const portadaReg = document.getElementById('portada-reg');
const fileNameSpan = document.getElementById('file-name');

formRegistroLibro.addEventListener('submit', function(event) {
    // 1. Validar el formulario antes de mostrar el modal
    if (!formRegistroLibro.checkValidity()) {
        formRegistroLibro.classList.add('was-validated');
        return; // Detener si hay campos inválidos
    }

    // 2. Bloquear envío automático para mostrar resumen
    event.preventDefault();

    // 3. Captura de TODOS los valores (IDs mapeados según tu HTML)
    const data = {
        sala: document.getElementById('salaSelect').value,
        area: document.getElementById('areaSelect').value,
        titulo: document.getElementById('titulo-reg').value,
        cota: document.getElementById('cota').value,
        autor: document.getElementById('autor-reg').value,
        ciudad: document.getElementById('ciudad').value,
        edicion: document.getElementById('edicion').value,
        anio: document.getElementById('year-reg').value,
        ejemplares: document.getElementById('ejemplares-reg').value,
        paginas: document.getElementById('paginas-reg').value,
        editorial: document.getElementById('editorial-reg').value,
        isbn: document.getElementById('isbn').value,
        obs: document.getElementById('observaciones-reg').value
    };

    const nombrePortada = portadaReg.files.length > 0 ? portadaReg.files[0].name : 'Sin archivo (se usará por defecto)';

    // 4. Construcción de la tabla de resumen
    let htmlResumen = `
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-bordered">
                <thead>
                    <tr class="info"><th colspan="2" class="text-center">RESUMEN DEL REGISTRO</th></tr>
                </thead>
                <tbody>
                    <tr><td style="width: 30%;"><strong>Sala:</strong></td><td>${data.sala}</td></tr>
                    ${data.area ? `<tr><td><strong>Área Infantil:</strong></td><td>${data.area}</td></tr>` : ''}
                    <tr><td><strong>Título:</strong></td><td>${data.titulo}</td></tr>
                    <tr><td><strong>Autor:</strong></td><td>${data.autor}</td></tr>
                    <tr><td><strong>Cota:</strong></td><td>${data.cota}</td></tr>
                    <tr><td><strong>Editorial:</strong></td><td>${data.editorial}</td></tr>
                    <tr><td><strong>ISBN:</strong></td><td>${data.isbn}</td></tr>
                    <tr><td><strong>Ubicación:</strong></td><td>${data.ciudad}, Edición: ${data.edicion}, Año: ${data.anio}</td></tr>
                    <tr><td><strong>Físico:</strong></td><td>${data.ejemplares} Ejemplares, ${data.paginas} Páginas</td></tr>
                    <tr><td><strong>Observaciones:</strong></td><td>${data.obs || '<em>Ninguna</em>'}</td></tr>
                    <tr><td><strong>Portada:</strong></td><td><i class="fa-solid fa-image"></i> ${nombrePortada}</td></tr>
                </tbody>
            </table>
        </div>
    `;

    // 5. Inyectar y mostrar
    resumenDatosLibro.innerHTML = htmlResumen;
    $('#modalConfirmacion').modal('show');
});

// 6. Acción final al confirmar
btnConfirmarEnvio.addEventListener('click', function() {
    $('#modalConfirmacion').modal('hide');
    formRegistroLibro.submit(); // Envía el formulario de forma nativa
});

// Actualizar nombre del archivo visualmente
portadaReg.addEventListener('change', function() {
    fileNameSpan.textContent = this.files.length > 0 ? this.files[0].name : 'No se ha seleccionado archivo';
});