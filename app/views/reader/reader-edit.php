<!DOCTYPE html>
<html lang="es">

<head>
    <title>Editar Lector</title>
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

        /* Alineación Perfecta de Cédula en una sola línea */
        .cedula-group {
            display: flex;
            align-items: flex-end; /* Fuerza la coincidencia en el borde inferior */
            gap: 10px;
        }

        .cedula-group .select-nacionalidad {
            width: 20% !important;
            border: none !important;
            border-bottom: 1px solid #d2d2d2 !important;
            padding-bottom: 5px;
            background: transparent;
            height: 35px !important;
        }

        .cedula-group .input-cedula-main {
            width: 80% !important;
            height: 35px !important;
        }

        .form-group input:disabled,
        .form-group select:disabled {
            pointer-events: none;
            cursor: not-allowed;
        }

        .form-group {
            pointer-events: auto;
        }

        /* Si el label está DESPUÉS del input en el HTML */
        .is-invalid~label,
        .is-invalid+label {
            color: #dc3545 !important;
        }

        /* Estructura tradicional donde el label está ANTES del input con pseudo-clase :has() */
        .mb-3:has(.is-invalid) label,
        .form-group:has(.is-invalid) label {
            color: #dc3545 !important;
        }
    </style>
</head>

<body>
    <?php include VIEW_PATH . "/component/sidebar.php" ?>

    <section class="full-box dashboard-contentPage">
        <?php include VIEW_PATH . "/component/navbar.php" ?>

        <div class="container-fluid">
            <div class="page-header">
                <h1 class="text-titles"> <i class="fa-solid fa-user-pen"></i> Editar Lector</h1>
            </div>
        </div>
        <?php include VIEW_PATH . "/component/readerbar.php" ?>

        <?php
        // Función para teléfonos
        function limpiarYSepararTelefono($telRaw) {
            $telRaw = trim($telRaw ?? '');
            $telRaw = str_replace('-', '', $telRaw);

            if (empty($telRaw)) {
                return ['pref' => '0414', 'num' => ''];
            }
            
            if (strlen($telRaw) >= 11) {
                return [
                    'pref' => substr($telRaw, 0, 4),
                    'num'  => substr($telRaw, 4)
                ];
            }
            
            return ['pref' => '0414', 'num' => $telRaw];
        }

        // NUEVA FUNCIÓN: Separa la nacionalidad (V- / E-) del número de cédula para la edición
        function separarCedula($cedulaRaw) {
            $cedulaRaw = trim($cedulaRaw ?? '');
            
            if (strpos($cedulaRaw, 'E-') === 0) {
                return [
                    'pref' => 'E-',
                    'num' => substr($cedulaRaw, 2)
                ];
            }
            
            // Por defecto asumimos Venezolano si empieza por V- o si es solo número
            if (strpos($cedulaRaw, 'V-') === 0) {
                return [
                    'pref' => 'V-',
                    'num' => substr($cedulaRaw, 2)
                ];
            }
            
            return ['pref' => 'V-', 'num' => $cedulaRaw];
        }
        ?>

        <div class="container-fluid">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title"> MODIFICAR DATOS DEL LECTOR</h3>
                </div>
                <div class="panel-body">
                    <form action="<?= BASE_URL ?>/lectores/update" method="POST" id="form-registro-lector">

                        <input type="hidden" name="id" value="<?php echo $lector->getIdLector(); ?>">

                        <fieldset>
                            <legend> &nbsp; Información personal</legend>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="carnet-reg"><span class="text-danger">*</span> N° de Carnet</label>
                                            <input class="form-control" type="text" name="carnet" id="carnet-reg" value="<?php echo $lector->getCarnet(); ?>" data-original="<?php echo $lector->getCarnet(); ?>" required>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="carnet-error"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="cedula-reg"><span class="text-danger">*</span> Cédula</label>
                                            
                                            <div class="cedula-group">
                                                <?php 
                                                    $cedData = separarCedula($lector->getPersona()->getCedula());
                                                    $prefCed = $cedData['pref'];
                                                    $numCed = $cedData['num'];
                                                ?>
                                                <select class="form-control select-nacionalidad" id="prefijo-cedula">
                                                    <option value="V-" <?php if($prefCed == 'V-') echo 'selected'; ?>>V-</option>
                                                    <option value="E-" <?php if($prefCed == 'E-') echo 'selected'; ?>>E-</option>
                                                </select>
                                                <input class="form-control input-cedula-main" type="text" id="cedula-reg" value="<?php echo $numCed; ?>" data-original="<?php echo $numCed; ?>" required maxlength="8" placeholder="12345678">
                                            </div>

                                            <input type="hidden" name="cedula" id="cedula-final" value="<?php echo $lector->getPersona()->getCedula(); ?>" data-original="<?php echo $lector->getPersona()->getCedula(); ?>">
                                            
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="cedula-error"></div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="nombre-reg"><span class="text-danger">*</span> Nombres</label>
                                            <input class="form-control" type="text" name="nombre-reg" id="nombre-reg" value="<?php echo $lector->getPersona()->getNombre(); ?>" data-original="<?php echo $lector->getPersona()->getNombre(); ?>" required>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="nombre-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="apellido-reg"><span class="text-danger">*</span> Apellidos</label>
                                            <input class="form-control" type="text" name="apellido-reg" id="apellido-reg" value="<?php echo $lector->getPersona()->getApellido(); ?>" data-original="<?php echo $lector->getPersona()->getApellido(); ?>" required>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="apellido-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="sexo-reg"><span class="text-danger">*</span> Sexo</label>
                                            <select class="form-control" name="sexo" id="sexo-reg" data-original="<?php echo strtolower($lector->getSexo()); ?>" required>
                                                <option value="m" <?php if (strtolower($lector->getSexo()) == 'm') echo 'selected'; ?>>Masculino</option>
                                                <option value="f" <?php if (strtolower($lector->getSexo()) == 'f') echo 'selected'; ?>>Femenino</option>
                                            </select>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="sexo-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="direccion-reg"><span class="text-danger">*</span> Dirección</label>
                                            <input class="form-control" type="text" name="direccion" id="direccion-reg" value="<?php echo $lector->getDireccion(); ?>" data-original="<?php echo $lector->getDireccion(); ?>" required>
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="direccion-error"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label"><span class="text-danger">*</span> Teléfono Personal</label>
                                            <div class="phone-group">
                                                <?php 
                                                    $telPersData = limpiarYSepararTelefono($lector->getPersona()->getTelefono());
                                                    $prefPers = $telPersData['pref'];
                                                    $numPers = $telPersData['num'];
                                                    $telPersOriginalLimpio = $prefPers . $numPers;
                                                ?>
                                                <select class="form-control select-prefix" id="pref-reg">
                                                    <option value="0414" <?php if($prefPers == '0414') echo 'selected'; ?>>0414</option>
                                                    <option value="0424" <?php if($prefPers == '0424') echo 'selected'; ?>>0424</option>
                                                    <option value="0416" <?php if($prefPers == '0416') echo 'selected'; ?>>0416</option>
                                                    <option value="0426" <?php if($prefPers == '0426') echo 'selected'; ?>>0426</option>
                                                    <option value="0412" <?php if($prefPers == '0412') echo 'selected'; ?>>0412</option>
                                                    <option value="0422" <?php if($prefPers == '0422') echo 'selected'; ?>>0422</option>
                                                </select>
                                                <input type="text" class="form-control input-number-main" id="num-reg" maxlength="7" placeholder="1234567" value="<?php echo $numPers; ?>" required>
                                            </div>
                                            <input type="hidden" name="telefono-reg" id="telefono-reg" value="<?php echo $telPersOriginalLimpio; ?>" data-original="<?php echo $telPersOriginalLimpio; ?>">
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
                                            <input class="form-control" type="text" name="profesion-reg" id="profesion-reg" value="<?php echo $lector->getProfesion(); ?>" data-original="<?php echo $lector->getProfesion(); ?>">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="profesion-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="direccion-profesion-reg">Dirección Laboral</label>
                                            <input class="form-control" type="text" name="direccion-profesion-reg" id="direccion-profesion-reg" value="<?php echo $lector->getDireccionProfesion(); ?>" data-original="<?php echo $lector->getDireccionProfesion(); ?>">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="direccion-profesion-error"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Teléfono Profesión</label>
                                            <div class="phone-group">
                                                <?php 
                                                    $telProfData = limpiarYSepararTelefono($lector->getTelefonoProfesion());
                                                    $prefProf = $telProfData['pref'];
                                                    $numProf = $telProfData['num'];
                                                    $telProfOriginalLimpio = !empty($numProf) ? $prefProf . $numProf : "";
                                                ?>
                                                <select class="form-control select-prefix" id="pref-prof">
                                                    <option value="0414" <?php if($prefProf == '0414') echo 'selected'; ?>>0414</option>
                                                    <option value="0424" <?php if($prefProf == '0424') echo 'selected'; ?>>0424</option>
                                                    <option value="0416" <?php if($prefProf == '0416') echo 'selected'; ?>>0416</option>
                                                    <option value="0426" <?php if($prefProf == '0426') echo 'selected'; ?>>0426</option>
                                                    <option value="0412" <?php if($prefProf == '0412') echo 'selected'; ?>>0412</option>
                                                    <option value="0422" <?php if($prefProf == '0422') echo 'selected'; ?>>0422</option>
                                                </select>
                                                <input type="text" class="form-control input-number-main" id="num-prof" maxlength="7" value="<?php echo $numProf; ?>">
                                            </div>
                                            <input type="hidden" name="telefono-profesion-reg" id="telefono-profesion-reg" value="<?php echo $telProfOriginalLimpio; ?>" data-original="<?php echo $telProfOriginalLimpio; ?>">
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
                                            <input class="form-control" type="text" name="refLegal" id="referencia-legal-personal-reg" value="<?php echo $lector->getRefLegal(); ?>" data-original="<?php echo $lector->getRefLegal(); ?>">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="referencia-legal-personal-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group label-floating">
                                            <label class="control-label" for="referencia-personal-reg">Referencia Personal</label>
                                            <input class="form-control" type="text" name="refPersonal" id="referencia-personal-reg" value="<?php echo $lector->getRefPersonal(); ?>" data-original="<?php echo $lector->getRefPersonal(); ?>">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="referencia-personal-error"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Teléfono Ref. Legal</label>
                                            <div class="phone-group">
                                                <?php 
                                                    $telRefLData = limpiarYSepararTelefono($lector->getRefLegalTel());
                                                    $prefRefL = $telRefLData['pref'];
                                                    $numRefL = $telRefLData['num'];
                                                    $telRefLOriginalLimpio = !empty($numRefL) ? $prefRefL . $numRefL : "";
                                                ?>
                                                <select class="form-control select-prefix" id="pref-ref-l">
                                                    <option value="0414" <?php if($prefRefL == '0414') echo 'selected'; ?>>0414</option>
                                                    <option value="0424" <?php if($prefRefL == '0424') echo 'selected'; ?>>0424</option>
                                                    <option value="0416" <?php if($prefRefL == '0416') echo 'selected'; ?>>0416</option>
                                                    <option value="0426" <?php if($prefRefL == '0426') echo 'selected'; ?>>0426</option>
                                                    <option value="0412" <?php if($prefRefL == '0412') echo 'selected'; ?>>0412</option>
                                                    <option value="0422" <?php if($prefRefL == '0422') echo 'selected'; ?>>0422</option>
                                                </select>
                                                <input type="text" class="form-control input-number-main" id="num-ref-l" maxlength="7" value="<?php echo $numRefL; ?>">
                                            </div>
                                            <input type="hidden" name="refLegalTel" id="telefono-ref-legal-reg" value="<?php echo $telRefLOriginalLimpio; ?>" data-original="<?php echo $telRefLOriginalLimpio; ?>">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-ref-legal-error"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-12 col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">Teléfono Ref. Personal</label>
                                            <div class="phone-group">
                                                <?php 
                                                    $telRefPData = limpiarYSepararTelefono($lector->getRefPersonalTel());
                                                    $prefRefP = $telRefPData['pref'];
                                                    $numRefP = $telRefPData['num'];
                                                    $telRefPOriginalLimpio = !empty($numRefP) ? $prefRefP . $numRefP : "";
                                                ?>
                                                <select class="form-control select-prefix" id="pref-ref-p">
                                                    <option value="0414" <?php if($prefRefP == '0414') echo 'selected'; ?>>0414</option>
                                                    <option value="0424" <?php if($prefRefP == '0424') echo 'selected'; ?>>0424</option>
                                                    <option value="0416" <?php if($prefRefP == '0416') echo 'selected'; ?>>0416</option>
                                                    <option value="0426" <?php if($prefRefP == '0426') echo 'selected'; ?>>0426</option>
                                                    <option value="0412" <?php if($prefRefP == '0412') echo 'selected'; ?>>0412</option>
                                                    <option value="0422" <?php if($prefRefP == '0422') echo 'selected'; ?>>0422</option>
                                                </select>
                                                <input type="text" class="form-control input-number-main" id="num-ref-p" maxlength="7" value="<?php echo $numRefP; ?>">
                                            </div>
                                            <input type="hidden" name="refPersonalTel" id="telefono-ref-personal-reg" value="<?php echo $telRefPOriginalLimpio; ?>" data-original="<?php echo $telRefPOriginalLimpio; ?>">
                                            <div class="invalid-feedback bg-danger text-danger rounded-pill" id="telefono-ref-personal-error"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <p class="text-center" style="margin-top: 20px;">
                            <a href="<?= BASE_URL ?>/lectores" class="btn btn-secondary btn-raised">
                                <i class="fa-solid fa-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-info btn-raised">Actualizar Cambios</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    
    <?php include VIEW_PATH . "/modal/confirmation-reader-edit.php" ?>
    <?php include VIEW_PATH . "/component/scripts.php" ?>
    
    <script src="<?= PUBLIC_PATH ?>/js/validations/reader/createvalidation.js"></script>
</body>
</html>