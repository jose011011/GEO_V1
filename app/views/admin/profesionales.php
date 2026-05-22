<?php
$profesionales = $profesionales ?? [];
$mensaje = $_SESSION['mensaje_admin'] ?? '';
unset($_SESSION['mensaje_admin']);

$activePage = 'profesionales';
$pageTitle = 'Gestión de profesionales';
$pageSubtitle = 'Administración de técnicos registrados en la plataforma';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Profesionales | GEO V1</title>
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
                    <h3 class="font-bold text-slate-800 text-lg">Listado de profesionales</h3>
                    <p class="text-sm text-slate-500">Profesionales técnicos registrados.</p>
                </div>

                <a href="<?= BASE_URL ?>admin/pendientes" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                    Ver pendientes
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600 border-b border-slate-100">
                        <tr>
                            <th class="p-4 text-left">ID</th>
                            <th class="p-4 text-left">Profesional</th>
                            <th class="p-4 text-left">Categoría</th>
                            <th class="p-4 text-left">Documento</th>
                            <th class="p-4 text-left">Zona</th>
                            <th class="p-4 text-left">Validación</th>
                            <th class="p-4 text-left">Usuario</th>
                            <th class="p-4 text-left">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($profesionales)): ?>
                            <tr>
                                <td colspan="8" class="p-6 text-center text-slate-500">
                                    No hay profesionales registrados.
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($profesionales as $pro): ?>
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="p-4 font-semibold text-slate-700">
                                    <?= htmlspecialchars($pro['id_profesional']) ?>
                                </td>

                                <td class="p-4">
                                    <p class="font-semibold text-slate-800">
                                        <?= htmlspecialchars($pro['nombre'] . ' ' . $pro['apellido']) ?>
                                    </p>
                                    <p class="text-xs text-slate-500"><?= htmlspecialchars($pro['correo']) ?></p>
                                    <p class="text-xs text-slate-500"><?= htmlspecialchars($pro['celular']) ?></p>
                                </td>

                                <td class="p-4"><?= htmlspecialchars($pro['nombre_categoria']) ?></td>

                                <td class="p-4">
                                    <p class="font-semibold text-slate-700"><?= htmlspecialchars($pro['tipo_documento_identidad']) ?></p>
                                    <p class="text-xs text-slate-500"><?= htmlspecialchars($pro['numero_documento']) ?></p>
                                </td>

                                <td class="p-4"><?= htmlspecialchars($pro['zona_trabajo']) ?></td>

                                <td class="p-4">
                                    <?php if ($pro['estado_validacion'] === 'APROBADO'): ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">APROBADO</span>
                                    <?php elseif ($pro['estado_validacion'] === 'RECHAZADO'): ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">RECHAZADO</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">PENDIENTE</span>
                                    <?php endif; ?>
                                </td>

                                <td class="p-4">
                                    <?php if ($pro['estado_usuario'] === 'ACTIVO'): ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">ACTIVO</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            <?= htmlspecialchars($pro['estado_usuario']) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td class="p-4">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="<?= BASE_URL ?>admin/verProfesional/<?= $pro['id_profesional'] ?>"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            Ver
                                        </a>

                                        <a href="<?= BASE_URL ?>admin/editarProfesional/<?= $pro['id_profesional'] ?>"
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            Editar
                                        </a>

                                        <a href="<?= BASE_URL ?>admin/aprobarProfesional/<?= $pro['id_profesional'] ?>"
                                           onclick="return confirm('¿Aprobar este profesional?')"
                                           class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            Aprobar
                                        </a>

                                        <a href="<?= BASE_URL ?>admin/rechazarProfesional/<?= $pro['id_profesional'] ?>"
                                           onclick="return confirm('¿Rechazar este profesional?')"
                                           class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            Rechazar
                                        </a>

                                        <?php if ($pro['estado_usuario'] === 'ACTIVO'): ?>
                                            <a href="<?= BASE_URL ?>admin/bloquearProfesional/<?= $pro['id_usuario'] ?>"
                                               onclick="return confirm('¿Bloquear este profesional?')"
                                               class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
                                                Bloquear
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= BASE_URL ?>admin/activarProfesional/<?= $pro['id_usuario'] ?>"
                                               onclick="return confirm('¿Activar este profesional?')"
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