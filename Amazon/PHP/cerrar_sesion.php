<?php
session_start();
session_unset();
session_destroy();

// Borrar la cookie de recordarme
setcookie("recordarme", "", time() - 3600, "/");

header("Location: ../HTML/InicioSesion.php");
exit;
?>
