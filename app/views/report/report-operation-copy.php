<!DOCTYPE html>
<html lang="es">

<head>
    <title>Reporte Estadístico Mensual</title>
    <?php include VIEW_PATH . "/component/heat.php" ?>
    <style>
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

        .table-report th,\r
        .table-report td {
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

        /* Ajustes para los botones del filtro de tiempo */
        .time-selector-container {
            margin-bottom: 25px;
        }

        .btn-group .btn.active {
            background-color: #0d6efd !important;
            color: white !important;
            box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
        }

        /* Centrar y dar más altura al contenedor de las pestañas */
        .nav-tabs {
            border-radius: 5px;
            display: flex;
            justify-content: center; 
            align-items: center;     
            padding: 10px 0;         
            border-bottom: none;     
        }

        /* Aplicar el borde de 1px a cada botón de la lista */
        .nav-tabs>li>a {
            border: 1px solid #00000062 !important; 
            margin: 0 5px;                         
            border-radius: 4px;                    
            background-color: #fff;
            color: #333;
        }

        /* Estilo cuando el botón está activo (seleccionado) */
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
                <h1 class="text-titles"> Reporte de Operaciones</small></h1>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-3">
                    <div class="panel panel-info text-center">
                        <div class="panel-heading text-uppercase">Consultas</div>
                        <div class="panel-body">
                            <h4><strong>360</strong></h4>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="panel panel-primary text-center">
                        <div class="panel-heading text-uppercase">Préstamos</div>
                        <div class="panel-body">
                            <h4><strong>120</strong></h4>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="panel panel-success text-center">
                        <div class="panel-heading text-uppercase">Actividades</div>
                        <div class="panel-body">
                            <h4><strong>14</strong></h4>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="panel panel-danger text-center">
                        <div class="panel-heading text-uppercase">Logros</div>
                        <div class="panel-body">
                            <h4><strong>5</strong></h4>
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

    <div class="modal fade" id="modalFiltroReporte" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="zmdi zmdi-filter-list"></i> Reporte de Operaciones</h4>
                </div>

                <form action="procesar_pdf.php" method="GET">
                    <input type="hidden" name="rango-tiempo" id="rango-tiempo-input" value="mes">
                    <input type="hidden" name="sala" id="sala-input" value="general">

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

                        <div class="tab-content">

                            <!-- TAB 1: GENERAL -->
                            <div role="tabpanel" class="tab-pane active" id="general">
                                <div class="report-paper">
                                    <div class="report-title">Visitantes atendidos - Reporte Institucional General</div>
                                    <table class="table-report">
                                        <tr class="bg-gray">
                                            <td>Sala general</td>
                                            <td>Sala Estatal</td>
                                            <td>Sala de Referencia</td>
                                            <td>Sala infantil</td>
                                        </tr>
                                        <tr>
                                            <td>23</td>
                                            <td>54</td>
                                            <td>23</td>
                                            <td>41</td>
                                        </tr>
                                        <tr class="bg-gray">
                                            <td colspan="4">Distribución demográfica</td>
                                        </tr>
                                        <tr class="bg-gray">
                                            <td>Género</td>
                                            <td>Niños</td>
                                            <td>Adolescentes</td>
                                            <td>Adultos</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-gray">Masculinos</td>
                                            <td>23</td>
                                            <td>13</td>
                                            <td>76</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-gray">Femeninos</td>
                                            <td>34</td>
                                            <td>12</td>
                                            <td>32</td>
                                        </tr>
                                    </table>

                                    <div class="report-title">Obras consultadas</div>
                                    <table class="table-report">
                                        <tr class="bg-gray">
                                            <td>000</td>
                                            <td>100</td>
                                            <td>200</td>
                                            <td>300</td>
                                            <td>400</td>
                                            <td>500</td>
                                            <td>600</td>
                                        </tr>
                                        <tr>
                                            <td>15</td>
                                            <td>20</td>
                                            <td>5</td>
                                            <td>40</td>
                                            <td>10</td>
                                            <td>30</td>
                                            <td>25</td>
                                        </tr>
                                        <tr class="bg-gray">
                                            <td>700</td>
                                            <td>800</td>
                                            <td>900</td>
                                            <td>B</td>
                                            <td>N</td>
                                            <td>NV</td>
                                            <td>PV</td>
                                        </tr>
                                        <tr>
                                            <td>12</td>
                                            <td>80</td>
                                            <td>40</td>
                                            <td>20</td>
                                            <td>35</td>
                                            <td>15</td>
                                            <td>13</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="bg-gray text-left">Total de obras consultadas</td>
                                            <td class="bg-gray">360</td>
                                        </tr>
                                    </table>

                                    <div class="report-title">Préstamo circulante</div>
                                    <table class="table-report">
                                        <tr class="bg-gray">
                                            <td colspan="7">Distribución de obras prestadas</td>
                                        </tr>
                                        <tr class="bg-gray">
                                            <td>000</td>
                                            <td>100</td>
                                            <td>200</td>
                                            <td>300</td>
                                            <td>400</td>
                                            <td>500</td>
                                            <td>600</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>10</td>
                                            <td>2</td>
                                            <td>15</td>
                                            <td>5</td>
                                            <td>12</td>
                                            <td>8</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="bg-gray text-left">Total de préstamos emitidos</td>
                                            <td class="bg-gray">120</td>
                                        </tr>
                                    </table>

                                    <div class="report-title">Actividades y Logros</div>
                                    <table class="table-report">
                                        <tr class="bg-gray">
                                            <td colspan="2">Gestión Realizada</td>
                                            <td colspan="2">Metas Alcanzadas</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">Talleres/Charlas</td>
                                            <td>10</td>
                                            <td class="text-left">Meta Visitas</td>
                                            <td>100%</td>
                                        </tr>
                                        <tr class="bg-gray">
                                            <td class="text-left">TOTAL ACTIVIDADES</td>
                                            <td>14</td>
                                            <td class="text-left">TOTAL LOGROS</td>
                                            <td>5</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- TAB 2: SALS GENERAL -->
                            <div role="tabpanel" class="tab-pane" id="sala-general">
                                <div class="report-paper">
                                    <div class="report-title">Estadísticas de Afluencia - Sala General</div>
                                    <table class="table-report">
                                        <tr class="bg-gray">
                                            <td colspan="4">Distribución demográfica</td>
                                        </tr>
                                        <tr class="bg-gray">
                                            <td>Género</td>
                                            <td>Niños</td>
                                            <td>Adolescentes</td>
                                            <td>Adultos</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-gray">Masculinos</td>
                                            <td>5</td>
                                            <td>8</td>
                                            <td>45</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-gray">Femeninos</td>
                                            <td>10</td>
                                            <td>4</td>
                                            <td>20</td>
                                        </tr>
                                    </table>
                                    
                                    <div class="report-title">Obras consultadas - Sala General</div>
                                    <table class="table-report">
                                        <tr class="bg-gray">
                                            <td>000</td>
                                            <td>100</td>
                                            <td>200</td>
                                            <td>300</td>
                                            <td>400</td>
                                            <td>500</td>
                                            <td>600</td>
                                            <td>700</td>
                                            <td>800</td>
                                            <td>900</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>5</td>
                                            <td>1</td>
                                            <td>12</td>
                                            <td>3</td>
                                            <td>8</td>
                                            <td>4</td>
                                            <td>2</td>
                                            <td>20</td>
                                            <td>10</td>
                                        </tr>
                                    </table>

                                    <div class="report-title">Préstamo circulante - Sala General</div>
                                    <table class="table-report">
                                        <tr class="bg-gray">
                                            <td colspan="7">Distribución de obras prestadas</td>
                                        </tr>
                                        <tr class="bg-gray">
                                            <td>000</td>
                                            <td>100</td>
                                            <td>200</td>
                                            <td>300</td>
                                            <td>400</td>
                                            <td>500</td>
                                            <td>600</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>4</td>
                                            <td>1</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td>5</td>
                                            <td>3</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="bg-gray text-left">Total de préstamos emitidos</td>
                                            <td class="bg-gray">25</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- TAB 3: SALA DE REFERENCIA -->
                            <div role="tabpanel" class="tab-pane" id="sala-referencia">
                                <div class="report-paper">
                                    <div class="report-title">Estadísticas de Afluencia - Sala de Referencia</div>
                                    <table class="table-report">
                                        <tr class="bg-gray">
                                            <td colspan="4">Distribución demográfica</td>
                                        </tr>
                                        <tr class="bg-gray">
                                            <td>Género</td>
                                            <td>Niños</td>
                                            <td>Adolescentes</td>
                                            <td>Adultos</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-gray">Masculinos</td>
                                            <td>0</td>
                                            <td>2</td>
                                            <td>30</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-gray">Femeninos</td>
                                            <td>0</td>
                                            <td>3</td>
                                            <td>25</td>
                                        </tr>
                                    </table>

                                    <div class="report-title">Obras consultadas - Sala de Referencia</div>
                                    <table class="table-report">
                                        <tr class="bg-gray">
                                            <td>000</td>
                                            <td>100</td>
                                            <td>200</td>
                                            <td>300</td>
                                            <td>400</td>
                                            <td>500</td>
                                            <td>600</td>
                                            <td>700</td>
                                            <td>800</td>
                                            <td>900</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>12</td>
                                            <td>4</td>
                                            <td>18</td>
                                            <td>2</td>
                                            <td>9</td>
                                            <td>11</td>
                                            <td>3</td>
                                            <td>15</td>
                                            <td>7</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- TAB 4: SALA ESTATAL -->
                            <div role="tabpanel" class="tab-pane" id="sala-estatal">
                                <div class="report-paper">
                                    <div class="report-title">Estadísticas de Afluencia - Sala Estatal</div>
                                    <table class="table-report">
                                        <tr class="bg-gray">
                                            <td colspan="4">Distribución demográfica</td>
                                        </tr>
                                        <tr class="bg-gray">
                                            <td>Género</td>
                                            <td>Niños</td>
                                            <td>Adolescentes</td>
                                            <td>Adultos</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-gray">Masculinos</td>
                                            <td>2</td>
                                            <td>5</td>
                                            <td>60</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-gray">Femeninos</td>
                                            <td>4</td>
                                            <td>8</td>
                                            <td>42</td>
                                        </tr>
                                    </table>

                                    <div class="report-title">Obras consultadas - Sala Estatal</div>
                                    <table class="table-report">
                                        <tr class="bg-gray">
                                            <td>000</td>
                                            <td>100</td>
                                            <td>200</td>
                                            <td>300</td>
                                            <td>400</td>
                                            <td>500</td>
                                            <td>600</td>
                                            <td>700</td>
                                            <td>800</td>
                                            <td>900</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>3</td>
                                            <td>0</td>
                                            <td>22</td>
                                            <td>1</td>
                                            <td>4</td>
                                            <td>8</td>
                                            <td>14</td>
                                            <td>9</td>
                                            <td>35</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- TAB 5: SALA INFANTIL -->
                            <div role="tabpanel" class="tab-pane" id="sala-infantil">
                                <div class="report-paper">
                                    <div class="report-title">Estadísticas de Afluencia - Sala Infantil</div>
                                    <table class="table-report">
                                        <tr class="bg-gray">
                                            <td colspan="4">Distribución demográfica</td>
                                        </tr>
                                        <tr class="bg-gray">
                                            <td>Género</td>
                                            <td>Niños</td>
                                            <td>Adolescentes</td>
                                            <td>Adultos (Representantes)</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-gray">Masculinos</td>
                                            <td>20</td>
                                            <td>1</td>
                                            <td>5</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-gray">Femeninos</td>
                                            <td>25</td>
                                            <td>2</td>
                                            <td>8</td>
                                        </tr>
                                    </table>

                                    <div class="report-title">Obras consultadas - Sala Infantil</div>
                                    <table class="table-report">
                                        <tr class="bg-gray">
                                            <td>000</td>
                                            <td>100</td>
                                            <td>200</td>
                                            <td>300</td>
                                            <td>400</td>
                                            <td>500</td>
                                            <td>600</td>
                                            <td>700</td>
                                            <td>800</td>
                                            <td>900</td>
                                        </tr>
                                        <tr>
                                            <td>12</td>
                                            <td>4</td>
                                            <td>15</td>
                                            <td>8</td>
                                            <td>34</td>
                                            <td>6</td>
                                            <td>2</td>
                                            <td>20</td>
                                            <td>45</td>
                                            <td>3</td>
                                        </tr>
                                    </table>

                                    <div class="report-title">Préstamo circulante - Sala Infantil</div>
                                    <table class="table-report">
                                        <tr class="bg-gray">
                                            <td colspan="7">Distribución de obras prestadas</td>
                                        </tr>
                                        <tr class="bg-gray">
                                            <td>000</td>
                                            <td>100</td>
                                            <td>200</td>
                                            <td>300</td>
                                            <td>400</td>
                                            <td>500</td>
                                            <td>600</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>1</td>
                                            <td>3</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>2</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="bg-gray text-left">Total de préstamos emitidos</td>
                                            <td class="bg-gray">14</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" onclick="descargarPDF($('#sala-input').val())" class="btn btn-danger btn-raised">
                            <i class="zmdi zmdi-print"></i> EMITIR PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include VIEW_PATH . "/component/scripts.php" ?>
    <script src="<?= PUBLIC_PATH ?>/js/pdf-generator.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/html2canvas.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jsPDF.js"></script>
    <script src="<?= PUBLIC_PATH ?>/js/pdf/jspdf-autotable.js"></script>

    <script>
        $(document).ready(function() {
            $('.btn-time-filter').on('click', function() {
                $('.btn-time-filter').removeClass('active');
                $(this).addClass('active');

                var valorTiempo = $(this).data('value');
                $('#rango-tiempo-input').val(valorTiempo);
            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var salaSeleccionada = $(e.target).data('sala');
                $('#sala-input').val(salaSeleccionada);
            });
        });
    </script>
</body>

</html>