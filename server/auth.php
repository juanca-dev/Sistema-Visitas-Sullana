<?php
// Iniciamos sesión para poder leer las variables del login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// EL GUARDIÁN: Si no existe la sesión de ID, el usuario no se ha logueado
if (!isset($_SESSION['usuario_id'])) {
    // Lo expulsamos al login
    header("location:login.php");
    exit(); // Detenemos la ejecución del resto de la página
}

// OPCIONAL: Control de Roles (Nivel Pro)
// Si intentan entrar a historial y no son admin, los regresamos al index
if (basename($_SERVER['PHP_SELF']) == 'historico.php' && $_SESSION['rol'] != 'admin') {
    $_SESSION['mensaje'] = "No tienes permisos para ver el histórico";
    header("location:index.php");
    exit();
}
?>