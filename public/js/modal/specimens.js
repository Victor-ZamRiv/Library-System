let nuevosEjemplaresCount = 0;
let ejemplarIdToDelete = null;
let rowElementToDelete = null;

function agregarNuevoEjemplar() {
  const tableBody = document.querySelector('#ejemplares-table tbody');
  const newRow = tableBody.insertRow();

  // Render visual (no necesitas ID real aún)
  const nextCode = `EJ-NUEVO-${nuevosEjemplaresCount + 1}`;
  newRow.innerHTML = `
    <td>${nextCode}</td>
    <td>
      <select class="form-control nuevo-estado-ejemplar" style="width:auto;display:inline-block;">
        <option value="Disponible" selected>Disponible</option>
        <option value="Prestado">Prestado</option>
        <option value="Dañado">Dañado</option>
        <option value="En Reparación">En Reparación</option>
      </select>
    </td>
    <td>No Registrado</td>
    <td>
      <button type="button" class="btn btn-danger btn-xs" onclick="eliminarEjemplarNuevo(this)">
        <i class="fa-solid fa-trash-can"></i>
      </button>
    </td>
  `;

  // Incrementa contador y sincroniza hidden
  nuevosEjemplaresCount++;
  document.getElementById('nuevos_ejemplares').value = nuevosEjemplaresCount;

  actualizarTotalEjemplares();
}

function eliminarEjemplarNuevo(button) {
  const row = button.closest('tr');
  row.remove();

  // Decrementa y sincroniza hidden
  nuevosEjemplaresCount = Math.max(0, nuevosEjemplaresCount - 1);
  document.getElementById('nuevos_ejemplares').value = nuevosEjemplaresCount;

  actualizarTotalEjemplares();
}

function mostrarModalEliminar(id, code, button) {
  ejemplarIdToDelete = id;
  rowElementToDelete = button.closest('tr');
  document.getElementById('ejemplar-code-to-delete').textContent = code;
  $('#confirmDeleteModal').modal('show');
}

function ejecutarEliminacionEjemplar() {
    if (ejemplarIdToDelete !== null && rowElementToDelete !== null) {
        // Obtener motivo seleccionado
        const motivoSelect = document.getElementById('motivo-descatalogar');
        const motivo = motivoSelect ? motivoSelect.value : 'No especificado';

        // Oculta visualmente la fila
        rowElementToDelete.style.display = 'none';

        // Contenedor para campos ocultos (existe en el formulario)
        const container = document.getElementById('ejemplares-hidden-fields');

        // Campo para el ID del ejemplar a descatalogar
        let inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = 'ejemplares_descatalogar[]';
        inputId.value = String(ejemplarIdToDelete);
        container.appendChild(inputId);

        // Campo para el motivo correspondiente (mismo orden)
        let inputMotivo = document.createElement('input');
        inputMotivo.type = 'hidden';
        inputMotivo.name = 'motivos_descatalogar[]';
        inputMotivo.value = motivo;
        container.appendChild(inputMotivo);

        // Cerrar modal
        $('#confirmDeleteModal').modal('hide');

        // Actualizar contador de ejemplares visibles
        actualizarTotalEjemplares();

        // Limpiar variables
        ejemplarIdToDelete = null;
        rowElementToDelete = null;
    }
}

// Captura cambios de estado de ejemplares existentes y los refleja en hidden
document.addEventListener('change', (e) => {
  if (e.target.matches('.estado-ejemplar')) {
    const id = e.target.getAttribute('data-id');
    const estado = e.target.value;

    const container = document.getElementById('ejemplares-hidden-fields');
    // Busca todos los inputs y compara el atributo name manualmente
    let input = [...container.querySelectorAll('input')]
      .find(el => el.name === `estado_ejemplar[${id}]`);

    if (!input) {
      input = document.createElement('input');
      input.type = 'hidden';
      input.name = `estado_ejemplar[${id}]`;
      container.appendChild(input);
    }
    // Aquí siempre se actualiza el valor
    input.value = estado;
  }
});


function actualizarTotalEjemplares() {
  const visibleRows = document.querySelectorAll('#ejemplares-table tbody tr:not([style*="display: none"])');
  const ejemplaresTotalInput = document.getElementById('ejemplares-reg');
  if (ejemplaresTotalInput) {
    ejemplaresTotalInput.value = visibleRows.length;
  }
}

document.addEventListener('DOMContentLoaded', actualizarTotalEjemplares);
