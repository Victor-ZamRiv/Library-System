var chartConsultas;
var chartModal;

// 1. Inicialización de la gráfica del Dashboard (Área)
var optionsConsultas = {
    chart: { height: 250, type: 'area', toolbar: { show: false } },
    series: [{ name: 'Consultas', data: [40, 45, 38, 50, 42, 30] }],
    xaxis: { categories: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'] },
    colors: ['#2e6da4'],
    stroke: { curve: 'smooth' },
    fill: { type: 'gradient', gradient: { opacityFrom: 0.7, opacityTo: 0.3 } }
};

chartConsultas = new ApexCharts(document.querySelector("#chartConsultas"), optionsConsultas);
chartConsultas.render();

// 2. Control del Modal
$(document).ready(function() {
    $('#modalDetalleConsultasGrafico').on('shown.bs.modal', function() {
        if (!chartModal) {
            var optionsModal = {
                chart: { height: 250, type: 'area', toolbar: { show: false } },
                series: [{ name: 'Consultas', data: chartConsultas.w.globals.series[0].data }],
                xaxis: { categories: chartConsultas.w.globals.labels },
                colors: ['#2c3e50'],
                stroke: { width: 3, curve: 'smooth' },
                fill: { type: 'solid', opacity: 0.1 }
            };
            chartModal = new ApexCharts(document.querySelector("#chartModalConsultas"), optionsModal);
            chartModal.render();
        }
        // Carga datos iniciales al abrir
        actualizarTodo('semana');
    });
});

// 3. Función Maestra de Actualización
function actualizarTodo(periodo) {
    let nuevosDatos = [], nuevasCategorias = [], reporte = {};

    switch (periodo) {
        case 'semana':
            nuevosDatos = [40, 45, 38, 50, 42, 30];
            nuevasCategorias = ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
            reporte = { 
                total: '245', 
                pico: 'Jueves', 
                crecimiento: '+5%', 
                tabla: `<tr><td>Turno Mañana</td><td>145</td><td><span class="label label-danger">Saturado</span></td></tr>
                        <tr><td>Turno Tarde</td><td>100</td><td><span class="label label-primary">Estable</span></td></tr>` 
            };
            break;
        case 'mes':
            nuevosDatos = [120, 150, 180, 140];
            nuevasCategorias = ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'];
            reporte = { 
                total: '590', 
                pico: 'Semana 3', 
                crecimiento: '+12%', 
                tabla: `<tr><td>Primera Quincena</td><td>270</td><td><span class="label label-primary">Normal</span></td></tr>
                        <tr><td>Segunda Quincena</td><td>320</td><td><span class="label label-warning">Alta</span></td></tr>` 
            };
            break;
        case 'trimestre':
            nuevosDatos = [450, 520, 480];
            nuevasCategorias = ['Mes 1', 'Mes 2', 'Mes 3'];
            reporte = { 
                total: '1,450', 
                pico: 'Mes 2', 
                crecimiento: '+8%', 
                tabla: `<tr><td>Promedio Mensual</td><td>483</td><td><span class="label label-success">Óptimo</span></td></tr>` 
            };
            break;
    }

    // Actualizar Gráficas
    chartConsultas.updateOptions({ series: [{ data: nuevosDatos }], xaxis: { categories: nuevasCategorias } });
    if (chartModal) {
        chartModal.updateOptions({ series: [{ data: nuevosDatos }], xaxis: { categories: nuevasCategorias } });
    }

    // Actualizar Indicadores de Texto (Wells)
    if (document.getElementById('reporteTotal')) {
        document.getElementById('reporteTotal').innerText = reporte.total;
        document.getElementById('reportePico').innerText = reporte.pico;
        document.getElementById('reporteCrecimiento').innerText = reporte.crecimiento;
        document.getElementById('tablaReporteCuerpo').innerHTML = reporte.tabla;
    }
}