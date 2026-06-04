/**
 * Generador de Reportes Institucionales
 * Biblioteca Pública Central "Armando Zuloaga Blanco"
 */

// 1. Inyección de estilos para el cargador
(function injectLoaderStyles() {
    if (!document.getElementById('pdf-loader-styles')) {
        const style = document.createElement('style');
        style.id = 'pdf-loader-styles';
        style.innerHTML = `
            .pdf-loader-overlay {
                position: fixed;
                top: 0; left: 0;
                width: 100%; height: 100%;
                background: rgba(23, 31, 55, 0.7);
                display: flex; flex-direction: column;
                justify-content: center; align-items: center;
                z-index: 10000; 
                font-family: sans-serif;
            }
            .pdf-spinner {
                width: 60px; height: 60px;
                border: 6px solid #f3f3f3;
                border-top: 6px solid #616162; 
                border-radius: 50%;
                animation: pdf-spin 1s linear infinite;
                margin-bottom: 20px;
            }
            @keyframes pdf-spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .pdf-loader-text { 
                font-size: 18px; 
                font-weight: bold; 
                color: #ffffff; 
                letter-spacing: 1px; 
            }
            .pdf-loader-subtext {
                font-size: 12px;
                color: #ffffff;
                margin-top: 10px;
            }
        `;
        document.head.appendChild(style);
    }
})();

// --- FUNCIONES DE RENDIMIENTO Y CACHÉ ---
const imgCache = {};

async function capturarElemento(seccion) {
    if (!seccion.chartId) return null;
    const el = document.querySelector(seccion.chartId);
    if (!el) return null;

    const canvas = el.querySelector('canvas');
    if (canvas) {
        return { id: seccion.chartId, img: canvas.toDataURL('image/png', 1.0) };
    }

    const canvasH2C = await html2canvas(el, { scale: 1, backgroundColor: "#ffffff", useCORS: true, logging: false });
    return { id: seccion.chartId, img: canvasH2C.toDataURL('image/png') };
}

async function getCachedImage(url) {
    if (imgCache[url]) return imgCache[url];
    return new Promise((resolve) => {
        const img = new Image();
        img.setAttribute('crossOrigin', 'anonymous');
        img.onload = () => { imgCache[url] = img; resolve(img); };
        img.onerror = () => resolve(null);
        img.src = url;
    });
}

function obtenerRangoFechas() {
    let desde = document.querySelector('#filtro-desde')?.value || document.querySelector('input[name="desde"]')?.value;
    let hasta = document.querySelector('#filtro-hasta')?.value || document.querySelector('input[name="hasta"]')?.value;
    if (desde && hasta) {
        return { desde, hasta };
    }
    let periodoTexto = document.querySelector('.btn-group .btn.active')?.innerText || 'Mes';
    let hoy = new Date();
    let desdeDate = new Date();
    if (periodoTexto === 'Semana') desdeDate.setDate(hoy.getDate() - 7);
    else if (periodoTexto === 'Mes') desdeDate.setMonth(hoy.getMonth() - 1);
    else if (periodoTexto === 'Trimestre') desdeDate.setMonth(hoy.getMonth() - 3);
    return {
        desde: desdeDate.toISOString().split('T')[0],
        hasta: hoy.toISOString().split('T')[0]
    };
}

