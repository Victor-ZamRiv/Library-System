// Variables de control global
let chartConsultas;
let chartModalConsultas;
let periodoActual = 'mes';

/**
 * Evalúa las reglas del negocio basadas en volumen físico de consultas diarias (Nuevos Rangos)
 */
function obtenerColorConsultas(rendimiento) {
    if (rendimiento < 10) {
        return '#d9534f'; // Crítico (Rojo) < 10
    } else if (rendimiento >= 10 && rendimiento <= 20) {
        return '#f0ad4e'; // Tolerable / En proceso (Amarillo) 10 - 20
    } else {
        return '#5cb85c'; // Óptimo / Logrado (Verde) > 20
    }
}

/**
 * Sincroniza cabeceras, cintillos y badges reactivos según el volumen de consultas
 */
function sincronizarLíneaVisualConsultas(rendimiento, textoRendimiento) {
    const colorDinamico = obtenerColorConsultas(rendimiento);
    
    // Extraer cadena limpia de texto según la escala actualizada
    let estadoTexto = 'CRÍTICO';
    if (rendimiento >= 10 && rendimiento <= 20) estadoTexto = 'TOLERABLE';
    if (rendimiento > 20) estadoTexto = 'ÓPTIMO';

    // 1. Sincronizar Badge del Dashboard principal
    const $badgePrincipal = $('#badgeConsultasEstado');
    if ($badgePrincipal.length > 0) {
        $badgePrincipal.css('background-color', colorDinamico).text(`${estadoTexto} (${textoRendimiento})`);
    }

    // 2. Sincronizar Cabecera de este Modal
    const $headerModal = $('#modalConsultasHeader');
    const $textoModal = $('#modalConsultasEstadoText');
    if ($headerModal.length > 0) {
        $headerModal.attr('style', `background-color: ${colorDinamico} !important; color: white; padding: 12px 20px; border-bottom: none; transition: background-color 0.3s ease;`);
    }
    if ($textoModal.length > 0) {
        $textoModal.text(`${estadoTexto} (${textoRendimiento})`);
    }

    // 3. Sincronizar Borde de la Tarjeta de Rendimiento
    const $cardRend = $('#cardRendimiento');
    if ($cardRend.length > 0) {
        $cardRend.css('border-left-color', colorDinamico);
    }

    // 4. Resetear estilos del Cintillo Estructurado
    $('#cintilloConsultasCritico').attr('style', 'flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #f9dbdb; font-size: 14px; opacity: 0.75;');
    $('#cintilloConsultasTolerable').attr('style', 'flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #fef0de; font-size: 14px; opacity: 0.75;');
    $('#cintilloConsultasOptimo').attr('style', 'flex: 1; padding: 12px; color: #222222; transition: all 0.3s ease; background-color: #e2f3e2; font-size: 14px; opacity: 0.75;');

    // Activar bloque correspondiente con relieve según el volumen analizado
    if (estadoTexto === 'CRÍTICO') {
        $('#cintilloConsultasCritico').attr('style', 'flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease; background-color: #d9534f; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);');
    } else if (estadoTexto === 'TOLERABLE') {
        $('#cintilloConsultasTolerable').attr('style', 'flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease; background-color: #f0ad4e; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);');
    } else if (estadoTexto === 'ÓPTIMO') {
        $('#cintilloConsultasOptimo').attr('style', 'flex: 1; padding: 12px; color: #222222; font-size: 16px; transition: all 0.3s ease; background-color: #5cb85c; font-weight: bold; transform: scale(1.02); box-shadow: inset 0 0 8px rgba(0,0,0,0.3);');
    }
}

/**
 * Petición Ajax unificada para actualizar la data e interfaz del módulo
 */
