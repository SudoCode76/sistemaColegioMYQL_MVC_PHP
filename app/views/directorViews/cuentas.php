<?php
require_once __DIR__ . '/../../config/checkSession.php';
require_once __DIR__ . '/../../config/conexion.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$role = isset($_GET['role']) ? $_GET['role'] : '';
?>

<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>GESTIÓN DE CUENTAS</title>
    <script>
        // Función para cambiar el tema
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        }

        // Aplicar el tema guardado o el preferido del sistema
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
            } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        });
    </script>
</head>
<body>
<div class="min-h-screen bg-base-100 text-base-content">

    <div class="container mx-auto p-4">

        <?php include "../loginViews/menuv2.php"; ?>

        <div class="bg-base-200 p-6 rounded-box shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">Gestión de Cuentas</h1>
                <a href="../../controllers/directorControllers/gestionCuentas/anadir.php" class="btn btn-primary">Añadir Cuentas</a>
            </div>

            <form method="GET" class="flex flex-col sm:flex-row gap-4 mb-6">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Buscar por usuario" class="input input-bordered flex-grow">
                <select name="role" class="select select-bordered">
                    <option value="">Todos los roles</option>
                    <option value="Director" <?php if ($role == 'Director') echo 'selected'; ?>>Director</option>
                    <option value="Profesor" <?php if ($role == 'Profesor') echo 'selected'; ?>>Profesor</option>
                    <option value="Secretaria" <?php if ($role == 'Secretaria') echo 'selected'; ?>>Secretaria</option>
                    <option value="Estudiante" <?php if ($role == 'Estudiante') echo 'selected'; ?>>Estudiante</option>
                </select>
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Password</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT USUARIO.codUsuario, USUARIO.nombreUsuario, USUARIO.contrasenia, R.nombre
                            FROM USUARIO JOIN ROL R on USUARIO.codRol = R.codRol 
                            WHERE USUARIO.nombreUsuario LIKE ? AND (? = '' OR R.nombre = ?)";
                    $stmt = $conexion->prepare($sql);
                    $searchParam = "%$search%";
                    $stmt->bind_param("sss", $searchParam, $role, $role);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row["nombreUsuario"]) . "</td>
                                    <td>
                                        <span class='password'>••••••••</span>
                                        <button class='btn btn-ghost btn-xs' onclick='togglePassword(this)'>
                                            <i class='fas fa-eye'></i>
                                        </button>
                                        <span class='hidden-password hidden'>" . htmlspecialchars($row["contrasenia"]) . "</span>
                                    </td>
                                    <td>" . htmlspecialchars($row["nombre"]) . "</td>
                                    <td>
                                        <a href='../../controllers/directorControllers/gestionCuentas/editar.php?id=" . urlencode($row["codUsuario"]) . "' class='btn btn-warning btn-md mx-2'>Editar</a>
                                        <a href='../../controllers/directorControllers/gestionCuentas/eliminar.php?id=" . urlencode($row["codUsuario"]) . "' class='btn btn-error btn-md mx-2'>Eliminar</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No hay usuarios</td></tr>";
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

<script>
    function togglePassword(button) {
        const row = button.closest('tr');
        const passwordSpan = row.querySelector('.password');
        const hiddenPasswordSpan = row.querySelector('.hidden-password');
        const icon = button.querySelector('i');

        if (passwordSpan.textContent === '••••••••') {
            passwordSpan.textContent = hiddenPasswordSpan.textContent;
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordSpan.textContent = '••••••••';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
</body>
</html>