    // Variables globales
    let chartConsultasVisitor;
    let periodoActual = 'mes'; // valor inicial

    // Función para cargar/actualizar gráfico y totales
    function cargarDatos(periodo) {
        fetch('/Library_System/visitantes/datos-grafico?periodo=' + periodo)
            .then(response => response.json())
            .then(data => {
                // Actualizar paneles de totales
                document.getElementById('total-ninos').innerText = data.totales.ninos;
                document.getElementById('total-adolescentes').innerText = data.totales.adolescentes;
                document.getElementById('total-adultos').innerText = data.totales.adultos;
                document.getElementById('total-obras').innerText = data.totalObras;

                // Preparar datos para el gráfico (ApexCharts espera series y xaxis)
                const seriesData = data.grafico.data;
                const categories = data.grafico.labels;

                if (chartConsultasVisitor) {
                    // Actualizar gráfico existente
                    chartConsultasVisitor.updateOptions({
                        xaxis: { categories: categories }
                    });
                    chartConsultasVisitor.updateSeries([{ name: 'Total Obras', data: seriesData }]);
                } else {
                    // Crear gráfico por primera vez
                    const options = {
                        chart: {
                            height: 300,
                            type: 'area',
                            toolbar: { show: false }
                        },
                        series: [{ name: 'Total Obras', data: seriesData }],
                        xaxis: { categories: categories },
                        colors: ['#2e6da4'],
                        stroke: { curve: 'smooth' },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                opacityFrom: 0.7,
                                opacityTo: 0.3
                            }
                        }
                    };
                    chartConsultasVisitor = new ApexCharts(document.querySelector("#chartConsultasVisitor"), options);
                    chartConsultasVisitor.render();
                }
            })
            .catch(error => console.error('Error al cargar datos:', error));
    }

    // Función para actualizar el modal con los datos del período actual
    function actualizarModal(periodo) {
        fetch('/Library_System/visitantes/datos-modal?periodo=' + periodo)
            .then(response => response.json())
            .then(data => {
                // Actualizar los elementos del modal (visitor-graph.php)
                document.getElementById('modal-total-periodo').innerText = data.totalPeriodo;
                document.getElementById('modal-dia-mas-concurrido').innerText = data.diaMasConcurrido;
                document.getElementById('modal-tendencia').innerHTML = '<i class="fa-solid fa-arrow-up"></i> ' + data.tendencia;

                // Llenar la tabla del modal
                const tbody = document.querySelector('#tabla-detalle-modal tbody');
                tbody.innerHTML = '';
                data.tabla.forEach(item => {
                    const row = `<tr>
                        <td>${item.dia}</td>
                        <td><strong>${item.total}</strong></td>
                        <td>${Math.round((item.total / data.totalAcumulado) * 100)}%</td>
                    </tr>`;
                    tbody.insertAdjacentHTML('beforeend', row);
                });
                document.getElementById('modal-total-acumulado').innerText = data.totalAcumulado + ' Obras';
            })
            .catch(error => console.error('Error al cargar modal:', error));
    }

    // Al cargar la página, inicializar gráfico con período 'mes'
    document.addEventListener('DOMContentLoaded', function() {
        cargarDatos(periodoActual);
        // También precargar datos del modal (opcional)
        actualizarModal(periodoActual);

        // Asignar eventos a los botones de período
        document.querySelectorAll('[data-periodo]').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const periodo = this.getAttribute('data-periodo');
                periodoActual = periodo;
                cargarDatos(periodo);
                actualizarModal(periodo);
            });
        });
    });