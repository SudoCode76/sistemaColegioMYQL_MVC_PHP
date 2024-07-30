<?php
include '../../../config/conexion.php';

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
    header("Location: ../../../views/directorViews/moneyEst.php?error=MissingParameters");
}
?>
