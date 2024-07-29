<?php
require_once __DIR__ . '/../../../config/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $codCursoMateria = $_POST['codCursoMateria'];
        $codEmpleado = $_POST['codEmpleado'];

        $sql = "UPDATE ASIGNACIONCURSO SET codCursoMateria = ?, codEmpleado = ? WHERE codAsignacion = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iii", $codCursoMateria, $codEmpleado, $id);

        if ($stmt->execute()) {
            header("Location: ../../../views/directorViews/gestionAsignaciones.php?success=Asignación actualizada exitosamente");
        } else {
            header("Location: ../../../views/directorViews/gestionAsignaciones.php?error=Error al actualizar asignación: " . $stmt->error);
        }

        $stmt->close();
    }

    $sql = "SELECT * FROM ASIGNACIONCURSO WHERE codAsignacion = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $asignacion = $result->fetch_assoc();
    } else {
        header("Location: ../../../views/directorViews/gestionAsignaciones.php?error=Asignación no encontrada");
    }

    $sql = "SELECT CM.codCursoMateria, CONCAT(C.nombreCurso, ' - ', M.nombreMateria) AS cursoMateria
            FROM CURSOMATERIA CM
            JOIN CURSO C ON CM.codCurso = C.codCurso
            JOIN MATERIA M ON CM.codMateria = M.codMateria";
    $result = $conexion->query($sql);
    $cursosMaterias = $result->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT E.codEmpleado, CONCAT(E.nombre, ' ', E.apellido) AS nombreDocente
            FROM EMPLEADO E
            WHERE E.tipoEmpleado = 'Docente'";
    $result = $conexion->query($sql);
    $docentes = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
} else {
    header("Location: ../../../views/directorViews/gestionAsignaciones.php?error=ID de asignación no especificado");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Asignación</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5">Editar Asignación</h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>" class="space-y-4">
        <div class="form-control">
            <label for="codCursoMateria" class="label">Curso y Materia:</label>
            <select class="select select-bordered" id="codCursoMateria" name="codCursoMateria" required>
                <?php foreach ($cursosMaterias as $cursoMateria) : ?>
                    <option value="<?php echo htmlspecialchars($cursoMateria['codCursoMateria']); ?>" <?php if ($asignacion['codCursoMateria'] == $cursoMateria['codCursoMateria']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($cursoMateria['cursoMateria']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-control">
            <label for="codEmpleado" class="label">Docente:</label>
            <select class="select select-bordered" id="codEmpleado" name="codEmpleado" required>
                <?php foreach ($docentes as $docente) : ?>
                    <option value="<?php echo htmlspecialchars($docente['codEmpleado']); ?>" <?php if ($asignacion['codEmpleado'] == $docente['codEmpleado']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($docente['nombreDocente']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
</body>
</html>
