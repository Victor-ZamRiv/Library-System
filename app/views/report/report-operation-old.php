<!DOCTYPE html>
<html lang="es">
<head>
    <title>Reporte Estadístico Mensual</title>
    <?php include VIEW_PATH . "/component/heat.php" ?>
    <style>
        /* ========== ESTILOS ORIGINALES ========== */
        .report-paper {
            background: white;
            padding: 30px;
            border: 1px solid #dcdcdc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #000;
            margin-top: 15px;
        }
        .report-title {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin: 20px 0;
            text-transform: uppercase;
        }
        .table-report {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .table-report th, .table-report td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-size: 12px;
        }
        .bg-gray {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-left {
            text-align: left !important;
            padding-left: 10px !important;
        }
        .btn-main-action {
            margin-top: 30px;
        }
        .time-selector-container {
            margin-bottom: 25px;
        }
        .btn-group .btn.active {
            background-color: #0d6efd !important;
            color: white !important;
            box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
        }
        .nav-tabs {
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px 0;
            border-bottom: none;
        }
        .nav-tabs>li>a {
            border: 1px solid #00000062 !important;
            margin: 0 5px;
            border-radius: 4px;
            background-color: #fff;
            color: #333;
        }
        .nav-tabs>li.active>a,
        .nav-tabs>li.active>a:hover,
        .nav-tabs>li.active>a:focus {
            background-color: #13a862 !important;
            color: white !important;
            border: 1px solid #198754 !important;
        }
    </style>
</head>
<body>
    <?php include VIEW_PATH . "/component/sidebar.php" ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php" ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"> Reporte de Operaciones</h1>
            </div>
        </div>

        <!-- Tarjetas superiores (totales generales) -->
        <div class="container-fluid" id="totales-container">
            <div class="row">
                <div class="col-xs-12 col-sm-3">
                    <div class="panel panel-info text-center">
                        <div class="panel-heading text-uppercase">Consultas</div>
                        <div class="panel-body">
                            <h4><strong id="total-consultas">0</strong></h4>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="panel panel-primary text-center">
                        <div class="panel-heading text-uppercase">Préstamos</div>
                        <div class="panel-body">
                            <h4><strong id="total-prestamos">0</strong></h4>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="panel panel-success text-center">
                        <div class="panel-heading text-uppercase">Actividades</div>
                        <div class="panel-body">
                            <h4><strong id="total-actividades">0</strong></h4>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="panel panel-danger text-center">
                        <div class="panel-heading text-uppercase">Logros</div>
                        <div class="panel-body">
                            <h4><strong id="total-logros">0</strong></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid text-center btn-main-action">
            <div class="panel panel-default">
                <div class="panel-body" style="padding: 50px;">
                    <i class="zmdi zmdi-assignment-check zmdi-hc-5x text-muted"></i>
                    <h3 class="text-muted">Generar Reporte de Operaciones</h3>
                    <p>Balance detallado de afluencia, servicios bibliotecarios y cumplimiento de metas institucionales.</p>
                    <br>
                    <button class="btn btn-primary btn-raised btn-lg" data-toggle="modal" data-target="#modalFiltroReporte">
                        <i class="zmdi zmdi-settings"></i> EMITIR REPORTE
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- MODAL DE REPORTE (contenido dinámico) -->
    <div class="modal fade" id="modalFiltroReporte" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="zmdi zmdi-filter-list"></i> Reporte de Operaciones</h4>
                </div>
                <div class="modal-body">
                    <div class="row time-selector-container text-center">
                        <div class="col-sm-12">
                            <label class="control-label" style="display:block; margin-bottom:10px;">Seleccionar Periodo de Tiempo</label>
                            <div class="btn-group" role="group" aria-label="Rango de tiempo">
                                <button type="button" class="btn btn-default btn-raised btn-time-filter" data-value="semana">SEMANA</button>
                                <button type="button" class="btn btn-default btn-raised btn-time-filter active" data-value="mes">MES</button>
                                <button type="button" class="btn btn-default btn-raised btn-time-filter" data-value="trimestre">TRIMESTRE</button>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 15px;">
                        <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab" data-sala="general">General (Institucional)</a></li>
                        <li role="presentation"><a href="#sala-general" aria-controls="sala-general" role="tab" data-toggle="tab" data-sala="sala_general">Sala General</a></li>
                        <li role="presentation"><a href="#sala-referencia" aria-controls="sala-referencia" role="tab" data-toggle="tab" data-sala="sala_referencia">Sala de Referencia</a></li>
                        <li role="presentation"><a href="#sala-estatal" aria-controls="sala-estatal" role="tab" data-toggle="tab" data-sala="sala_estatal">Sala Estatal</a></li>
                        <li role="presentation"><a href="#sala-infantil" aria-controls="sala-infantil" role="tab" data-toggle="tab" data-sala="sala_infantil">Sala Infantil</a></li>
                    </ul>

                    <!-- Contenedor donde se inyectará el contenido del reporte -->
                    <div id="reporte-contenido">
                        <div class="report-paper text-center">Cargando datos...</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" onclick="descargarPDF('operativo')" class="btn btn-danger btn-raised">
                        <i class="zmdi zmdi-print"></i> EMITIR PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include VIEW_PATH . "/component/scripts.php" ?>
    <script src="<?= PUBLIC_PATH ?>/js/pdf-generator.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/html2canvas.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jsPDF.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jspdf-autotable.js"></script>

    <script>
        // Variables globales
        let periodoActual = 'mes';
        let salaActual = 'general';

        // Función para formatear números (puntos de miles)
        function formatearNumero(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Cargar datos del reporte vía AJAX y actualizar el contenido
        function cargarReporte(periodo, sala) {
            $('#reporte-contenido').html('<div class="report-paper text-center">Cargando datos...</div>');
            $.ajax({
                url: '/library_system/reportes/operativo/datos',
                method: 'GET',
                data: { periodo: periodo, sala: sala },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Actualizar tarjetas superiores (totales generales)
                        $('#total-consultas').text(formatearNumero(response.totales.consultas));
                        $('#total-prestamos').text(formatearNumero(response.totales.prestamos));
                        $('#total-actividades').text(response.actividades ? formatearNumero(response.actividades.totalActividades) : '0');
                        $('#total-logros').text(response.logros ? formatearNumero(response.logros) : '0');
                        
                        // Generar HTML del reporte según la sala
                        let html = '';
                        if (sala === 'general') {
                            html = generarReporteGeneral(response);
                        } else {
                            html = generarReportePorSala(response, sala);
                        }
                        $('#reporte-contenido').html(html);
                    } else {
                        $('#reporte-contenido').html('<div class="report-paper text-center text-danger">Error al cargar los datos.</div>');
                    }
                },
                error: function() {
                    $('#reporte-contenido').html('<div class="report-paper text-center text-danger">Error de conexión.</div>');
                }
            });
        }

        // Generar HTML para reporte general (con todas las salas, actividades y logros)
        function generarReporteGeneral(data) {
            // Calcular total obras consultadas (suma de consultasPorArea)
            let totalObras = 0;
            for (let area in data.consultasPorArea) {
                totalObras += parseInt(data.consultasPorArea[area]) || 0;
            }

            let html = '<div class="report-paper">';
            
            // Tabla de visitantes por sala
            html += '<div class="report-title">Visitantes atendidos - Reporte Institucional General</div>';
            html += '<table class="table-report">';
            html += '<tr class="bg-gray"><th>Sala General</th><th>Sala Estatal</th><th>Sala de Referencia</th><th>Sala Infantil</th></tr>';
            html += '<tr>';
            html += '<td>' + (data.consultasPorSala['Sala General'] || 0) + '</td>';
            html += '<td>' + (data.consultasPorSala['Sala Estatal'] || 0) + '</td>';
            html += '<td>' + (data.consultasPorSala['Sala de Referencia'] || 0) + '</td>';
            html += '<td>' + (data.consultasPorSala['Sala Infantil'] || 0) + '</td>';
            html += '</tr>',
            html += '</table>';

            // Distribución demográfica
            html += '<div class="report-title">Distribución demográfica</div>';
            html += '<table class="table-report">';
            html += '<tr class="bg-gray"><th>Género</th><th>Niños</th><th>Adolescentes</th><th>Adultos</th></tr>';
            html += '<tr><td class="bg-gray">Masculinos</td><td>' + formatearNumero(data.demografia.masculinos.ninos) + '</td><td>' + formatearNumero(data.demografia.masculinos.adolescentes) + '</td><td>' + formatearNumero(data.demografia.masculinos.adultos) + '</td></tr>';
            html += '<tr><td class="bg-gray">Femeninos</td><td>' + formatearNumero(data.demografia.femeninos.ninos) + '</td><td>' + formatearNumero(data.demografia.femeninos.adolescentes) + '</td><td>' + formatearNumero(data.demografia.femeninos.adultos) + '</td></tr>';
            html += '</table>';

            // Obras consultadas por área
            html += '<div class="report-title">Obras consultadas</div>';
            html += '<table class="table-report">';
            html += '<tr class="bg-gray"><th>000</th><th>100</th><th>200</th><th>300</th><th>400</th><th>500</th><th>600</th></tr>';
            html += '<tr><td>' + (data.consultasPorArea['000'] || 0) + '</td><td>' + (data.consultasPorArea['100'] || 0) + '</td><td>' + (data.consultasPorArea['200'] || 0) + '</td><td>' + (data.consultasPorArea['300'] || 0) + '</td><td>' + (data.consultasPorArea['400'] || 0) + '</td><td>' + (data.consultasPorArea['500'] || 0) + '</td><td>' + (data.consultasPorArea['600'] || 0) + '</td></tr>';
            html += '<tr class="bg-gray"><th>700</th><th>800</th><th>900</th><th>B</th><th>N</th><th>NV</th><th>PV</th></tr>';
            html += '<tr><td>' + (data.consultasPorArea['700'] || 0) + '</td><td>' + (data.consultasPorArea['800'] || 0) + '</td><td>' + (data.consultasPorArea['900'] || 0) + '</td><td>' + (data.consultasPorArea['Biog'] || 0) + '</td><td>' + (data.consultasPorArea['N'] || 0) + '</td><td>' + (data.consultasPorArea['NV'] || 0) + '</td><td>0</td></tr>';
            html += '<tr><td colspan="6" class="bg-gray text-left">Total de obras consultadas</td><td class="bg-gray">' + formatearNumero(totalObras) + '</td></tr>';
            html += '</table>';

            // Préstamo circulante (ejemplares prestados por área)
            let totalPrestamosEjemplares = 0;
            for (let area in data.prestamosPorArea) {
                totalPrestamosEjemplares += parseInt(data.prestamosPorArea[area]) || 0;
            }
            html += '<div class="report-title">Préstamo circulante</div>';
            html += '<table class="table-report">';
            html += '<tr class="bg-gray"><td colspan="7">Distribución de obras prestadas (ejemplares)</td></tr>';
            html += '<tr class="bg-gray"><th>000</th><th>100</th><th>200</th><th>300</th><th>400</th><th>500</th><th>600</th></tr>';
            html += '<tr><td>' + (data.prestamosPorArea['000'] || 0) + '</td><td>' + (data.prestamosPorArea['100'] || 0) + '</td><td>' + (data.prestamosPorArea['200'] || 0) + '</td><td>' + (data.prestamosPorArea['300'] || 0) + '</td><td>' + (data.prestamosPorArea['400'] || 0) + '</td><td>' + (data.prestamosPorArea['500'] || 0) + '</td><td>' + (data.prestamosPorArea['600'] || 0) + '</td></tr>';
            html += '<tr class="bg-gray"><th>700</th><th>800</th><th>900</th><th>B</th><th>N</th><th>NV</th><th>PV</th></tr>';
            html += '<tr><td>' + (data.prestamosPorArea['700'] || 0) + '</td><td>' + (data.prestamosPorArea['800'] || 0) + '</td><td>' + (data.prestamosPorArea['900'] || 0) + '</td><td>' + (data.prestamosPorArea['Biog'] || 0) + '</td><td>' + (data.prestamosPorArea['N'] || 0) + '</td><td>' + (data.prestamosPorArea['NV'] || 0) + '</td><td>0</td></tr>';
            html += '<tr><td colspan="6" class="bg-gray text-left">Total de préstamos emitidos (transacciones)</td><td class="bg-gray">' + formatearNumero(data.totales.prestamos) + '</td></tr>';
            html += '<tr><td colspan="6" class="bg-gray text-left">Total de ejemplares prestados</td><td class="bg-gray">' + formatearNumero(data.totalEjemplaresPrestados) + '</td></tr>';
            html += '</table>';

            // Actividades y Logros
            html += '<div class="report-title">Actividades y Logros</div>';
            html += '<table class="table-report">';
            html += '<tr class="bg-gray"><td colspan="2">Gestión Realizada</td><td colspan="2">Logros Alcanzados</td></tr>';
            html += '<tr><td class="text-left">Talleres/Charlas</td><td>' + formatearNumero(data.actividades.talleresCharlas) + '</td><td class="text-left">Total Logros</td><td>' + formatearNumero(data.logros) + '</td></tr>';
            html += '<tr class="bg-gray"><td class="text-left">TOTAL ACTIVIDADES</td><td>' + formatearNumero(data.actividades.totalActividades) + '</td><td class="text-left"></td><td></td></tr>';
            html += '</table>';

            html += '</div>';
            return html;
        }

        // Generar HTML para reporte por sala específica (sin actividades/logros)
        function generarReportePorSala(data, sala) {
            let nombreSala = '';
            if (sala === 'sala_general') nombreSala = 'Sala General';
            else if (sala === 'sala_referencia') nombreSala = 'Sala de Referencia';
            else if (sala === 'sala_estatal') nombreSala = 'Sala Estatal';
            else if (sala === 'sala_infantil') nombreSala = 'Sala Infantil';

            // Calcular total obras consultadas para esta sala
            let totalObras = 0;
            for (let area in data.consultasPorArea) {
                totalObras += parseInt(data.consultasPorArea[area]) || 0;
            }

            let html = '<div class="report-paper">';
            
            // Distribución demográfica
            html += '<div class="report-title">Estadísticas de Afluencia - ' + nombreSala + '</div>';
            html += '<table class="table-report">';
            html += '<tr class="bg-gray"><td colspan="4">Distribución demográfica</td></tr>';
            html += '<tr class="bg-gray"><th>Género</th><th>Niños</th><th>Adolescentes</th><th>Adultos</th></tr>';
            html += '<tr><td class="bg-gray">Masculinos</td><td>' + formatearNumero(data.demografia.masculinos.ninos) + '</td><td>' + formatearNumero(data.demografia.masculinos.adolescentes) + '</td><td>' + formatearNumero(data.demografia.masculinos.adultos) + '</td></tr>';
            html += '<tr><td class="bg-gray">Femeninos</td><td>' + formatearNumero(data.demografia.femeninos.ninos) + '</td><td>' + formatearNumero(data.demografia.femeninos.adolescentes) + '</td><td>' + formatearNumero(data.demografia.femeninos.adultos) + '</td></tr>';
            html += '</table>';

            // Obras consultadas
            html += '<div class="report-title">Obras consultadas - ' + nombreSala + '</div>';
            html += '<table class="table-report">';
            html += '<tr class="bg-gray"><th>000</th><th>100</th><th>200</th><th>300</th><th>400</th><th>500</th><th>600</th><th>700</th><th>800</th><th>900</th></tr>';
            html += '<tr><td>' + (data.consultasPorArea['000'] || 0) + '</td><td>' + (data.consultasPorArea['100'] || 0) + '</td><td>' + (data.consultasPorArea['200'] || 0) + '</td><td>' + (data.consultasPorArea['300'] || 0) + '</td><td>' + (data.consultasPorArea['400'] || 0) + '</td><td>' + (data.consultasPorArea['500'] || 0) + '</td><td>' + (data.consultasPorArea['600'] || 0) + '</td><td>' + (data.consultasPorArea['700'] || 0) + '</td><td>' + (data.consultasPorArea['800'] || 0) + '</td><td>' + (data.consultasPorArea['900'] || 0) + '</td></tr>';
            html += '<tr><td colspan="9" class="bg-gray text-left">Total de obras consultadas</td><td class="bg-gray">' + formatearNumero(totalObras) + '</td></tr>';
            html += '</table>';

            // Préstamo circulante (ejemplares)
            let totalPrestamosEjemplares = 0;
            for (let area in data.prestamosPorArea) {
                totalPrestamosEjemplares += parseInt(data.prestamosPorArea[area]) || 0;
            }
            html += '<div class="report-title">Préstamo circulante - ' + nombreSala + '</div>';
            html += '<table class="table-report">';
            html += '<tr class="bg-gray"><td colspan="7">Distribución de obras prestadas (ejemplares)</td></tr>';
            html += '<tr class="bg-gray"><th>000</th><th>100</th><th>200</th><th>300</th><th>400</th><th>500</th><th>600</th></tr>';
            html += '<tr><td>' + (data.prestamosPorArea['000'] || 0) + '</td><td>' + (data.prestamosPorArea['100'] || 0) + '</td><td>' + (data.prestamosPorArea['200'] || 0) + '</td><td>' + (data.prestamosPorArea['300'] || 0) + '</td><td>' + (data.prestamosPorArea['400'] || 0) + '</td><td>' + (data.prestamosPorArea['500'] || 0) + '</td><td>' + (data.prestamosPorArea['600'] || 0) + '</td></tr>';
            html += '<tr class="bg-gray"><th>700</th><th>800</th><th>900</th><th>B</th><th>N</th><th>NV</th><th>PV</th></tr>';
            html += '<tr><td>' + (data.prestamosPorArea['700'] || 0) + '</td><td>' + (data.prestamosPorArea['800'] || 0) + '</td><td>' + (data.prestamosPorArea['900'] || 0) + '</td><td>' + (data.prestamosPorArea['Biog'] || 0) + '</td><td>' + (data.prestamosPorArea['N'] || 0) + '</td><td>' + (data.prestamosPorArea['NV'] || 0) + '</td><td>0</td></tr>';
            html += '<tr><td colspan="6" class="bg-gray text-left">Total de préstamos emitidos (transacciones)</td><td class="bg-gray">' + formatearNumero(data.totales.prestamos) + '</td></tr>';
            html += '<tr><td colspan="6" class="bg-gray text-left">Total de ejemplares prestados</td><td class="bg-gray">' + formatearNumero(data.totalEjemplaresPrestados) + '</td></tr>';
            html += '</table>';

            html += '</div>';
            return html;
        }

        // Eventos
        $(document).ready(function() {
            // Cuando se abre el modal, cargar datos del período y sala actual
            $('#modalFiltroReporte').on('show.bs.modal', function() {
                cargarReporte(periodoActual, salaActual);
            });

            // Manejar cambio de período
            $('.btn-time-filter').on('click', function() {
                $('.btn-time-filter').removeClass('active');
                $(this).addClass('active');
                periodoActual = $(this).data('value');
                if ($('#modalFiltroReporte').hasClass('in')) {
                    cargarReporte(periodoActual, salaActual);
                }
            });

            // Manejar cambio de pestaña (sala)
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                salaActual = $(e.target).data('sala');
                if ($('#modalFiltroReporte').hasClass('in')) {
                    cargarReporte(periodoActual, salaActual);
                }
            });
        });
    </script>
</body>
</html>