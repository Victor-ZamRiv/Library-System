// Variables globales
let chartPlazos;
let chartModalPlazos;

// Función para actualizar
function actualizarCumplimiento(periodo) {
    fetch(`/Library_System/dashboard/cumplimiento?periodo=${periodo}`)
        .then(response => response.json())
        .then(data => {
            // 1. Actualizar gráfico de dona del dashboard
            if (chartPlazos) {
                chartPlazos.updateSeries(data.series);
            } else {
                const options = {
                    chart: { height: 250, type: 'donut' },
                    series: data.series,
                    labels: ['A tiempo', 'Fuera de plazo'],
                    colors: ['#5cb85c', '#d9534f'],
                    legend: { position: 'bottom' },
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: 'Efectividad',
                                        formatter: function (w) {
                                            return w.globals.seriesTotals[0] + "%"
                                        }
                                    }
                                }
                            }
                        }
                    }
                };
                chartPlazos = new ApexCharts(document.querySelector("#chartPlazos"), options);
                chartPlazos.render();
            }

            // 2. Actualizar gráfico del modal (si existe)
            if (chartModalPlazos) {
                chartModalPlazos.updateSeries(data.series);
            } else {
                window.datosCumplimientoModal = { series: data.series };
            }

            // 3. Actualizar indicadores secundarios (libros, audio, inter, bloqueados)
            if (data.datos_adicionales) {
                if (document.getElementById('indLibros')) {
                    document.getElementById('indLibros').innerText = data.datos_adicionales.libros;
                    document.getElementById('indAudio').innerText = data.datos_adicionales.audio;
                    document.getElementById('indInter').innerText = data.datos_adicionales.inter;
                    document.getElementById('indBloqueados').innerText = data.datos_adicionales.bloqueados;
                }
            }

            // 4. Actualizar tabla de desglose
            if (data.tabla && document.getElementById('tablaCumplimientoCuerpo')) {
                document.getElementById('tablaCumplimientoCuerpo').innerHTML = data.tabla;
            }
        })
        .catch(error => console.error('Error al actualizar cumplimiento:', error));
}

// Inicializar al cargar la página (período mes)
document.addEventListener('DOMContentLoaded', function() {
    actualizarCumplimiento('mes');
});

// Evento para crear gráfico del modal cuando se abre
$(document).ready(function() {
    $('#modalDetalleCumplimiento').on('shown.bs.modal', function() {
        if (!chartModalPlazos && window.datosCumplimientoModal) {
            const optionsModal = {
                chart: { height: 220, type: 'donut' },
                series: window.datosCumplimientoModal.series,
                labels: ['A tiempo', 'Fuera de plazo'],
                colors: ['#5cb85c', '#d9534f'],
                legend: { position: 'bottom' }
            };
            chartModalPlazos = new ApexCharts(document.querySelector("#chartModalPlazos"), optionsModal);
            chartModalPlazos.render();
        }
    });
});