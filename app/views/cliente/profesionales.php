<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Profesionales | GEO V1</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body class="bg-slate-100 min-h-screen">

<!-- HEADER -->

<header class="bg-white shadow-sm border-b">

<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

<div>
<h1 class="text-3xl font-bold text-slate-800">
Profesionales Disponibles
</h1>

<p class="text-slate-500 text-sm">
Encuentra técnicos calificados cerca de ti
</p>
</div>

<a href="<?= BASE_URL ?>cliente/dashboard"
class="bg-slate-800 hover:bg-slate-900 text-white px-5 py-2 rounded-xl">

<i class="fa-solid fa-arrow-left mr-2"></i>
Volver

</a>

</div>

</header>

<div class="max-w-7xl mx-auto p-6">

<?php if(empty($profesionales)): ?>

<div class="bg-white rounded-2xl shadow p-10 text-center">

<div class="text-6xl text-slate-300 mb-4">
<i class="fa-solid fa-user-slash"></i>
</div>

<h2 class="text-2xl font-bold text-slate-700 mb-2">
No hay profesionales disponibles
</h2>

<p class="text-slate-500">
Intenta nuevamente más tarde o en otra zona.
</p>

</div>

<?php else: ?>

<div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">

<?php foreach($profesionales as $pro): ?>

<div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 overflow-hidden">

<div class="p-6">

<!-- NOMBRE -->

<div class="flex items-center justify-between mb-3">

<h2 class="text-xl font-bold text-slate-800">

<i class="fa-solid fa-user-tie text-blue-600 mr-2"></i>

<?= htmlspecialchars($pro['nombre']) ?>
<?= htmlspecialchars($pro['apellido']) ?>

</h2>

<!-- RATING -->

<div class="bg-yellow-400 text-white text-sm px-3 py-1 rounded-full font-semibold">

<i class="fa-solid fa-star"></i>
<?= $pro['promedio'] ?? '0' ?>

</div>

</div>

<!-- CATEGORIA -->

<p class="text-slate-600 mb-2">

<i class="fa-solid fa-screwdriver-wrench text-green-600 mr-2"></i>

<?= htmlspecialchars($pro['nombre_categoria']) ?>

</p>

<!-- EXPERIENCIA -->

<p class="text-slate-600 mb-2">

<i class="fa-solid fa-briefcase text-indigo-600 mr-2"></i>

<?= $pro['experiencia_anios'] ?> años de experiencia

</p>

<!-- ZONA -->

<p class="text-slate-600 mb-3">

<i class="fa-solid fa-location-dot text-red-500 mr-2"></i>

<?= htmlspecialchars($pro['zona_trabajo']) ?>

</p>

<!-- DESCRIPCIÓN -->

<p class="text-sm text-slate-500 leading-relaxed mb-4">

<?= htmlspecialchars($pro['descripcion_servicio']) ?>

</p>

<!-- OPINIONES -->

<p class="text-xs text-slate-400 mb-4">

<i class="fa-regular fa-comment-dots mr-1"></i>

<?= $pro['opiniones'] ?? 0 ?> opiniones

</p>

</div>

<!-- BOTÓN -->

<div class="p-5 border-t bg-slate-50">

<a href="<?= BASE_URL ?>cliente/crearSolicitud/<?= $pro['id_profesional'] ?>"
class="block w-full text-center bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold transition">

<i class="fa-solid fa-paper-plane mr-2"></i>

Solicitar Servicio

</a>

</div>

</div>

<?php endforeach; ?>

</div>

<?php endif; ?>

</div>

</body>
</html>