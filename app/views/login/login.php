<!DOCTYPE html>
<html lang="es">

<head>
    <title>Login | Sistema de Gestión Bibliográfica</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/css/login.css">
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/fontawesome/fontawesome-free-7.0.1-web/css/all.min.css">
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/css/notification.css">
    <script src="<?= PUBLIC_PATH ?>/js/notification.js" defer></script>
</head>

<body>

    <div class="header-slogan">
        <p>Sistema de Gestión Bibliográfica</p>
        <img src="<?= PUBLIC_PATH ?>/img/img-login/libro.png" alt="Logo de la biblioteca">
    </div>

    <div class="login-container">
        <div class="card-inner" id="cardInner">

            <div class="form-section login-face">
                <div class="login-box">
                    <h2>Iniciar Sesión</h2>

                    <form action="<?= BASE_URL ?>/login" method="POST" autocomplete="off">
                        <div class="input-group">
                            <input type="text" id="username" name="username" placeholder="Usuario" maxlength="15"
                                value="<?= isset($_SESSION['old_data']['usuario']) ? htmlspecialchars($_SESSION['old_data']['usuario']) : ''; ?>"
                                required autofocus>
                            <?php unset($_SESSION['old_data']['usuario']); ?>
                        </div>

                        <div class="input-group password-container">
                            <input type="password" id="password" name="password" placeholder="Contraseña" required maxlength="15">
                            <button type="button" id="togglePassword" class="toggle-btn" aria-label="Mostrar contraseña">
                                <i class="fa-solid fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger" style="color: #d9534f; margin-bottom: 15px; font-size: 14px; text-align: center;">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                            </div>
                        <?php endif; ?>

                        <button type="submit" class="btn-access">ACCEDER</button>
                    </form>

                    <div class="forgot-password-container">
                        <button type="button" class="btn-forgot" onclick="flipCard()">¿Olvidaste tu contraseña?</button>
                    </div>

                    <p class="footer-text">Biblioteca Pública Central “Armando Zuloaga Blanco”.<br>Cumaná, Estado Sucre</p>
                </div>
            </div>

            <div class="form-section recovery-face">
                <div class="login-box" id="recoveryContent">
                    <h2>Recuperar</h2>

                    <div id="step-1">
                        <p style="margin-bottom: 20px; color: #666;">Ingresa tu usuario para verificar tu cuenta</p>
                        <div class="input-group">
                            <input type="text" id="recover_username" placeholder="Tu Usuario">
                        </div>
                        <button type="button" class="btn-access" onclick="verifyUserStatic()">VERIFICAR</button>
                    </div>

                    <div id="step-2" style="display: none;">
                        <p id="security-question-text" style="font-weight: bold; margin-bottom: 15px; color: #333;"></p>
                        <div class="input-group">
                            <input type="text" id="security_answer" maxlength="15" placeholder="Tu respuesta">
                        </div>
                        <button type="button" class="btn-access" onclick="checkFinalAnswer()">RESTABLECER</button>
                    </div>

                    <div class="forgot-password-container">
                        <button type="button" class="btn-forgot" onclick="flipCard()">Volver al Login</button>
                    </div>
                    <p class="footer-text">Biblioteca Pública Central “Armando Zuloaga Blanco”.<br>Cumaná, Estado Sucre</p>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Lógica de mostrar/ocultar contraseña
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Cambio de iconos optimizado para FA 7
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });

        // Efecto 3D Flip
        function flipCard() {
            document.getElementById('cardInner').classList.toggle('is-flipped');
        }

        // Lógica de recuperación (Simulada/Estática)
        const usuarioPrueba = {
            username: "admin",
            pregunta: "¿Cuál es el nombre de tu primera mascota?",
            respuesta: "pelusa"
        };

        function verifyUserStatic() {
            const inputUser = document.getElementById('recover_username').value;
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            const questionText = document.getElementById('security-question-text');

            if (inputUser.toLowerCase() === usuarioPrueba.username) {
                step1.style.display = 'none';
                step2.style.display = 'block';
                questionText.innerText = usuarioPrueba.pregunta;
            } else {
                alert("Usuario no encontrado.");
            }
        }

        function checkFinalAnswer() {
            const answer = document.getElementById('security_answer').value;
            if (answer.toLowerCase() === usuarioPrueba.respuesta) {
                alert("¡Verificación exitosa! Redirigiendo a cambio de contraseña...");
                // Aquí podrías redirigir a la vista de nueva contraseña
            } else {
                alert("Respuesta incorrecta.");
            }
        }
    </script>

</body>
</html>