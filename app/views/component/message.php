<?php
$old = $_SESSION['old_data'] ?? [];
$success = $_SESSION['success'] ?? NULL;
$error = $_SESSION['error'] ?? null;
$info = $_SESSION['info'] ?? null;
$warning = $_SESSION['warning'] ?? null;
unset($_SESSION['old_data'], $_SESSION['error'], $_SESSION['success'], $_SESSION['info'], $_SESSION['warning']);
?>
