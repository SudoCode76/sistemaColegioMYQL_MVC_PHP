<?php
include '../../../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreUsuario = $_POST['nombreUsuario'];
    $contrasenia = $_POST['contrasenia'];

    $codRol = $_POST['codRol'];

    $sql = "INSERT INTO USUARIO (nombreUsuario, contrasenia, codRol) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssi", $nombreUsuario, $contrasenia, $codRol);
    if ($stmt->execute()) {
        echo "Nueva dato agregado";
        header("Location: ../../../views/directorViews/cuentas.php");
        exit();
    } else {
        echo "Error al registrar: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nueva Prenda</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5">Añadir nuevo dato</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-4">

        <div class="form-control">
            <label for="nombreUsuario" class="label">Nombre Usuario:</label>
            <input type="text" class="input input-bordered" id="nombreUsuario" name="nombreUsuario" required>
        </div>

        <div class="form-control">
            <label for="contrasenia" class="label">contraseña:</label>
            <input type="password" class="input input-bordered" id="contrasenia" name="contrasenia" required>
        </div>

        <div class="form-control">
            <label for="codRol" class="label">Rol:</label>
            <select class="select select-bordered" id="codRol" name="codRol" required>
                <?php
                $sql = "SELECT codRol, nombre FROM ROL";
                $result = $conexion->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row["codRol"]) . "'>" . htmlspecialchars($row["nombre"]) . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Añadir</button>
    </form>
</div>

<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
