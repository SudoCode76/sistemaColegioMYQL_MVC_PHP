<?php
require_once __DIR__ . '/../../config/checkSession.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
</head>
<body class="bg-gray-100">

<div class="navbar bg-base-100">
    <div class="navbar-start">
        <a class="btn btn-ghost text-xl">daisyUI</a>
    </div>
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1">
            <?php

            if ($_SESSION['rol'] == 'Director') {
                echo '<li><a href="directorPage1.php">Cuentas</a></li>';
                echo '<li><a href="directorPage2.php">Salarios</a></li>';
                echo '<li><a href="directorPage2.php">Horarios</a></li>';
                echo '<li><a href="directorPage2.php">Mensualidades</a></li>';
                echo '<li><a href="directorPage2.php">Materias</a></li>';
            } elseif ($_SESSION['rol'] == 'Profesor') {
                echo '<li><a href="profesorPage1.php">Página del Profesor 1</a></li>';
                echo '<li><a href="profesorPage2.php">Página del Profesor 2</a></li>';
            } elseif ($_SESSION['rol'] == 'Secretaria') {
                echo '<li><a href="secretariaPage1.php">Página de la Secretaria 1</a></li>';
                echo '<li><a href="secretariaPage2.php">Página de la Secretaria 2</a></li>';
            } elseif ($_SESSION['rol'] == 'Estudiante') {
                echo '<li><a href="estudiantePage1.php">Página del Estudiante 1</a></li>';
                echo '<li><a href="estudiantePage2.php">Página del Estudiante 2</a></li>';
            } else {
                echo '<li><a href="#">Opción 1</a></li>';
                echo '<li><a href="#">Opción 2</a></li>';
            }
            ?>
        </ul>
    </div>
    <div class="navbar-end">
        <a class="btn" href="../../controllers/loginControllers/logout.php">Cerrar sesión</a>
    </div>
</div>

<!-- Contenido principal -->

    <div class="bg-base-200 flex justify-center px-4 py-16">Bienvenido, <?php echo htmlspecialchars($_SESSION['nombreUsuario']); ?></div>
    <div class="bg-base-200 flex justify-center px-4 py-16">Este es el contenido principal del dashboard!</div>


<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
