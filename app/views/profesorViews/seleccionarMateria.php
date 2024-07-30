<?php
require_once __DIR__ . '/../../config/checkSession.php';
require_once __DIR__ . '/../../config/conexion.php';

if (!isset($_SESSION['codEmpleado'])) {
    echo "Error: No se ha encontrado la información del empleado en la sesión.";
    exit();
}

$codEmpleado = $_SESSION['codEmpleado'];

$sql = "SELECT M.codMateria, M.nombreMateria 
        FROM MATERIA M
        JOIN CURSOMATERIA CM ON M.codMateria = CM.codMateria
        JOIN ASIGNACIONCURSO AC ON CM.codCursoMateria = AC.codCursoMateria
        WHERE AC.codEmpleado = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $codEmpleado);
$stmt->execute();
$result = $stmt->get_result();
$materias = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Seleccionar Materia</title>
</head>
<body>
<div class="min-h-screen bg-base-100 text-base-content">
    <div class="container mx-auto p-4">
        <?php include "../loginViews/menuv2.php"; ?>

        <div class="bg-base-200 p-6 rounded-box shadow-lg">
            <h1 class="text-3xl font-bold mb-6">Seleccionar Materia</h1>

            <?php if (!empty($materias)): ?>
                <ul class="list-disc pl-5">
                    <?php foreach ($materias as $materia): ?>
                        <li>
                            <a href="ingresarNotas.php?codMateria=<?php echo $materia['codMateria']; ?>" class="text-blue-500">
                                <?php echo htmlspecialchars($materia['nombreMateria']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No tienes materias asignadas.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
