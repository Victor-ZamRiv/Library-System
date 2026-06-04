// =========================================================================
// SGB - MÓDULO DE INDICADOR DE CUMPLIMIENTO (ÚNICA FUENTE DE VERDAD)
// =========================================================================

// Variables globales para mantener las instancias de las gráficas
let chartPlazos;
let chartModalPlazos;

/**
 * Función Maestra: Realiza la petición asíncrona al backend, actualiza
 * las gráficas dinámicamente y sincroniza el Badge de Estado con los datos puros.
 * @param {string} periodo - Rango de tiempo ('semana', 'mes', 'trimestre')
 */
function actualizarCumplimiento(periodo) {
    // 1. Efecto visual de carga en el desglose del modal
    const tablaCuerpo = document.getElementById('tbodyDetalleCumplimiento');
    if (tablaCuerpo) {
        tablaCuerpo.innerHTML = '<tr><td colspan="5" class="text-center text-muted"><i class="fa-solid fa-spinner fa-spin"></i> Cargando datos detallados...</td></tr>';
    }

    // 2. Consumo del endpoint de tu arquitectura MVC local en XAMPP
    fetch(`/Library_System/dashboard/cumplimiento?periodo=${periodo}`)
        .then(response => response.json())
        .then(data => {
            console.log('Datos recibidos para cumplimiento:', data);
            
            // Validación de seguridad de los datos del backend
            if (!data || !data.series || data.series.length === 0) {
                console.error('La estructura de las series no es válida o está vacía.');
                return;
            }

            // 3. Inicializar o Actualizar la gráfica del Dashboard principal
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
                                            // Extrae de forma limpia el entero del total de la primera serie
                                            return Math.round(w.globals.seriesTotals[0]) + "%";
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

            // 4. Actualizar la gráfica réplica dentro del Modal si se encuentra instanciada
            if (chartModalPlazos) {
                chartModalPlazos.updateSeries(data.series);
            } else {
                // Persistencia en memoria por si el usuario abre el modal más tarde
                window.datosCumplimientoModal = data;
            }

            // =================================================================
            // NUEVA INTEGRACIÓN: ACTUALIZACIÓN DE INDICADORES NUMÉRICOS SUPERIORES
            // =================================================================
            if (document.getElementById('totalPrestamos')) {
                document.getElementById('totalPrestamos').innerText = data.total_prestamos;
                document.getElementById('prestamosDevueltos').innerText = data.devueltos;
                document.getElementById('prestamosVencidos').innerText = data.vencidos;
                document.getElementById('totalRenovaciones').innerText = data.renovaciones;
            }
            // =================================================================

            // =================================================================
            // INTEGRACIÓN DE TU LOGICA: CAPTURA E INYECCIÓN DEL VALOR "A TIEMPO"
            // =================================================================
            // data.series[0] almacena de forma inalterable el área de préstamos a tiempo
            const porcentajeATiempo = Math.round(parseFloat(data.series[0])) || 0;
            sincronizarBadgeCumplimiento(porcentajeATiempo);
            // =================================================================

            // 5. Construcción dinámica de la tabla informativa del Modal
            if (tablaCuerpo) {
                let htmlFilas = '';
                
                if (data.detalles && data.detalles.length > 0) {
                    data.detalles.forEach(item => {
                        htmlFilas += `
                            <tr>
                                <td>${item.categoria}</td>
                                <td class="text-center font-weight-bold">${item.totales}</td>
                                <td class="text-center text-success">${item.a_tiempo}</td>
                                <td class="text-center text-warning">${item.fuera_plazo}</td>
                                <td class="text-center text-danger">${item.criticos || 0}</td>
                            </tr>`;
                    });
                } else {
                    // Fallback matemático predictivo si el desglose detallado viene vacío
                    const totalCalculado = data.total_prestamos || 0;
                    const aTiempoCalculado = Math.round((porcentajeATiempo * totalCalculado) / 100);
                    const fueraPlazoCalculado = totalCalculado - aTiempoCalculado;

                    htmlFilas = `
                        <tr>
                            <td>Préstamos del Periodo (${periodo})</td>
                            <td class="text-center font-weight-bold">${totalCalculado}</td>
                            <td class="text-center text-success">${aTiempoCalculado}</td>
                            <td class="text-center text-warning">${fueraPlazoCalculado}</td>
                            <td class="text-center text-danger">0</td>
                        </tr>`;
                }

                tablaCuerpo.innerHTML = htmlFilas;
            }
        })
        .catch(error => {
            console.error('Error crítico en el flujo fetch de cumplimiento:', error);
            if (tablaCuerpo) {
                tablaCuerpo.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Error de comunicación con el servidor.</td></tr>';
            }
            // Estado visual de error en la interfaz
            const $badge = $('#badgeEstadoCumplimiento');
            if ($badge.length > 0) {
                $badge.css('background-color', '#777777').text('Estado: Error de Red');
            }
        });
}

