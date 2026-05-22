<?php
$pageTitle = $pageTitle ?? 'Panel administrativo';
$pageSubtitle = $pageSubtitle ?? 'Gestión general del sistema';
$usuario = $_SESSION['usuario'] ?? [];
$nombreUsuario = $usuario['nombre'] ?? 'Admin';
$rolUsuario = $usuario['rol'] ?? 'ADMIN';
?>

<header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 sticky top-0 z-20">
    <div>
        <h2 class="font-bold text-slate-800"><?= htmlspecialchars($pageTitle) ?></h2>
        <p class="text-xs text-slate-500"><?= htmlspecialchars($pageSubtitle) ?></p>
    </div>

    <div class="flex items-center gap-4">
        <div class="hidden md:block text-right">
            <p class="font-semibold text-slate-800"><?= htmlspecialchars($nombreUsuario) ?></p>
            <p class="text-xs text-slate-500"><?= htmlspecialchars($rolUsuario) ?></p>
        </div>

        <div class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold">
            <?= strtoupper(substr($nombreUsuario, 0, 1)) ?>
        </div>
    </div>
</header>