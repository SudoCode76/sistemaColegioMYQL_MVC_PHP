<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../views/loginViews/login.php");
    exit();
}
?>
