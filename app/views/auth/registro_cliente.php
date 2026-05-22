<?php
$errores = $errores ?? [];
$datos = $datos ?? [];

$nombre = $datos['nombre'] ?? '';
$apellido = $datos['apellido'] ?? '';
$correo = $datos['correo'] ?? '';
$celular = $datos['celular'] ?? '';
$zona = $datos['zona'] ?? '';
$direccion = $datos['direccion_referencia'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro cliente | GEO V1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/validaciones.css">
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center py-10 px-4">

    <div class="w-full max-w-4xl bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-2">Registro de cliente</h1>
        <p class="text-center text-gray-500 mb-6">Crea tu cuenta para solicitar servicios técnicos.</p>

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
            action="<?= BASE_URL ?>auth/guardarCliente"
            method="POST"
            class="grid grid-cols-1 md:grid-cols-2 gap-5"
            novalidate
        >
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" placeholder="Ejemplo: Juan Carlos" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="nombre_error" class="error-message"></div>
                <p class="help-message">Solo letras. Máximo tres nombres.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($apellido) ?>" placeholder="Ejemplo: Mamani" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="apellido_error" class="error-message"></div>
                <p class="help-message">Ingrese un solo apellido, sin números ni espacios.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Correo electrónico</label>
                <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($correo) ?>" placeholder="Ejemplo: cliente@gmail.com" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="correo_error" class="error-message"></div>
                <p class="help-message">Debe tener @ y dominio. Ejemplo: usuario@gmail.com.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Celular</label>
                <input type="text" id="celular" name="celular" value="<?= htmlspecialchars($celular) ?>" placeholder="Ejemplo: 76543210" maxlength="15" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="celular_error" class="error-message"></div>
                <p class="help-message">Solo números. Entre 7 y 15 dígitos.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Zona</label>
                <input type="text" id="zona" name="zona" value="<?= htmlspecialchars($zona) ?>" placeholder="Ejemplo: Sopocachi" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="zona_error" class="error-message"></div>
                <p class="help-message">Indique la zona donde vive o donde solicitará servicios.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Dirección de referencia</label>
                <input type="text" id="direccion_referencia" name="direccion_referencia" value="<?= htmlspecialchars($direccion) ?>" placeholder="Ejemplo: cerca de la plaza principal" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="direccion_referencia_error" class="error-message"></div>
                <p class="help-message">Escriba una referencia clara para ubicar el servicio.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Ejemplo: Cliente123@" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="password_error" class="error-message"></div>
                <p class="help-message">Mínimo 8 caracteres, mayúscula, minúscula, número y símbolo.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Confirmar contraseña</label>
                <input type="password" id="confirmar_password" name="confirmar_password" placeholder="Repita la contraseña" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="confirmar_password_error" class="error-message"></div>
                <p class="help-message">Debe escribir exactamente la misma contraseña.</p>
            </div>

            <div class="md:col-span-2">
                <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700">
                    Crear cuenta de cliente
                </button>
            </div>
        </form>

        <div class="mt-6 text-center text-sm">
            <a href="<?= BASE_URL ?>auth/login" class="text-blue-600 hover:underline">Ya tengo una cuenta</a>
        </div>
    </div>

    <script src="<?= BASE_URL ?>assets/js/validarCliente.js"></script>
</body>
</html>