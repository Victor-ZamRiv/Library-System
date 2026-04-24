   // 1. Declaramos la variable de la gráfica globalmente
        var chartConsultasVisitor;

        document.addEventListener("DOMContentLoaded", function() {
            var optionsConsultas = {
                chart: {
                    height: 300,
                    type: 'area',
                    toolbar: {
                        show: false
                    }
                },
                series: [{
                    name: 'Total Obras',
                    data: [40, 45, 38, 50, 42, 30]
                }],
                xaxis: {
                    categories: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab']
                },
                colors: ['#2e6da4'],
                stroke: {
                    curve: 'smooth'
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        opacityFrom: 0.7,
                        opacityTo: 0.3
                    }
                }
            };

            // Inicializamos usando el nuevo nombre de variable y el nuevo selector ID
            chartConsultasVisitor = new ApexCharts(document.querySelector("#chartConsultasVisitor"), optionsConsultas);
            chartConsultasVisitor.render();
        });

        // 2. Función para actualizar los datos
        function actualizarConsultas(filtro) {
            let nuevosDatos = [];
            let nuevasCategorias = [];

            if (filtro === 'semana') {
                nuevosDatos = [40, 45, 38, 50, 42, 30];
                nuevasCategorias = ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
            } else if (filtro === 'mes') {
                nuevosDatos = [150, 210, 180, 250];
                nuevasCategorias = ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'];
            } else if (filtro === 'trimestre') {
                nuevosDatos = [600, 850, 720];
                nuevasCategorias = ['Enero', 'Febrero', 'Marzo'];
            }

            chartConsultasVisitor.updateOptions({
                xaxis: {
                    categories: nuevasCategorias
                }
            });

            chartConsultasVisitor.updateSeries([{
                name: 'Total Obras',
                data: nuevosDatos
            }]);
        }