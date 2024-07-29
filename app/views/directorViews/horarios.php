<?php
require_once __DIR__ . '/../../config/checkSession.php';
require_once __DIR__ . '/../../config/conexion.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$curso = isset($_GET['curso']) ? $_GET['curso'] : '';
$materia = isset($_GET['materia']) ? $_GET['materia'] : '';
$periodo = isset($_GET['periodo']) ? $_GET['periodo'] : '';
?>

<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>GESTIÓN DE HORARIOS</title>
</head>
<body>
<div class="min-h-screen bg-base-100 text-base-content">
    <div class="container mx-auto p-4">
        <?php include "../loginViews/menuv2.php"; ?>

        <div class="bg-base-200 p-6 rounded-box shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Gestión de Horarios</h1>
                <a href="../../controllers/directorControllers/gestionHorario/anadirHorario.php" class="btn btn-primary">Añadir Horario</a>
            </div>

            <form method="GET" class="flex flex-col sm:flex-row gap-4 mb-6">

                <select name="curso" class="select select-bordered">
                    <option value="">Todos los cursos</option>
                    <?php
                    $sqlCurso = "SELECT codCurso, nombreCurso FROM CURSO";
                    $resultCurso = $conexion->query($sqlCurso);
                    while ($rowCurso = $resultCurso->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($rowCurso['codCurso']) . "' " . ($curso == $rowCurso['codCurso'] ? "selected" : "") . ">" . htmlspecialchars($rowCurso['nombreCurso']) . "</option>";
                    }
                    ?>
                </select>

                <select name="materia" class="select select-bordered">
                    <option value="">Todas las materias</option>
                    <?php
                    $sqlMateria = "SELECT codMateria, nombreMateria FROM MATERIA";
                    $resultMateria = $conexion->query($sqlMateria);
                    while ($rowMateria = $resultMateria->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($rowMateria['codMateria']) . "' " . ($materia == $rowMateria['codMateria'] ? "selected" : "") . ">" . htmlspecialchars($rowMateria['nombreMateria']) . "</option>";
                    }
                    ?>
                </select>

                <select name="periodo" class="select select-bordered">
                    <option value="">Todos los periodos</option>
                    <option value="Mañana" <?php if ($periodo == 'Mañana') echo 'selected'; ?>>Mañana</option>
                    <option value="Tarde" <?php if ($periodo == 'Tarde') echo 'selected'; ?>>Tarde</option>
                </select>

                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Materia</th>
                        <th>Curso</th>
                        <th>Periodo</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT 
                                E.nombre, 
                                E.apellido, 
                                M.nombreMateria, 
                                C.nombreCurso, 
                                H.periodo, 
                                H.horaInicio, 
                                H.horaFin,
                                H.codHorario
                            FROM HORARIO H
                            JOIN CURSOMATERIA CM ON H.codCursoMateria = CM.codCursoMateria
                            JOIN MATERIA M ON CM.codMateria = M.codMateria
                            JOIN CURSO C ON CM.codCurso = C.codCurso
                            JOIN ASIGNACIONCURSO AC ON CM.codCursoMateria = AC.codCursoMateria
                            JOIN EMPLEADO E ON AC.codEmpleado = E.codEmpleado
                            WHERE E.tipoEmpleado = 'Docente'
                            AND (E.nombre LIKE ? OR E.apellido LIKE ?)";

                    // Variables para los parámetros de la consulta
                    $searchParam = "%$search%";
                    $types = 'ss';
                    $params = [$searchParam, $searchParam];

                    // Agregar filtros adicionales si se seleccionaron
                    if ($curso) {
                        $sql .= " AND C.codCurso = ?";
                        $types .= 'i';
                        $params[] = $curso;
                    }
                    if ($materia) {
                        $sql .= " AND M.codMateria = ?";
                        $types .= 'i';
                        $params[] = $materia;
                    }
                    if ($periodo) {
                        $sql .= " AND H.periodo = ?";
                        $types .= 's';
                        $params[] = $periodo;
                    }

                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param($types, ...$params);

                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row["nombre"]) . "</td>
                                    <td>" . htmlspecialchars($row["apellido"]) . "</td>
                                    <td>" . htmlspecialchars($row["nombreMateria"]) . "</td>
                                    <td>" . htmlspecialchars($row["nombreCurso"]) . "</td>
                                    <td>" . htmlspecialchars($row["periodo"]) . "</td>
                                    <td>" . htmlspecialchars($row["horaInicio"]) . "</td>
                                    <td>" . htmlspecialchars($row["horaFin"]) . "</td>
                                    <td>
                                        <a href='../../controllers/directorControllers/gestionHorario/editarHorario.php?id=" . urlencode($row["codHorario"]) . "' class='btn btn-warning btn-md mx-2'>Editar</a>
                                        <a href='../../controllers/directorControllers/gestionHorario/eliminarHorario.php?id=" . urlencode($row["codHorario"]) . "' class='btn btn-error btn-md mx-2'>Eliminar</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No hay horarios</td></tr>";
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
