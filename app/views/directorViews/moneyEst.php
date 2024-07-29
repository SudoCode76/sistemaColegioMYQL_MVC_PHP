<?php
require_once __DIR__ . '/../../config/checkSession.php';
require_once __DIR__ . '/../../config/conexion.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$mes = isset($_GET['mes']) ? $_GET['mes'] : '';
$estadoPago = isset($_GET['estadoPago']) ? $_GET['estadoPago'] : '';
?>

<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>GESTIÓN DE MENSUALIDADES</title>
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
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Buscar por estudiante" class="input input-bordered flex-grow">
                <input type="month" name="mes" value="<?php echo htmlspecialchars($mes); ?>" class="input input-bordered">
                <select name="estadoPago" class="select select-bordered">
                    <option value="">Todos</option>
                    <option value="Pagado" <?php if ($estadoPago == 'Pagado') echo 'selected'; ?>>Pagado</option>
                    <option value="Pendiente" <?php if ($estadoPago == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                </select>
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Mes de Pago</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT E.codEstudiante, E.nombre, E.apellido, 
                                   COALESCE(PM.mesPago, ?) AS mesPago, 
                                   COALESCE(PM.monto, 0) AS monto, 
                                   COALESCE(PM.estadoPago, 'Pendiente') AS estadoPago
                            FROM ESTUDIANTE E
                            LEFT JOIN PAGO_MENSUALIDAD_ESTUDIANTE PM 
                            ON E.codEstudiante = PM.codEstudiante AND DATE_FORMAT(PM.mesPago, '%Y-%m') = ?
                            WHERE (E.nombre LIKE ? OR E.apellido LIKE ?)
                            AND (? = '' OR PM.estadoPago = ? OR PM.estadoPago IS NULL)";
                    $stmt = $conexion->prepare($sql);
                    $searchParam = "%$search%";
                    $stmt->bind_param("ssssss", $mes, $mes, $searchParam, $searchParam, $estadoPago, $estadoPago);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row["nombre"]) . " " . htmlspecialchars($row["apellido"]) . "</td>
                                    <td>" . htmlspecialchars($row["mesPago"]) . "</td>
                                    <td>" . htmlspecialchars($row["monto"]) . "</td>
                                    <td>" . htmlspecialchars($row["estadoPago"]) . "</td>
                                    <td>";
                            if ($row["estadoPago"] == 'Pendiente') {
                                echo "<a href='../../controllers/directorControllers/gestionMensualidad/marcarPagado.php?estudiante=" . urlencode($row["codEstudiante"]) . "&mes=" . urlencode($row["mesPago"]) . "' class='btn btn-success btn-md mx-2'>Marcar como Pagado</a>";
                            }
                            echo "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No hay mensualidades</td></tr>";
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
