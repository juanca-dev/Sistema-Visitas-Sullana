<?php 
    session_start();
    include "Visitas.php";
    $visitas = new Visitas(); 

    $validacion = 0;
    // Validamos que no vengan vacíos
    foreach ($_POST as $key => $value) {
        if (empty(trim($value))){
            $validacion ++;
        }
    }

    if ($validacion == 0) {
        // 1. GENERAMOS EL TOKEN ÚNICO PARA EL QR
        $qr_token = bin2hex(random_bytes(10)); // Genera algo como 'a1b2c3d4e5...'

        $datos = array(
            "paterno" => $_POST['paterno'],
            "materno" => $_POST['materno'],
            "nombre"  => $_POST['nombre'],
            "dni"     => $_POST['dni'], // <--- NUEVO: Capturamos el DNI
            "motivo"  => $_POST['motivo'],
            "fecha"   => date('Y-m-d H:i:s'),
            "qr_token"=> $qr_token,      // <--- NUEVO: El token para el QR
            "en_planta" => 1             // <--- NUEVO: Entra como activo
        );

        

        // 2. INSERTAR EN LA BASE DE DATOS
        if ($visitas->agregarVisita($datos)) {
            $_SESSION['mensaje'] = 'exito';
            
            // OPCIÓN PRO: En lugar de index, mándalo al ticket para que vea su QR
            // header('location:../ticket.php?token=' . $qr_token); 
            
            header('location:../ticket.php?token=' . $qr_token);
        } else {
            $_SESSION['mensaje'] = 'error_db';
            header('location:../index.php');
        }
    } else {
        $_SESSION['mensaje'] = 'campos_vacios';
        header('location:../index.php');
    }
?>