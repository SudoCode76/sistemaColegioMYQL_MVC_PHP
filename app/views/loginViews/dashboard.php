<?php
require_once __DIR__ . '/../../config/checkSession.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
<header class="min-h-screen bg-base-100 text-base-content">
    <div class="container mx-auto p-4">
        <?php include "../loginViews/menuv2.php"; ?>
        <div class="bg-base-200 p-6 rounded-box shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Bienvenido al sistema de colegio privado</h1>
            </div>
            <div class="mockup-code">
                <pre><code>Todas sus opciones disponibles estan en el menu</code></pre>
                <pre><code>Cualquier error contacte con el administrador</code></pre>
                <pre><code>********************************</code></pre>
                <pre><code>Grupo 3</code></pre>
                <pre><code>Intengrantes:</code></pre>
                <pre><code>Miguel Angel Zenteno Orellana</code></pre>
                <pre><code>Jhunior Danilo Sonco Canaza</code></pre>
                <pre><code>Cristina Germayoni Fuentes Medrano</code></pre>
            </div>
        </div>
    </div>
</header>

</body>
</html>
