<?php
include '../../../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreUsuario = $_POST['nombreUsuario'];
    $contrasenia = $_POST['contrasenia'];
    $codRol = $_POST['codRol'] === "none" ? NULL : $_POST['codRol'];
    $codUsuario = $_POST['codUsuario'];

    if (empty($nombreUsuario) || empty($contrasenia)) {
        $error = "Por favor, complete todos los campos correctamente.";
    } else {

        $sql = "UPDATE USUARIO SET nombreUsuario=?, contrasenia=?, codRol=? WHERE codUsuario=?";
        $stmt = $conexion->prepare($sql);

        $stmt->bind_param("ssii", $nombreUsuario, $contrasenia, $codRol, $codUsuario);

        if ($stmt->execute()) {
            $success = "Dato actualizado correctamente.";

            header("refresh:2;url=../../../views/directorViews/cuentas.php");
        } else {
            $error = "Error al actualizar: " . $stmt->error;
        }

        $stmt->close();
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM USUARIO WHERE codUsuario=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Revisar
        $nombreUsuario = $row['nombreUsuario'];
        $contrasenia = $row['contrasenia'];
        $codRol = $row['codRol'] ? $row['codRol'] : "none";
    } else {
        $error = "Dato no encontrado";
    }

    $stmt->close();
} else {
    $error = "ID de dato no especificado";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Dato</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-5">Editar dato</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>" class="space-y-4">
        <input type="hidden" name="codUsuario" value="<?php echo htmlspecialchars($id); ?>">

        <div class="form-control">
            <label for="nombreUsuario" class="label">Nombre de Usuario:</label>
            <input type="text" class="input input-bordered" id="nombreUsuario" name="nombreUsuario" value="<?php echo htmlspecialchars($nombreUsuario); ?>" required>
        </div>

        <div class="form-control">
            <label for="contrasenia" class="label">Contraseña:</label>
            <input type="password" class="input input-bordered" id="contrasenia" name="contrasenia" value="<?php echo htmlspecialchars($contrasenia); ?>" required>
        </div>

        <div class="form-control">
            <label for="codRol" class="label">Rol:</label>
            <select class="select select-bordered" id="codRol" name="codRol" required>
                <?php
                $sql = "SELECT codRol, nombre FROM ROL";
                $result = $conexion->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row["codRol"]) . "' " . ($codRol == $row["codRol"] ? "selected" : "") . ">" . htmlspecialchars($row["nombre"]) . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>

<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
