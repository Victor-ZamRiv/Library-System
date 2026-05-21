// Variables globales
let chartOcupacion;
let chartModalOcupacion;

// Función para actualizar
function actualizarOcupacion(periodo) {
    fetch(`/Library_System/dashboard/ocupacion?periodo=${periodo}`)
        .then(response => response.json())
        .then(data => {
            // 1. Actualizar gráfico de barras del dashboard
            if (chartOcupacion) {
                chartOcupacion.updateSeries([{ name: 'Ocupación %', data: data.series }]);
                chartOcupacion.updateOptions({ xaxis: { categories: data.categorias } });
            } else {
                const options = {
                    chart: { type: 'bar', height: 250, toolbar: { show: false } },
                    plotOptions: { bar: { horizontal: true, distributed: true, borderRadius: 4 } },
                    colors: ['#2e6da4', '#5bc0de', '#5cb85c', '#f0ad4e'],
                    series: [{ name: 'Ocupación %', data: data.series }],
                    xaxis: { categories: data.categorias, max: 100 }
                };
                chartOcupacion = new ApexCharts(document.querySelector("#chartOcupacion"), options);
                chartOcupacion.render();
            }

            // 2. Actualizar gráfico del modal (si existe)
            if (chartModalOcupacion) {
                chartModalOcupacion.updateSeries([{ name: 'Ocupación %', data: data.series }]);
                chartModalOcupacion.updateOptions({ xaxis: { categories: data.categorias } });
            } else {
                window.datosOcupacionModal = { series: data.series, categorias: data.categorias };
            }

            // 3. Actualizar tabla de desglose
            if (data.tabla && document.getElementById('tablaOcupacionCuerpo')) {
                document.getElementById('tablaOcupacionCuerpo').innerHTML = data.tabla;
            }
        })
        .catch(error => console.error('Error al actualizar ocupación:', error));
}

// Inicializar al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    actualizarOcupacion('mes');
});

// Evento para crear gráfico del modal cuando se abre
$(document).ready(function() {
    $('#modalDetalleOcupacion').on('shown.bs.modal', function() {
        if (!chartModalOcupacion && window.datosOcupacionModal) {
            const optionsModal = {
                chart: { type: 'bar', height: 250, toolbar: { show: false } },
                plotOptions: { bar: { horizontal: true, distributed: true, borderRadius: 4 } },
                colors: ['#2e6da4', '#5bc0de', '#5cb85c', '#f0ad4e'],
                series: [{ name: 'Ocupación %', data: window.datosOcupacionModal.series }],
                xaxis: { categories: window.datosOcupacionModal.categorias, max: 100 }
            };
            chartModalOcupacion = new ApexCharts(document.querySelector("#chartModalOcupacion"), optionsModal);
            chartModalOcupacion.render();
        }
    });
});