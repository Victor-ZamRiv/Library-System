 <?php include  VIEW_PATH . "/component/message.php" ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Login - Sistema Bibliográfico</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Estilos -->
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/css/login.css">
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/fontawesome/fontawesome-free-7.0.1-web/css/all.min.css">
    <link rel="stylesheet" href="<?= PUBLIC_PATH ?>/css/notification.css">
    
    <!-- Scripts base -->
    <script src="<?= PUBLIC_PATH ?>/js/notification.js" defer></script>
    
    <style>
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }
        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="header-slogan">
        <p>Sistema de Gestión Bibliográfica</p>
        <img src="<?= PUBLIC_PATH ?>/img/img-login/libro.png" alt="Logo de la biblioteca">
    </div>

    <div class="login-container">
        <div class="card-inner" id="cardInner">

            <!-- CARA FRONTAL: LOGIN -->
            <div class="form-section login-face">
                <div class="login-box">
                    <h2>Iniciar Sesión</h2>

                    <form action="<?= BASE_URL ?>/login" method="POST" autocomplete="off">
                        <div class="input-group">
                            <input type="text" id="username" name="username" placeholder="Usuario" maxlength="15"
                                value="<?= isset($old['usuario']) ? htmlspecialchars($old['usuario']) : ''; ?>"
                                required autofocus>
                        </div>

                        <div class="input-group password-container">
                            <input type="password" id="password" name="password" placeholder="Contraseña" required maxlength="15">
                            <button type="button" id="togglePassword" class="toggle-btn" aria-label="Mostrar contraseña">
                                <i class="fa-solid fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>

                        <button type="submit" class="btn-sistema btn-access">ACCEDER</button>
                    </form>

                    <div class="forgot-password-container">
                        <button type="button" class="btn-forgot" onclick="flipCard()">¿Olvidaste tu contraseña?</button>
                    </div>

                    <p class="footer-text">Biblioteca Pública Central “Armando Zuloaga Blanco”.<br>Cumaná, Estado Sucre</p>
                </div>
            </div>

            <!-- CARA TRASERA: RECUPERACIÓN -->
            <div class="form-section recovery-face">
                <div class="login-box" id="recoveryContent">
                    <h2>Recuperar</h2>

                    <div id="step-1">
                        <p style="margin-bottom: 20px; color: #666;">Ingresa tu usuario para verificar tu cuenta</p>
                        <div class="input-group">
                            <input type="text" id="recover_username" placeholder="Tu Usuario">
                        </div>
                        <button type="button" class="btn-sistema btn-access" onclick="verifyUserStatic()">VERIFICAR</button>
                    </div>

                    <div id="step-2" style="display: none;">
                        <p id="security-question-text" style="font-weight: bold; margin-bottom: 15px; color: #333;"></p>
                        <div class="input-group">
                            <input type="text" id="security_answer" maxlength="15" placeholder="Tu respuesta">
                        </div>
                        <button type="button" class="btn-sistema btn-access" onclick="checkFinalAnswer()">RESTABLECER</button>
                    </div>

                    <div class="forgot-password-container">
                        <button type="button" class="btn-forgot" onclick="flipCard()">Volver al Login</button>
                    </div>
                    <p class="footer-text">Biblioteca Pública Central “Armando Zuloaga Blanco”.<br>Cumaná, Estado Sucre</p>
                </div>
            </div>

        </div>
    </div>

    <!-- MODAL PARA NUEVA CONTRASEÑA -->
    <div id="modal-password" class="modal-overlay">
        <div class="modal-content">
            <h3>Restablecer Contraseña</h3>
            <p>Por favor, ingresa tu nueva clave de acceso.</p>

            <form id="form-reset-password">
                <div class="input-group">
                    <input type="password" id="new_password" placeholder="Nueva contraseña" required maxlength="15">
                </div>
                <div class="input-group">
                    <input type="password" id="confirm_password" placeholder="Confirmar contraseña" required maxlength="15">
                </div>
                <button type="button" class="btn-sistema btn-access" onclick="saveNewPassword()">GUARDAR CAMBIOS</button>
                <button type="button" class="btn-forgot" onclick="closePasswordModal()" style="text-decoration: none;">Cancelar</button>
            </form>
        </div>
    </div>

    <!-- Contenedor de Toasts -->
    <div id="contenedor-toast" class="contenedor-toast"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            // --- 1. MOSTRAR MENSAJES DE SESIÓN (PHP) ---
            <?php if ($success): ?>
                agregarToast({
                    tipo: 'exito',
                    titulo: '¡Operación Exitosa!',
                    descripcion: '<?= htmlspecialchars($success); ?>',
                    autoCierre: true
                });
            <?php endif; ?>

            <?php if ($error): ?>
                agregarToast({
                    tipo: 'error',
                    titulo: 'Error',
                    descripcion: '<?= htmlspecialchars($error); ?>',
                    autoCierre: true
                });
            <?php endif; ?>

            // --- 2. UI: LOGIN & PASSWORD TOGGLE ---
            const togglePassword = document.querySelector('#togglePassword');
            const passwordInput = document.querySelector('#password');
            const eyeIcon = document.querySelector('#eyeIcon');

            if(togglePassword) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    eyeIcon.classList.toggle('fa-eye');
                    eyeIcon.classList.toggle('fa-eye-slash');
                });
            }
        });

        // --- 3. LÓGICA DE RECUPERACIÓN ---
        const usuarioPrueba = {
            username: "admin",
            pregunta: "¿Cuál es el nombre de tu primera mascota?",
            respuesta: "pelusa"
        };

        function flipCard() {
            document.getElementById('cardInner').classList.toggle('is-flipped');
            setTimeout(() => {
                document.getElementById('step-1').style.display = 'block';
                document.getElementById('step-2').style.display = 'none';
                document.getElementById('recover_username').value = '';
                document.getElementById('security_answer').value = '';
            }, 300);
        }

        function verifyUserStatic() {
            const inputUser = document.getElementById('recover_username').value.trim();
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            const questionText = document.getElementById('security-question-text');

            if (inputUser.toLowerCase() === usuarioPrueba.username) {
                step1.style.display = 'none';
                step2.style.display = 'block';
                questionText.innerText = usuarioPrueba.pregunta;
                agregarToast({ tipo: 'info', titulo: 'Usuario Verificado', descripcion: 'Responde la pregunta.' });
            } else {
                agregarToast({ tipo: 'error', titulo: 'No encontrado', descripcion: 'El usuario no existe.' });
            }
        }

        function checkFinalAnswer() {
            const answer = document.getElementById('security_answer').value.trim();
            if (answer.toLowerCase() === usuarioPrueba.respuesta) {
                agregarToast({ tipo: 'exito', titulo: '¡Correcto!', descripcion: 'Ingresa tu nueva clave.' });
                openPasswordModal();
            } else {
                agregarToast({ tipo: 'warning', titulo: 'Error', descripcion: 'Respuesta incorrecta.' });
            }
        }

        // --- 4. MODAL Y GUARDADO ---
        function openPasswordModal() { document.getElementById('modal-password').style.display = 'flex'; }
        function closePasswordModal() { document.getElementById('modal-password').style.display = 'none'; }

        function saveNewPassword() {
            const p1 = document.getElementById('new_password').value;
            const p2 = document.getElementById('confirm_password').value;

            if (p1.length < 4) {
                agregarToast({ tipo: 'warning', titulo: 'Muy corta', descripcion: 'Mínimo 4 caracteres.' });
                return;
            }
            if (p1 !== p2) {
                agregarToast({ tipo: 'error', titulo: 'Error', descripcion: 'Las claves no coinciden.' });
                return;
            }

            agregarToast({ tipo: 'exito', titulo: '¡Éxito!', descripcion: 'Contraseña actualizada.' });
            setTimeout(() => { window.location.reload(); }, 2000);
        }
    </script>
</body>
</html>