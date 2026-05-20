<!DOCTYPE html>
<html lang="es">

<head>
    <title>Reporte Estadístico Mensual</title>
    <?php include VIEW_PATH . "/component/heat.php" ?>
    <style>
        /* Estilos para imitar el formato oficial de la imagen image_a1247d.png */
        .report-paper {
            background: white;
            padding: 30px;
            border: 1px solid #dcdcdc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            color: #000;
            font-family: 'Arial', sans-serif;
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
        .bg-gray { background-color: #f2f2f2; font-weight: bold; }
        .text-left { text-align: left !important; padding-left: 10px !important; }
        .btn-main-action { margin-top: 30px; }
    </style>
</head>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php" ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php" ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"> Reportes <small>Reporte de Operaciones</small></h1>
            </div>
        </div>

        <!-- 1. TARJETAS ARRIBA -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-3">
                    <div class="panel panel-info text-center">
                        <div class="panel-heading text-uppercase">Consultas</div>
                        <div class="panel-body"><h4><strong>360</strong></h4></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="panel panel-primary text-center">
                        <div class="panel-heading text-uppercase">Préstamos</div>
                        <div class="panel-body"><h4><strong>120</strong></h4></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="panel panel-success text-center">
                        <div class="panel-heading text-uppercase">Actividades</div>
                        <div class="panel-body"><h4><strong>14</strong></h4></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <div class="panel panel-danger text-center">
                        <div class="panel-heading text-uppercase">Logros</div>
                        <div class="panel-body"><h4><strong>5</strong></h4></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. BOTÓN DE ACCIÓN CON NUEVO TEXTO -->
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

    <!-- MODAL CON FILTROS Y PREVISUALIZACIÓN -->
    <div class="modal fade" id="modalFiltroReporte" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="zmdi zmdi-filter-list"></i> Reporte de Operaciones</h4>
                </div>
                
                <form action="procesar_pdf.php" method="GET">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Seleccionar Periodo de Tiempo</label>
                                    <select class="form-control" name="rango-tiempo" required>
                                        <option value="" disabled selected>Elija una opción...</option>
                                        <option value="mes">Mensual (Mes en curso)</option>
                                        <option value="trimestre">Trimestral (Últimos 3 meses)</option>
                                        <option value="anual">Anual (Año actual 2026)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- PREVISUALIZACIÓN BASADA EN IMAGE_A1247D.PNG -->
                        <div class="report-paper">
                            <div class="report-title">Visitantes atendidos</div>
                            <table class="table-report">
                                <tr class="bg-gray">
                                    <td>Sala general</td><td>Sala Estatal</td><td>Sala de Referencia</td><td>Sala infantil</td>
                                </tr>
                                <tr><td>23</td><td>54</td><td>23</td><td>41</td></tr>
                                <tr class="bg-gray"><td colspan="4">Distribución demográfica</td></tr>
                                <tr class="bg-gray"><td>Género</td><td>Niños</td><td>Adolescentes</td><td>Adultos</td></tr>
                                <tr><td class="bg-gray">Masculinos</td><td>23</td><td>13</td><td>76</td></tr>
                                <tr><td class="bg-gray">Femeninos</td><td>34</td><td>12</td><td>32</td></tr>
                            </table>

                            <div class="report-title">Obras consultadas</div>
                            <table class="table-report">
                                <tr class="bg-gray"><td>000</td><td>100</td><td>200</td><td>300</td><td>400</td><td>500</td><td>600</td></tr>
                                <tr><td>15</td><td>20</td><td>5</td><td>40</td><td>10</td><td>30</td><td>25</td></tr>
                                <tr class="bg-gray"><td>700</td><td>800</td><td>900</td><td>B</td><td>N</td><td>NV</td><td>PV</td></tr>
                                <tr><td>12</td><td>80</td><td>40</td><td>20</td><td>35</td><td>15</td><td>13</td></tr>
                                <tr><td colspan="6" class="bg-gray text-left">Total de obras consultadas</td><td class="bg-gray">360</td></tr>
                            </table>

                            <div class="report-title">Préstamo circulante</div>
                            <table class="table-report">
                                <tr class="bg-gray"><td colspan="7">Distribución de obras prestadas</td></tr>
                                <tr class="bg-gray"><td>000</td><td>100</td><td>200</td><td>300</td><td>400</td><td>500</td><td>600</td></tr>
                                <tr><td>5</td><td>10</td><td>2</td><td>15</td><td>5</td><td>12</td><td>8</td></tr>
                                <tr><td colspan="6" class="bg-gray text-left">Total de préstamos emitidos</td><td class="bg-gray">120</td></tr>
                            </table>

                            <div class="report-title">Actividades y Logros</div>
                            <table class="table-report">
                                <tr class="bg-gray"><td colspan="2">Gestión Realizada</td><td colspan="2">Metas Alcanzadas</td></tr>
                                <tr>
                                    <td class="text-left">Talleres/Charlas</td><td>10</td>
                                    <td class="text-left">Meta Visitas</td><td>100%</td>
                                </tr>
                                <tr class="bg-gray">
                                    <td class="text-left">TOTAL ACTIVIDADES</td><td>14</td>
                                    <td class="text-left">TOTAL LOGROS</td><td>5</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger btn-raised">
                            <i class="zmdi zmdi-print"></i> EMITIR PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include VIEW_PATH . "/component/scripts.php" ?>
</body>
</html>