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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>


<body class="bg-gray-100">
<div class="navbar bg-base-200 rounded-box shadow-lg mb-4">
    <div class="flex-1">
        <a class="text-xl font-bold">daisyUI</a>
    </div>
    <div class="flex-none">
        <ul class="menu menu-horizontal px-1">
            <?php

            if ($_SESSION['rol'] == 'Director') {
                echo '<li><a href="../directorViews/cuentas.php">Cuentas</a></li>';
                echo '<li><a href="../directorViews/gestionSalarios.php">Salarios</a></li>';
                echo '<li><a href="../directorViews/horarios.php">Horarios</a></li>';
                echo '<li><a href="../directorViews/moneyEst.php">Mensualidades</a></li>';
                echo '<li><a href="../directorViews/gestionAsignaciones.php">Asignaciones</a></li>';

            } elseif ($_SESSION['rol'] == 'Profesor') {
                echo '<li><a href="../profesorViews/extractoSalario.php">Extracto Salario</a></li>';
                echo '<li><a href="../profesorViews/seleccionarMateria.php">Mis horarios</a></li>';

            } elseif ($_SESSION['rol'] == 'Secretaria') {
                echo '<li><a href="../secretaryViews/horarios.php">Horarios</a></li>';
                echo '<li><a href="../secretaryViews/gestionEstudiante.php">Gestion Estudiantes</a></li>';
                echo '<li><a href="../directorViews/moneyEst.php">Mensualidades</a></li>';


            } elseif ($_SESSION['rol'] == 'Estudiante') {
                echo '<li><a href="../estudianteViews/mensualidad.php">Mensualidad</a></li>';
                echo '<li><a href="../estudianteViews/notas.php">Notas</a></li>';

            } elseif ($_SESSION['rol'] == 'Administrador') {
                echo '<li><a href="../directorViews/cuentas.php">Cuentas</a></li>';
                echo '<li><a href="../directorViews/gestionSalarios.php">Salarios</a></li>';
                echo '<li><a href="../directorViews/horarios.php">Horarios</a></li>';
                echo '<li><a href="../directorViews/moneyEst.php">Mensualidades</a></li>';
                echo '<li><a href="../directorViews/gestionAsignaciones.php">Asignaciones</a></li>';
                echo '<li><a href="../secretaryViews/gestionEstudiante.php">Estudiantes</a></li>';
                echo '<li><a href="../estudianteViews/mensualidad.php">Mensualidad Estudiante</a></li>';
                echo '<li><a href="../estudianteViews/notas.php">Notas Estudiante</a></li>';
            }
            ?>
        </ul>

        <button class="btn btn-ghost" onclick="toggleTheme()">
            <i class="fas fa-adjust"></i>
        </button>
        <a class="btn-ghost" href="../../controllers/loginControllers/logout.php">Cerrar sesión</a>
    </div>
</div>

<script src="https://cdn.tailwindcss.com"></script>

<script>
    // Función para cambiar el tema
    function toggleTheme() {
        const html = document.documentElement;
        const currentTheme = html.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
    }

    // Aplicar el tema guardado o el preferido del sistema
    document.addEventListener('DOMContentLoaded', () => {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
        } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.setAttribute('data-theme', 'dark');
        }
    });
</script>

</body>
</html>










