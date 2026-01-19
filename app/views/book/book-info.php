<!DOCTYPE html>
<html lang="es">

	<title>Info Libro</title>
	<!-- SideBar -->
	<?php include VIEW_PATH . '/component/heat.php'; ?>
<body>
	<!-- SideBar -->
	<?php include VIEW_PATH . '/component/sidebar.php'; ?>

	<!-- Content page-->
	<section class="full-box dashboard-contentPage">
		<!-- NavBar -->
		
	<?php include VIEW_PATH . '/component/navbar.php'; ?>
		
		<!-- Content page -->
		<div class="container-fluid">
    <div class="page-header">
      <h1 class="text-titles"><i class="zmdi zmdi-book zmdi-hc-fw"></i> INFORMACIÓN LIBRO</small></h1>
    </div>
</div>

<div class="container-fluid">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-info"></i> &nbsp; <?= htmlspecialchars($libro->getTitulo()) ?></h3>
        </div>
        <div class="panel-body">
            
            <fieldset>
                <legend><i class="zmdi zmdi-library"></i> &nbsp; Información del Libro</legend>
                <div class="container-fluid" style="font-size: 1.1em;">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Cota:</strong> <?= htmlspecialchars($libro->getCota()) ?></p>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Título:</strong> <?= htmlspecialchars($libro->getTitulo()) ?></p>
                        </div>
                        <div class ="col-xs-12 col-sm-6">
                            <p><strong> Autor: </strong> <?php if (!empty($libro->getAutores())): ?>
                                
                                    <?php foreach ($libro->getAutores() as $autor): ?>
                                        </i> <?= htmlspecialchars($autor->getNombre()) ?>
                                    <?php endforeach; ?>
                                
                            <?php else: ?>
                                <p>No hay autores registrados.</p>
                            <?php endif; ?></p>
                        </div>
                        <div class= "col-xs-12 col-sm-6">    </div>
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>ISBN:</strong> <?= htmlspecialchars($libro->getIsbn() ?? 'N/A') ?></p>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Año:</strong> <?= htmlspecialchars($libro->getAnioPublicacion() ?? 'Sin dato') ?></p>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Páginas:</strong> <?= htmlspecialchars($libro->getPaginas() ?? '0') ?></p>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Edición:</strong> <?= htmlspecialchars($libro->getEdicion() ?? 'N/A') ?></p>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Editorial:</strong> <?= $libro->getEditorial() ? htmlspecialchars($libro->getEditorial()->getNombre()) : 'Sin Editorial' ?></p>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Ciudad:</strong> <?= htmlspecialchars($libro->getCiudad() ?? 'N/A') ?></p>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <p><strong>Volumen:</strong> <?= htmlspecialchars($libro->getVolumen() ?? 'N/A') ?></p>
                        </div>
                        <div class="col-xs-12">
                            <p><strong>Observaciones:</strong> <?= nl2br(htmlspecialchars($libro->getObservaciones() ?? 'Sin observaciones')) ?></p>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend><i class="zmdi zmdi-bookmark"></i> &nbsp; Ejemplares</legend>
                <div class="container-fluid" style="font-size: 1.1em;">
                    <div class="row">
                        <?php if (!empty($libro->getEjemplares())): ?>
                            <?php foreach ($libro->getEjemplares() as $ejemplar): ?>
                                <div class="col-xs-12 col-sm-6" style="border-bottom: 1px solid #eee; padding: 10px 0;">
                                    <p><strong>Número de Ejemplar:</strong> <?= htmlspecialchars($ejemplar->getNumeroEjemplar()) ?></p>
                                    <p><strong>Estado:</strong> 
                                        <span class="label <?= $ejemplar->getEstado() == 'Disponible' ? 'label-success' : 'label-danger' ?>">
                                            <?= htmlspecialchars($ejemplar->getEstado()) ?>
                                        </span>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-xs-12">
                                <p>No hay ejemplares registrados para este libro.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </fieldset>

        </div>
    </div>
</div>

	</section>

	<!--====== Scripts -->
	<!-- SideBar -->
	<?php include VIEW_PATH . '/component/scripts.php'; ?>
</body>
</html>