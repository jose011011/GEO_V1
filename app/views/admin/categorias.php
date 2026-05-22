<?php
$categorias = $categorias ?? [];
$mensaje = $_SESSION['mensaje_admin'] ?? '';
unset($_SESSION['mensaje_admin']);

$activePage = 'categorias';
$pageTitle = 'Gestión de categorías';
$pageSubtitle = 'Administración de áreas técnicas disponibles';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Categorías | GEO V1</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 min-h-screen">

<?php require_once __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<div class="md:ml-64 min-h-screen">
    <?php require_once __DIR__ . '/../layouts/admin_topbar.php'; ?>

    <main class="p-6">

        <?php if ($mensaje): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5">
                <?= htmlspecialchars($mensaje) ?>
            </div>
        <?php endif; ?>

        <section class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg">Listado de categorías</h3>
                    <p class="text-sm text-slate-500">Categorías disponibles para los profesionales.</p>
                </div>

                <a href="<?= BASE_URL ?>categoria/crear" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    Nueva categoría
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600 border-b border-slate-100">
                        <tr>
                            <th class="p-4 text-left">ID</th>
                            <th class="p-4 text-left">Categoría</th>
                            <th class="p-4 text-left">Descripción</th>
                            <th class="p-4 text-left">Estado</th>
                            <th class="p-4 text-left">Fecha</th>
                            <th class="p-4 text-left">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($categorias)): ?>
                            <tr>
                                <td colspan="6" class="p-6 text-center text-slate-500">
                                    No hay categorías registradas.
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($categorias as $cat): ?>
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="p-4 font-semibold text-slate-700"><?= htmlspecialchars($cat['id_categoria']) ?></td>
                                <td class="p-4 font-semibold text-slate-800"><?= htmlspecialchars($cat['nombre_categoria']) ?></td>
                                <td class="p-4 text-slate-600"><?= htmlspecialchars($cat['descripcion']) ?></td>

                                <td class="p-4">
                                    <?php if ($cat['estado'] == 1): ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            ACTIVA
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            INACTIVA
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="p-4 text-slate-600"><?= htmlspecialchars($cat['fecha_creacion']) ?></td>

                                <td class="p-4">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="<?= BASE_URL ?>categoria/editar/<?= $cat['id_categoria'] ?>"
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            Editar
                                        </a>

                                        <?php if ($cat['estado'] == 1): ?>
                                            <a href="<?= BASE_URL ?>categoria/desactivar/<?= $cat['id_categoria'] ?>"
                                               onclick="return confirm('¿Desactivar esta categoría?')"
                                               class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
                                                Desactivar
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= BASE_URL ?>categoria/activar/<?= $cat['id_categoria'] ?>"
                                               onclick="return confirm('¿Activar esta categoría?')"
                                               class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
                                                Activar
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </section>

    </main>
</div>

</body>
</html>