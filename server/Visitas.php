<?php
/**
 * Visitas.php — Todo en uno, sin herencia externa.
 * Ubicación: /server/Visitas.php
 *
 * Solo necesitas este archivo. No requiere Conexion.php.
 * Sube únicamente este archivo a /server/ y listo.
 */

date_default_timezone_set('America/Lima');
require_once __DIR__ . '/../config.php';

class Visitas
{
    /** @var mysqli Conexión compartida para toda la instancia */
    private mysqli $db;

    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->db->set_charset('utf8mb4');
    }

    /**
     * Expone la conexión para scripts legados (reporte_excel.php, reporte_pdf.php).
     */
    public function getConexion(): mysqli
    {
        return $this->db;
    }

    // ──────────────────────────────────────────────
    //  VISITAS
    // ──────────────────────────────────────────────

    public function agregarVisita(array $datos): bool
    {
        $sql = "INSERT INTO t_visitas
                    (paterno, materno, nombre, dni, motivo, fecha, qr_token, en_planta)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            'sssssssi',
            $datos['paterno'],
            $datos['materno'],
            $datos['nombre'],
            $datos['dni'],
            $datos['motivo'],
            $datos['fecha'],
            $datos['qr_token'],
            $datos['en_planta']
        );
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    /** Visitantes actualmente en planta (hoy). */
    public function mostrarDia(): array
    {
        $fecha = date('Y-m-d');
        $stmt  = $this->db->prepare(
            "SELECT * FROM t_visitas
             WHERE DATE(fecha) = ? AND en_planta = 1
             ORDER BY fecha DESC"
        );
        $stmt->bind_param('s', $fecha);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /** Todo el historial sin filtro de fecha. */
    public function mostrarTodos(): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM t_visitas ORDER BY fecha DESC"
        );
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /** Marca la salida por qr_token. */
    public function marcarSalida(string $token): bool
    {
        $fecha_salida = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare(
            "UPDATE t_visitas
             SET fecha_salida = ?, en_planta = 0
             WHERE qr_token = ?"
        );
        $stmt->bind_param('ss', $fecha_salida, $token);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    /** Busca una visita por su qr_token (para ticket.php). */
    public function buscarPorToken(string $token): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM t_visitas WHERE qr_token = ? LIMIT 1"
        );
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ?: null;
    }

    // ──────────────────────────────────────────────
    //  CONTADORES (dashboard)
    // ──────────────────────────────────────────────

    public function contarTotalHoy(): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM t_visitas WHERE DATE(fecha) = CURDATE()"
        );
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();
        return (int) $total;
    }

    public function contarEnPlanta(): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM t_visitas
             WHERE DATE(fecha) = CURDATE() AND en_planta = 1"
        );
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();
        return (int) $total;
    }

    public function contarEgresosHoy(): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM t_visitas
             WHERE DATE(fecha) = CURDATE()
               AND en_planta = 0
               AND fecha_salida IS NOT NULL"
        );
        $stmt->execute();
        $stmt->bind_result($total);
        $stmt->fetch();
        return (int) $total;
    }

    // ──────────────────────────────────────────────
    //  USUARIOS
    // ──────────────────────────────────────────────

    /** Busca un usuario activo por nombre de usuario. */
    public function buscarUsuario(string $usuario): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM t_usuarios
             WHERE usuario = ? AND activo = 1
             LIMIT 1"
        );
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ?: null;
    }
}