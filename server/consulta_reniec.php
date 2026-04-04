<?php
// Recibimos el DNI por URL
$dni = $_GET['dni'] ?? '';

if (strlen($dni) != 8) {
    echo json_encode(['success' => false, 'msg' => 'DNI inválido']);
    exit;
}

// AQUÍ CONFIGURAS TU API (Ejemplo con un token ficticio)
$token = "TU_TOKEN_AQUÍ"; 
$url = "https://api.peru.com/v1/dni/" . $dni . "?token=" . $token;

// Simulación de respuesta (Para que pruebes tu código sin pagar API aún)
// En producción, aquí usarías curl_exec() para llamar a la API real.
$respuesta_simulada = [
    'success' => true,
    'nombres' => 'JUAN ALBERTO',
    'apellidoPaterno' => 'GARCIA',
    'apellidoMaterno' => 'RODRIGUEZ'
];

header('Content-Type: application/json');
echo json_encode($respuesta_simulada);