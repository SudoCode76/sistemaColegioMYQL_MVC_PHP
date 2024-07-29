<?php
require_once __DIR__ . '/../../config/checkSession.php';
require_once __DIR__ . '/../../config/conexion.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$usuario = isset($_GET['usuario']) ? $_GET['usuario'] : '';
$contrasenia = isset($_GET['contrasenia']) ? $_GET['contrasenia'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GESTIÓN DE ALUMNOS</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="min-h-screen bg-base-100 text-base-content">
    <div class="container mx-auto p-4">
        <?php include "../loginViews/menuv2.php"; ?>

        <div class="bg-base-200 p-6 rounded-box shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Gestión de Alumnos</h1>
                <a href="../../controllers/secretariaControllers/gestionEstudiante/inscribirAlumno.php" class="btn btn-primary">Inscribir Alumno</a>
            </div>

            <form method="GET" class="flex flex-col sm:flex-row gap-4 mb-6">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Buscar por nombre o apellido" class="input input-bordered flex-grow">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Cédula ID</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT * FROM ESTUDIANTE WHERE nombre LIKE ? OR apellido LIKE ?";
                    $stmt = $conexion->prepare($sql);
                    $searchParam = "%$search%";
                    $stmt->bind_param("ss", $searchParam, $searchParam);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row["nombre"]) . "</td>
                                    <td>" . htmlspecialchars($row["apellido"]) . "</td>
                                    <td>" . htmlspecialchars($row["cedulaIdEstudiante"]) . "</td>
                                    <td>
                                        <a href='../../controllers/secretariaControllers/gestionEstudiante/editarAlumno.php?id=" . urlencode($row["codEstudiante"]) . "' class='btn btn-warning btn-md mx-2'>Editar</a>
                                        <a href='../../controllers/secretariaControllers/gestionEstudiante/eliminarAlumno.php?id=" . urlencode($row["codEstudiante"]) . "' class='btn btn-error btn-md mx-2'>Eliminar</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No hay alumnos</td></tr>";
                    }
                    $stmt->close();
                    $conexion->close();
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>
