var chartPlazos;
var chartModalPlazos;

// 1. Inicialización de la gráfica de dona (Dashboard)
var optionsPlazos = {
    chart: { height: 250, type: 'donut', id: 'dashPlazos' },
    series: [88, 12], // Datos estáticos iniciales (Semana)
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

chartPlazos = new ApexCharts(document.querySelector("#chartPlazos"), optionsPlazos);
chartPlazos.render();

// 2. Lógica del Modal
$(document).ready(function() {
    $('#modalDetalleCumplimiento').on('shown.bs.modal', function() {
        if (!chartModalPlazos) {
            var optionsModal = {
                chart: { height: 220, type: 'donut' },
                series: chartPlazos.w.globals.series,
                labels: ['A tiempo', 'Fuera de plazo'],
                colors: ['#5cb85c', '#d9534f'],
                legend: { position: 'bottom' }
            };
            chartModalPlazos = new ApexCharts(document.querySelector("#chartModalPlazos"), optionsModal);
            chartModalPlazos.render();
        }
        // Al abrir, sincroniza con el periodo actual
        actualizarCumplimiento('semana');
    });
});

// 3. Función Maestra de Actualización
function actualizarCumplimiento(periodo) {
    let datosGrafica = [];
    let reporte = {};

    switch (periodo) {
        case 'semana':
            datosGrafica = [88, 12];
            reporte = {
                libros: '95%',
                audio: '88%',
                inter: '72%',
                bloqueados: '12',
                tabla: `<tr><td>Préstamos Circulantes</td><td>150</td><td>132</td><td>12</td><td>6</td></tr>
                        <tr><td>Renovaciones</td><td>45</td><td>40</td><td>5</td><td>0</td></tr>`
            };
            break;
        case 'mes':
            datosGrafica = [75, 25];
            reporte = {
                libros: '82%',
                audio: '70%',
                inter: '65%',
                bloqueados: '28',
                tabla: `<tr><td>Préstamos Circulantes</td><td>620</td><td>465</td><td>90</td><td>65</td></tr>
                        <tr><td>Renovaciones</td><td>180</td><td>150</td><td>20</td><td>10</td></tr>`
            };
            break;
        case 'trimestre':
            datosGrafica = [92, 8];
            reporte = {
                libros: '94%',
                audio: '90%',
                inter: '85%',
                bloqueados: '15',
                tabla: `<tr><td>Préstamos Circulantes</td><td>1,850</td><td>1,702</td><td>100</td><td>48</td></tr>
                        <tr><td>Renovaciones</td><td>540</td><td>510</td><td>20</td><td>10</td></tr>`
            };
            break;
    }

    // 1. Actualizar Gráficas
    chartPlazos.updateSeries(datosGrafica);
    if (chartModalPlazos) {
        chartModalPlazos.updateSeries(datosGrafica);
    }

    // 2. Actualizar los IDs que sí están en tu HTML
    if (document.getElementById('indLibros')) {
        document.getElementById('indLibros').innerText = reporte.libros;
        document.getElementById('indAudio').innerText = reporte.audio;
        document.getElementById('indInter').innerText = reporte.inter;
        document.getElementById('indBloqueados').innerText = reporte.bloqueados;
        document.getElementById('tablaCumplimientoCuerpo').innerHTML = reporte.tabla;
    }
}