<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel Profesional | GEO V1</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body class="bg-slate-100 min-h-screen flex flex-col">

<!-- HEADER -->
<header class="bg-slate-900 text-white shadow">

<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

<div class="flex items-center gap-3">
<i class="fa-solid fa-user-tie text-xl text-yellow-400"></i>
<h1 class="text-lg font-semibold tracking-wide">
Panel Profesional
</h1>
</div>

<a href="<?= BASE_URL ?>auth/logout"
class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg text-sm">

<i class="fa-solid fa-right-from-bracket mr-1"></i>
Salir
</a>

</div>

</header>

<!-- CONTENIDO -->
<main class="max-w-7xl mx-auto p-6 flex-1">

<!-- BIENVENIDA -->
<section class="bg-white rounded-xl shadow p-6 mb-6 flex justify-between items-center">

<div>
<h2 class="text-xl font-bold text-slate-800">
👨‍🔧 Hola,
<?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>
</h2>

<p class="text-slate-500 text-sm mt-1">
Administra tus trabajos y responde a clientes.
</p>
</div>

<div class="text-4xl text-yellow-500">
<i class="fa-solid fa-helmet-safety"></i>
</div>

</section>

<!-- MÉTRICAS -->
<div class="grid md:grid-cols-3 gap-6 mb-6">

<div class="bg-white p-5 rounded-xl shadow">
<p class="text-sm text-gray-500">Solicitudes</p>
<h3 class="text-2xl font-bold text-yellow-600">--</h3>
</div>

<div class="bg-white p-5 rounded-xl shadow">
<p class="text-sm text-gray-500">En proceso</p>
<h3 class="text-2xl font-bold text-blue-600">--</h3>
</div>

<div class="bg-white p-5 rounded-xl shadow">
<p class="text-sm text-gray-500">Finalizados</p>
<h3 class="text-2xl font-bold text-green-600">--</h3>
</div>

</div>

<!-- ACCIONES -->
<div class="grid md:grid-cols-2 gap-6">

<!-- SOLICITUDES -->
<a href="<?= BASE_URL ?>profesional/solicitudes">

<div class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition group">

<div class="flex justify-between items-center">

<div>
<h3 class="text-lg font-bold text-slate-800 group-hover:text-yellow-600">
📥 Solicitudes
</h3>

<p class="text-sm text-gray-500 mt-1">
Revisa pedidos de clientes
</p>
</div>

<i class="fa-solid fa-inbox text-3xl text-yellow-400"></i>

</div>

</div>

</a>

<!-- ESTADO -->
<div class="bg-white rounded-xl shadow p-6">

<div class="flex justify-between items-center">

<div>
<h3 class="text-lg font-bold text-slate-800">
🟢 Estado
</h3>

<p class="text-sm text-gray-500 mt-1">
Disponible para trabajar
</p>
</div>

<i class="fa-solid fa-signal text-3xl text-green-500"></i>

</div>

<div class="mt-4 flex items-center gap-3">

<span class="text-sm text-gray-500">Disponibilidad</span>

<div class="w-12 h-6 bg-green-500 rounded-full relative">
<div class="w-5 h-5 bg-white rounded-full absolute top-0.5 right-0.5"></div>
</div>

</div>

</div>

</div>

</main>

<!-- FOOTER -->
<footer class="bg-slate-900 text-gray-300 text-sm">

<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

<p>© 2025 GEO V1 - Plataforma de Servicios</p>

<div class="flex gap-4 text-lg">
<i class="fa-solid fa-headset"></i>
<i class="fa-solid fa-shield-halved"></i>
<i class="fa-solid fa-star"></i>
</div>

</div>

</footer>

</body>
</html>