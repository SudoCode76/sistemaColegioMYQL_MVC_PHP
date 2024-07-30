<?php
require_once __DIR__ . '/../../config/checkSession.php';
require_once __DIR__ . '/../../config/conexion.php';

$cedulaIdEstudiante = isset($_GET['cedulaIdEstudiante']) ? $_GET['cedulaIdEstudiante'] : '';
$materia = isset($_GET['materia']) ? $_GET['materia'] : '';
$trimestre = isset($_GET['trimestre']) ? $_GET['trimestre'] : '';

$query = "SELECT E.nombre, E.apellido, M.nombreMateria, N.trimestre, N.nota 
          FROM NOTA N 
          JOIN ESTUDIANTE E ON N.codEstudiante = E.codEstudiante
          JOIN CURSOMATERIA CM ON N.codCursoMateria = CM.codCursoMateria
          JOIN MATERIA M ON CM.codMateria = M.codMateria
          WHERE E.cedulaIdEstudiante = ?";

$params = [$cedulaIdEstudiante];

if ($materia) {
    $query .= " AND M.nombreMateria = ?";
    $params[] = $materia;
}

if ($trimestre) {
    $query .= " AND N.trimestre = ?";
    $params[] = $trimestre;
}

$stmt = $conexion->prepare($query);
$stmt->bind_param(str_repeat('s', count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Notas del Estudiante</title>
</head>
<body>
<div class="min-h-screen bg-base-100 text-base-content">
    <div class="container mx-auto p-4">
        <?php include "../loginViews/menuv2.php"; ?>

        <div class="bg-base-200 p-6 rounded-box shadow-lg">
            <h1 class="text-3xl font-bold mb-6 text-center">Notas del Estudiante</h1>
            <form method="GET" action="mostrarNotas.php" class="mb-6 flex flex-col sm:flex-row gap-4">
                <input type="hidden" name="cedulaIdEstudiante" value="<?php echo htmlspecialchars($cedulaIdEstudiante); ?>">
                <select name="materia" class="select select-bordered w-full sm:w-auto">
                    <option value="">Todas las Materias</option>
                    <?php
                    $materiaQuery = "SELECT DISTINCT M.nombreMateria FROM MATERIA M 
                                     JOIN CURSOMATERIA CM ON M.codMateria = CM.codMateria 
                                     JOIN NOTA N ON CM.codCursoMateria = N.codCursoMateria
                                     JOIN ESTUDIANTE E ON N.codEstudiante = E.codEstudiante
                                     WHERE E.cedulaIdEstudiante = ?";
                    $materiaStmt = $conexion->prepare($materiaQuery);
                    $materiaStmt->bind_param("s", $cedulaIdEstudiante);
                    $materiaStmt->execute();
                    $materiaResult = $materiaStmt->get_result();

                    while ($row = $materiaResult->fetch_assoc()) {
                        echo "<option value=\"" . htmlspecialchars($row['nombreMateria']) . "\">" . htmlspecialchars($row['nombreMateria']) . "</option>";
                    }

                    $materiaStmt->close();
                    ?>
                </select>

                <select name="trimestre" class="select select-bordered w-full sm:w-auto">
                    <option value="">Todos los Trimestres</option>
                    <option value="Primer Trimestre">Primer Trimestre</option>
                    <option value="Segundo Trimestre">Segundo Trimestre</option>
                    <option value="Tercer Trimestre">Tercer Trimestre</option>
                </select>

                <button type="submit" class="btn btn-primary w-full sm:w-auto">Filtrar</button>
            </form>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Materia</th>
                        <th>Trimestre</th>
                        <th>Nota</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . htmlspecialchars($row["nombre"]) . "</td>
                                <td>" . htmlspecialchars($row["apellido"]) . "</td>
                                <td>" . htmlspecialchars($row["nombreMateria"]) . "</td>
                                <td>" . htmlspecialchars($row["trimestre"]) . "</td>
                                <td>" . htmlspecialchars($row["nota"]) . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No hay registros</td></tr>";
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
