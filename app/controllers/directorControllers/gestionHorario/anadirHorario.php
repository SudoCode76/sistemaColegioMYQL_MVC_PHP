<?php
include '../../../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codCursoMateria = $_POST['codCursoMateria'];
    $periodo = $_POST['periodo'];
    $horaInicio = $_POST['horaInicio'];
    $horaFin = $_POST['horaFin'];

    if (empty($codCursoMateria) || empty($periodo) || empty($horaInicio) || empty($horaFin)) {
        $error = "Por favor, complete todos los campos correctamente.";
    } else {
        $sql = "INSERT INTO HORARIO (codCursoMateria, periodo, horaInicio, horaFin) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("isss", $codCursoMateria, $periodo, $horaInicio, $horaFin);

        if ($stmt->execute()) {
            $success = "Horario añadido correctamente.";
            header("Location: ../../../views/directorViews/horarios.php?success=" . urlencode($success));
            exit();
        } else {
            $error = "Error al añadir el horario: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Horario</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5">Añadir Horario</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-4">
        <div class="form-control">
            <label for="codCursoMateria" class="label">Curso y Materia:</label>
            <select class="select select-bordered" id="codCursoMateria" name="codCursoMateria" required>
                <?php
                $sql = "SELECT CM.codCursoMateria, C.nombreCurso, M.nombreMateria 
                        FROM CURSOMATERIA CM
                        JOIN CURSO C ON CM.codCurso = C.codCurso
                        JOIN MATERIA M ON CM.codMateria = M.codMateria
                        JOIN ASIGNACIONCURSO AC ON CM.codCursoMateria = AC.codCursoMateria";
                $result = $conexion->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row["codCursoMateria"]) . "'>" . htmlspecialchars($row["nombreCurso"]) . " - " . htmlspecialchars($row["nombreMateria"]) . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-control">
            <label for="periodo" class="label">Periodo:</label>
            <select class="select select-bordered" id="periodo" name="periodo" required>
                <option value="Mañana">Mañana</option>
                <option value="Tarde">Tarde</option>
            </select>
        </div>

        <div class="form-control">
            <label for="horaInicio" class="label">Hora Inicio:</label>
            <input type="time" class="input input-bordered" id="horaInicio" name="horaInicio" required>
        </div>

        <div class="form-control">
            <label for="horaFin" class="label">Hora Fin:</label>
            <input type="time" class="input input-bordered" id="horaFin" name="horaFin" required>
        </div>

        <button type="submit" class="btn btn-primary">Añadir Horario</button>
    </form>
</div>

<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
