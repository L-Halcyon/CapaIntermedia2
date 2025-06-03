<?php
$origin = $_SERVER['HTTP_ORIGIN'] ?? '*';
header("Access-Control-Allow-Origin: $origin"); // Permite solo el origen actual
header("Access-Control-Allow-Credentials: true"); // Permite el uso de cookies
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$case = $_GET['case'] ?? '';

switch ($case) {
    case 'login':
        require '../CapaIntermedia2/Amazon/PHP/loguear.php';
        break;
    case 'register':
        require '../CapaIntermedia2/Amazon/PHP/registro1.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "Ruta no encontrada"]);
        break;
}
