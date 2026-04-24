<!DOCTYPE html>
<html lang="es">
<head>
    <title>Lectores</title>
    <?php include VIEW_PATH . "/component/heat.php" ?>
    <style>
        /* Alineación de teléfonos en una sola línea */
        .phone-group {
            display: flex;
            align-items: center;
        }
        .phone-group .select-prefix {
            width: 35% !important;
            margin-right: 5px;
        }
        .phone-group .input-number-main {
            width: 65% !important;
        }
    </style>
</head>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php" ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php" ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"> <i class="fa-solid fa-book-open-reader"></i> Lectores <small> Nuevo Lector</small></h1>
            </div>
        </div>
        <?php include VIEW_PATH . "/component/readerbar.php" ?>

        <div class="container-fluid">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"> REGISTRAR LECTOR</h3>
                </div>
                <div class="panel-body">
                    <form action="<?= BASE_URL ?>/lectores/store" method="POST" id="form-registro-lector">
                        
                        <fieldset>
                            <legend> &nbsp; Información personal</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="carnet-reg"><span class="text-danger">*</span> N° de Carnet</label>
                                            <input class="form-control" type="text" name="carnet-reg" id="carnet-reg" value="<?= htmlspecialchars($old['carnet-reg'] ?? '') ?>" required>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="carnet-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="cedula-reg"><span class="text-danger">*</span> Cédula </label>
                                            <input class="form-control" type="text" name="cedula" id="cedula-reg" value="<?= htmlspecialchars($old['cedula'] ?? '') ?>" required maxlength="8">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="cedula-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="nombre-reg"><span class="text-danger">*</span> Nombres </label>
                                            <input class="form-control" type="text" name="nombre-reg" id="nombre-reg" value="<?= htmlspecialchars($old['nombre-reg'] ?? '') ?>" required>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="nombre-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="apellido-reg"><span class="text-danger">*</span> Apellidos </label>
                                            <input class="form-control" type="text" name="apellido-reg" id="apellido-reg" value="<?= htmlspecialchars($old['apellido-reg'] ?? '') ?>" required>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="apellido-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="sexo-reg"><span class="text-danger">*</span> Sexo</label>
                                            <select class="form-control" name="sexo-reg" id="sexo-reg" required>
                                                <option value="" disabled <?php if (!isset($old['sexo-reg'])) echo 'selected'; ?>>Seleccione el sexo</option>
                                                <option value="M" <?php if (isset($old['sexo-reg']) && $old['sexo-reg'] == 'M') echo 'selected'; ?>>Masculino</option>
                                                <option value="F" <?php if (isset($old['sexo-reg']) && $old['sexo-reg'] == 'F') echo 'selected'; ?>>Femenino</option>
                                            </select>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="sexo-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="direccion-reg"><span class="text-danger">*</span> Dirección </label>
                                            <input class="form-control" type="text" name="direccion-reg" id="direccion-reg" value="<?= htmlspecialchars($old['direccion-reg'] ?? '') ?>" required>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pillbg-danger text-danger rounded-pill" id="direccion-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-danger">*</span> Teléfono Personal</label>
                                            <div class="phone-group">
                                                <select class="form-control select-prefix" id="pref-reg">
                                                    <option value="0414">0414</option>
                                                    <option value="0424">0424</option>
                                                    <option value="0412">0412</option>
                                                    <option value="0416">0416</option>
                                                    <option value="0426">0426</option>
                                                </select>
                                                <input type="text" class="form-control input-number-main" id="num-reg" maxlength="7" placeholder="1234567" required>
                                            </div>
                                            <input type="hidden" name="telefono-reg" id="telefono-reg">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-error"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <br>

                        <fieldset>
                            <legend> &nbsp; Información Laboral (Opcional)</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="profesion-reg">Profesión</label>
                                            <input class="form-control" type="text" name="profesion-reg" id="profesion-reg">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="profesion-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="direccion-profesion-reg">Dirección Laboral</label>
                                            <input class="form-control" type="text" name="direccion-profesion-reg" id="direccion-profesion-reg">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="direccion-profesion-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Teléfono Profesión</label>
                                            <div class="phone-group">
                                                <select class="form-control select-prefix" id="pref-prof">
                                                    <option value="0414">0414</option>
                                                    <option value="0424">0424</option>
                                                    <option value="0412">0412</option>
                                                    <option value="0416">0416</option>
                                                    <option value="0426">0426</option>
                                                </select>
                                                <input type="text" class="form-control input-number-main" id="num-prof" maxlength="7">
                                            </div>
                                            <input type="hidden" name="telefono-profesion-reg" id="telefono-profesion-reg">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-profesion-error"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <br>

                        <fieldset>
                            <legend> &nbsp; Referencias (Opcional)</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="referencia-legal-personal-reg">Referencia Legal</label>
                                            <input class="form-control" type="text" name="ref-legal-reg" id="referencia-legal-personal-reg">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="referencia-legal-personal-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="referencia-personal-reg">Referencia Personal</label>
                                            <input class="form-control" type="text" name="ref-personal-reg" id="referencia-personal-reg">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="referencia-personal-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Teléfono Ref. Legal</label>
                                            <div class="phone-group">
                                                <select class="form-control select-prefix" id="pref-ref-l">
                                                    <option value="0414">0414</option>
                                                    <option value="0424">0424</option>
                                                    <option value="0412">0412</option>
                                                    <option value="0416">0416</option>
                                                    <option value="0426">0426</option>
                                                </select>
                                                <input type="text" class="form-control input-number-main" id="num-ref-l" maxlength="7">
                                            </div>
                                            <input type="hidden" name="telefono-ref-legal-reg" id="telefono-referencia-legal-reg">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-referencia-legal-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Teléfono Ref. Personal</label>
                                            <div class="phone-group">
                                                <select class="form-control select-prefix" id="pref-ref-p">
                                                    <option value="0414">0414</option>
                                                    <option value="0424">0424</option>
                                                    <option value="0412">0412</option>
                                                    <option value="0416">0416</option>
                                                    <option value="0426">0426</option>
                                                </select>
                                                <input type="text" class="form-control input-number-main" id="num-ref-p" maxlength="7">
                                            </div>
                                            <input type="hidden" name="telefono-ref-personal-reg" id="telefono-referencia-personal-reg">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-referencia-personal-error"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <p class="text-center" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-success btn-raised btn-sm"> Guardar</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include VIEW_PATH . "/component/scripts.php" ?>
    <script src="<?= PUBLIC_PATH ?>/js/validations/reader/createvalidation.js"></script>
</body>
</html>