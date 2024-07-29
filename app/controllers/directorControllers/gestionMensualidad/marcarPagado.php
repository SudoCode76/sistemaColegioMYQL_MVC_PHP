<?php
require_once __DIR__ . '/../../../config/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verificar si ya está pagado
    $sql = "SELECT estadoPago FROM PAGO_MENSUALIDAD_ESTUDIANTE WHERE codPago = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['estadoPago'] == 'Pagado') {
        header("Location: ../../views/directorViews/gestionMensualidades.php?error=Ya está marcado como pagado");
        exit();
    }

    // Marcar como pagado
    $sql = "UPDATE PAGO_MENSUALIDAD_ESTUDIANTE SET estadoPago = 'Pagado' WHERE codPago = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../../views/directorViews/gestionMensualidades.php?success=Pago registrado exitosamente");
    } else {
        header("Location: ../../views/directorViews/gestionMensualidades.php?error=Error al registrar el pago: " . $stmt->error);
    }

    $stmt->close();
    $conexion->close();
} else {
    header("Location: ../../views/directorViews/gestionMensualidades.php?error=ID de pago no especificado");
}
?>
