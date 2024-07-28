<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Colegio Privado Login</title>
</head>
<body class="bg-gray-900 text-gray-100">
<div class="flex items-center justify-center min-h-screen bg-gray-900">
    <div
            class="relative flex flex-col m-6 space-y-8 bg-gray-800 shadow-2xl rounded-2xl md:flex-row md:space-y-0"
    >
        <!-- left side -->
        <div class="flex flex-col justify-center p-8 md:p-14">
            <span class="mb-3 text-4xl font-bold text-gray-100">Bienvenido</span>
            <span class="font-light text-gray-400 mb-8">
            ¡Bienvenido de nuevo! Por favor, introduzca sus datos
          </span>
            <form action="../../controllers/loginControllers/loginAction.php" method="POST">
                <div class="py-4">
                    <span class="mb-2 text-md text-gray-400">Usuario</span>
                    <input
                            type="text"
                            id="username"
                            name="username"
                            class="w-full p-2 border border-gray-600 rounded-md bg-gray-700 text-gray-100 placeholder:font-light placeholder:text-gray-500"
                    />
                </div>
                <div class="py-4">
                    <span class="mb-2 text-md text-gray-400">Contraseña</span>
                    <input
                            type="password"
                            name="password"
                            id="password"
                            class="w-full p-2 border border-gray-600 rounded-md bg-gray-700 text-gray-100 placeholder:font-light placeholder:text-gray-500"
                    />
                </div>

                <button
                        type="submit"
                        class="w-full bg-blue-600 text-white p-2 rounded-lg mb-6 hover:bg-blue-700"
                >
                    Iniciar sesión
                </button>
            </form>

            <?php if (isset($_GET['error'])): ?>
                <p>Error en el login. Inténtalo de nuevo.</p>
            <?php endif; ?>

        </div>
        <!-- right side -->
        <div class="relative">
            <img
                    src="../../../public/images/image.jpg"
                    alt="img"
                    class="w-[400px] h-full hidden rounded-r-2xl md:block object-cover"
            />
        </div>
    </div>
</div>
</body>
</html>
