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
    <title>Ver Salarios</title>
    <style>
        .credit-card {
            background: #2a2a72;
            color: #fff;
            border-radius: 10px;
            padding: 20px;
            max-width: 400px;
            margin: 0 auto;
        }
        .credit-card input {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="min-h-screen bg-base-100 text-base-content">
    <div class="container mx-auto p-4">
        <?php include "../loginViews/menuv2.php"; ?>

            <h1 class="text-3xl font-bold mb-6 text-center">Ver Salarios</h1>
            <form method="GET" action="mostrarSalario.php">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-white">Cédula de Identidad</label>
                    <input type="text" name="cedulaIdEmpleado" required class="input input-bordered w-full" placeholder="12345678">
                </div>
                <button type="submit" class="btn btn-primary w-full">Ver Salarios</button>
            </form>

    </div>

</div>
</body>
</html>
