<?php 
    $rol = $_SESSION['administrador']['rol'] ?? '';
    

    // Definición de permisos (Vacío = Visible, display:none = Oculto)
    $styleDashboard = ($rol == 'Director' || $rol == 'Jefe de Sala') ? '' : 'display: none !important;';
    $styleVisitas    = ($rol == 'Director' || $rol == 'Jefe de Sala' || $rol == 'Bibliotecario') ? '' : 'display: none !important;';
    $styleBiblioteca = ($rol == 'Director' || $rol == 'Jefe de Sala' || $rol == 'Bibliotecario') ? '' : 'display: none !important;';
    $styleEventos    = ($rol == 'Director' || $rol == 'Jefe de Sala') ? '' : 'display: none !important;';
    $styleAdminOnly  = ($rol == 'Director') ? '' : 'display: none !important;';
?>
	<?php include  VIEW_PATH . "/component/message.php"; ?>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="/Library_System/public/css/main.css">
	<link rel="stylesheet" href="/Library_System/public/fontawesome/fontawesome-free-7.0.1-web/css/all.min.css">
	<link rel="stylesheet" href="/Library_System/public/css/notification.css">
	<script src="/Library_System/public/js/notification.js"></script>