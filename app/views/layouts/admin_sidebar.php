<?php
$activePage = $activePage ?? '';
$usuario = $_SESSION['usuario'] ?? [];
$nombreUsuario = $usuario['nombre'] ?? 'Admin';
$rolUsuario = $usuario['rol'] ?? 'ADMIN';
?>

<aside class="w-64 bg-slate-900 text-slate-200 hidden md:flex flex-col fixed left-0 top-0 bottom-0">
    <div class="h-16 flex items-center gap-3 px-6 border-b border-slate-800">
        <div class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center font-bold text-white">
            G
        </div>
        <div>
            <h1 class="font-bold text-white leading-tight">GEO V1</h1>
            <p class="text-xs text-slate-400">Panel administrativo</p>
        </div>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2 text-sm">
        <a href="<?= BASE_URL ?>admin/dashboard"
           class="flex items-center gap-3 px-4 py-3 rounded-lg <?= $activePage === 'dashboard' ? 'bg-blue-600 text-white' : 'hover:bg-slate-800' ?>">
            <span class="w-6 h-6 rounded bg-slate-700 flex items-center justify-center text-xs font-bold">D</span>
            <span>Dashboard</span>
        </a>

        <a href="<?= BASE_URL ?>admin/clientes"
           class="flex items-center gap-3 px-4 py-3 rounded-lg <?= $activePage === 'clientes' ? 'bg-blue-600 text-white' : 'hover:bg-slate-800' ?>">
            <span class="w-6 h-6 rounded bg-slate-700 flex items-center justify-center text-xs font-bold">C</span>
            <span>Clientes</span>
        </a>

        <a href="<?= BASE_URL ?>admin/profesionales"
           class="flex items-center gap-3 px-4 py-3 rounded-lg <?= $activePage === 'profesionales' ? 'bg-blue-600 text-white' : 'hover:bg-slate-800' ?>">
            <span class="w-6 h-6 rounded bg-slate-700 flex items-center justify-center text-xs font-bold">P</span>
            <span>Profesionales</span>
        </a>

        <a href="<?= BASE_URL ?>admin/pendientes"
           class="flex items-center gap-3 px-4 py-3 rounded-lg <?= $activePage === 'pendientes' ? 'bg-blue-600 text-white' : 'hover:bg-slate-800' ?>">
            <span class="w-6 h-6 rounded bg-slate-700 flex items-center justify-center text-xs font-bold">V</span>
            <span>Validaciones</span>
        </a>

        <a href="<?= BASE_URL ?>categoria/index"
           class="flex items-center gap-3 px-4 py-3 rounded-lg <?= $activePage === 'categorias' ? 'bg-blue-600 text-white' : 'hover:bg-slate-800' ?>">
            <span class="w-6 h-6 rounded bg-slate-700 flex items-center justify-center text-xs font-bold">T</span>
            <span>Categorías</span>
        </a>
    </nav>

    <div class="p-4 border-t border-slate-800">
        <div class="mb-4">
            <p class="text-sm font-semibold text-white"><?= htmlspecialchars($nombreUsuario) ?></p>
            <p class="text-xs text-slate-400"><?= htmlspecialchars($rolUsuario) ?></p>
        </div>

        <a href="<?= BASE_URL ?>auth/logout"
           class="block text-center bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg text-sm font-semibold">
            Cerrar sesión
        </a>
    </div>
</aside>