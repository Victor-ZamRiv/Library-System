/**
 * Generador de Reportes Institucionales
 * Biblioteca Pública Central "Armando Zuloaga Blanco"
 */

// 1. Inyección de estilos para el cargador (Corregido para visibilidad)
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
                border-top: 6px solid #616162; /* Color institucional */
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

async function descargarPDF(tipo) {
    // 2. Mostrar Cargador
    const loader = document.createElement('div');
    loader.id = 'pdf-loader-container';
    loader.innerHTML = `
        <div class="pdf-loader-overlay">
            <div class="pdf-spinner"></div>
            <div class="pdf-loader-text">GENERANDO REPORTE...</div>
            <p class="pdf-loader-subtext">Preparando formato oficial e imágenes</p>
        </div>
    `;
    document.body.appendChild(loader);

    try {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'mm', 'a4');
        
        // --- MANEJO DE RUTAS ---
        const baseUrl = window.BASE_URL || ''; 
        
        // Logos del Cintillo Superior
        const logoIzquierdoUrl = `${baseUrl}/img/img-login/gobernacion.png`; 
        const logoDerechoUrl = `${baseUrl}/img/img-login/libro.png`; 

        // =========================================================================
        // CAMBIA AQUÍ LOS LOGOS INFERIORES: Coloca el nombre real de tus archivos
        // =========================================================================
        const logoInferiorIzqUrl = `${baseUrl}/img/img-login/sucre.png`; 
        const logoInferiorDerUrl = `${baseUrl}/img/img-login/division.png`; 
        // =========================================================================

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

        // Carga asíncrona de las 4 imágenes en paralelo
        const [imgIzq, imgDer, imgInfIzq, imgInfDer] = await Promise.all([
            cargarImagen(logoIzquierdoUrl),
            cargarImagen(logoDerechoUrl),
            cargarImagen(logoInferiorIzqUrl),
            cargarImagen(logoInferiorDerUrl)
        ]);

        // --- DISEÑO: Cintillo Superior Institucional ---
        doc.setFillColor(255, 255, 255);
        doc.rect(0, 0, 210, 35, 'F');

        if (imgIzq) doc.addImage(imgIzq, 'PNG', 12, 5, 22, 22);
        if (imgDer) doc.addImage(imgDer, 'PNG', 176, 5, 22, 22);

        doc.setTextColor(0, 0, 0);
        doc.setFont("helvetica", "normal");
        doc.setFontSize(8);
        
        const centerX = 105;
        doc.text("República Bolivariana de Venezuela", centerX, 8, { align: "center" });
        doc.text("Gobernación del Estado Sucre", centerX, 12, { align: "center" });
        doc.text("Instituto Autónomo de Cultura del Estado Sucre", centerX, 16, { align: "center" });
        doc.text("División de Bibliotecas Públicas del Estado Sucre", centerX, 20, { align: "center" });
        
        doc.setFont("helvetica", "bold");
        doc.setFontSize(10);
        doc.text('Biblioteca Pública Central "Armando Zuloaga Blanco"', centerX, 26, { align: "center" });

        // Líneas divisoras del cintillo
        doc.setDrawColor(0, 0, 0);
        doc.setLineWidth(0.4);
        doc.line(12, 32, 198, 32);
        doc.setLineWidth(0.1);
        doc.line(12, 33.5, 198, 33.5);

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
        doc.setFontSize(14);
        doc.text(config.titulo, 14, 45);
        doc.setFontSize(9);
        doc.setFont("helvetica", "normal");
        doc.text("Fecha de emisión: " + new Date().toLocaleString(), 14, 51);
        doc.line(14, 53, 196, 53);

        // --- CAPTURA DE GRÁFICA ---
        let finalChartY = 53;
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
                doc.addImage(imgData, 'PNG', 15, 58, 180, 75);
                finalChartY = 140;
            }
        } else {
            finalChartY = 60;
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

        // --- SECCIÓN DE FIRMAS Y LOGOS INFERIORES ---
        const pageHeight = doc.internal.pageSize.height;
        let finalY = doc.lastAutoTable.finalY + 25;
        
        // Control de salto de página: evitar que firmas + logos se corten
        if (finalY + 35 > pageHeight) {
            doc.addPage();
            finalY = 30;
        }
        
        // 1. Renderizar Bloque de Firmas
        doc.setFontSize(9);
        doc.setTextColor(0);
        doc.text("__________________________", 55, finalY, { align: "center" });
        doc.text("Firma del Responsable", 55, finalY + 5, { align: "center" });
        doc.text("__________________________", 155, finalY, { align: "center" });
        doc.text("Sello de la Institución", 155, finalY + 5, { align: "center" });

        // 2. Renderizar Logos Inferiores Nuevos
        const logosBottomY = pageHeight - 27; 

        // Líneas decorativas de cierre
        doc.setDrawColor(0, 0, 0);
        doc.setLineWidth(0.1);
        doc.line(12, logosBottomY - 4, 198, logosBottomY - 4);
        doc.setLineWidth(0.4);
        doc.line(12, logosBottomY - 2.5, 198, logosBottomY - 2.5);

        // Renderizado usando las variables de las nuevas imágenes cargadas arriba
        if (imgInfIzq) doc.addImage(imgInfIzq, 'PNG', 12, logosBottomY, 22, 22);
        if (imgInfDer) doc.addImage(imgInfDer, 'PNG', 176, logosBottomY, 22, 22);

        // Pie de página institucional centrado
        doc.setFont("helvetica", "italic");
        doc.setFontSize(7);
        doc.text("Biblioteca Pública Central 'Armando Zuloaga Blanco' - Estado Sucre", centerX, logosBottomY + 10, { align: "center" });

        // ABRIR PDF
        window.open(doc.output('bloburl'), '_blank');

    } catch (error) {
        console.error("Error al generar PDF:", error);
        alert("Ocurrió un error al generar el PDF.");
    } finally {
        const loaderContainer = document.getElementById('pdf-loader-container');
        if (loaderContainer) loaderContainer.remove();
    }
}