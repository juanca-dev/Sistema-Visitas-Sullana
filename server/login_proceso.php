<?php
/**
 * login_proceso.php
 * Procesa el formulario de login y crea la sesión.
 * Ubicación: /server/login_proceso.php
 */

session_start();

// Si ya tiene sesión activa, redirigir directo
if (isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit;
}

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit;
}

// Requerir la clase (Visitas require Conexion internamente)
require_once __DIR__ . '/Visitas.php';

// Sanitizar entradas
$usuario  = trim($_POST['usuario']  ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($usuario) || empty($password)) {
    $_SESSION['mensaje'] = 'campos_vacios';
    header('Location: ../login.php');
    exit;
}

// Buscar usuario en la BD
$obj  = new Visitas();
$user = $obj->buscarUsuario($usuario);   // retorna array|null

if ($user === null) {
    // Usuario no existe o está inactivo
    $_SESSION['mensaje'] = 'usuario_incorrecto';
    header('Location: ../login.php');
    exit;
}

// Verificar contraseña con password_verify (hash bcrypt)
if (!password_verify($password, $user['password'])) {
    $_SESSION['mensaje'] = 'usuario_incorrecto';
    header('Location: ../login.php');
    exit;
}

// ✅ Credenciales correctas — crear sesión
$_SESSION['usuario_id']  = $user['id'];
$_SESSION['usuario_nom'] = $user['nombre'] ?? $user['usuario'];
$_SESSION['rol']         = $user['rol'];

header('Location: ../index.php');
exit;