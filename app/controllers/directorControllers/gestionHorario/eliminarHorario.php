<?php
include '../../../config/conexion.php';

if (isset($_GET['id'])) {
    $codHorario = $_GET['id'];

    $sql = "DELETE FROM HORARIO WHERE codHorario=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $codHorario);

    if ($stmt->execute()) {
        $success = "Horario eliminado correctamente.";
        header("Location: ../../../views/directorViews/horarios.php");
    } else {
        $error = "Error al eliminar el horario: " . $stmt->error;
    }

    $stmt->close();
} else {
    $error = "ID de horario no especificado.";
}

$conexion->close();
?>
