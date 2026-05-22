<?php
$profesional = $profesional ?? [];
$categorias = $categorias ?? [];
$errores = $errores ?? [];

$idProfesional = $profesional['id_profesional'] ?? '';
$idUsuario = $profesional['id_usuario'] ?? '';
$nombre = $profesional['nombre'] ?? '';
$apellido = $profesional['apellido'] ?? '';
$correo = $profesional['correo'] ?? '';
$celular = $profesional['celular'] ?? '';
$idCategoria = $profesional['id_categoria'] ?? '';
$tipoDocumentoIdentidad = $profesional['tipo_documento_identidad'] ?? '';
$numeroDocumento = $profesional['numero_documento'] ?? '';
$experienciaAnios = $profesional['experiencia_anios'] ?? '';
$zonaTrabajo = $profesional['zona_trabajo'] ?? '';
$descripcionServicio = $profesional['descripcion_servicio'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar profesional | GEO V1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/validaciones.css">
</head>
<body class="bg-gray-100 min-h-screen">

<header class="bg-blue-700 text-white px-8 py-4 flex justify-between items-center">
    <h1 class="text-xl font-bold">Editar profesional</h1>

    <div class="flex gap-3">
        <a href="<?= BASE_URL ?>admin/profesionales" class="bg-gray-600 px-4 py-2 rounded-lg">
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
            id="formEditarProfesional"
            action="<?= BASE_URL ?>admin/actualizarProfesional/<?= htmlspecialchars($idProfesional) ?>"
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
                <label class="block text-gray-700 font-semibold mb-1">Categoría técnica</label>
                <select id="id_categoria" name="id_categoria" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    <option value="">Seleccione una categoría</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= htmlspecialchars($categoria['id_categoria']) ?>" <?= $idCategoria == $categoria['id_categoria'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categoria['nombre_categoria']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div id="id_categoria_error" class="error-message"></div>
                <p class="help-message">Seleccione electricista o técnico electrónico.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Tipo de documento</label>
                <select id="tipo_documento_identidad" name="tipo_documento_identidad" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    <option value="">Seleccione CI o NIT</option>
                    <option value="CI" <?= $tipoDocumentoIdentidad === 'CI' ? 'selected' : '' ?>>CI</option>
                    <option value="NIT" <?= $tipoDocumentoIdentidad === 'NIT' ? 'selected' : '' ?>>NIT</option>
                </select>
                <div id="tipo_documento_identidad_error" class="error-message"></div>
                <p class="help-message">CI para persona natural, NIT para negocio.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Número de documento</label>
                <input type="text" id="numero_documento" name="numero_documento" value="<?= htmlspecialchars($numeroDocumento) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="numero_documento_error" class="error-message"></div>
                <p class="help-message">CI: 5 a 12 dígitos. NIT: 7 a 15 dígitos.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Años de experiencia</label>
                <input type="number" id="experiencia_anios" name="experiencia_anios" value="<?= htmlspecialchars($experienciaAnios) ?>" min="0" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="experiencia_anios_error" class="error-message"></div>
                <p class="help-message">Debe estar entre 0 y 60 años.</p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-1">Zona de trabajo</label>
                <input type="text" id="zona_trabajo" name="zona_trabajo" value="<?= htmlspecialchars($zonaTrabajo) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="zona_trabajo_error" class="error-message"></div>
                <p class="help-message">Indique las zonas donde atiende.</p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-1">Descripción del servicio</label>
                <textarea id="descripcion_servicio" name="descripcion_servicio" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-2"><?= htmlspecialchars($descripcionServicio) ?></textarea>
                <div id="descripcion_servicio_error" class="error-message"></div>
                <p class="help-message">Mínimo 30 caracteres y máximo 500.</p>
            </div>

            <div class="md:col-span-2">
                <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700">
                    Actualizar profesional
                </button>
            </div>
        </form>

    </div>

</main>

<script src="<?= BASE_URL ?>assets/js/validarEditarProfesional.js"></script>
</body>
</html>