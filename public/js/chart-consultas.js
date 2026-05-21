// Variables globales
let chartConsultas;
let chartModalConsultas;
let periodoActual = 'mes';

// Función para actualizar todo (gráficos, totales, tabla)
function actualizarTodo(periodo) {
    fetch(`/Library_System/dashboard/consultas?periodo=${periodo}`)
        .then(response => response.json())
        .then(data => {
            // 1. Actualizar gráfico del dashboard
            if (chartConsultas) {
                chartConsultas.updateOptions({
                    xaxis: { categories: data.categorias },
                    series: [{ name: 'Consultas', data: data.series }]
                });
            } else {
                // Si no existe, crearlo (esto debería ocurrir solo si la página se carga sin script)
                const options = {
                    chart: { height: 250, type: 'area', toolbar: { show: false } },
                    series: [{ name: 'Consultas', data: data.series }],
                    xaxis: { categories: data.categorias },
                    colors: ['#2e6da4'],
                    stroke: { curve: 'smooth' },
                    fill: { type: 'gradient', gradient: { opacityFrom: 0.7, opacityTo: 0.3 } }
                };
                chartConsultas = new ApexCharts(document.querySelector("#chartConsultas"), options);
                chartConsultas.render();
            }

            // 2. Actualizar gráfico del modal (si existe)
            if (chartModalConsultas) {
                chartModalConsultas.updateOptions({
                    xaxis: { categories: data.categorias },
                    series: [{ name: 'Consultas', data: data.series }]
                });
            } else {
                // El modal se crea la primera vez que se abre (ver evento 'shown.bs.modal')
                // Solo almacenamos los datos para ese momento
                window.datosConsultasModal = { series: data.series, categorias: data.categorias };
            }

            // 3. Actualizar valores de los cuadros resumen (totales, pico, crecimiento)
            if (document.getElementById('reporteTotal')) {
                document.getElementById('reporteTotal').innerText = data.total;
                document.getElementById('reportePico').innerText = data.pico;
                document.getElementById('reporteCrecimiento').innerHTML = data.crecimiento;
            }

            // 4. Actualizar tabla del modal (desglose)
            if (data.tabla && document.getElementById('tablaReporteCuerpo')) {
                document.getElementById('tablaReporteCuerpo').innerHTML = data.tabla;
            }
        })
        .catch(error => console.error('Error al actualizar consultas:', error));
}

// Inicializar gráfico del dashboard al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    actualizarTodo('mes'); // Período inicial
});

// Configurar evento para cuando se abra el modal, crear el gráfico si no existe
$(document).ready(function() {
    $('#modalDetalleConsultasGrafico').on('shown.bs.modal', function() {
        if (!chartModalConsultas && window.datosConsultasModal) {
            const optionsModal = {
                chart: { height: 250, type: 'area', toolbar: { show: false } },
                series: [{ name: 'Consultas', data: window.datosConsultasModal.series }],
                xaxis: { categories: window.datosConsultasModal.categorias },
                colors: ['#2c3e50'],
                stroke: { width: 3, curve: 'smooth' },
                fill: { type: 'solid', opacity: 0.1 }
            };
            chartModalConsultas = new ApexCharts(document.querySelector("#chartModalConsultas"), optionsModal);
            chartModalConsultas.render();
        }
    });
});