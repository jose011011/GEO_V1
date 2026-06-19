<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Solicitudes Recibidas</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">

<!-- HEADER -->
<header class="bg-white shadow-md p-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-yellow-600">
        Solicitudes Recibidas
    </h1>

    <!-- BOTÓN VOLVER -->
    <a href="<?= BASE_URL ?>profesional/dashboard"
       class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg text-sm">
        ← Volver al Dashboard
    </a>
</header>

<!-- CONTENIDO -->
<main class="flex-grow container mx-auto p-6">

<div class="bg-white shadow-lg rounded-xl overflow-hidden">

<table class="w-full text-sm">

<thead class="bg-yellow-500 text-white">
<tr>
<th class="p-4 text-left">Cliente</th>
<th class="p-4 text-left">Zona</th>
<th class="p-4 text-left">Estado</th>
<th class="p-4 text-center">Acciones</th>
</tr>
</thead>

<tbody>

<?php foreach($solicitudes as $s): ?>

<tr class="border-b hover:bg-gray-50 transition">

<td class="p-4 font-medium">
<?= htmlspecialchars($s['nombre']) ?>
<?= htmlspecialchars($s['apellido']) ?>
</td>

<td class="p-4 text-gray-600">
<?= htmlspecialchars($s['zona']) ?>
</td>

<td class="p-4">
<span class="
px-3 py-1 rounded-full text-xs font-semibold
<?php
if($s['estado_servicio']=='PENDIENTE') echo 'bg-yellow-100 text-yellow-700';
if($s['estado_servicio']=='ACEPTADA') echo 'bg-blue-100 text-blue-700';
if($s['estado_servicio']=='EN_PROCESO') echo 'bg-purple-100 text-purple-700';
?>
">
<?= htmlspecialchars($s['estado_servicio']) ?>
</span>
</td>

<td class="p-4 flex flex-wrap gap-2 justify-center">

<?php if($s['estado_servicio']=='PENDIENTE'): ?>
<a href="<?= BASE_URL ?>profesional/aceptar/<?= $s['id_solicitud'] ?>"
   class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-xs">
Aceptar
</a>

<a href="<?= BASE_URL ?>profesional/cancelar/<?= $s['id_solicitud'] ?>"
   class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs">
Cancelar
</a>
<?php endif; ?>

<?php if($s['estado_servicio']=='ACEPTADA'): ?>
<a href="<?= BASE_URL ?>profesional/iniciar/<?= $s['id_solicitud'] ?>"
   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-xs">
Iniciar
</a>
<?php endif; ?>

<?php if($s['estado_servicio']=='EN_PROCESO'): ?>
<a href="<?= BASE_URL ?>profesional/finalizar/<?= $s['id_solicitud'] ?>"
   class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded-lg text-xs">
Finalizar
</a>
<?php endif; ?>

<a href="<?= BASE_URL ?>chat/ver/<?= $s['id_solicitud'] ?>"
   class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1 rounded-lg text-xs">
Chat
</a>

<a href="<?= BASE_URL ?>profesional/verSolicitud/<?= $s['id_solicitud'] ?>"
   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-xs">
Ver
</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</main>

<!-- FOOTER -->
<footer class="bg-white shadow-inner p-4 text-center text-sm text-gray-500">
    © <?= date('Y') ?> Tu Plataforma | Profesionales conectando servicios 🚀
</footer>

</body>
</html>