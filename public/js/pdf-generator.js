/**
 * Generador de Reportes con Doble Logo y Animación Nativa
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
                background: rgba(44, 62, 80, 0.9);
                display: flex; flex-direction: column;
                justify-content: center; align-items: center;
                z-index: 10000; color: white; font-family: sans-serif;
            }
            .pdf-spinner {
                width: 60px; height: 60px;
                border: 6px solid rgba(255,255,255,0.3);
                border-top: 6px solid #ffffff;
                border-radius: 50%;
                animation: pdf-spin 1s linear infinite;
                margin-bottom: 20px;
            }
            @keyframes pdf-spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .pdf-loader-text { font-size: 18px; font-weight: bold; letter-spacing: 1px; }
        `;
        document.head.appendChild(style);
    }
})();

async function descargarPDF(tipo) {
    // 2. Mostrar Cargador
    const loader = document.createElement('div');
    loader.id = 'pdf-loader-container';
    loader.innerHTML = `
        <div class="pdf-loader-overlay">
            <div class="pdf-spinner"></div>
            <div class="pdf-loader-text">GENERANDO REPORTE...</div>
            <p style="font-size: 12px; margin-top: 10px;">Procesando datos e imágenes</p>
        </div>
    `;
    document.body.appendChild(loader);

    try {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'mm', 'a4');
        
        // --- MANEJO DE RUTAS ---
        const baseUrl = window.BASE_URL || ''; 
        const logoIzquierdoUrl = `${baseUrl}/img/img-login/libro.png`; 
        const logoDerechoUrl = `${baseUrl}/img/img-login/gobernacion2.jpeg`; 

        const cargarImagen = (url) => {
            return new Promise((resolve) => {
                const img = new Image();
                img.setAttribute('crossOrigin', 'anonymous');
                img.onload = () => resolve(img);
                img.onerror = () => {
                    console.warn("No se pudo cargar la imagen en:", url);
                    resolve(null); // Resolvemos con null para no romper el flujo
                };
                img.src = url;
            });
        };

        // --- DISEÑO: Cintillo Superior ---
        doc.setFillColor(44, 62, 80);
        doc.rect(0, 0, 210, 30, 'F');

        // Carga de logos con Promise.all
        const [imgIzq, imgDer] = await Promise.all([
            cargarImagen(logoIzquierdoUrl),
            cargarImagen(logoDerechoUrl)
        ]);

        if (imgIzq) doc.addImage(imgIzq, 'PNG', 12, 4, 22, 22);
        if (imgDer) doc.addImage(imgDer, 'JPEG', 176, 4, 22, 22);

        // Texto del encabezado
        doc.setTextColor(255, 255, 255);
        doc.setFont("helvetica", "bold");
        doc.setFontSize(11);
        doc.text("Biblioteca Pública Central Armando Zuloaga Blanco", 105, 12, { align: "center" });
        doc.setFontSize(8);
        doc.setFont("helvetica", "normal");
        doc.text("SISTEMA DE GESTIÓN Y CONTROL DE INDICADORES", 105, 18, { align: "center" });
        doc.text("Cumaná, Estado Sucre, Venezuela", 105, 23, { align: "center" });

        // --- CONFIGURACIONES DE REPORTES ---
        const configs = {
            'Cobertura': { titulo: "ANÁLISIS DE COBERTURA DE USUARIOS", tablaBodyId: "tablaCoberturaCuerpo", headers: [['Segmento', 'Total Registrados', 'Nuevos (Mes)', 'Tendencia']], hasChart: false },
            'Referencia': { titulo: "DETALLE: CONSULTAS DE REFERENCIA", tablaBodyId: "tablaReferenciaCuerpo", headers: [['Área del Conocimiento', 'Consultas', 'Eficiencia de Respuesta']], hasChart: false },
            'Consultas': { titulo: "ESTADÍSTICA HISTÓRICA DE CONSULTAS", chartId: "#chartModalConsultas", chartVar: typeof chartModal !== 'undefined' ? chartModal : null, tablaBodyId: "tablaReporteCuerpo", headers: [['Periodo / Turno', 'Consultas', 'Estado']], hasChart: true },
            'Cumplimiento': { titulo: "INFORME DE CUMPLIMIENTO Y PLAZOS", chartId: "#chartModalPlazos", chartVar: typeof chartModalPlazos !== 'undefined' ? chartModalPlazos : null, tablaBodyId: "tablaCumplimientoCuerpo", headers: [['Categoría', 'Total Préstamos', 'A Tiempo', 'Mora Leve', 'Mora Grave']], hasChart: true },
            'Ocupacion': { titulo: "CAPACIDAD Y USO DE ESPACIOS", chartId: "#chartModalOcupacion", chartVar: typeof chartModalOcupacion !== 'undefined' ? chartModalOcupacion : null, tablaBodyId: "tablaOcupacionCuerpo", headers: [['Sala', 'Capacidad Máxima', 'Ocupación Pico', 'Promedio', 'Estado']], hasChart: true },
            'Rotacion': { titulo: "INFORME DETALLADO: ÍNDICE DE ROTACIÓN", chartId: "#chartModalRotacion", chartVar: typeof chartModalRotacion !== 'undefined' ? chartModalRotacion : null, tablaBodyId: "tablaRotacionCuerpo", headers: [['Categoría', 'Inventario', 'Préstamos', 'Rotación']], hasChart: true },
            'Salud': { titulo: "INFORME: SALUD FÍSICA DE LA COLECCIÓN", tablaBodyId: "tablaSaludCuerpo", headers: [['Sala', 'Total Libros', 'Buen Estado', 'En Reparación', 'Salud Física']], hasChart: false },
            'AsistenciaEstatal': { titulo: "REPORTE DE ASISTENCIA: SALA ESTATAL", tablaBodyId: "tablaAsistenciaEstatalCuerpo", headers: [['Tipo de Usuario', 'Nro. de Visitas', 'Permanencia Promedio', 'Tendencia']], hasChart: false },
            'Coleccion': { titulo: "ESTADO DE ACTUALIZACIÓN DE LA COLECCIÓN", tablaBodyId: "tablaColeccionCuerpo", headers: [['Sala', 'Títulos Totales', 'Novedades (2024-25)', 'Estado', 'Acción Requerida']], hasChart: false }
        };

        const config = configs[tipo];
        if (!config) throw new Error("Tipo de reporte no configurado");

        // Título del cuerpo
        doc.setTextColor(40, 40, 40);
        doc.setFontSize(16);
        doc.text(config.titulo, 14, 45);
        doc.setFontSize(10);
        doc.setFont("helvetica", "normal");
        doc.text("Fecha de emisión: " + new Date().toLocaleString(), 14, 52);
        doc.line(14, 55, 196, 55);

        // --- CAPTURA DE GRÁFICA ---
        let finalChartY = 55;
        if (config.hasChart && config.chartId) {
            const chartElement = document.querySelector(config.chartId);
            if (chartElement) {
                await new Promise(resolve => setTimeout(resolve, 800)); 
                let imgData;
                if (config.chartVar && typeof config.chartVar.dataURI === 'function') {
                    const res = await config.chartVar.dataURI();
                    imgData = res.imgURI;
                } else {
                    const canvas = await html2canvas(chartElement, { scale: 2, backgroundColor: "#ffffff", useCORS: true });
                    imgData = canvas.toDataURL('image/png');
                }
                doc.addImage(imgData, 'PNG', 15, 60, 180, 75);
                finalChartY = 142;
            }
        } else {
            finalChartY = 62;
        }

        // --- EXTRACCIÓN DE DATOS ---
        const rows = [];
        const tableBody = document.getElementById(config.tablaBodyId);
        if (tableBody) {
            Array.from(tableBody.querySelectorAll('tr')).forEach(tr => {
                const rowData = Array.from(tr.querySelectorAll('td')).map(td => td.innerText.trim());
                if (rowData.length > 0) rows.push(rowData);
            });
        }

        // --- RENDERIZAR TABLA ---
        doc.autoTable({
            head: config.headers,
            body: rows,
            startY: finalChartY,
            theme: 'grid',
            headStyles: { fillColor: [44, 62, 80], halign: 'center', fontSize: 9 },
            styles: { fontSize: 8, cellPadding: 2.5 },
            alternateRowStyles: { fillColor: [245, 245, 245] },
            margin: { left: 14, right: 14 }
        });

        // --- SECCIÓN DE FIRMAS ---
        const finalY = doc.lastAutoTable.finalY + 25;
        const pageHeight = doc.internal.pageSize.height;
        const safeY = (finalY + 20) > pageHeight ? pageHeight - 35 : finalY;
        
        doc.setFontSize(9);
        doc.text("__________________________", 55, safeY, { align: "center" });
        doc.text("Firma del Responsable", 55, safeY + 5, { align: "center" });
        doc.text("__________________________", 155, safeY, { align: "center" });
        doc.text("Sello de la Institución", 155, safeY + 5, { align: "center" });

        // --- PIE DE PÁGINA ---
        doc.setFontSize(7);
        doc.setTextColor(150);
        doc.text("Generado por el Sistema de Gestión de BPCAZB", 105, 285, { align: "center" });

        // ABRIR PDF
        window.open(doc.output('bloburl'), '_blank');

    } catch (error) {
        console.error("Error al generar PDF:", error);
        alert("Ocurrió un error al generar el PDF. Revisa la consola para más detalles.");
    } finally {
        const loaderContainer = document.getElementById('pdf-loader-container');
        if (loaderContainer) loaderContainer.remove();
    }
}