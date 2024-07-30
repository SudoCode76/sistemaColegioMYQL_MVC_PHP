<?php
require_once __DIR__ . '/../../config/checkSession.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Ver Notas</title>
</head>
<body>
<div class="min-h-screen bg-base-100 text-base-content">
    <div class="container mx-auto p-4">
        <?php include "../loginViews/menuv2.php"; ?>
        <div class="credit-card card shadow-lg">
            <h1 class="text-3xl font-bold mb-6 text-center">Ver Notas</h1>
            <form method="GET" action="mostrarNotas.php">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-white">Carnet de Identidad</label>
                    <input type="text" name="cedulaIdEstudiante" required class="input input-bordered w-full" placeholder="12345678">
                </div>
                <button type="submit" class="btn btn-primary w-full">Ver Notas</button>
            </form>
        </div>
    </div>

</div>
</body>
</html>
