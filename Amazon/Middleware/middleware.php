<?php
// Extender la sesión si existe cookie "recordarme"
if (session_status() === PHP_SESSION_NONE) {
    if (isset($_COOKIE['recordarme'])) {
        // Duración de 30 días
        session_set_cookie_params(86400 * 30);
    }
    session_start();
}

// Función para validar campos requeridos desde POST
function validateInput($requiredFields) {
    $input = [];

    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Falta el campo: $field"]);
            exit;
        } else {
            $input[$field] = trim($_POST[$field]);
        }
    }

    return $input;
}

// (Opcional) Validar si hay sesión activa
function requireSession() {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(["success" => false, "message" => "Sesión no iniciada"]);
        exit;
    }
}

function redirectIfNotLoggedIn() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        // Si existe la cookie 'recordarme', restaurar la sesión
        if (isset($_COOKIE['recordarme'])) {
            $_SESSION['user_id'] = $_COOKIE['recordarme'];
        } else {
            header("Location: ../HTML/InicioSesion.php");
            exit;
        }
    }
}


?>
