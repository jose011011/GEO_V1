<?php
$profesionales = $profesionales ?? [];

$activePage = 'pendientes';
$pageTitle = 'Validaciones pendientes';
$pageSubtitle = 'Revisión de profesionales que esperan aprobación';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validaciones pendientes | GEO V1</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 min-h-screen">

<?php require_once __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<div class="md:ml-64 min-h-screen">
    <?php require_once __DIR__ . '/../layouts/admin_topbar.php'; ?>

    <main class="p-6">

        <section class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 text-lg">Profesionales pendientes</h3>
                <p class="text-sm text-slate-500">Revise documentos y datos antes de aprobar.</p>
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
                            <th class="p-4 text-left">Fecha</th>
                            <th class="p-4 text-left">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($profesionales)): ?>
                            <tr>
                                <td colspan="7" class="p-6 text-center text-slate-500">
                                    No hay profesionales pendientes.
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($profesionales as $pro): ?>
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="p-4 font-semibold text-slate-700"><?= htmlspecialchars($pro['id_profesional']) ?></td>

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
                                <td class="p-4"><?= htmlspecialchars($pro['fecha_registro']) ?></td>

                                <td class="p-4">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="<?= BASE_URL ?>admin/verProfesional/<?= $pro['id_profesional'] ?>"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            Revisar
                                        </a>

                                        <a href="<?= BASE_URL ?>admin/aprobarProfesional/<?= $pro['id_profesional'] ?>"
                                           onclick="return confirm('¿Aprobar este profesional?')"
                                           class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            Aprobar
                                        </a>

                                        <a href="<?= BASE_URL ?>admin/rechazarProfesional/<?= $pro['id_profesional'] ?>"
                                           onclick="return confirm('¿Rechazar este profesional?')"
                                           class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
                                            Rechazar
                                        </a>
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