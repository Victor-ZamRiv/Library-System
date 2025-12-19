<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error en registro de libro</title>
    <link rel="stylesheet" href="<?= BASE_PATH ?>/public/css/style.css">
</head>
<body>
    <div class="error-container">
        <h1>❌ Ocurrió un error</h1>
        <p><?= isset($mensaje) ? htmlspecialchars($mensaje) : 'Ha ocurrido un error inesperado.' ?></p>
        <a href="/library_system/libros" class="btn">Volver al listado de libros</a>
    </div>
</body>
</html>