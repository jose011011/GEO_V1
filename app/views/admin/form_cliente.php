<?php
$cliente = $cliente ?? [];
$errores = $errores ?? [];

$idCliente = $cliente['id_cliente'] ?? '';
$idUsuario = $cliente['id_usuario'] ?? '';
$nombre = $cliente['nombre'] ?? '';
$apellido = $cliente['apellido'] ?? '';
$correo = $cliente['correo'] ?? '';
$celular = $cliente['celular'] ?? '';
$zona = $cliente['zona'] ?? '';
$direccion = $cliente['direccion_referencia'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar cliente | GEO V1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/validaciones.css">
</head>
<body class="bg-gray-100 min-h-screen">

<header class="bg-blue-700 text-white px-8 py-4 flex justify-between items-center">
    <h1 class="text-xl font-bold">Editar cliente</h1>

    <div class="flex gap-3">
        <a href="<?= BASE_URL ?>admin/clientes" class="bg-gray-600 px-4 py-2 rounded-lg">
            Volver
        </a>

        <a href="<?= BASE_URL ?>auth/logout" class="bg-red-500 px-4 py-2 rounded-lg">
            Cerrar sesión
        </a>
    </div>
</header>

<main class="p-8 flex justify-center">

    <div class="bg-white rounded-xl shadow p-8 w-full max-w-4xl">

        <?php if (!empty($errores)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-5">
                <ul class="list-disc ml-5">
                    <?php foreach ($errores as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form 
            id="registroClienteForm"
            action="<?= BASE_URL ?>admin/actualizarCliente/<?= htmlspecialchars($idCliente) ?>"
            method="POST"
            class="grid grid-cols-1 md:grid-cols-2 gap-5"
            novalidate
        >
            <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($idUsuario) ?>">

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="nombre_error" class="error-message"></div>
                <p class="help-message">Solo letras. Máximo tres nombres.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($apellido) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="apellido_error" class="error-message"></div>
                <p class="help-message">Ingrese un solo apellido, sin números ni espacios.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Correo electrónico</label>
                <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($correo) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="correo_error" class="error-message"></div>
                <p class="help-message">Debe tener @ y dominio.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Celular</label>
                <input type="text" id="celular" name="celular" value="<?= htmlspecialchars($celular) ?>" maxlength="15" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="celular_error" class="error-message"></div>
                <p class="help-message">Solo números. Entre 7 y 15 dígitos.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Zona</label>
                <input type="text" id="zona" name="zona" value="<?= htmlspecialchars($zona) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="zona_error" class="error-message"></div>
                <p class="help-message">Indique la zona del cliente.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Dirección de referencia</label>
                <input type="text" id="direccion_referencia" name="direccion_referencia" value="<?= htmlspecialchars($direccion) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="direccion_referencia_error" class="error-message"></div>
                <p class="help-message">Escriba una referencia clara.</p>
            </div>

            <div class="md:col-span-2">
                <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700">
                    Actualizar cliente
                </button>
            </div>
        </form>

    </div>

</main>

<script src="<?= BASE_URL ?>assets/js/validarCliente.js"></script>
</body>
</html>