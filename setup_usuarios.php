<?php
// ============================================================
//  EJECUTA ESTE ARCHIVO UNA SOLA VEZ para crear la tabla
//  de usuarios y los accesos iniciales.
//  LUEGO ELIMÍNALO del servidor por seguridad.
//  URL: http://tuservidor/Sistema-Visitas/setup_usuarios.php
// ============================================================
require_once 'config.php';

$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conexion) die("Error de conexión: " . mysqli_connect_error());

// 1. Crear tabla t_usuarios
$sql_tabla = "CREATE TABLE IF NOT EXISTS t_usuarios (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    usuario   VARCHAR(50) NOT NULL UNIQUE,
    password  VARCHAR(255) NOT NULL,
    rol       ENUM('admin', 'recepcion') NOT NULL DEFAULT 'recepcion',
    activo    TINYINT(1) NOT NULL DEFAULT 1,
    creado_en DATETIME DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conexion, $sql_tabla)) {
    echo "✅ Tabla t_usuarios creada correctamente.<br>";
} else {
    echo "⚠️ Tabla ya existe o error: " . mysqli_error($conexion) . "<br>";
}

// 2. Insertar usuario ADMIN
$pass_admin = password_hash('Admin2024!', PASSWORD_DEFAULT);
$sql_admin  = "INSERT IGNORE INTO t_usuarios (usuario, password, rol) VALUES ('admin', ?, 'admin')";
$q = mysqli_prepare($conexion, $sql_admin);
mysqli_stmt_bind_param($q, 's', $pass_admin);
mysqli_stmt_execute($q);
echo "✅ Usuario <strong>admin</strong> creado. Contraseña: <strong>Admin2024!</strong><br>";

// 3. Insertar usuario PORTERÍA
$pass_port  = password_hash('Porteria2024!', PASSWORD_DEFAULT);
$sql_port   = "INSERT IGNORE INTO t_usuarios (usuario, password, rol) VALUES ('porteria', ?, 'recepcion')";
$q2 = mysqli_prepare($conexion, $sql_port);
mysqli_stmt_bind_param($q2, 's', $pass_port);
mysqli_stmt_execute($q2);
echo "✅ Usuario <strong>porteria</strong> creado. Contraseña: <strong>Porteria2024!</strong><br>";

echo "<br>⚠️ <strong>IMPORTANTE: Elimina este archivo del servidor ahora que terminaste.</strong>";
echo "<br>🔒 Cambia las contraseñas por defecto desde tu panel de administración.";
?>