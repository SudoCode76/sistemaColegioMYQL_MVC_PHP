<?php
session_start();
if (!isset($_SESSION['nombreUsuario'])) {
    header("Location: ../../views/loginViews/login.php");
    exit();
}
?>