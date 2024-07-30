<?php
require_once __DIR__ . '/../../../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codCursoMateria = $_POST['codCursoMateria'];
    $codEmpleado = $_POST['codEmpleado'];
    $fechaAsignacion = date("Y-m-d");

    $sql = "INSERT INTO ASIGNACIONCURSO (fechaAsignacion, codEmpleado, codCursoMateria) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sii", $fechaAsignacion, $codEmpleado, $codCursoMateria);

    if ($stmt->execute()) {
        header("Location: ../../../views/directorViews/gestionAsignaciones.php?success=Asignación añadida exitosamente");
    } else {
        header("Location: ../../../views/directorViews/gestionAsignaciones.php?error=Error al añadir asignación: " . $stmt->error);
    }

    $stmt->close();
    $conexion->close();
}

$sql = "SELECT CM.codCursoMateria, CONCAT(C.nombreCurso, ' - ', M.nombreMateria) AS cursoMateria
            FROM CURSOMATERIA CM
            JOIN CURSO C ON CM.codCurso = C.codCurso
            JOIN MATERIA M ON CM.codMateria = M.codMateria";
$result = $conexion->query($sql);
$cursosMaterias = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT E.codEmpleado, CONCAT(E.nombre, ' ', E.apellido) AS nombreDocente
            FROM EMPLEADO E
            WHERE E.tipoEmpleado = 'Profesor'";
$result = $conexion->query($sql);
$docentes = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nueva Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5">Añadir Asignación</h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-4">
        <div class="form-control">

            <label for="codCursoMateria" class="label">Curso y Materia:</label>
            <select class="select select-bordered" id="codCursoMateria" name="codCursoMateria" required>
                <?php foreach ($cursosMaterias as $cursoMateria) : ?>
                    <option value="<?php echo htmlspecialchars($cursoMateria['codCursoMateria']); ?>">
                        <?php echo htmlspecialchars($cursoMateria['cursoMateria']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

        </div>

        <div class="form-control">
            <label for="codEmpleado" class="label">Docente:</label>
            <select class="select select-bordered" id="codEmpleado" name="codEmpleado" required>
                <?php foreach ($docentes as $docente) : ?>
                    <option value="<?php echo htmlspecialchars($docente['codEmpleado']); ?>">
                        <?php echo htmlspecialchars($docente['nombreDocente']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>

<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>