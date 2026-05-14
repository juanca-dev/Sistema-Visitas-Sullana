<?php
// ============================================================
//  CONFIGURACIÓN CENTRAL DEL SISTEMA
//  Cambia estos valores según tu servidor de producción
// ============================================================
 
define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // Cambia en producción
define('DB_PASS', '');           // Cambia en producción
define('DB_NAME', 'libro_visitas');
 
// URL base del sistema (sin slash al final)
define('BASE_URL', 'http://librodevisitasdigital.test');
 
// Token de la API RENIEC (consíguelo en https://apiperu.dev)
define('RENIEC_TOKEN', 'TU_TOKEN_AQUI');
 