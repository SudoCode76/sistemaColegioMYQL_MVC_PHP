<?php
require_once __DIR__ . '/loginController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username && $password) {
        $controller = new LoginController();
        $user = $controller->login($username, $password);

        if ($user) {
            session_start();
            $_SESSION['username'] = $user['username'];
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
