<?php
$errores = $errores ?? [];
$correo = $correo ?? '';
$mensajeExito = $_SESSION['mensaje_exito'] ?? '';
unset($_SESSION['mensaje_exito']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | GEO V1</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-2">GEO V1</h1>
        <p class="text-center text-gray-500 mb-6">Servicios técnicos por geolocalización</p>

        <?php if ($mensajeExito): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?= htmlspecialchars($mensajeExito) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errores)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc ml-5">
                    <?php foreach ($errores as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>auth/autenticar" method="POST" class="space-y-4">
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Correo electrónico</label>
                <input 
                    type="email"
                    name="correo"
                    value="<?= htmlspecialchars($correo) ?>"
                    placeholder="Ejemplo: usuario@gmail.com"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">Contraseña</label>
                <input 
                    type="password"
                    name="password"
                    placeholder="Ingrese su contraseña"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >
            </div>

            <button class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700">
                Iniciar sesión
            </button>
        </form>

        <div class="mt-6 text-center text-sm">
            <p class="text-gray-600">¿No tienes cuenta?</p>
            <div class="flex justify-center gap-4 mt-2">
                <a href="<?= BASE_URL ?>auth/registroCliente" class="text-blue-600 hover:underline">Cliente</a>
                <a href="<?= BASE_URL ?>auth/registroProfesional" class="text-blue-600 hover:underline">Profesional</a>
            </div>
        </div>
    </div>

</body>
</html>