async function descargarPDF(tipo) {
    const loader = document.createElement('div');
    loader.id = 'pdf-loader-container';
    loader.innerHTML = `
        <div class="pdf-loader-overlay">
            <div class="pdf-spinner"></div>
            <div class="pdf-loader-text">GENERANDO REPORTE...</div>
            <p class="pdf-loader-subtext">Compilando todas las secciones operacionales del sistema</p>
        </div>
    `;
    if (tipo === 'macro') {
        loader.querySelector('.pdf-loader-text').innerText = 'GENERANDO REPORTE MACRO...';
        loader.querySelector('.pdf-loader-subtext').innerText = 'Analizando dimensiones de componentes y empaquetando tablas';
    } else {
        loader.querySelector('.pdf-loader-subtext').innerText = 'Preparando formato oficial e imágenes';
    }
    document.body.appendChild(loader);

    try {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'mm', 'a4');
        const centerX = 105;
        const pageHeight = doc.internal.pageSize.height;
        const pageUsableHeight = pageHeight - 25; // Margen inferior de seguridad
        
        const baseUrl = window.BASE_URL || ''; 
        
        const logoIzquierdoUrl = `${baseUrl}/img/img-login/gober.png`; 
        const logoDerechoUrl = `${baseUrl}/img/img-login/libro.png`; 
        const logoInferiorIzqUrl = `${baseUrl}/img/img-login/sucre.png`; 
        const logoInferiorDerUrl = `${baseUrl}/img/img-login/division.png`; 

        const cargarImagen = (url) => {
            return new Promise((resolve) => {
                const img = new Image();
                img.setAttribute('crossOrigin', 'anonymous');
                img.onload = () => resolve(img);
                img.onerror = () => {
                    console.warn("No se pudo cargar la imagen en:", url);
                    resolve(null);
                };
                img.src = url;
            });
        };

        const [imgIzq, imgDer, imgInfIzq, imgInfDer] = await Promise.all([
            cargarImagen(logoIzquierdoUrl),
            cargarImagen(logoDerechoUrl),
            cargarImagen(logoInferiorIzqUrl),
            cargarImagen(logoInferiorDerUrl)
        ]);

        const bosquejoCabeceraInstitucional = (pdfDoc) => {
            pdfDoc.setFillColor(255, 255, 255);
            pdfDoc.rect(0, 0, 210, 35, 'F');

            if (imgIzq) pdfDoc.addImage(imgIzq, 'PNG', 12, 5, 22, 22);
            if (imgDer) pdfDoc.addImage(imgDer, 'PNG', 176, 5, 22, 22);

            pdfDoc.setTextColor(0, 0, 0);
            pdfDoc.setFont("helvetica", "normal");
            pdfDoc.setFontSize(8);
            
            pdfDoc.text("República Bolivariana de Venezuela", centerX, 8, { align: "center" });
            pdfDoc.text("Gobernación del Estado Sucre", centerX, 12, { align: "center" });
            pdfDoc.text("Instituto Autónomo de Cultura del Estado Sucre", centerX, 16, { align: "center" });
            pdfDoc.text("División de Bibliotecas Públicas del Estado Sucre", centerX, 20, { align: "center" });
            
            pdfDoc.setFont("helvetica", "bold");
            pdfDoc.setFontSize(10);
            pdfDoc.text('Biblioteca Pública Central "Armando Zuloaga Blanco"', centerX, 26, { align: "center" });

            pdfDoc.setDrawColor(0, 0, 0);
            pdfDoc.setLineWidth(0.4);
            pdfDoc.line(12, 32, 198, 32);
            pdfDoc.setLineWidth(0.1);
            pdfDoc.line(12, 33.5, 198, 33.5);
        };

        // El cintillo principal se dibuja estrictamente al inicio de la primera página
        bosquejoCabeceraInstitucional(doc);

        const configs = {
            'dashboard': { titulo: "REPORTE GENERAL DE INDICADORES", headers: [['Indicador Operacional', 'Valor Medido', 'Estado Evaluado']], hasChart: false, customResumen: true },
            'macro': { titulo: "REPORTE GENERAL MACRO (DATOS Y GRÁFICOS)", hasChart: false },
            'Cobertura': { titulo: "ANÁLISIS DE COBERTURA DE USUARIOS", tablaBodyId: "tablaCoberturaCuerpo", headers: [['Segmento', 'Total Registrados', 'Nuevos (Mes)', 'Tendencia']], hasChart: false },
            'Referencia': { titulo: "DETALLE: CONSULTAS DE REFERENCIA", tablaBodyId: "tablaReferenciaCuerpo", headers: [['Área del Conocimiento', 'Consultas', 'Eficiencia de Respuesta']], hasChart: false },
            'Consultas': { titulo: "ESTADÍSTICA HISTÓRICA DE CONSULTAS", chartId: "#chartModalConsultas", tablaBodyId: "tablaReporteCuerpo", headers: [['Periodo / Turno', 'Consultas', 'Estado']], hasChart: true },
            'Cumplimiento': { titulo: "INFORME DE CUMPLIMIENTO Y PLAZOS", chartId: "#chartModalPlazos", tablaBodyId: "tbodyDetalleCumplimiento", headers: [['Categoría', 'Total Préstamos', 'A Tiempo', 'Mora Leve', 'Mora Grave']], hasChart: true },            
            'Ocupacion': { titulo: "CAPACIDAD Y USO DE ESPACIOS", chartId: "#chartModalOcupacion", tablaBodyId: "tablaOcupacionCuerpo", headers: [['Sala', 'Capacidad Máxima', 'Ocupación Pico', 'Promedio', 'Estado']], hasChart: true },
            'Rotacion': { titulo: "INFORME DETALLADO: ÍNDICE DE ROTACIÓN", chartId: "#chartModalRotacion", tablaBodyId: "tablaRotacionCuerpo", headers: [['Categoría', 'Inventario', 'Préstamos', 'Rotación']], hasChart: true },
            'Salud': { titulo: "INFORME: SALUD FÍSICA DE LA COLECCIÓN", tablaBodyId: "tablaSaludCuerpo", headers: [['Sala', 'Total Libros', 'Buen Estado', 'En Reparación', 'Salud Física']], hasChart: false },
            'AsistenciaEstatal': { titulo: "REPORTE DE ASISTENCIA: SALA ESTATAL", tablaBodyId: "tablaAsistenciaEstatalCuerpo", headers: [['Tipo de Usuario', 'Nro. de Visitas', 'Tendencia']], hasChart: false },
            'Coleccion': { titulo: "ESTADO DE ACTUALIZACIÓN DE LA COLECCIÓN", tablaBodyId: "tablaColeccionCuerpo", headers: [['Sala', 'Títulos Totales', 'Novedades (2024-25)', 'Estado', 'Acción Requerida']], hasChart: false },
            'Lectores': { titulo: "REPORTE GENERAL DE LECTORES REGISTRADOS", tablaBodyId: "tabla-lectores-cuerpo", headers: [['N° CARNET', 'CÉDULA', 'NOMBRE COMPLETO', 'TELÉFONO', 'PROFESIÓN']], hasChart: false },
            'LectoresInhabilitados': { titulo: "REPORTE DE LECTORES CON SERVICIO SUSPENDIDO", tablaBodyId: "tablaLectoresInhabilitados", headers: [['N° CARNET', 'CÉDULA', 'NOMBRE COMPLETO', 'TELÉFONO', 'PROFESIÓN']], hasChart: false },
            'DetalleVisita': { titulo: "REGISTRO DE VISITA Y CONSULTAS", hasChart: true, chartId: "#chartConsultasVisitor", customCapture: true },
            'TablaVisitas': { titulo: "REPORTE INSTITUCIONAL: LISTADO DE VISITAS", tablaBodyId: "tabla-registros-visitas",headers: [['FECHA', 'TURNO', 'DISTRIBUCIÓN (N/A/A)', 'SALA', 'TOTAL']], hasChart: false},
            'TablaActividades': { titulo: "REPORTE INSTITUCIONAL: PLANIFICACIÓN DE ACTIVIDADES", tablaBodyId: "tabla-actividades", headers: [['FECHA', 'CATEGORÍA', 'ESTADO ACTUAL', 'DESCRIPCIÓN DE LA ACTIVIDAD']], hasChart: false },
            'TablaLogros': { titulo: "REPORTE INSTITUCIONAL: HISTÓRICO DE LOGROS", tablaBodyId: "tabla-modal-logros",headers: [['FECHA', 'PERSONAL INVOLUCRADO', 'DESCRIPCIÓN E IMPACTO DEL LOGRO']], hasChart: false },
            'TablaPrestamos': { titulo: "REPORTE INSTITUCIONAL: LISTADO GENERAL DE PRÉSTAMOS", tablaBodyId: "tabla-prestamos", headers: [['CARNET LECTOR', 'RESPONSABLE (ADMIN)', 'COTA / EJEMPLAR', 'F. EMISIÓN', 'F. DEVOLUCIÓN', 'ESTADO ACTUAL']], hasChart: false },
            'TablaMultas': { titulo: "REPORTE GENERAL DE MULTAS ASOCIADAS A PRÉSTAMOS", tablaBodyId: "tabla-multas-cuerpo", headers: [['N° PRÉSTAMO', 'MONTO DE MULTA', 'ESTADO ACTUAL', 'FECHA DE CANCELACIÓN']], hasChart: false},
            'Historial': { titulo: "REPORTE INSTITUCIONAL: HISTORIAL DE ACTIVIDAD Y LOGS", tablaBodyId: "tablaHistorialCuerpo", headers: [['USUARIO', 'MÓDULO', 'FECHA / HORA', 'ACCIÓN', 'DESCRIPCIÓN']], hasChart: false },
            'Usuarios': { titulo: "REPORTE INSTITUCIONAL: PERSONAL Y ADMINISTRADORES DEL SISTEMA", tablaBodyId: "tablaUsuariosCuerpo", headers: [['USUARIO', 'CÉDULA', 'NOMBRES', 'APELLIDOS', 'TELÉFONO']], hasChart: false },
            'UsuariosInhabilitados': { titulo: "REPORTE INSTITUCIONAL: USUARIOS DEL SISTEMA SUSPENDIDOS", tablaBodyId: "tablaUsuariosInhabilitados", headers: [['USUARIO', 'CÉDULA', 'NOMBRES', 'APELLIDOS', 'TELÉFONO']], hasChart: false},
            'Idcar': { titulo: "INFORME: ÍNDICE DE DETERIORO (IDCAR)", tablaBodyId: "tablaIdcarCuerpo", headers: [['Cota', 'Título del Libro', 'Total de Ejemplares', 'Ejemplares Dañados']], hasChart: false },
            'Iiur': { titulo: "INFORME: INTENSIDAD DE USO DE RECURSOS (IIUR)", tablaBodyId: "tablaIiurCuerpo", headers: [['Área / Sala', 'Consultas', 'Ejemplares', 'Índice', 'Estado']], hasChart: false },
            'Actividades': { titulo: "INFORME: PARTICIPACIÓN EN ACTIVIDADES", tablaBodyId: "tablaActividadesCuerpo", headers: [['Categoría', 'Eventos Realizados', 'Total Asistentes', 'Participación (%)', 'Estado']], hasChart: false },
            'Ipe': { titulo: "INFORME: ÍNDICE DE PRODUCTIVIDAD DE EVENTOS (IPE)", tablaBodyId: "tablaIpeCuerpo",headers: [['Categoría', 'Eventos', 'Asistentes', 'Promedio', 'Estado']], hasChart: false},
        };

        const config = configs[tipo];
        if (!config) throw new Error("Tipo de reporte no configurado");

        doc.setTextColor(40, 40, 40);
        doc.setFontSize(14);
        doc.text(config.titulo, 14, 45);
        doc.setFontSize(9);
        doc.setFont("helvetica", "normal");
        doc.text("Fecha de emisión: " + new Date().toLocaleString(), 14, 51);
        doc.line(14, 53, 196, 53);

        let startY = 58; 
        const rows = [];

        const limpiarTextoEstado = (el) => {
            if (!el) return '--';
            let t = el.innerText.toUpperCase().replace('ESTADO:', '').trim();
            if (t.includes('CRÍTICO') || t.includes('CRITICO')) return 'CRÍTICO';
            if (t.includes('TOLERABLE')) return 'TOLERABLE';
            if (t.includes('ÓPTIMO') || t.includes('OPTIMO')) return 'ÓPTIMO';
            return t;
        };

        if (config.customResumen) {
            // Lógica Dashboard...
            if (document.getElementById('panel-cobertura-usuarios')) {
                const v = document.getElementById('cobertura-valor')?.innerText || '--';
                const e = limpiarTextoEstado(document.getElementById('panel-cobertura-usuarios').querySelector('.label'));
                rows.push(['Cobertura de Usuarios', v, e]);
            }
            if (document.getElementById('panel-consultas-referencia')) {
                const v = document.getElementById('referencia-valor')?.innerText || '--';
                const e = limpiarTextoEstado(document.getElementById('panel-consultas-referencia').querySelector('.label'));
                rows.push(['Consultas de Material de Referencia', `${v} (Por usuario activo)`, e]);
            }
            if (document.getElementById('panel-grafico-consultas')) {
                const raw = document.getElementById('panel-grafico-consultas').querySelector('.label')?.innerText || '';
                const match = raw.match(/\d+(\.\d+)?%/);
                rows.push(['Promedio de Consultas', match ? match[0] : '--', limpiarTextoEstado(document.getElementById('panel-grafico-consultas').querySelector('.label'))]);
            }
            const cumPanel = document.querySelector('[data-target="#modalDetalleCumplimiento"]');
            if (cumPanel) {
                const raw = cumPanel.querySelector('.label')?.innerText || '';
                const match = raw.match(/\d+(\.\d+)?%/);
                rows.push(['Cumplimiento de Plazos de Préstamo', match ? match[0] : '--', limpiarTextoEstado(cumPanel.querySelector('.label'))]);
            }
            if (document.getElementById('chartOcupacion')) {
                const raw = document.getElementById('badgeOcupacionEstado')?.innerText || '';
                const match = raw.match(/\d+(\.\d+)?%/);
                rows.push(['Ocupación Diaria de Salas', match ? match[0] : '--', limpiarTextoEstado(document.getElementById('badgeOcupacionEstado'))]);
            }
            if (document.getElementById('indicador-rotacion')) {
                const v = document.getElementById('indicador-rotacion').querySelector('.status-label')?.innerText || '--';
                const e = limpiarTextoEstado(document.getElementById('rotacion-estado-badge'));
                rows.push(['Índice de Rotación del Inventario', v, e]);
            }
            if (document.getElementById('indicador-physico') || document.getElementById('indicador-fisico')) {
                const el = document.getElementById('indicador-fisico') || document.getElementById('indicador-physico');
                const v = el.querySelector('.status-label')?.innerText || '--';
                const e = limpiarTextoEstado(document.getElementById('fisico-estado-badge'));
                rows.push(['Estado Físico de Colecciones', v, e]);
            }
            if (document.getElementById('indicador-asistencia')) {
                const v = document.getElementById('indicador-asistencia').querySelector('.status-label')?.innerText || '--';
                const e = limpiarTextoEstado(document.getElementById('asistencia-estado-badge'));
                rows.push(['Asistencia a la Sala Estatal', v, e]);
            }
            if (document.getElementById('indicador-coleccion')) {
                const v = document.getElementById('indicador-coleccion').querySelector('.status-label')?.innerText || '--';
                const e = limpiarTextoEstado(document.getElementById('coleccion-estado-badge'));
                rows.push(['Actualización de Colección Estatal', v, e]);
            }
            if (document.getElementById('panel-participacion-actividades')) {
                const pBar = document.getElementById('panel-participacion-actividades').querySelector('.progress-bar');
                const v = pBar ? pBar.innerText.trim().split(' ')[0] : '--';
                const num = parseFloat(v) || 0;
                const e = num <= 30 ? 'CRÍTICO' : (num < 70 ? 'TOLERABLE' : 'ÓPTIMO');
                rows.push(['Participación en Actividades y Talleres', v, e]);
            }

            doc.autoTable({
                head: config.headers,
                body: rows,
                startY: startY + 5,
                theme: 'grid',
                headStyles: { fillColor: [31, 78, 121], halign: 'center', fontSize: 10, fontStyle: 'bold' },
                styles: { fontSize: 9, cellPadding: 4 },
                margin: { left: 14, right: 14 },
                didParseCell: function(data) {
                    if (data.column.index === 2 && data.cell.section === 'body') {
                        const txt = data.cell.raw ? data.cell.raw.toString() : '';
                        if (txt === 'CRÍTICO') {
                            data.cell.styles.fillColor = [252, 213, 213];
                            data.cell.styles.textColor = [169, 68, 66];
                            data.cell.styles.fontStyle = 'bold';
                        } else if (txt === 'TOLERABLE') {
                            data.cell.styles.fillColor = [254, 240, 205];
                            data.cell.styles.textColor = [138, 109, 59];
                            data.cell.styles.fontStyle = 'bold';
                        } else if (txt === 'ÓPTIMO') {
                            data.cell.styles.fillColor = [212, 237, 218];
                            data.cell.styles.textColor = [21, 87, 36];
                            data.cell.styles.fontStyle = 'bold';
                        }
                    }
                }
            });
            startY = doc.lastAutoTable.finalY + 15;

        } else if (tipo === 'macro') {
            
            doc.setFontSize(11);
            doc.setFont("helvetica", "bold");
            doc.setTextColor(31, 78, 121);
            doc.text("1. RESUMEN DE INDICADORES OPERACIONALES (KPI)", 14, startY);
            
            const resumenRows = [];
            const idsMapeo = [
                { id: 'panel-cobertura-usuarios', val: 'cobertura-valor', badge: '.label', label: 'Cobertura de Usuarios' },
                { id: 'panel-consultas-referencia', val: 'referencia-valor', badge: '.label', label: 'Consultas de Referencia' },
                { id: 'panel-grafico-consultas', val: null, badge: '.label', label: 'Promedio de Consultas' },
                { id: 'indicador-rotacion', val: '.status-label', badge: '#rotacion-estado-badge', label: 'Rotación de Colección' },
                { id: 'indicador-fisico', val: '.status-label', badge: '#fisico-estado-badge', label: 'Estado Físico de Materiales' }
            ];

            idsMapeo.forEach(m => {
                const el = document.getElementById(m.id);
                if (el) {
                    let v = m.val?.startsWith('.') || m.val?.startsWith('#') ? el.querySelector(m.val)?.innerText : document.getElementById(m.val)?.innerText;
                    if (!v && m.id === 'panel-grafico-consultas') {
                        const match = el.querySelector('.label')?.innerText.match(/\d+(\.\d+)?%/);
                        v = match ? match[0] : '--';
                    }
                    const e = limpiarTextoEstado(el.querySelector(m.badge));
                    resumenRows.push([m.label, v || '--', e]);
                }
            });

            doc.autoTable({
                head: [['Área de Gestión', 'Valor Actual', 'Evaluación']],
                body: resumenRows,
                startY: startY + 4,
                theme: 'grid',
                headStyles: { fillColor: [31, 78, 121], fontSize: 9 },
                styles: { fontSize: 8.5 }
            });
            
            startY = doc.lastAutoTable.finalY + 12;

            const seccionesMacro = [
                { id: null, headers: [], titulo: "2. PROMEDIO DE CONSULTAS", chartId: "#panel-grafico-consultas" },
                { id: 'tablaReporteCuerpo', headers: [['Periodo / Turno', 'Consultas', 'Estado']], titulo: "3. HISTÓRICO: FLUJO DE CONSULTAS", chartId: "#chartModalConsultas" },
                { id: 'tbodyDetalleCumplimiento', headers: [['Categoría', 'Total Préstamos', 'A Tiempo', 'Mora Leve', 'Mora Grave']], titulo: "4. SEGUIMIENTO DE CUMPLIMIENTO Y MOROSIDAD", chartId: "#chartPlazos" },
                { id: 'tablaOcupacionCuerpo', headers: [['Sala', 'Capacidad Máxima', 'Ocupación Pico', 'Promedio', 'Estado']], titulo: "5. CAPACIDAD Y OCUPACIÓN DE SALAS", chartId: "#chartOcupacion" },
                { id: 'tablaCoberturaCuerpo', headers: [['Segmento', 'Total Registrados', 'Nuevos (Mes)', 'Tendencia']], titulo: "6. DESGLOSE: COBERTURA DE USUARIOS" },
                { id: 'tablaReferenciaCuerpo', headers: [['Área del Conocimiento', 'Consultas', 'Eficiencia de Respuesta']], titulo: "7. DESGLOSE: CONSULTAS DE REFERENCIA" },
                { id: 'tablaRotacionCuerpo', headers: [['Categoría', 'Inventario', 'Préstamos', 'Rotación']], titulo: "8. DINÁMICA DE ROTACIÓN DE INVENTARIO" },
                { id: 'tablaSaludCuerpo', headers: [['Sala', 'Total Libros', 'Buen Estado', 'En Reparación', 'Salud Física']], titulo: "9. EVALUACIÓN DE SALUD FÍSICA DEL MATERIAL" },
                { id: 'tablaAsistenciaEstatalCuerpo', headers: [['Tipo de Usuario', 'Nro. de Visitas', 'Tendencia']], titulo: "10. ASISTENCIA Y VISITAS A SALA ESTATAL" },
                { id: 'tablaColeccionCuerpo', headers: [['Sala', 'Títulos Totales', 'Novedades (2024-25)', 'Estado', 'Acción Requerida']], titulo: "11. ACTUALIZACIÓN ACADÉMICA DE LA COLECCIÓN" }
            ];

            for (const seccion of seccionesMacro) {
                const tableBody = seccion.id ? document.getElementById(seccion.id) : null;
                const chartElement = seccion.chartId ? document.querySelector(seccion.chartId) : null;
                
                if (tableBody || chartElement) {
                    // --- PRE-CÁLCULO EXACTO DE ESPACIO PARA EVITAR CORTES ---
                    let estimadoTablaH = 0;
                    let dRows = [];

                    if (tableBody) {
                        Array.from(tableBody.querySelectorAll('tr')).forEach(tr => {
                            const rowData = Array.from(tr.querySelectorAll('td')).map(td => td.innerText.trim());
                            if (rowData.length > 0) dRows.push(rowData);
                        });
                        // ~6.5mm por fila de datos + 10mm de cabecera de tabla
                        estimadoTablaH = (dRows.length * 6.5) + 10;
                    }

                    // Título de sección (8mm de margen) + Gráfico (82mm si existe) + Tabla
                    let espacioRequerido = 8 + estimadoTablaH; 
                    if (chartElement) {
                        espacioRequerido += 82; 
                    }

                    // Si el bloque completo supera el espacio usable disponible, forzamos el salto de página
                    if (startY + espacioRequerido > pageUsableHeight) {
                        doc.addPage();
                        // No se vuelve a llamar a la cabecera. Dejamos un margen superior limpio
                        startY = 20; 
                    }

                    // Renderizar título seguro
                    doc.setFontSize(11);
                    doc.setFont("helvetica", "bold");
                    doc.setTextColor(44, 62, 80);
                    doc.text(seccion.titulo, 14, startY);
                    startY += 6;

                    // Captura e inyección de gráficos directos de memoria
                    if (chartElement) {
                        try {
                            let imgData = null;
                            const canvasDirecto = chartElement.querySelector('canvas');
                            
                            if (canvasDirecto) {
                                imgData = canvasDirecto.toDataURL('image/png', 1.0);
                            } else {
                                const canvasH2C = await html2canvas(chartElement, { 
                                    scale: 2, 
                                    backgroundColor: "#ffffff", 
                                    useCORS: true, 
                                    logging: false 
                                });
                                imgData = canvasH2C.toDataURL('image/png');
                            }
                            
                            if (imgData && imgData.length > 50) {
                                doc.addImage(imgData, 'PNG', 15, startY, 180, 75);
                                startY += 82; 
                            }
                        } catch (e) {
                            console.warn("No se pudo capturar el gráfico para:", seccion.titulo, e);
                        }
                    }

                    // Renderizar tabla emparejada sin cortes internos flotantes
                    if (dRows.length > 0) {
                        doc.autoTable({
                            head: seccion.headers,
                            body: dRows,
                            startY: startY,
                            theme: 'grid',
                            pageBreak: 'avoid', // Refuerzo de comportamiento nativo para estructuras rígidas
                            headStyles: { fillColor: [44, 62, 80], halign: 'center', fontSize: 9 },
                            styles: { fontSize: 8, cellPadding: 2.5 },
                            alternateRowStyles: { fillColor: [245, 245, 245] },
                            margin: { left: 14, right: 14 }
                        });
                        startY = doc.lastAutoTable.finalY + 12;
                    } else {
                        startY += 4; 
                    }
                }
            }

        } else if (tipo === 'DetalleVisita' && config.customCapture) {
            const rango = obtenerRangoFechas();
            doc.setFontSize(10);
            doc.setTextColor(0,0,0);
            doc.text(`Período: ${rango.desde} al ${rango.hasta}`, 14, startY);
            startY += 10;

            const totalPeriodo = document.getElementById('modal-total-periodo')?.innerText || '--';
            const diaMasConcurrido = document.getElementById('modal-dia-mas-concurrido')?.innerText || '--';
            const tendencia = document.getElementById('modal-tendencia')?.innerText || '--';
            doc.setFontSize(11);
            doc.setFont("helvetica", "bold");
            doc.text("Resumen del período", 14, startY);
            startY += 7;
            doc.setFontSize(9);
            doc.setFont("helvetica", "normal");
            doc.text(`Día de la semana más concurrido: ${diaMasConcurrido}`, 14, startY + 5);
            doc.text(`Tendencia: ${tendencia}`, 14, startY + 10);
            startY += 20;

            const chartElement = document.querySelector(config.chartId);
            if (chartElement) {
                try {
                    let imgData = null;
                    const canvasDirecto = chartElement.querySelector('canvas');
                    
                    if (canvasDirecto) {
                        imgData = canvasDirecto.toDataURL('image/png', 1.0);
                    } else {
                        const canvasH2C = await html2canvas(chartElement, { scale: 2, backgroundColor: "#ffffff", useCORS: true, logging: false });
                        imgData = canvasH2C.toDataURL('image/png');
                    }
                    
                    if (imgData && imgData.startsWith('data:image/') && imgData.length > 50) {
                        doc.addImage(imgData, 'PNG', 15, startY, 180, 75);
                        startY += 85;
                    }
                } catch(e) { console.warn("Fallo al procesar imagen de detalle", e); }
            }

            const tablaElement = document.querySelector('#tabla-detalle-modal');
            if (tablaElement) {
                const headers = [];
                const thead = tablaElement.querySelector('thead tr');
                if (thead) {
                    Array.from(thead.querySelectorAll('th')).forEach(th => headers.push(th.innerText.trim()));
                }
                const dRows = [];
                const tbody = tablaElement.querySelector('tbody');
                if (tbody) {
                    Array.from(tbody.querySelectorAll('tr')).forEach(tr => {
                        const rowData = Array.from(tr.querySelectorAll('td')).map(td => td.innerText.trim());
                        if (rowData.length) dRows.push(rowData);
                    });
                }
                const totalAcumulado = document.getElementById('modal-total-acumulado')?.innerText || '';
                if (dRows.length) {
                    doc.autoTable({
                        head: [headers],
                        body: dRows,
                        startY: startY,
                        theme: 'grid',
                        headStyles: { fillColor: [44, 62, 80], halign: 'center', fontSize: 9 },
                        styles: { fontSize: 8, cellPadding: 2.5 },
                        margin: { left: 14, right: 14 }
                    });
                    startY = doc.lastAutoTable.finalY + 10;
                    doc.text(`Total acumulado: ${totalAcumulado}`, 14, startY);
                }
            }
        } else {
            let finalChartY = 53;
            if (config.hasChart && config.chartId) {
                const chartElement = document.querySelector(config.chartId);
                if (chartElement) {
                    try {
                        let imgData = null;
                        const canvasDirecto = chartElement.querySelector('canvas');
                        
                        if (canvasDirecto) {
                            imgData = canvasDirecto.toDataURL('image/png', 1.0);
                        } else {
                            const canvasH2C = await html2canvas(chartElement, { scale: 2, backgroundColor: "#ffffff", useCORS: true, logging: false });
                            imgData = canvasH2C.toDataURL('image/png');
                        }

                        if (imgData && imgData.startsWith('data:image/') && imgData.length > 50) {
                            doc.addImage(imgData, 'PNG', 15, 58, 180, 75);
                            finalChartY = 140;
                        } else {
                            finalChartY = 60; 
                        }
                    } catch(e) { 
                        finalChartY = 60;
                    }
                }
            } else {
                finalChartY = 60;
            }

            const dRows = [];
            const tableBody = document.getElementById(config.tablaBodyId);
            if (tableBody) {
                Array.from(tableBody.querySelectorAll('tr')).forEach(tr => {
                    let cells = Array.from(tr.querySelectorAll('td'));
                    if (tipo === 'Lectores' && cells.length > 0) {
                        cells = cells.slice(0, -1);
                    }
                    const rowData = cells.map(td => td.innerText.trim());
                    if (rowData.length > 0) dRows.push(rowData);
                });
            }

            doc.autoTable({
                head: config.headers,
                body: dRows,
                startY: finalChartY,
                theme: 'grid',
                headStyles: { fillColor: [44, 62, 80], halign: 'center', fontSize: 9 },
                styles: { fontSize: 8, cellPadding: 2.5 },
                alternateRowStyles: { fillColor: [245, 245, 245] },
                margin: { left: 14, right: 14 }
            });
            startY = doc.lastAutoTable.finalY + 25;
        }

        // --- CINTILLO INFERIOR Y SECCIÓN DE FIRMAS (ÚNICO AL FINAL DEL DOCUMENTO) ---
        let finalY = startY + 10;
        if (finalY + 35 > pageHeight) {
            doc.addPage();
            finalY = 30;
        }
        
        doc.setFontSize(9);
        doc.setTextColor(0);
        doc.text("__________________________", 55, finalY, { align: "center" });
        doc.text("Firma del Responsable", 55, finalY + 5, { align: "center" });
        doc.text("__________________________", 155, finalY, { align: "center" });
        doc.text("Sello de la Institución", 155, finalY + 5, { align: "center" });

        const logosBottomY = pageHeight - 27; 
        doc.setDrawColor(0, 0, 0);
        doc.setLineWidth(0.1);
        doc.line(12, logosBottomY - 4, 198, logosBottomY - 4);
        doc.setLineWidth(0.4);
        doc.line(12, logosBottomY - 2.5, 198, logosBottomY - 2.5);
        if (imgInfIzq) doc.addImage(imgInfIzq, 'PNG', 12, logosBottomY, 22, 22);
        if (imgInfDer) doc.addImage(imgInfDer, 'PNG', 176, logosBottomY, 22, 22);

        doc.setFont("helvetica", "italic");
        doc.setFontSize(7);
        doc.text("Biblioteca Pública Central 'Armando Zuloaga Blanco' - Estado Sucre", centerX, logosBottomY + 10, { align: "center" });

        window.open(doc.output('bloburl'), '_blank');

    } catch (error) {
        console.error("Error al generar PDF:", error);
        alert("Ocurrió un error al generar el PDF: " + error.message);
    } finally {
        const loaderContainer = document.getElementById('pdf-loader-container');
        if (loaderContainer) loaderContainer.remove();
    }
}