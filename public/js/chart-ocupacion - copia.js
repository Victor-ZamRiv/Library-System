var chartOcupacion;
var chartModalOcupacion;

// 1. Inicialización de la gráfica de barras
var optionsOcupacion = {
    chart: { type: 'bar', height: 250, toolbar: { show: false } },
    plotOptions: { 
        bar: { horizontal: true, distributed: true, borderRadius: 4 } 
    },
    colors: ['#2e6da4', '#5bc0de', '#5cb85c', '#f0ad4e'],
    series: [{ 
        name: 'Ocupación %', 
        data: [85, 65, 40, 92] 
    }],
    xaxis: { 
        categories: ['General', 'Referencia', 'Estatal', 'Infantil'], 
        max: 100 
    }
};

chartOcupacion = new ApexCharts(document.querySelector("#chartOcupacion"), optionsOcupacion);
chartOcupacion.render();

// 2. Control del Modal
$(document).ready(function() {
    $('#modalDetalleOcupacion').on('shown.bs.modal', function() {
        if (!chartModalOcupacion) {
            var optionsModal = { 
                ...optionsOcupacion, 
                chart: { ...optionsOcupacion.chart, height: 250 } 
            };
            chartModalOcupacion = new ApexCharts(document.querySelector("#chartModalOcupacion"), optionsModal);
            chartModalOcupacion.render();
        }
        // Carga datos iniciales (Semana) al abrir
        actualizarOcupacion('semana');
    });
});

// 3. Función de Actualización y Llenado de Tabla
function actualizarOcupacion(periodo) {
    let nuevosDatos = [];
    let htmlTabla = "";

    switch (periodo) {
        case 'semana':
            nuevosDatos = [85, 65, 40, 92];
            htmlTabla = `
                <tr><td>Sala General</td><td>120</td><td>102</td><td>85%</td><td><span class="label label-warning">Alta</span></td></tr>
                <tr><td>Referencia</td><td>40</td><td>26</td><td>65%</td><td><span class="label label-primary">Normal</span></td></tr>
                <tr><td>Estatal</td><td>30</td><td>12</td><td>40%</td><td><span class="label label-success">Baja</span></td></tr>
                <tr><td>Infantil</td><td>50</td><td>46</td><td>92%</td><td><span class="label label-danger">Crítica</span></td></tr>`;
            break;
        case 'mes':
            nuevosDatos = [70, 55, 30, 80];
            htmlTabla = `
                <tr><td>Sala General</td><td>120</td><td>84</td><td>70%</td><td><span class="label label-primary">Normal</span></td></tr>
                <tr><td>Referencia</td><td>40</td><td>22</td><td>55%</td><td><span class="label label-success">Baja</span></td></tr>
                <tr><td>Estatal</td><td>30</td><td>9</td><td>30%</td><td><span class="label label-success">Baja</span></td></tr>
                <tr><td>Infantil</td><td>50</td><td>40</td><td>80%</td><td><span class="label label-warning">Alta</span></td></tr>`;
            break;
        case 'trimestre':
            nuevosDatos = [60, 40, 25, 70];
            htmlTabla = `
                <tr><td>Sala General</td><td>120</td><td>72</td><td>60%</td><td><span class="label label-primary">Normal</span></td></tr>
                <tr><td>Referencia</td><td>40</td><td>16</td><td>40%</td><td><span class="label label-success">Baja</span></td></tr>
                <tr><td>Estatal</td><td>30</td><td>7</td><td>25%</td><td><span class="label label-success">Baja</span></td></tr>
                <tr><td>Infantil</td><td>50</td><td>35</td><td>70%</td><td><span class="label label-primary">Normal</span></td></tr>`;
            break;
    }

    // Actualizar Gráficas
    chartOcupacion.updateSeries([{ data: nuevosDatos }]);
    if (chartModalOcupacion) {
        chartModalOcupacion.updateSeries([{ data: nuevosDatos }]);
    }

    // Inyectar Filas en la Tabla
    const tabla = document.getElementById('tablaOcupacionCuerpo');
    if (tabla) {
        tabla.innerHTML = htmlTabla;
    }
}