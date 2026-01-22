<?php

$password_ingresada = 'holamundo'; // Lo que crees que pusiste
$hash_en_db = '$2y$10$Hk2E9b3D1CJvJwwG8xusOeXSWln23qTsCArlLB/87J4npLqlYSvg6'; // El hash que ves en tu tabla administradores

if (password_verify($password_ingresada, $hash_en_db)) {
    echo "✅ La contraseña es CORRECTA. El problema está en tu controlador o sesión.";
} else {
    echo "❌ La contraseña es INCORRECTA. Estás ingresando algo distinto a lo que se hasheó.";
}