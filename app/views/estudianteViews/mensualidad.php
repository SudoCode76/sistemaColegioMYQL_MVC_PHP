<?php
require_once __DIR__ . '/../../config/checkSession.php';
require_once __DIR__ . '/../../config/conexion.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$month = isset($_GET['month']) ? $_GET['month'] : date('n');
$cedulaIdEstudiante = isset($_GET['cedulaIdEstudiante']) ? $_GET['cedulaIdEstudiante'] : '';

$currentYear = date('Y');
$yearOptions = range(2020, $currentYear);

$monthOptions = [
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
];
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
                <h1 class="text-3xl font-bold">Gestión de Mensualidades</h1>
            </div>

            <form method="GET" class="flex flex-col sm:flex-row gap-4 mb-6">
                <input type="text" name="cedulaIdEstudiante" value="<?php echo htmlspecialchars($cedulaIdEstudiante); ?>"
                       placeholder="Ingrese su cédula de identidad" class="input input-bordered flex-grow">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>

            <?php if ($cedulaIdEstudiante): ?>
                <form method="GET" class="flex flex-col sm:flex-row gap-4 mb-6">
                    <input type="hidden" name="cedulaIdEstudiante" value="<?php echo htmlspecialchars($cedulaIdEstudiante); ?>">
                    <select name="year" class="select select-bordered">
                        <?php foreach ($yearOptions as $yearOption): ?>
                            <option value="<?php echo $yearOption; ?>" <?php echo $yearOption == $year ? 'selected' : ''; ?>>
                                <?php echo $yearOption; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <select name="month" class="select select-bordered">
                        <?php foreach ($monthOptions as $monthNumber => $monthName): ?>
                            <option value="<?php echo $monthNumber; ?>" <?php echo $monthNumber == $month ? 'selected' : ''; ?>>
                                <?php echo $monthName; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>

                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Mes Pago</th>
                            <th>Monto</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "SELECT E.codEstudiante,
                               E.nombre,
                               E.apellido,
                               IFNULL(P.mesPago, ?) AS mesPago,
                               IFNULL(P.monto, 500.00) AS monto,
                               IFNULL(P.estadoPago, 'Pendiente') AS estadoPago
                        FROM ESTUDIANTE E
                        LEFT JOIN PAGO_MENSUALIDAD_ESTUDIANTE P 
                            ON E.codEstudiante = P.codEstudiante
                            AND YEAR(P.mesPago) = ?
                            AND MONTH(P.mesPago) = ?
                        WHERE (E.nombre LIKE ? OR E.apellido LIKE ?) 
                          AND E.cedulaIdEstudiante = ?";

                        $stmt = $conexion->prepare($sql);
                        $searchParam = "%$search%";
                        $defaultDate = "$year-$month-01";
                        $stmt->bind_param("ssssss", $defaultDate, $year, $month, $searchParam, $searchParam, $cedulaIdEstudiante);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($row["nombre"]) . "</td>
                                        <td>" . htmlspecialchars($row["apellido"]) . "</td>
                                        <td>" . htmlspecialchars($row["mesPago"]) . "</td>
                                        <td>" . htmlspecialchars($row["monto"]) . "</td>
                                        <td>" . htmlspecialchars($row["estadoPago"]) . "</td>
                                        <td>";
                                if ($row["estadoPago"] == 'Pendiente') {
                                    echo "<a href='../../controllers/estudianteControllers/pagar.php?id=" . urlencode($row["codEstudiante"]) . "&year=" . urlencode($year) . "&month=" . urlencode($month) . "' class='btn btn-success btn-md mx-2'>Pagar</a>";
                                }
                                echo "</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No hay registros</td></tr>";
                        }
                        $stmt->close();
                        $conexion->close();
                        ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
