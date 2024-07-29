<?php
require_once __DIR__ . '/../../../config/conexion.php';

if (isset($_GET['estudiante']) && isset($_GET['mes'])) {
    $codEstudiante = $_GET['estudiante'];
    $mes = $_GET['mes'];
    $monto = 500.00; // Ajustar el monto según sea necesario

    // Verificar si ya está pagado
    $sql = "SELECT estadoPago FROM PAGO_MENSUALIDAD_ESTUDIANTE WHERE codEstudiante = ? AND DATE_FORMAT(mesPago, '%Y-%m') = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("is", $codEstudiante, $mes);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['estadoPago'] == 'Pagado') {
            header("Location: ../../../views/secretaryViews/gestionMensualidades.php?error=Ya está marcado como pagado");
            exit();
        }
    }

    // Marcar como pagado
    $sql = "INSERT INTO PAGO_MENSUALIDAD_ESTUDIANTE (codEstudiante, mesPago, monto, estadoPago) VALUES (?, ?, ?, 'Pagado')
            ON DUPLICATE KEY UPDATE estadoPago = 'Pagado', monto = VALUES(monto)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("isd", $codEstudiante, $mes, $monto);

    if ($stmt->execute()) {
        header("Location: ../../../views/directorViews/moneyEst.php?success=Pago registrado exitosamente");
    } else {
        header("Location: ../../../views/directorViews/moneyEst.php?error=Error al registrar el pago: " . $stmt->error);
    }

    $stmt->close();
    $conexion->close();
} else {
    header("Location: ../../../views/directorViews/moneyEst.php?error=Datos del estudiante o mes no especificados");
}
?>
