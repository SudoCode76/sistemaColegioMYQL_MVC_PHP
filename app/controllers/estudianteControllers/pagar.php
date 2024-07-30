<?php
require_once __DIR__ . '/../../config/conexion.php';

if (isset($_GET['id']) && isset($_GET['year']) && isset($_GET['month'])) {
    $codEstudiante = $_GET['id'];
    $year = $_GET['year'];
    $month = $_GET['month'];

    // Validar que los parámetros sean números
    if (!is_numeric($codEstudiante) || !is_numeric($year) || !is_numeric($month)) {
        header("Location: ../../../views/directorViews/moneyEst.php?error=InvalidParameters");
        exit();
    }

    // Generar la fecha de pago
    $mesPago = "$year-$month-01";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Procesar los datos de la tarjeta
        $nombreTarjeta = $_POST['nombreTarjeta'];
        $numeroTarjeta = $_POST['numeroTarjeta'];
        $fechaExpiracion = $_POST['fechaExpiracion'];
        $cvv = $_POST['cvv'];

        // Aquí puedes agregar la lógica para procesar el pago con la tarjeta

        // Verificar si ya existe un registro de pago para ese mes y año
        $sql = "SELECT * FROM PAGO_MENSUALIDAD_ESTUDIANTE 
                WHERE codEstudiante = ? 
                AND YEAR(mesPago) = ? 
                AND MONTH(mesPago) = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sss", $codEstudiante, $year, $month);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Si ya existe, actualizar el estado de pago
            $sql = "UPDATE PAGO_MENSUALIDAD_ESTUDIANTE 
                    SET estadoPago = 'Pagado'
                    WHERE codEstudiante = ? 
                    AND YEAR(mesPago) = ? 
                    AND MONTH(mesPago) = ?";
        } else {
            // Si no existe, insertar un nuevo registro
            $sql = "INSERT INTO PAGO_MENSUALIDAD_ESTUDIANTE (codEstudiante, mesPago, monto, estadoPago) 
                    VALUES (?, ?, 500.00, 'Pagado')";
        }

        $stmt = $conexion->prepare($sql);
        if ($result->num_rows > 0) {
            $stmt->bind_param("sss", $codEstudiante, $year, $month);
        } else {
            $stmt->bind_param("ss", $codEstudiante, $mesPago);
        }

        if ($stmt->execute()) {
            header("Location: ../../../views/directorViews/moneyEst.php?success=PaymentUpdated");
        } else {
            header("Location: ../../../views/directorViews/moneyEst.php?error=UpdateFailed");
        }

        $stmt->close();
        $conexion->close();
    } else {
        // Mostrar el formulario de la tarjeta de crédito
        echo '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
            <link rel="stylesheet" href="../../../public/css/pagar.css">
            <title>Pagar Mensualidad</title>
            
        </head>
        <body>
        <div class="min-h-screen bg-base-100 text-base-content flex items-center justify-center">
            <div class="credit-card card shadow-lg">
                <h1 class="text-3xl font-bold mb-6 text-center">Pagar Mensualidad</h1>
                <form method="POST" action="">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-white">Nombre en la tarjeta</label>
                        <input type="text" name="nombreTarjeta" required class="input input-bordered w-full" placeholder="Nombre Completo">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-white">Número de tarjeta</label>
                        <input type="text" name="numeroTarjeta" required class="input input-bordered w-full" placeholder="1234 5678 9012 3456" pattern="\d{16}" title="Debe contener 16 dígitos">
                    </div>
                    <div class="mb-4 flex justify-between">
                        <div class="w-1/2 pr-2">
                            <label class="block text-sm font-medium text-white">Fecha de expiración</label>
                            <input type="month" name="fechaExpiracion" required class="input input-bordered w-full">
                        </div>
                        <div class="w-1/2 pl-2">
                            <label class="block text-sm font-medium text-white">CVV</label>
                            <input type="text" name="cvv" required class="input input-bordered w-full" placeholder="123" pattern="\d{3}" title="Debe contener 3 dígitos">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-full">Pagar</button>
                </form>
            </div>
        </div>
        </body>
        </html>';
    }
} else {
    header("Location: ../../../views/estudianteViews/mensualidad.php?error=MissingParameters");
}
?>
