<?php
session_start();
require_once "Visitas.php";

// 1. Verificamos que el token llegue por la URL
if (isset($_GET['token']) && !empty($_GET['token'])) {
    
    $token = $_GET['token'];
    $obj = new Visitas();

    // 2. Llamamos al método que creamos en la clase Visitas
    if ($obj->marcarSalida($token)) {
        // Si todo sale bien, mandamos mensaje de éxito
        $_SESSION['mensaje'] = 'salida_exitosa';
        header("location:../index.php");
    } else {
        // Si hay error en la BD
        $_SESSION['mensaje'] = 'error_salida';
        header("location:../index.php");
    }

} else {
    // Si alguien intenta entrar al archivo sin un token
    header("location:../index.php");
}
?>