function actualizarTodo(periodo) {
    periodoActual = periodo;

    // Control visual de botones activos
    $('.btn-group .btn').removeClass('active');
    $(`#btnConsultasDash${periodo}`).addClass('active');

    const tablaCuerpo = document.getElementById('tablaReporteCuerpo');
    if (tablaCuerpo) {
        tablaCuerpo.innerHTML = '<tr><td colspan="2" class="text-center text-muted" style="padding: 20px;"><i class="fa-solid fa-spinner fa-spin"></i> Cargando flujo temporal...</td></tr>';
    }

    fetch(`/Library_System/dashboard/consultas?periodo=${periodo}`)
        .then(response => response.json())
        .then(data => {
            
            // Extraer el valor numérico absoluto enviado por el backend (ej: "21" o "40")
            let rawCrecimiento = data.crecimiento || '0';
            let rendimientoNum = parseInt(rawCrecimiento.replace(/[^0-9]/g, '')) || 0;
            let colorGrafico = obtenerColorConsultas(rendimientoNum);

            // Guardar variables globales para la sincronización reactiva en el evento del Modal
            window.pctConsultasActual = rendimientoNum;
            window.textoConsultasActual = rawCrecimiento;

            // Sincronizar todos los componentes visuales
            sincronizarLíneaVisualConsultas(rendimientoNum, rawCrecimiento);

            // 1. Actualizar o renderizar el gráfico del Dashboard principal
            if (chartConsultas) {
                chartConsultas.updateOptions({
                    xaxis: { categories: data.categorias },
                    series: [{ name: 'Consultas', data: data.series }],
                    colors: [colorGrafico]
                });
            } else {
                const optionsDashboard = {
                    chart: { height: 230, type: 'area', toolbar: { show: false } },
                    series: [{ name: 'Consultas', data: data.series }],
                    xaxis: { categories: data.categorias },
                    colors: [colorGrafico],
                    stroke: { width: 3, curve: 'smooth' },
                    fill: { type: 'gradient', gradient: { opacityFrom: 0.6, opacityTo: 0.1 } }
                };
                chartConsultas = new ApexCharts(document.querySelector("#chartConsultas"), optionsDashboard);
                chartConsultas.render();
            }

            // 2. Actualizar u optimizar la cola de renderizado del gráfico del Modal
            if (chartModalConsultas) {
                chartModalConsultas.updateOptions({
                    xaxis: { categories: data.categorias },
                    series: [{ name: 'Consultas', data: data.series }],
                    colors: [colorGrafico]
                });
            } else {
                window.datosConsultasModal = { series: data.series, categories: data.categorias, color: colorGrafico };
            }

            // 3. Modificar valores de los cuadros de resumen
            if (document.getElementById('reporteTotal')) {
                document.getElementById('reporteTotal').innerText = data.total;
                document.getElementById('reportePico').innerText = data.pico;
                
                // Actualizar clases dinámicas Bootstrap usando los nuevos rangos reales
                const textClass = (rendimientoNum < 10) ? 'text-danger' : ((rendimientoNum <= 20) ? 'text-warning' : 'text-success');
                $('#reporteCrecimiento').removeClass('text-success text-warning text-danger').addClass(textClass).html(rawCrecimiento);
            }

            // 4. Reconstrucción dinámica de la tabla de desglose temporal
            if (data.tablaDatos && tablaCuerpo) {
                let html = '';
                data.tablaDatos.forEach(item => {
                    html += `<tr>
                                <td><strong>${item.periodo}</strong></td>
                                <td class="text-center"><span class="badge" style="background-color: #777; font-weight: 500;">${item.consultas} consultas</span></td>
                             </tr>`;
                });
                tablaCuerpo.innerHTML = html;
            }
        })
        .catch(error => {
            console.error('Error al actualizar consultas:', error);
            if (tablaCuerpo) {
                tablaCuerpo.innerHTML = '<tr><td colspan="2" class="text-center text-danger">Error de comunicación con el servidor local.</td></tr>';
            }
        });
}

// Inicialización asíncrona por defecto al cargar el árbol DOM
document.addEventListener('DOMContentLoaded', function() {
    actualizarTodo('mes');
});

// Eventos de escucha jQuery para la inicialización controlada del gráfico interno del Modal
$(document).ready(function() {
    $('#modalDetalleConsultasGrafico').on('shown.bs.modal', function() {
        if (window.pctConsultasActual !== undefined) {
            sincronizarLíneaVisualConsultas(window.pctConsultasActual, window.textoConsultasActual);
        }

        if (!chartModalConsultas && window.datosConsultasModal) {
            const optionsModal = {
                chart: { height: 240, type: 'area', toolbar: { show: false } },
                series: [{ name: 'Consultas', data: window.datosConsultasModal.series }],
                xaxis: { categories: window.datosConsultasModal.categorias },
                colors: [window.datosConsultasModal.color],
                stroke: { width: 3, curve: 'smooth' },
                fill: { type: 'gradient', gradient: { opacityFrom: 0.5, opacityTo: 0.05 } }
            };
            chartModalConsultas = new ApexCharts(document.querySelector("#chartModalConsultas"), optionsModal);
            chartModalConsultas.render();
        } else if (chartConsultas && chartModalConsultas) {
            chartModalConsultas.updateOptions({
                xaxis: { categories: chartConsultas.w.config.xaxis.categories },
                series: [{ name: 'Consultas', data: chartConsultas.w.config.series[0].data }],
                colors: [chartConsultas.w.config.colors[0]]
            });
        }
    });
});