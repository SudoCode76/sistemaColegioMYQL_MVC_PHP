<?php
require_once __DIR__ . '/../../config/checkSession.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@1.14.0/dist/full.css" rel="stylesheet">
</head>
<body>
<div class="drawer drawer-mobile">
    <input id="my-drawer" type="checkbox" class="drawer-toggle">
    <div class="drawer-content flex flex-col p-6">
        <!-- Contenido principal -->
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <div class="bg-white rounded-lg shadow-lg p-6 mt-4">
            <!-- Aquí va el contenido del dashboard -->
        </div>
    </div>

    <div class="drawer-side">
        <label for="my-drawer" class="drawer-overlay"></label>
        <ul class="menu p-4 overflow-y-auto w-80 bg-base-100 text-base-content">
            <!-- Menú -->
            <li class="py-2">
                <a href="#" class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9-2v12m-5-5h5m5 0h5M3 12v2m0 2l2 2m0 0l7 7 7-7m-9-2v12m-5-5h5m5 0h5"></path></svg>
                    <span>Inicio</span>
                </a>
            </li>
            <li class="py-2">
                <a href="#" class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <span>Orders</span>
                </a>
            </li>
            <li class="py-2">
                <a href="#" class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Customers</span>
                </a>
            </li>
            <li class="py-2">
                <a href="#" class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.28 0-4 1.72-4 4s1.72 4 4 4 4-1.72 4-4-1.72-4-4-4zM12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"></path></svg>
                    <span>Products</span>
                </a>
            </li>

            <li class="py-2">
                <a href="#" class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-3.09 1.26-4.66 2.59-5.66C15.91 4.56 17 4 19 4c2 0 3 .91 4 2s1 2 1 4c0 2-.91 3-2 4s-2 1-4 1c-1.67 0-2.99-.42-4-1.1M9 9.36c.96-2.68 2.96-3.58 5-3.94m-3.5 6.68c.91-1.53 1.77-1.8 2.63-1.8 1.52 0 3 .92 4 3s1 3 1 5c0 1-.92 2-2 2s-2 .38-4 1c-2 1-4 2-6 2-.71 0-1.45-.16-2-.5-.67-.4-1.13-.94-1.37-1.63s-.25-1.45-.25-2c0-2 1-3 2-4s3-2 5-2c1.68 0 3 .38 4 1M9 17c-1 0-2-1-2-3s1-3 2-3"></path></svg>
                    <span>Analytics</span>
                </a>
            </li>

            <li class="py-2">
                <a href="../../controllers/loginControllers/logout.php" class="flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-3.09 1.26-4.66 2.59-5.66C15.91 4.56 17 4 19 4c2 0 3 .91 4 2s1 2 1 4c0 2-.91 3-2 4s-2 1-4 1c-1.67 0-2.99-.42-4-1.1M9 9.36c.96-2.68 2.96-3.58 5-3.94m-3.5 6.68c.91-1.53 1.77-1.8 2.63-1.8 1.52 0 3 .92 4 3s1 3 1 5c0 1-.92 2-2 2s-2 .38-4 1c-2 1-4 2-6 2-.71 0-1.45-.16-2-.5-.67-.4-1.13-.94-1.37-1.63s-.25-1.45-.25-2c0-2 1-3 2-4s3-2 5-2c1.68 0 3 .38 4 1M9 17c-1 0-2-1-2-3s1-3 2-3"></path></svg>
                    <span>Cerrar Sesion</span>
                </a>
            </li>


        </ul>
    </div>
</div>
</body>
</html>
