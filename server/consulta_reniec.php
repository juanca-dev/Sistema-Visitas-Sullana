<?php
require_once __DIR__ . '/../config.php';

header('Content-Type: application/json');

$dni = isset($_GET['dni']) ? trim($_GET['dni']) : '';

if (strlen($dni) != 8 || !ctype_digit($dni)) {
    echo json_encode(['success' => false, 'msg' => 'DNI inválido']);
    exit;
}

// ✅ Llamada REAL a la API (apiperu.dev - S/. 0 las primeras consultas)
$url = "https://apiperu.dev/api/dni/" . $dni;

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL            => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 10,
    CURLOPT_HTTPHEADER     => [
        'Accept: application/json',
        'Authorization: Bearer ' . RENIEC_TOKEN
    ]
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($response === false || $httpCode !== 200) {
    // Si la API falla, devolvemos error claro
    echo json_encode(['success' => false, 'msg' => 'No se pudo conectar con RENIEC. Ingresa los datos manualmente.']);
    exit;
}

$data = json_decode($response, true);

// apiperu.dev devuelve: nombres, apellido_paterno, apellido_materno
if (isset($data['data']['nombres'])) {
    echo json_encode([
        'success'        => true,
        'nombres'        => $data['data']['nombres'],
        'apellidoPaterno'=> $data['data']['apellido_paterno'],
        'apellidoMaterno'=> $data['data']['apellido_materno'],
    ]);
} else {
    echo json_encode(['success' => false, 'msg' => 'DNI no encontrado en RENIEC']);
}