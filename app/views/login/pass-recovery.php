<!DOCTYPE html>
<html lang="es">

<head>
    <title>Recuperar Contraseña</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/css/login.css">
</head>

<body> <div class="header-slogan">
    <p>Sistema de Gestión Bibliográfica</p>
    <img src="<?= PUBLIC_PATH ?>/img/img-login/libro.png" alt="Logo de la biblioteca">
</div>

<div class="login-container">
    <div class="form-section">
        <div class="login-box">
            <h2>Recuperar Cuenta</h2>
            <p style="margin-bottom: 20px; color: #555; font-size: 0.9em;">
                Responda a su pregunta de seguridad para acceder
            </p>

            <form action="<?= BASE_URL ?>/password-recovery" method="POST">
                <div class="input-group">
                    <select name="preguntas" id="pregunta-seguridad" required>
                        <option value="" disabled selected>Seleccione su pregunta de seguridad</option>
                        <?php foreach ($preguntasSeguridad as $pregunta): ?>
                            <option value="<?= htmlspecialchars($pregunta) ?>"
                                <?php if (isset($_SESSION['old_data']['preguntas']) && $_SESSION['old_data']['preguntas'] === $pregunta): ?>
                                    selected
                                <?php endif; ?>
                            >
                                <?= htmlspecialchars($pregunta) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="submit" class="btn-access">ENVIAR INSTRUCCIONES</button>
            </form>

            <div class="forgot-password-container">
                <a href="<?= BASE_URL ?>/login" class="btn-forgot">Volver al Inicio de Sesión</a>
            </div>

            <p class="footer-text">Biblioteca Pública Central “Armando Zuloaga Blanco”. Cumaná, Estado Sucre</p>
        </div>
    </div>
</div>

</body>
</html>