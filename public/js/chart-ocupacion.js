// =========================================================================
// SGB - MÓDULO DE OCUPACIÓN Y AFORO DE ESPACIOS
// =========================================================================

let chartOcupacion;
let chartModalOcupacion;

/**
 * Función pura que dictamina el color del semáforo según las reglas del aforo
 */
function obtenerColorSemaforo(valor) {
    if (valor <= 30) {
        return '#d9534f'; // Crítico / Bajo (Rojo)
    } else if (valor > 30 && valor < 70) {
        return '#f0ad4e'; // Tolerable / Normal (Naranja)
    } else if (valor >= 70 && valor <= 100) {
        return '#5cb85c'; // Óptimo / Alta (Verde)
    } else {
        return '#d9534f'; // Saturado > 100 (Rojo)
    }
}

/**
 * Configuración unificada de colores para Barras y Leyendas de ApexCharts
 */
const configColoresBarras = {
    colors: [
        function({ value, seriesIndex, dataPointIndex }) {
            // Si ApexCharts evalúa la leyenda o la barra pasará por aquí
            return obtenerColorSemaforo(value);
        }
    ]
};

/**
 * Sincroniza dinámicamente Badge del Dashboard, Cabecera del Modal y Bloques del Cintillo
 */
function sincronizarComponentesOcupacion(porcentaje) {
    let colorHex = '#d9534f'; 
    let estadoTexto = 'CRÍTICO';

    if (porcentaje <= 30) {
        colorHex = '#d9534f';
        estadoTexto = 'CRÍTICO';
    } else if (porcentaje < 70) {
        colorHex = '#f0ad4e';
        estadoTexto = 'TOLERABLE';
    } else {
        colorHex = '#5cb85c';
        estadoTexto = 'ÓPTIMO';
    }

    // 1. Actualizar Badge en Dashboard Principal
    const $badge = $('#badgeOcupacionEstado');
    if ($badge.length > 0) {
        $badge.css('background-color', colorHex);
        $badge.text(`ESTADO: ${estadoTexto} (${porcentaje}%)`);
    }

    // 2. Actualizar Cabecera de Modal (Cambio fluido de color como Cumplimiento)
    const $modalHeader = $('#modalOcupacionHeader');
    const $modalText = $('#modalOcupacionEstadoText');

    if ($modalHeader.length > 0) {
        $modalHeader.attr('style', `background: ${colorHex} !important; color: white; padding: 12px 20px; border-bottom: none; transition: background-color 0.3s ease;`);
    }
    if ($modalText.length > 0) {
        $modalText.text(`${estadoTexto} (${porcentaje}%)`);
    }

    // 3. Control de los bloques del cintillo
    $('#cintilloOcupacionCritico').attr('style', 'flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #f9dbdb; font-size: 14px; opacity: 0.75;');
    $('#cintilloOcupacionTolerable').attr('style', 'flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #fef0de; font-size: 14px; opacity: 0.75;');
    $('#cintilloOcupacionOptimo').attr('style', 'flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #e2f3e2; font-size: 14px; opacity: 0.75;');

    if (estadoTexto === 'CRÍTICO') {
        $('#cintilloOcupacionCritico').attr('style', 'flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease; background-color: #d9534f; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);');
    } else if (estadoTexto === 'TOLERABLE') {
        $('#cintilloOcupacionTolerable').attr('style', 'flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease; background-color: #f0ad4e; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);');
    } else if (estadoTexto === 'ÓPTIMO') {
        $('#cintilloOcupacionOptimo').attr('style', 'flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease; background-color: #5cb85c; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);');
    }
}

