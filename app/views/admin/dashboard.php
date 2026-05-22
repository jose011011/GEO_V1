<?php
$usuario = $_SESSION['usuario'] ?? null;

$estadisticas = $estadisticas ?? [
    'clientes' => 0,
    'profesionales' => 0,
    'pendientes' => 0,
    'aprobados' => 0,
    'rechazados' => 0,
    'categorias' => 0
];

$nombreUsuario = $usuario['nombre'] ?? 'Administrador';

$activePage = 'dashboard';
$pageTitle = 'Dashboard administrativo';
$pageSubtitle = 'Resumen general del sistema GEO V1';

$totalProfesionales = (int)$estadisticas['profesionales'];
$porcentajeAprobados = $totalProfesionales > 0 ? min(100, ($estadisticas['aprobados'] / $totalProfesionales) * 100) : 0;
$porcentajePendientes = $totalProfesionales > 0 ? min(100, ($estadisticas['pendientes'] / $totalProfesionales) * 100) : 0;
$porcentajeRechazados = $totalProfesionales > 0 ? min(100, ($estadisticas['rechazados'] / $totalProfesionales) * 100) : 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | GEO V1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-slate-100 min-h-screen">

<?php require_once __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<div class="md:ml-64 min-h-screen">

    <?php require_once __DIR__ . '/../layouts/admin_topbar.php'; ?>

    <main class="p-6">

        <!-- BIENVENIDA -->
        <section class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">
                        Bienvenido, <?= htmlspecialchars($nombreUsuario) ?>
                    </h1>

                    <p class="text-slate-500 mt-1">
                        Administra clientes, profesionales, categorías y validaciones desde un solo panel.
                    </p>
                </div>

                <a href="<?= BASE_URL ?>admin/pendientes"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold text-center">
                    Revisar validaciones
                </a>
            </div>
        </section>

        <!-- TARJETAS PRINCIPALES -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

            <a href="<?= BASE_URL ?>admin/clientes"
               class="rounded-2xl p-5 text-white bg-gradient-to-r from-emerald-500 to-emerald-600 shadow-sm hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-emerald-100">Total clientes</p>
                        <h3 class="text-3xl font-bold mt-2">
                            <?= htmlspecialchars($estadisticas['clientes']) ?>
                        </h3>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center font-bold text-lg">
                        C
                    </div>
                </div>
            </a>

            <a href="<?= BASE_URL ?>admin/profesionales"
               class="rounded-2xl p-5 text-white bg-gradient-to-r from-sky-500 to-blue-600 shadow-sm hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-100">Profesionales</p>
                        <h3 class="text-3xl font-bold mt-2">
                            <?= htmlspecialchars($estadisticas['profesionales']) ?>
                        </h3>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center font-bold text-lg">
                        P
                    </div>
                </div>
            </a>

            <a href="<?= BASE_URL ?>admin/pendientes"
               class="rounded-2xl p-5 text-white bg-gradient-to-r from-rose-500 to-pink-600 shadow-sm hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-rose-100">Pendientes</p>
                        <h3 class="text-3xl font-bold mt-2">
                            <?= htmlspecialchars($estadisticas['pendientes']) ?>
                        </h3>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center font-bold text-lg">
                        V
                    </div>
                </div>
            </a>

            <a href="<?= BASE_URL ?>categoria/index"
               class="rounded-2xl p-5 text-white bg-gradient-to-r from-amber-500 to-orange-500 shadow-sm hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-orange-100">Categorías activas</p>
                        <h3 class="text-3xl font-bold mt-2">
                            <?= htmlspecialchars($estadisticas['categorias']) ?>
                        </h3>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center font-bold text-lg">
                        T
                    </div>
                </div>
            </a>

        </section>

        <!-- GRÁFICO Y ESTADOS -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">
                            Resumen del sistema
                        </h3>
                        <p class="text-sm text-slate-500">
                            Vista general de registros y validaciones.
                        </p>
                    </div>
                </div>

                <canvas id="resumenChart" height="110"></canvas>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="font-bold text-slate-800 text-lg mb-5">
                    Estado de profesionales
                </h3>

                <div class="space-y-5">

                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-slate-600">Aprobados</span>
                            <span class="text-sm font-bold text-green-600">
                                <?= htmlspecialchars($estadisticas['aprobados']) ?>
                            </span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-3">
                            <div class="bg-green-500 h-3 rounded-full"
                                 style="width: <?= $porcentajeAprobados ?>%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-slate-600">Pendientes</span>
                            <span class="text-sm font-bold text-yellow-600">
                                <?= htmlspecialchars($estadisticas['pendientes']) ?>
                            </span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-3">
                            <div class="bg-yellow-500 h-3 rounded-full"
                                 style="width: <?= $porcentajePendientes ?>%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-sm text-slate-600">Rechazados</span>
                            <span class="text-sm font-bold text-red-600">
                                <?= htmlspecialchars($estadisticas['rechazados']) ?>
                            </span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-3">
                            <div class="bg-red-500 h-3 rounded-full"
                                 style="width: <?= $porcentajeRechazados ?>%"></div>
                        </div>
                    </div>

                </div>

                <div class="mt-8 p-4 rounded-xl bg-blue-50 border border-blue-100">
                    <p class="text-sm text-blue-700">
                        Mantén revisados los profesionales pendientes para asegurar la confiabilidad de la plataforma.
                    </p>
                </div>
            </div>

        </section>

        <!-- ACCESOS Y ACTIVIDAD -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6">
                <h3 class="font-bold text-slate-800 text-lg mb-5">
                    Accesos rápidos
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <a href="<?= BASE_URL ?>admin/clientes"
                       class="border border-slate-200 rounded-xl p-4 hover:bg-slate-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                                C
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">Gestionar clientes</h4>
                                <p class="text-sm text-slate-500">Editar, activar o bloquear clientes.</p>
                            </div>
                        </div>
                    </a>

                    <a href="<?= BASE_URL ?>admin/profesionales"
                       class="border border-slate-200 rounded-xl p-4 hover:bg-slate-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                                P
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">Gestionar profesionales</h4>
                                <p class="text-sm text-slate-500">Editar, aprobar o bloquear profesionales.</p>
                            </div>
                        </div>
                    </a>

                    <a href="<?= BASE_URL ?>admin/pendientes"
                       class="border border-slate-200 rounded-xl p-4 hover:bg-slate-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-yellow-100 text-yellow-700 flex items-center justify-center font-bold">
                                V
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">Validaciones pendientes</h4>
                                <p class="text-sm text-slate-500">Revisar documentos subidos.</p>
                            </div>
                        </div>
                    </a>

                    <a href="<?= BASE_URL ?>categoria/index"
                       class="border border-slate-200 rounded-xl p-4 hover:bg-slate-50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-orange-100 text-orange-700 flex items-center justify-center font-bold">
                                T
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">Categorías</h4>
                                <p class="text-sm text-slate-500">Administrar áreas técnicas.</p>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="font-bold text-slate-800 text-lg mb-5">
                    Estado operativo
                </h3>

                <div class="space-y-5">

                    <div class="flex gap-3">
                        <div class="w-3 h-3 mt-1 rounded-full bg-green-500"></div>
                        <div>
                            <h4 class="font-semibold text-slate-800 text-sm">Sistema activo</h4>
                            <p class="text-xs text-slate-500">El panel administrativo está funcionando.</p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <div class="w-3 h-3 mt-1 rounded-full bg-yellow-500"></div>
                        <div>
                            <h4 class="font-semibold text-slate-800 text-sm">Validaciones pendientes</h4>
                            <p class="text-xs text-slate-500">
                                Actualmente hay <?= htmlspecialchars($estadisticas['pendientes']) ?> registros pendientes.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <div class="w-3 h-3 mt-1 rounded-full bg-blue-500"></div>
                        <div>
                            <h4 class="font-semibold text-slate-800 text-sm">Categorías activas</h4>
                            <p class="text-xs text-slate-500">
                                Hay <?= htmlspecialchars($estadisticas['categorias']) ?> categorías disponibles.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <div class="w-3 h-3 mt-1 rounded-full bg-red-500"></div>
                        <div>
                            <h4 class="font-semibold text-slate-800 text-sm">Control de acceso</h4>
                            <p class="text-xs text-slate-500">
                                Solo administradores autorizados pueden ingresar.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </section>

    </main>
</div>

<script>
    const ctx = document.getElementById('resumenChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Clientes', 'Profesionales', 'Pendientes', 'Aprobados', 'Rechazados', 'Categorías'],
            datasets: [{
                label: 'Resumen',
                data: [
                    <?= (int)$estadisticas['clientes'] ?>,
                    <?= (int)$estadisticas['profesionales'] ?>,
                    <?= (int)$estadisticas['pendientes'] ?>,
                    <?= (int)$estadisticas['aprobados'] ?>,
                    <?= (int)$estadisticas['rechazados'] ?>,
                    <?= (int)$estadisticas['categorias'] ?>
                ],
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.12)',
                pointBackgroundColor: '#2563eb'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>

</body>
</html>