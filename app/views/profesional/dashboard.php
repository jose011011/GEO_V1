<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Profesional | GEO V1</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <header class="bg-yellow-600 text-white px-8 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">Panel Profesional</h1>
        <a href="<?= BASE_URL ?>auth/logout" class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600">Cerrar sesión</a>
    </header>

    <main class="p-8">
        <section class="bg-white rounded-xl shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Bienvenido, <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>
            </h2>
            <p class="text-gray-600 mt-2">
                Tu cuenta profesional será revisada por administración antes de aparecer públicamente.
            </p>
        </section>
    </main>
</body>
</html>