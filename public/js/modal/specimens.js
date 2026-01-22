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
    // Oculta visualmente
    rowElementToDelete.style.display = 'none';

    // Agrega hidden para el backend: ejemplares_descatalogar[]
    const container = document.getElementById('ejemplares-hidden-fields');
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'ejemplares_descatalogar[]';
    input.value = String(ejemplarIdToDelete);
    container.appendChild(input);

    $('#confirmDeleteModal').modal('hide');
    actualizarTotalEjemplares();

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
