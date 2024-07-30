<?php
require_once __DIR__ . '/../../config/checkSession.php';
require_once __DIR__ . '/../../config/conexion.php';

$cedulaIdEmpleado = isset($_GET['cedulaIdEmpleado']) ? $_GET['cedulaIdEmpleado'] : '';
$year = isset($_GET['year']) ? $_GET['year'] : '';
$month = isset($_GET['month']) ? $_GET['month'] : '';

$query = "SELECT E.nombre, E.apellido, S.mesPago, S.monto, S.estadoPago 
          FROM PAGO_MENSUAL S 
          JOIN EMPLEADO E ON S.codEmpleado = E.codEmpleado
          WHERE E.cedulaIdEmpleado = ?";

$params = [$cedulaIdEmpleado];

if ($year) {
    $query .= " AND YEAR(S.mesPago) = ?";
    $params[] = $year;
}

if ($month) {
    $query .= " AND MONTH(S.mesPago) = ?";
    $params[] = $month;
}

$query .= " ORDER BY S.mesPago DESC";

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
    <title>Salarios del Empleado</title>
</head>
<body>
<div class="min-h-screen bg-base-100 text-base-content">
    <div class="container mx-auto p-4">
        <?php include "../loginViews/menuv2.php"; ?>

        <div class="bg-base-200 p-6 rounded-box shadow-lg">
            <h1 class="text-3xl font-bold mb-6 text-center">Salarios del Empleado</h1>
            <form method="GET" action="mostrarSalario.php" class="mb-6 flex flex-col sm:flex-row gap-4">
                <input type="hidden" name="cedulaIdEmpleado" value="<?php echo htmlspecialchars($cedulaIdEmpleado); ?>">

                <select name="year" class="select select-bordered w-full sm:w-auto">
                    <option value="">Todos los Años</option>
                    <?php
                    $currentYear = date('Y');
                    for ($y = 2020; $y <= $currentYear; $y++) {
                        echo "<option value=\"$y\" " . ($y == $year ? 'selected' : '') . ">$y</option>";
                    }
                    ?>
                </select>

                <select name="month" class="select select-bordered w-full sm:w-auto">
                    <option value="">Todos los Meses</option>
                    <option value="1" <?php echo ($month == 1 ? 'selected' : ''); ?>>Enero</option>
                    <option value="2" <?php echo ($month == 2 ? 'selected' : ''); ?>>Febrero</option>
                    <option value="3" <?php echo ($month == 3 ? 'selected' : ''); ?>>Marzo</option>
                    <option value="4" <?php echo ($month == 4 ? 'selected' : ''); ?>>Abril</option>
                    <option value="5" <?php echo ($month == 5 ? 'selected' : ''); ?>>Mayo</option>
                    <option value="6" <?php echo ($month == 6 ? 'selected' : ''); ?>>Junio</option>
                    <option value="7" <?php echo ($month == 7 ? 'selected' : ''); ?>>Julio</option>
                    <option value="8" <?php echo ($month == 8 ? 'selected' : ''); ?>>Agosto</option>
                    <option value="9" <?php echo ($month == 9 ? 'selected' : ''); ?>>Septiembre</option>
                    <option value="10" <?php echo ($month == 10 ? 'selected' : ''); ?>>Octubre</option>
                    <option value="11" <?php echo ($month == 11 ? 'selected' : ''); ?>>Noviembre</option>
                    <option value="12" <?php echo ($month == 12 ? 'selected' : ''); ?>>Diciembre</option>
                </select>

                <button type="submit" class="btn btn-primary w-full sm:w-auto">Filtrar</button>
            </form>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Mes de Pago</th>
                        <th>Monto</th>
                        <th>Estado de Pago</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . htmlspecialchars($row["nombre"]) . "</td>
                                <td>" . htmlspecialchars($row["apellido"]) . "</td>
                                <td>" . htmlspecialchars($row["mesPago"]) . "</td>
                                <td>" . htmlspecialchars($row["monto"]) . "</td>
                                <td>" . htmlspecialchars($row["estadoPago"]) . "</td>
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