function actualizarOcupacion(periodo) {
    const tablaCuerpo = document.getElementById('tablaOcupacionCuerpo');
    if (tablaCuerpo) {
        tablaCuerpo.innerHTML = '<tr><td colspan="5" class="text-center text-muted" style="padding: 20px;"><i class="fa-solid fa-spinner fa-spin"></i> Cargando...</td></tr>';
    }

    fetch(`/Library_System/dashboard/ocupacion?periodo=${periodo}`)
        .then(response => response.json())
        .then(data => {
            
            let promedioGlobal = data.promedioGlobal;
            if (promedioGlobal === undefined && data.tablaDatos && data.tablaDatos.length > 0) {
                let suma = data.tablaDatos.reduce((acc, item) => acc + item.porcentaje, 0);
                promedioGlobal = Math.round(suma / data.tablaDatos.length);
            }

            if (document.getElementById('totalAsistenciasPeriodo') && data.totalAsistencias) {
                document.getElementById('totalAsistenciasPeriodo').innerText = data.totalAsistencias;
            }
            
            if (document.getElementById('promedioOcupacionGlobal') && promedioGlobal !== undefined) {
                let colorKpi = (promedioGlobal <= 30) ? '#d9534f' : ((promedioGlobal < 70) ? '#f0ad4e' : '#5cb85c');
                $('#promedioOcupacionGlobal').css('color', colorKpi).text(promedioGlobal + '%');
                
                window.porcentajeOcupacionActual = promedioGlobal;
                sincronizarComponentesOcupacion(promedioGlobal);
            }

            // Sincronizar colores individuales para los marcadores de la leyenda inferior
            const listaColoresCalculados = data.series.map(val => obtenerColorSemaforo(val));

            // Options para el Dashboard Principal
            const options = {
                chart: { type: 'bar', height: 250, toolbar: { show: false } },
                plotOptions: { bar: { horizontal: true, distributed: true, borderRadius: 4 } },
                colors: configColoresBarras.colors,
                series: [{ name: 'Ocupación %', data: data.series }],
                xaxis: { categories: data.categorias },
                legend: {
                    markers: {
                        fillColors: listaColoresCalculados // Fuerza el color exacto en los recuadros de la leyenda
                    }
                }
            };

            if (chartOcupacion) {
                chartOcupacion.updateSeries([{ name: 'Ocupación %', data: data.series }]);
                chartOcupacion.updateOptions({ 
                    xaxis: { categories: data.categorias },
                    legend: { markers: { fillColors: listaColoresCalculados } }
                });
            } else {
                chartOcupacion = new ApexCharts(document.querySelector("#chartOcupacion"), options);
                chartOcupacion.render();
            }

            // Guardar o Actualizar el Modal
            if (chartModalOcupacion) {
                chartModalOcupacion.updateSeries([{ name: 'Ocupación %', data: data.series }]);
                chartModalOcupacion.updateOptions({ 
                    xaxis: { categories: data.categorias },
                    legend: { markers: { fillColors: listaColoresCalculados } }
                });
            } else {
                window.datosOcupacionModal = { series: data.series, categories: data.categorias, colores: listaColoresCalculados };
            }

            // Construir Tabla Desglose
            if (data.tablaDatos && tablaCuerpo) {
                let html = '';
                data.tablaDatos.forEach(item => {
                    let estado = '';
                    let estadoClase = '';
                    let pct = item.porcentaje;

                    if (pct <= 30) { estado = 'Bajo'; estadoClase = 'danger'; }
                    else if (pct > 30 && pct < 70) { estado = 'Normal'; estadoClase = 'warning'; }
                    else if (pct >= 70 && pct <= 100) { estado = 'Alta'; estadoClase = 'success'; }
                    else if (pct > 100) { estado = 'Saturado'; estadoClase = 'danger'; }

                    html += `<tr>
                                <td><strong>${item.sala}</strong></td>
                                <td>${item.capacidad}</td>
                                <td>${item.asistentes}</td>
                                <td>${pct}%</td>
                                <td><span class="label label-${estadoClase}">${estado}</span></td>
                            </tr>`;
                });
                tablaCuerpo.innerHTML = html;
            }
        })
        .catch(error => {
            console.error('Error al actualizar ocupación:', error);
            if (tablaCuerpo) {
                tablaCuerpo.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Error al cargar datos.</td></tr>';
            }
        });
}

document.addEventListener('DOMContentLoaded', function() {
    actualizarOcupacion('mes');
});

$(document).ready(function() {
    $('#modalDetalleOcupacion').on('shown.bs.modal', function() {
        if (window.porcentajeOcupacionActual !== undefined) {
            sincronizarComponentesOcupacion(window.porcentajeOcupacionActual);
        }

        if (!chartModalOcupacion && window.datosOcupacionModal) {
            const optionsModal = {
                chart: { type: 'bar', height: 250, toolbar: { show: false } },
                plotOptions: { bar: { horizontal: true, distributed: true, borderRadius: 4 } },
                colors: configColoresBarras.colors,
                series: [{ name: 'Ocupación %', data: window.datosOcupacionModal.series }],
                xaxis: { categories: window.datosOcupacionModal.categories },
                legend: {
                    markers: { fillColors: window.datosOcupacionModal.colores }
                }
            };
            chartModalOcupacion = new ApexCharts(document.querySelector("#chartModalOcupacion"), optionsModal);
            chartModalOcupacion.render();
        } else if (chartOcupacion) {
            chartModalOcupacion.updateSeries([{ name: 'Ocupación %', data: chartOcupacion.w.config.series[0].data }]);
            chartModalOcupacion.updateOptions({ 
                xaxis: { categories: chartOcupacion.w.config.xaxis.categories },
                legend: { markers: { fillColors: chartOcupacion.w.config.legend.markers.fillColors } }
            });
        }
    });
});