/**
 * Procesa el semáforo de alertas según el porcentaje y modifica los atributos del DOM
 * @param {number} porcentaje - Valor puro extraído de data.series[0]
 */
function sincronizarBadgeCumplimiento(porcentaje) {
    let colorHex = '#d9534f'; 
    let estadoTexto = 'CRÍTICO';

    // 1. Determinar el estado bajo las reglas de negocio oficiales del SGB
    if (porcentaje <= 70) {
        colorHex = '#d9534f';
        estadoTexto = 'CRÍTICO';
    } else if (porcentaje < 90) {
        colorHex = '#f0ad4e';
        estadoTexto = 'TOLERABLE';
    } else {
        colorHex = '#5cb85c';
        estadoTexto = 'ÓPTIMO';
    }

    // 2. Sincronizar Badge de la interfaz de Dashboard Principal
    const $badge = $('#badgeEstadoCumplimiento');
    if ($badge.length > 0) {
        $badge.css('background-color', colorHex);
        $badge.text(`Estado: ${estadoTexto} (${porcentaje}%)`);
    }

    // 3. Sincronizar Cabecera del Modal
    const $modalHeader = $('#modalCumplimientoHeader');
    const $modalText = $('#modalCumplimientoEstadoText');

    if ($modalHeader.length > 0) {
        $modalHeader.attr('style', `background-color: ${colorHex} !important; color: white; padding: 12px 15px; border-top-left-radius: 5px; border-top-right-radius: 5px; transition: background-color 0.3s ease;`);
    }
    if ($modalText.length > 0) {
        $modalText.text(`${estadoTexto} (${porcentaje}%)`);
    }

    // 4. CONTROL REACTIVO DEL CINTILLO FLEXBOX (TU EXCELENTE DISEÑO)
    // Primero, reseteamos los 3 bloques a su estado base/apagado de forma limpia
    $('#cintilloCritico').attr('style', 'flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #f9dbdb; font-size: 14px; opacity: 0.75;');
    $('#cintilloTolerable').attr('style', 'flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #fef0de; font-size: 14px; opacity: 0.75;');
    $('#cintilloOptimo').attr('style', 'flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #e2f3e2; font-size: 14px; opacity: 0.75;');

    // Segundo, encendemos y escalamos quirúrgicamente el bloque correspondiente al estado activo
    if (estadoTexto === 'CRÍTICO') {
        $('#cintilloCritico').attr('style', 'flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease; background-color: #d9534f; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);');
    } else if (estadoTexto === 'TOLERABLE') {
        $('#cintilloTolerable').attr('style', 'flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease; background-color: #f0ad4e; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);');
    } else if (estadoTexto === 'ÓPTIMO') {
        $('#cintilloOptimo').attr('style', 'flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease; background-color: #5cb85c; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);');
    }
}

// 6. Disparador de carga inicial por defecto del SGB (Fijado en 'mes')
document.addEventListener('DOMContentLoaded', function() {
    actualizarCumplimiento('mes');
});

// 7. Sincronizador del ciclo de vida del modal de Bootstrap
$(document).ready(function() {
    $('#modalDetalleCumplimiento').on('shown.bs.modal', function() {
        if (!chartModalPlazos) {
            const seriesIniciales = chartPlazos ? chartPlazos.w.config.series : [0, 0];
            
            const optionsModal = {
                chart: { height: 220, type: 'donut' },
                series: seriesIniciales,
                labels: ['A tiempo', 'Fuera de plazo'],
                colors: ['#5cb85c', '#d9534f'],
                legend: { position: 'bottom' }
            };
            chartModalPlazos = new ApexCharts(document.querySelector("#chartModalPlazos"), optionsModal);
            chartModalPlazos.render();
        } else if (chartPlazos) {
            chartModalPlazos.updateSeries(chartPlazos.w.config.series);
        }
    });
});