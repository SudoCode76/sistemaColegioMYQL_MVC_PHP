<?php
require_once __DIR__ . '/../../../config/checkSession.php';
require_once __DIR__ . '/../../../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codEstudiante = $_POST['codEstudiante'];
    $cedulaId = $_POST['cedulaId'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $nacionalidad = $_POST['nacionalidad'];
    $genero = $_POST['genero'];
    $tutor = $_POST['tutor'];
    $direccion = $_POST['direccion'];
    $estado = $_POST['estado'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $celular = $_POST['celular'];
    $correo = $_POST['correo'];
    $codPadre = $_POST['codPadre'];
    $codAsistencia = $_POST['codAsistencia'];

    $sql = "UPDATE ESTUDIANTE SET cedulaIdEstudiante=?, nombre=?, apellido=?, nacionalidad=?, genero=?, tutor=?, direccion=?, estado=?, fechaNacimiento=?, celular=?, correo=?, codPadre=?, codAsistencia=? WHERE codEstudiante=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssssssssssiii", $cedulaId, $nombre, $apellido, $nacionalidad, $genero, $tutor, $direccion, $estado, $fechaNacimiento, $celular, $correo, $codPadre, $codAsistencia, $codEstudiante);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../../views/secretaryViews/gestionEstudiante.php?success=" . urlencode("Alumno actualizado exitosamente"));
    exit();
}

$codEstudiante = $_GET['id'];
$sql = "SELECT * FROM ESTUDIANTE WHERE codEstudiante = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $codEstudiante);
$stmt->execute();
$result = $stmt->get_result();
$alumno = $result->fetch_assoc();
$stmt->close();
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
    <h1 class="text-2xl font-bold mb-5">Añadir nueva estudiante</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-4">
        <input type="hidden" name="codEstudiante" value="<?php echo htmlspecialchars($alumno['codEstudiante']); ?>">

        <!-- Campos del formulario para editar un alumno -->
        <div class="form-control">
            <label for="cedulaId" class="label">Cédula ID:</label>
            <input type="text" class="input input-bordered" id="cedulaId" name="cedulaId" value="<?php echo htmlspecialchars($alumno['cedulaIdEstudiante']); ?>" required>
        </div>
        <div class="form-control">
            <label for="nombre" class="label">Nombre:</label>
            <input type="text" class="input input-bordered" id="nombre" name="nombre" value="<?php echo htmlspecialchars($alumno['nombre']); ?>" required>
        </div>
        <div class="form-control">
            <label for="apellido" class="label">Apellido:</label>
            <input type="text" class="input input-bordered" id="apellido" name="apellido" value="<?php echo htmlspecialchars($alumno['apellido']); ?>" required>
        </div>
        <div class="form-control">
            <label for="nacionalidad" class="label">Nacionalidad:</label>
            <input type="text" class="input input-bordered" id="nacionalidad" name="nacionalidad" value="<?php echo htmlspecialchars($alumno['nacionalidad']); ?>" required>
        </div>
        <div class="form-control">
            <label for="genero" class="label">Género:</label>
            <input type="text" class="input input-bordered" id="genero" name="genero" value="<?php echo htmlspecialchars($alumno['genero']); ?>" required>
        </div>
        <div class="form-control">
            <label for="tutor" class="label">Tutor:</label>
            <input type="text" class="input input-bordered" id="tutor" name="tutor" value="<?php echo htmlspecialchars($alumno['tutor']); ?>" required>
        </div>
        <div class="form-control">
            <label for="direccion" class="label">Dirección:</label>
            <input type="text" class="input input-bordered" id="direccion" name="direccion" value="<?php echo htmlspecialchars($alumno['direccion']); ?>" required>
        </div>
        <div class="form-control">
            <label for="estado" class="label">Estado:</label>
            <input type="text" class="input input-bordered" id="estado" name="estado" value="<?php echo htmlspecialchars($alumno['estado']); ?>" required>
        </div>
        <div class="form-control">
            <label for="fechaNacimiento" class="label">Fecha de Nacimiento:</label>
            <input type="date" class="input input-bordered" id="fechaNacimiento" name="fechaNacimiento" value="<?php echo htmlspecialchars($alumno['fechaNacimiento']); ?>" required>
        </div>
        <div class="form-control">
            <label for="celular" class="label">Celular:</label>
            <input type="text" class="input input-bordered" id="celular" name="celular" value="<?php echo htmlspecialchars($alumno['celular']); ?>" required>
        </div>
        <div class="form-control">
            <label for="correo" class="label">Correo:</label>
            <input type="email" class="input input-bordered" id="correo" name="correo" value="<?php echo htmlspecialchars($alumno['correo']); ?>" required>
        </div>

        <div class="form-control">
            <label for="codAsistencia" class="label">Código de Asistencia:</label>
            <input type="number" class="input input-bordered" id="codAsistencia" name="codAsistencia" value="<?php echo htmlspecialchars($alumno['codAsistencia']); ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Alumno</button>
    </form>
</div>

<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
