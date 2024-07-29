<?php
require_once __DIR__ . '/../../config/checkSession.php';
require_once __DIR__ . '/../../config/conexion.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$role = isset($_GET['role']) ? $_GET['role'] : '';
$year = isset($_GET['year']) ? $_GET['year'] : '';
$month = isset($_GET['month']) ? $_GET['month'] : '';
?>

<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>GESTIÓN DE SALARIOS</title>
</head>
<body>
<div class="min-h-screen bg-base-100 text-base-content">
    <div class="container mx-auto p-4">
        <?php include "../loginViews/menuv2.php"; ?>

        <div class="bg-base-200 p-6 rounded-box shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Gestión de salarios</h1>
                <a href="../../controllers/directorControllers/gestionCuentas/anadir.php" class="btn btn-primary">Añadir Cuentas</a>
            </div>

            <form method="GET" class="flex flex-col sm:flex-row gap-4 mb-6">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Buscar por nombre o apellido" class="input input-bordered flex-grow">
                <select name="role" class="select select-bordered">
                    <option value="">Todos los roles</option>
                    <option value="Director" <?php if ($role == 'Director') echo 'selected'; ?>>Director</option>
                    <option value="Docente" <?php if ($role == 'Docente') echo 'selected'; ?>>Docente</option>
                    <option value="Secretaria" <?php if ($role == 'Secretaria') echo 'selected'; ?>>Secretaria</option>
                    <option value="Estudiante" <?php if ($role == 'Estudiante') echo 'selected'; ?>>Estudiante</option>
                </select>
                <input type="number" name="year" value="<?php echo htmlspecialchars($year); ?>" placeholder="Año" class="input input-bordered">
                <input type="number" name="month" value="<?php echo htmlspecialchars($month); ?>" placeholder="Mes" class="input input-bordered">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Cargo</th>
                        <th>Estado</th>
                        <th>Mes</th>
                        <th>Monto</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT
                                E.codEmpleado,
                                E.nombre,
                                E.apellido,
                                E.tipoEmpleado,
                                IFNULL(P.estadoPago, 'No Pagado') AS estadoPago,
                                P.mesPago,
                                P.monto
                            FROM
                                EMPLEADO E
                            LEFT JOIN
                                PAGO_MENSUAL P
                            ON
                                E.codEmpleado = P.codEmpleado
                            AND
                                (? = '' OR YEAR(P.mesPago) = ?)
                            AND
                                (? = '' OR MONTH(P.mesPago) = ?)
                            WHERE
                                (E.nombre LIKE ? OR E.apellido LIKE ?)
                                AND
                                (? = '' OR E.tipoEmpleado = ?)";

                    $stmt = $conexion->prepare($sql);
                    $searchParam = "%$search%";
                    $stmt->bind_param("ssssssss", $year, $year, $month, $month, $searchParam, $searchParam, $role, $role);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row["nombre"]) . "</td>
                                    <td>" . htmlspecialchars($row["apellido"]) . "</td>
                                    <td>" . htmlspecialchars($row["tipoEmpleado"]) . "</td>
                                    <td>" . htmlspecialchars($row["estadoPago"]) . "</td>
                                    <td>" . htmlspecialchars($row["mesPago"]) . "</td>
                                    <td>" . htmlspecialchars($row["monto"]) . "</td>
                                    <td>
                                        <a href='../../controllers/directorControllers/gestionSalarios/pagar.php?id=" . urlencode($row["codEmpleado"]) . "' class='btn btn-success btn-md mx-2'>Pagar</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>No hay registros</td></tr>";
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
