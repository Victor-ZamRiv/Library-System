  document.addEventListener("DOMContentLoaded", function() {
    
    // =========================================================
    //  SISTEMA DE SEMÁFORO INTERACTIVO - CONFIGURACIÓN OFICIAL
    // =========================================================
    
    // --- REGLAS DE NEGOCIO (Mapeado exacto de la tabla oficial) ---
    function obtenerConfiguracion(idIndicador, valor) {
        let claseColor = "danger";
        let colorHex = "#d9534f"; // Rojo
        let estadoTexto = "Crítico";
        let colorFondoBox = "#fdf7f7";

        switch (idIndicador) {
            case 'indicador-rotacion':
                // Rango: Crítico < 5% | Tolerable > 5% y < 15% | Óptimo > 15%
                // Ajustado matemáticamente para no dejar vacíos (<= 5, < 15, >= 15)
                if (valor < 5) {
                    claseColor = "danger"; colorHex = "#d9534f"; estadoTexto = "Crítico"; colorFondoBox = "#fdf7f7";
                } else if (valor >= 5 && valor < 15) {
                    claseColor = "warning"; colorHex = "#f0ad4e"; estadoTexto = "Tolerable"; colorFondoBox = "#fffaf0";
                } else {
                    claseColor = "success"; colorHex = "#5cb85c"; estadoTexto = "Óptimo"; colorFondoBox = "#f9fff9";
                }
                break;

            case 'indicador-cumplimiento': // Tasa de cumplimiento de plazos de devolución
                // Rango: Crítico <= 70% | Tolerable > 70% y < 90% | Óptimo >= 90%
                if (valor <= 70) {
                    claseColor = "danger"; colorHex = "#d9534f"; estadoTexto = "Crítico"; colorFondoBox = "#fdf7f7";
                } else if (valor > 70 && valor < 90) {
                    claseColor = "warning"; colorHex = "#f0ad4e"; estadoTexto = "Tolerable"; colorFondoBox = "#fffaf0";
                } else {
                    claseColor = "success"; colorHex = "#5cb85c"; estadoTexto = "Óptimo"; colorFondoBox = "#f9fff9";
                }
                break;

            case 'indicador-consultas':      // Promedio de consultas mensuales
            case 'indicador-cobertura':        // Cobertura de usuarios registrados
            case 'indicador-ocupacion':        // Porcentaje de ocupación diaria de salas
            case 'indicador-physico':          // Porcentaje de ejemplares en buen estado (Id alternativo)
            case 'indicador-fisico':           // Porcentaje de ejemplares en buen estado
            case 'indicador-asistencia':       // Porcentaje de asistentes a la sala Estatal
            case 'indicador-coleccion':        // Porcentaje de colección Estatal
            case 'indicador-talleres':         // Porcentaje de usuarios en actividades y talleres
            default:
                // Rango Estándar: Crítico <= 30% | Tolerable > 40% y < 70% | Óptimo >= 70%
                // Nota: Para continuidad de datos, se evalúa como <= 30 Crítico, de 30 a 70 Tolerable
                if (valor <= 30) {
                    claseColor = "danger"; colorHex = "#d9534f"; estadoTexto = "Crítico"; colorFondoBox = "#fdf7f7";
                } else if (valor > 30 && valor < 70) {
                    claseColor = "warning"; colorHex = "#f0ad4e"; estadoTexto = "Tolerable"; colorFondoBox = "#fffaf0";
                } else {
                    claseColor = "success"; colorHex = "#5cb85c"; estadoTexto = "Óptimo"; colorFondoBox = "#f9fff9";
                }
                break;
        }

        return { claseColor, colorHex, estadoTexto, colorFondoBox };
    }

    // --- 1. PROCESAMIENTO DE TARJETAS, POPOVERS Y SEMÁFORO LATERAL ---
    const tarjetas = document.querySelectorAll('.status-card');

    tarjetas.forEach(tarjeta => {
        const etiqueta = tarjeta.querySelector('.status-label');
        const icono = tarjeta.querySelector('.status-icon');
        const idTarjeta = tarjeta.id;

        if (etiqueta) {
            const valorTexto = etiqueta.textContent.replace('%', '').trim();
            const valor = parseFloat(valorTexto);

            // Obtener configuración real basada en la tabla
            const config = obtenerConfiguracion(idTarjeta, valor);

            // Limpiar clases previas del badge/etiqueta
            etiqueta.classList.remove('label-danger', 'label-warning', 'label-success');
            
            // Aplicar estilos dinámicos a la tarjeta lateral
            tarjeta.style.borderLeft = `5px solid ${config.colorHex}`;
            if (icono) icono.style.color = config.colorHex;
            
            etiqueta.style.backgroundColor = config.colorHex;
            etiqueta.style.color = "#ffffff";
            etiqueta.classList.add('label-' + config.claseColor);

            // Definición de mensajes detallados y metas dinámicas
            let mensajeDetalle = "Información del indicador en estado " + config.estadoTexto + ".";
            let metaTexto = "Meta: Óptimo";

            if (idTarjeta === 'indicador-rotacion') {
                metaTexto = "Meta: &gt; 15%";
                if (config.estadoTexto === "Crítico") mensajeDetalle = "La circulación de libros es muy baja respecto al inventario.";
                else if (config.estadoTexto === "Tolerable") mensajeDetalle = "La rotación de la colección es estable, pero puede mejorar.";
                else mensajeDetalle = "Excelente flujo y préstamo de libros en este módulo.";
            } else if (idTarjeta === 'indicador-fisico' || idTarjeta === 'indicador-physico') {
                metaTexto = "Meta: &gt;= 70%";
                if (config.estadoTexto === "Crítico") mensajeDetalle = "Se han detectado múltiples textos dañados que requieren reparación urgente.";
                else if (config.estadoTexto === "Tolerable") mensajeDetalle = "La colección está controlada, algunos textos necesitan mantenimiento menor.";
                else mensajeDetalle = "La mayoría de la colección se encuentra en óptimas condiciones.";
            } else if (idTarjeta === 'indicador-asistencia') {
                metaTexto = "Meta: 500 usuarios/mes";
                if (config.estadoTexto === "Crítico") mensajeDetalle = "El flujo de visitantes en la Sala Estatal está críticamente bajo.";
                else if (config.estadoTexto === "Tolerable") mensajeDetalle = "La asistencia a la Sala Estatal se mantiene cerca del promedio esperado.";
                else mensajeDetalle = "¡Meta superada! Alto flujo de usuarios en la Sala Estatal.";
            } else if (idTarjeta === 'indicador-coleccion') {
                metaTexto = "Meta: &gt;= 70%";
                if (config.estadoTexto === "Crítico") mensajeDetalle = "Nivel de actualización de títulos insuficiente este mes.";
                else if (config.estadoTexto === "Tolerable") mensajeDetalle = "Adquisición de títulos en progreso. Revisar catálogo pendiente.";
                else mensajeDetalle = "Colección actualizada con las últimas adquisiciones solicitadas.";
            }

            // Construir el HTML interno del Popover respetando la regla oficial
            const nuevoContenidoPopover = `${mensajeDetalle}<br><strong>Estado:</strong> ${config.estadoTexto}<br><div class='progress'><div class='progress-bar progress-bar-${config.claseColor}' style='width:${Math.min(valor, 100)}%'></div></div><small>${metaTexto}</small>`;

            // Inyectar el contenido para Bootstrap
            tarjeta.setAttribute('data-content', nuevoContenidoPopover);

            if (typeof $ !== 'undefined' && $(tarjeta).data('bs.popover')) {
                $(tarjeta).data('bs.popover').options.content = nuevoContenidoPopover;
            }
        }
    });

    // --- 2. CONTROLADORES DINÁMICOS AL ABRIR LOS MODALES (EVENTOS BOOTSTRAP) ---
    if (typeof $ !== 'undefined') {
        $(document).ready(function () {
            
            // Helper para actualizar modales de forma genérica y limpia
            function mapearModal(idModal, idIndicador, idHeader, idContenedor, idPorcentaje, idEstadoText, idBarra, idComplementario = null) {
                $(idModal).on('show.bs.modal', function () {
                    const tarjeta = document.getElementById(idIndicador);
                    if (!tarjeta) return;
                    
                    const valor = parseFloat(tarjeta.querySelector('.status-label').textContent.replace('%', '').trim());
                    const config = obtenerConfiguracion(idIndicador, valor);

                    if(document.getElementById(idHeader)) document.getElementById(idHeader).style.backgroundColor = config.colorHex;
                    
                    const contenedorBox = document.getElementById(idContenedor);
                    if (contenedorBox) {
                        contenedorBox.style.borderColor = config.colorHex;
                        contenedorBox.style.backgroundColor = config.colorFondoBox;
                    }
                    
                    if(document.getElementById(idPorcentaje)) {
                        document.getElementById(idPorcentaje).textContent = valor + "%";
                        document.getElementById(idPorcentaje).style.color = config.colorHex;
                    }
                    
                    if(document.getElementById(idEstadoText)) document.getElementById(idEstadoText).textContent = config.estadoTexto;

                    const barra = document.getElementById(idBarra);
                    if (barra) {
                        barra.classList.remove('progress-bar-danger', 'progress-bar-warning', 'progress-bar-success');
                        barra.style.width = Math.min(valor, 100) + "%";
                        barra.classList.add('progress-bar-' + config.claseColor);
                    }

                    // Cálculo dinámico para asistencia
                    if (idComplementario && idIndicador === 'indicador-asistencia') {
                        const visitantesCalculados = Math.round((valor * 500) / 100);
                        if (document.getElementById(idComplementario)) {
                            document.getElementById(idComplementario).textContent = visitantesCalculados.toLocaleString();
                        }
                    }
                });
            }

            // Mapeo Oficial de Modales
            mapearModal('#modalRotacion', 'indicador-rotacion', 'modalRotacionHeader', 'modalRotacionContenedorBox', 'modalRotacionPorcentaje', 'modalRotacionEstado', 'modalRotacionBarra');
            mapearModal('#modalEstadoFisico', 'indicador-fisico', 'modalFisicoHeader', 'modalFisicoContenedorPorcentaje', 'modalFisicoPorcentaje', 'modalFisicoEstadoText', 'modalFisicoBarra');
            mapearModal('#modalAsistenciaEstatal', 'indicador-asistencia', 'modalAsistenciaHeader', 'modalAsistenciaContenedorPorcentaje', 'modalAsistenciaPorcentaje', 'modalAsistenciaEstadoText', 'modalAsistenciaBarra', 'modalAsistenciaVisitantes');
            mapearModal('#modalColeccion', 'indicador-coleccion', 'modalColeccionHeader', 'modalColeccionContenedorPorcentaje', 'modalColeccionPorcentaje', 'modalColeccionEstadoText', 'modalColeccionBarra');
        });
    }
    
    
});