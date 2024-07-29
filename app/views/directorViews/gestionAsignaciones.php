<?php
require_once __DIR__ . '/../../config/checkSession.php';
require_once __DIR__ . '/../../config/conexion.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
?>

<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>GESTIÓN DE ASIGNACIONES</title>
</head>
<body>
<div class="min-h-screen bg-base-100 text-base-content">

    <div class="container mx-auto p-4">

        <?php include "../loginViews/menuv2.php"; ?>

        <div class="bg-base-200 p-6 rounded-box shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Gestión de Asignaciones</h1>
                <a href="../../controllers/directorControllers/gestionAsignaciones/anadir.php" class="btn btn-primary">Añadir Asignación</a>
            </div>

            <form method="GET" class="flex flex-col sm:flex-row gap-4 mb-6">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Buscar por materia o curso" class="input input-bordered flex-grow">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Curso</th>
                        <th>Docente</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT M.nombreMateria, C.nombreCurso, CONCAT(E.nombre, ' ', E.apellido) AS nombreDocente, AC.codAsignacion
                            FROM ASIGNACIONCURSO AC
                            JOIN CURSOMATERIA CM ON AC.codCursoMateria = CM.codCursoMateria
                            JOIN MATERIA M ON CM.codMateria = M.codMateria
                            JOIN CURSO C ON CM.codCurso = C.codCurso
                            JOIN EMPLEADO E ON AC.codEmpleado = E.codEmpleado
                            WHERE M.nombreMateria LIKE ? OR C.nombreCurso LIKE ?";
                    $stmt = $conexion->prepare($sql);
                    $searchParam = "%$search%";
                    $stmt->bind_param("ss", $searchParam, $searchParam);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row["nombreMateria"]) . "</td>
                                    <td>" . htmlspecialchars($row["nombreCurso"]) . "</td>
                                    <td>" . htmlspecialchars($row["nombreDocente"]) . "</td>
                                    <td>
                                        <a href='../../controllers/directorControllers/gestionAsignaciones/editar.php?id=" . urlencode($row["codAsignacion"]) . "' class='btn btn-warning btn-md mx-2'>Editar</a>
                                        <a href='../../controllers/directorControllers/gestionAsignaciones/eliminar.php?id=" . urlencode($row["codAsignacion"]) . "' class='btn btn-error btn-md mx-2'>Eliminar</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No hay asignaciones</td></tr>";
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
