<?php
session_start();
require_once "Visitas.php";

$usuario  = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// CASO 1: ENTRAR COMO ADMIN
if ($usuario === 'admin' && $password === 'admin') {
    $_SESSION['usuario_id']   = 1;
    $_SESSION['usuario_nom']  = 'admin';
    $_SESSION['rol']          = 'admin'; // El admin SI ve el histórico
    header("location:../index.php");
    exit();
} 
// CASO 2: ENTRAR COMO PORTERIA
elseif ($usuario === 'porteria' && $password === 'admin') {
    $_SESSION['usuario_id']   = 2;
    $_SESSION['usuario_nom']  = 'porteria';
    $_SESSION['rol']          = 'recepcion'; // El recepcionista NO ve el histórico
    header("location:../index.php");
    exit();
} 
// ERROR
else {
    $_SESSION['mensaje'] = "Usuario o clave incorrectos en el sistema de prueba.";
    header("location:../login.php");
    exit();
}