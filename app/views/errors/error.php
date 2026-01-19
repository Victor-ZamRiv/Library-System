<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error en registro de libro</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .error-container {
            background: #fff;
            border: 1px solid #ddd;
            padding: 2rem;
            border-radius: 8px;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .error-container h1 {
            color: #c0392b;
        }
        .error-container pre {
            background: #f4f4f4;
            padding: 1rem;
            border-radius: 4px;
            text-align: left;
            overflow-x: auto;
            font-size: 0.9rem;
            color: #555;
        }
        .btn {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>❌ Ocurrió un error</h1>
        <p><?= isset($mensaje) && $mensaje !== '' 
                ? htmlspecialchars($mensaje) 
                : 'Ha ocurrido un error inesperado.' ?></p>

        <?php if (!empty($detalle)): ?>
            <h3>Detalles técnicos (solo en desarrollo):</h3>
            <pre><?= htmlspecialchars($detalle) ?></pre>
        <?php endif; ?>

        <a href="<?= BASE_URL ?>/libros" class="btn">Volver al listado de libros</a>
    </div>
</body>
</html>