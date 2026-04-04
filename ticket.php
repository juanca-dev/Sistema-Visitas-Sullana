<?php
// PASO 1: Seguridad ante todo
    include "server/auth.php"; 

    include "server/Visitas.php";
    $obj = new Visitas();
    $token = $_GET['token'] ?? ''; // Evitamos errores si no hay token
 

// Necesitamos un método en Visitas.php para obtener datos por token
// (Lo podemos simular o añadir rápido a tu clase)
$conexion = $obj->conexion();
$sql = "SELECT * FROM t_visitas WHERE qr_token = '$token'";
$res = mysqli_query($conexion, $sql);
$v = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pase Digital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        body { background-color: #f4f4f4; }
        .ticket-card { margin-top: 50px; border-radius: 15px; overflow: hidden; }
        .qr-header { background-color: #ee6e73; color: white; padding: 20px; }
    </center></style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <div class="card ticket-card z-depth-3">
                    <div class="qr-header center-align">
                        <h5>PASE DE INGRESO</h5>
                        <p>Libro de Visitas Digital - Sullana</p>
                    </div>
                    <div class="card-content center-align">
                        <h6><b><?php echo $v['nombre'] . " " . $v['paterno']; ?></b></h6>
                        <p>DNI: <?php echo $v['dni']; ?></p>
                        <p>Motivo: <?php echo $v['motivo']; ?></p>
                        <hr>
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo $v['qr_token']; ?>" alt="QR">
                        <p class="grey-text">Muestre este código al salir</p>
                    </div>
                    <div class="card-action center-align">
                        <a href="index.php" class="btn-flat">Finalizar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>