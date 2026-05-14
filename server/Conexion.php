<?php
/**
 * Conexion.php
 * Clase base que gestiona la conexión a la base de datos.
 * Ubicación: /server/Conexion.php
 */

// Cargamos las constantes de BD desde la raíz del proyecto
require_once __DIR__ . '/../config.php';

class Conexion
{
    /** @var mysqli Instancia de la conexión compartida */
    protected mysqli $db;

    /**
     * El constructor abre la conexión una sola vez y la guarda en $this->db.
     * Todas las clases hijas la heredan automáticamente.
     */
    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->db->set_charset('utf8mb4');
    }
}