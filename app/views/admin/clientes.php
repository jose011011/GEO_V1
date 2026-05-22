<?php
$clientes = $clientes ?? [];
$mensaje = $_SESSION['mensaje_admin'] ?? '';
unset($_SESSION['mensaje_admin']);

$activePage = 'clientes';
$pageTitle = 'Gestión de clientes';
$pageSubtitle = 'Administración de usuarios registrados como clientes';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes | GEO V1</title>
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
                    <h3 class="font-bold text-slate-800 text-lg">Listado de clientes</h3>
                    <p class="text-sm text-slate-500">Clientes registrados en la plataforma.</p>
                </div>

                <a href="<?= BASE_URL ?>admin/dashboard" class="bg-slate-800 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    Volver al panel
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600 border-b border-slate-100">
                        <tr>
                            <th class="p-4 text-left">ID</th>
                            <th class="p-4 text-left">Cliente</th>
                            <th class="p-4 text-left">Contacto</th>
                            <th class="p-4 text-left">Ubicación</th>
                            <th class="p-4 text-left">Estado</th>
                            <th class="p-4 text-left">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($clientes)): ?>
                            <tr>
                                <td colspan="6" class="p-6 text-center text-slate-500">
                                    No hay clientes registrados.
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($clientes as $cliente): ?>
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="p-4 font-semibold text-slate-700">
                                    <?= htmlspecialchars($cliente['id_cliente']) ?>
                                </td>

                                <td class="p-4">
                                    <p class="font-semibold text-slate-800">
                                        <?= htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellido']) ?>
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        Registrado: <?= htmlspecialchars($cliente['fecha_registro']) ?>
                                    </p>
                                </td>

                                <td class="p-4">
                                    <p class="text-slate-700"><?= htmlspecialchars($cliente['correo']) ?></p>
                                    <p class="text-xs text-slate-500"><?= htmlspecialchars($cliente['celular']) ?></p>
                                </td>

                                <td class="p-4">
                                    <p class="text-slate-700"><?= htmlspecialchars($cliente['zona']) ?></p>
                                    <p class="text-xs text-slate-500"><?= htmlspecialchars($cliente['direccion_referencia']) ?></p>
                                </td>

                                <td class="p-4">
                                    <?php if ($cliente['estado'] === 'ACTIVO'): ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            ACTIVO
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            <?= htmlspecialchars($cliente['estado']) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="p-4">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="<?= BASE_URL ?>admin/editarCliente/<?= $cliente['id_cliente'] ?>"
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            Editar
                                        </a>

                                        <?php if ($cliente['estado'] === 'ACTIVO'): ?>
                                            <a href="<?= BASE_URL ?>admin/bloquearUsuario/<?= $cliente['id_usuario'] ?>"
                                               onclick="return confirm('¿Seguro que deseas bloquear este cliente?')"
                                               class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
                                                Bloquear
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= BASE_URL ?>admin/activarUsuario/<?= $cliente['id_usuario'] ?>"
                                               onclick="return confirm('¿Seguro que deseas activar este cliente?')"
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