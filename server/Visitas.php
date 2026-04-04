<?php
date_default_timezone_set('America/Lima');

class Visitas
{
    public function conexion()
    {
        $conexion = mysqli_connect(
            'localhost',
            'root', 
            '',
            'libro_visitas'
        );

        if (!$conexion) {
            die("Error en la conexión a la base de datos: " . mysqli_connect_error());
        }

        return $conexion;
    }

    public function agregarVisita($datos)
    {
        $conexion = $this->conexion();
        // Usamos t_visitas como en el resto de tu código
        $sql = "INSERT INTO t_visitas (paterno, materno, nombre, dni, motivo, fecha, qr_token, en_planta)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $query = mysqli_prepare($conexion, $sql);
        
        if (!$query) {
            die("Error al preparar la consulta: " . mysqli_error($conexion));
        }

        mysqli_stmt_bind_param(
            $query,
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

        $resultado = mysqli_stmt_execute($query);
        mysqli_stmt_close($query);
        return $resultado;
    }

    public function mostrarDia(){
        $conexion = $this->conexion();
        $fecha = date("Y-m-d");
        // Filtramos por los que están hoy dentro
        $sql = "SELECT * FROM t_visitas WHERE fecha LIKE '%$fecha%' AND en_planta = 1";
        $respuesta = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($respuesta, MYSQLI_ASSOC);
    }

    public function marcarSalida($token){
        $conexion = $this->conexion();
        $fecha_salida = date('Y-m-d H:i:s');
        $sql = "UPDATE t_visitas SET fecha_salida = ?, en_planta = 0 WHERE qr_token = ?";
        
        $query = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($query, 'ss', $fecha_salida, $token);
        $resultado = mysqli_stmt_execute($query);
        
        mysqli_stmt_close($query);
        return $resultado;
    }

    public function mostrarTodos(){
        $conexion = $this->conexion();
        $sql = "SELECT * FROM t_visitas ORDER BY fecha DESC";
        $respuesta = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($respuesta, MYSQLI_ASSOC);
    }

    // --- FUNCIONES DEL DASHBOARD ACTUALIZADAS ---

    public function contarTotalHoy() {
        $conexion = $this->conexion();
        // Buscamos en t_visitas donde la fecha sea hoy
        $sql = "SELECT COUNT(*) as total FROM t_visitas WHERE DATE(fecha) = CURDATE()";
        $res = mysqli_query($conexion, $sql);
        $data = mysqli_fetch_assoc($res);
        return $data['total'] ?? 0;
    }

    public function contarEnPlanta() {
        $conexion = $this->conexion();
        // Personas que están marcadas como en_planta = 1
        $sql = "SELECT COUNT(*) as total FROM t_visitas WHERE DATE(fecha) = CURDATE() AND en_planta = 1";
        $res = mysqli_query($conexion, $sql);
        $data = mysqli_fetch_assoc($res);
        return $data['total'] ?? 0;
    }

    public function contarEgresosHoy() {
        $conexion = $this->conexion();
        // Personas de hoy que ya salieron (en_planta = 0 y tienen fecha de salida)
        $sql = "SELECT COUNT(*) as total FROM t_visitas WHERE DATE(fecha) = CURDATE() AND en_planta = 0 AND fecha_salida IS NOT NULL";
        $res = mysqli_query($conexion, $sql);
        $data = mysqli_fetch_assoc($res);
        return $data['total'] ?? 0;
    }
}