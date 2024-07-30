<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['nombreUsuario'])) {
    header("Location: ../../views/loginViews/login.php");
    exit();
}

// Verificar si el rol es de un profesor y si codEmpleado está establecido en la sesión
if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'Profesor' && !isset($_SESSION['codEmpleado'])) {
    echo "Error: No se ha encontrado la información del empleado en la sesión.";
    exit();
}
?>
