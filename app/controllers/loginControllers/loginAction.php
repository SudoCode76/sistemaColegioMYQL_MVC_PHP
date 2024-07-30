<?php
require_once __DIR__ . '/loginController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreUsuario = filter_input(INPUT_POST, 'nombreUsuario', FILTER_SANITIZE_STRING);
    $contrasenia = filter_input(INPUT_POST, 'contrasenia', FILTER_SANITIZE_STRING);

    if ($nombreUsuario && $contrasenia) {
        $controller = new LoginController();
        $user = $controller->login($nombreUsuario, $contrasenia);

        if ($user) {
            session_start();
            $_SESSION['nombreUsuario'] = $user['nombreUsuario'];
            $_SESSION['rol'] = $user['nombreRol']; // Almacenar el rol en la sesión
            $_SESSION['codEmpleado'] = $user['codEmpleado']; // Almacenar el codEmpleado en la sesión
            header("Location: ../../views/loginViews/dashboard.php");
            exit();
        } else {
            header("Location: ../../views/loginViews/login.php?error=1");
            exit();
        }
    } else {
        header("Location: ../../views/loginViews/login.php?error=1");
        exit();
    }
}
?>
