<?php
include '../../../config/conexion.php';

// Verificar si se ha enviado el ID del estudiante a eliminar por el método GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Iniciar una transacción
    $conexion->begin_transaction();

    try {
        // Primero, eliminar registros relacionados en la tabla NOTA
        $sql_nota = "DELETE FROM NOTA WHERE codEstudiante=?";
        $stmt_nota = $conexion->prepare($sql_nota);
        $stmt_nota->bind_param("i", $id);
        $stmt_nota->execute();

        // Luego, eliminar registros relacionados en la tabla PAGO_MENSUALIDAD_ESTUDIANTE
        $sql_pago = "DELETE FROM PAGO_MENSUALIDAD_ESTUDIANTE WHERE codEstudiante=?";
        $stmt_pago = $conexion->prepare($sql_pago);
        $stmt_pago->bind_param("i", $id);
        $stmt_pago->execute();

        // Finalmente, eliminar el estudiante
        $sql_estudiante = "DELETE FROM ESTUDIANTE WHERE codEstudiante=?";
        $stmt_estudiante = $conexion->prepare($sql_estudiante);
        $stmt_estudiante->bind_param("i", $id);
        $stmt_estudiante->execute();

        // Si todo salió bien, confirmar la transacción
        $conexion->commit();

        header("Location: ../../../views/secretaryViews/gestionEstudiante.php");
        exit();
    } catch (Exception $e) {
        // Si algo salió mal, revertir la transacción
        $conexion->rollback();
        echo "Error al intentar eliminar: " . $e->getMessage();
    }

    // Cerrar todas las declaraciones
    if (isset($stmt_nota)) $stmt_nota->close();
    if (isset($stmt_pago)) $stmt_pago->close();
    if (isset($stmt_estudiante)) $stmt_estudiante->close();
} else {
    echo "ID no especificado";
    exit();
}

$conexion->close();
?>