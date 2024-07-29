<?php
include '../../../config/conexion.php';

if (isset($_GET['id'])) {
    $codEmpleado = $_GET['id'];

    // Verificar si ya ha sido pagado en el mes actual
    $mesActual = date('Y-m-01');
    $sqlCheck = "SELECT * FROM PAGO_MENSUAL WHERE codEmpleado = ? AND mesPago = ?";
    $stmtCheck = $conexion->prepare($sqlCheck);
    $stmtCheck->bind_param("is", $codEmpleado, $mesActual);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        $error = "El empleado ya ha sido pagado en el mes actual.";
    } else {
        // Obtener el monto del salario
        $sqlSalario = "SELECT monto FROM SALARIO WHERE codEmpleado = ?";
        $stmtSalario = $conexion->prepare($sqlSalario);
        $stmtSalario->bind_param("i", $codEmpleado);
        $stmtSalario->execute();
        $resultSalario = $stmtSalario->get_result();

        if ($resultSalario->num_rows == 1) {
            $rowSalario = $resultSalario->fetch_assoc();
            $monto = $rowSalario['monto'];

            // Insertar el registro de pago
            $estadoPago = 'Pagado';
            $sqlInsert = "INSERT INTO PAGO_MENSUAL (codEmpleado, mesPago, monto, estadoPago) VALUES (?, ?, ?, ?)";
            $stmtInsert = $conexion->prepare($sqlInsert);
            $stmtInsert->bind_param("isis", $codEmpleado, $mesActual, $monto, $estadoPago);

            if ($stmtInsert->execute()) {
                $success = "Pago registrado exitosamente.";
            } else {
                $error = "Error al registrar el pago: " . $stmtInsert->error;
            }

            $stmtInsert->close();
        } else {
            $error = "No se encontró el salario del empleado.";
        }

        $stmtSalario->close();
    }

    $stmtCheck->close();
} else {
    $error = "ID de empleado no especificado.";
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar Salario</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5">Pagar Salario</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <a href="../../../views/directorViews/gestionSalarios.php" class="btn btn-primary">Volver a Gestión de Salarios</a>
</div>

<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
