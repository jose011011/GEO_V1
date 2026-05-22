<?php
$modo = $modo ?? 'crear';
$categoria = $categoria ?? [];
$errores = $errores ?? [];

$idCategoria = $categoria['id_categoria'] ?? '';
$nombre = $categoria['nombre_categoria'] ?? '';
$descripcion = $categoria['descripcion'] ?? '';

$esEditar = $modo === 'editar';

$action = $esEditar
    ? BASE_URL . 'categoria/actualizar/' . $idCategoria
    : BASE_URL . 'categoria/guardar';

$titulo = $esEditar ? 'Editar categoría' : 'Nueva categoría';
$boton = $esEditar ? 'Actualizar categoría' : 'Guardar categoría';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo) ?> | GEO V1</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<header class="bg-blue-700 text-white px-8 py-4 flex justify-between items-center">
    <h1 class="text-xl font-bold"><?= htmlspecialchars($titulo) ?></h1>

    <div class="flex gap-3">
        <a href="<?= BASE_URL ?>categoria/index" class="bg-gray-600 px-4 py-2 rounded-lg">
            Volver
        </a>

        <a href="<?= BASE_URL ?>auth/logout" class="bg-red-500 px-4 py-2 rounded-lg">
            Cerrar sesión
        </a>
    </div>
</header>

<main class="p-8 flex justify-center">

    <div class="bg-white rounded-xl shadow p-8 w-full max-w-2xl">

        <?php if (!empty($errores)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-5">
                <ul class="list-disc ml-5">
                    <?php foreach ($errores as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= $action ?>" method="POST" class="space-y-5">
            <div>
                <label class="block font-semibold text-gray-700 mb-1">
                    Nombre de categoría
                </label>
                <input 
                    type="text"
                    name="nombre_categoria"
                    value="<?= htmlspecialchars($nombre) ?>"
                    placeholder="Ejemplo: Electricista"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                >
                <p class="text-xs text-gray-500 mt-1">
                    Mínimo 3 caracteres. No debe repetirse.
                </p>
            </div>

            <div>
                <label class="block font-semibold text-gray-700 mb-1">
                    Descripción
                </label>
                <textarea 
                    name="descripcion"
                    rows="4"
                    placeholder="Describe qué servicios pertenecen a esta categoría."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2"
                ><?= htmlspecialchars($descripcion) ?></textarea>
                <p class="text-xs text-gray-500 mt-1">
                    Mínimo 10 caracteres.
                </p>
            </div>

            <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700">
                <?= htmlspecialchars($boton) ?>
            </button>
        </form>

    </div>

</main>

</body>
</html>