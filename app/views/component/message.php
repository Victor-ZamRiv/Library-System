<?php
$old = $_SESSION['old_data'] ?? [];
$success = $_SESSION['success'] ?? NULL;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['old_data'], $_SESSION['error'], $_SESSION['success']);
?>
