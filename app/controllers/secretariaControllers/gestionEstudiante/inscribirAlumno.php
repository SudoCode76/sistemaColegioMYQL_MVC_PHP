<?php
require_once __DIR__ . '/../../../config/checkSession.php';
require_once __DIR__ . '/../../../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $codAsistencia = $_POST['codAsistencia'];

    // Insertar alumno
    $sql = "INSERT INTO ESTUDIANTE (cedulaIdEstudiante, nombre, apellido, nacionalidad, genero, tutor, direccion, estado, fechaNacimiento, celular, correo, codAsistencia) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?,  ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssssssssssi", $cedulaId, $nombre, $apellido, $nacionalidad, $genero, $tutor, $direccion, $estado, $fechaNacimiento, $celular, $correo, $codAsistencia);
    $stmt->execute();
    $codEstudiante = $stmt->insert_id;
    $stmt->close();

    header("Location: ../../../views/secretaryViews/gestionEstudiante.php?usuario=" . urlencode($nombreUsuario) . "&contrasenia=" . urlencode($contrasenia));
    exit();
}
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
        <div class="form-control">
            <label for="cedulaId" class="label">Cédula ID:</label>
            <input type="text" class="input input-bordered" id="cedulaId" name="cedulaId" required>
        </div>

        <div class="form-control">
            <label for="nombre" class="label">Nombre:</label>
            <input type="text" class="input input-bordered" id="nombre" name="nombre" required>
        </div>

        <div class="form-control">
            <label for="apellido" class="label">Apellido:</label>
            <input type="text" class="input input-bordered" id="apellido" name="apellido" required>
        </div>

        <div class="form-control">
            <label for="nacionalidad" class="label">Nacionalidad:</label>
            <input type="text" class="input input-bordered" id="nacionalidad" name="nacionalidad" required>
        </div>

        <div class="form-control">
            <label for="genero" class="label">genero:</label>
            <select class="select select-bordered" id="genero" name="genero" required>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
                <option value="Otros">Otros</option>
            </select>
        </div>

        <div class="form-control">
            <label for="tutor" class="label">Tutor:</label>
            <input type="text" class="input input-bordered" id="tutor" name="tutor" required>
        </div>

        <div class="form-control">
            <label for="direccion" class="label">Dirección:</label>
            <input type="text" class="input input-bordered" id="direccion" name="direccion" required>
        </div>


        <div class="form-control">
            <label for="estado" class="label">estado:</label>
            <select class="select select-bordered" id="estado" name="estado" required>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>
        </div>

        <div class="form-control">
            <label for="fechaNacimiento" class="label">Fecha de Nacimiento:</label>
            <input type="date" class="input input-bordered" id="fechaNacimiento" name="fechaNacimiento"
                   required>
        </div>

        <div class="form-control">
            <label for="celular" class="label">Celular:</label>
            <input type="text" class="input input-bordered" id="celular" name="celular" required>
        </div>

        <div class="form-control">
            <label for="correo" class="label">Correo:</label>
            <input type="email" class="input input-bordered" id="correo" name="correo" required>
        </div>


        <div class="form-control">
            <label for="codAsistencia" class="label">Código de Asistencia:</label>
            <input type="number" class="input input-bordered" id="codAsistencia" name="codAsistencia" required>
        </div>

        <button type="submit" class="btn btn-primary">Inscribir Alumno</button>
    </form>
</div>

<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>