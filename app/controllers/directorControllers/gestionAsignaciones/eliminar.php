<?php
require_once __DIR__ . '/../../../config/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM ASIGNACIONCURSO WHERE codAsignacion = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../../../views/directorViews/gestionAsignaciones.php?success=Asignación eliminada exitosamente");
    } else {
        header("Location: ../../../views/directorViews/gestionAsignaciones.php?error=Error al eliminar asignación: " . $stmt->error);
    }

    $stmt->close();
    $conexion->close();
} else {
    header("Location: ../../../views/directorViews/gestionAsignaciones.php?error=ID de asignación no especificado");
}
?>
