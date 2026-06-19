<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Detalle de Solicitud</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">

<!-- HEADER -->
<header class="bg-white shadow-md p-4 flex justify-between items-center">
    <h1 class="text-xl font-bold text-yellow-600">
        Detalle de Solicitud
    </h1>

    <a href="<?= BASE_URL ?>profesional/solicitudes"
       class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg text-sm">
        ← Volver
    </a>
</header>

<!-- CONTENIDO -->
<main class="flex-grow container mx-auto p-6">

<div class="bg-white rounded-xl shadow-lg overflow-hidden">

<!-- ESTADO -->
<div class="p-4 border-b flex justify-between items-center">
    <span class="text-gray-500 text-sm">
        Solicitud #<?= $solicitud['id_solicitud'] ?>
    </span>

    <span class="
    px-3 py-1 rounded-full text-xs font-semibold
    <?php
    if($solicitud['estado_servicio']=='PENDIENTE') echo 'bg-yellow-100 text-yellow-700';
    if($solicitud['estado_servicio']=='ACEPTADA') echo 'bg-blue-100 text-blue-700';
    if($solicitud['estado_servicio']=='EN_PROCESO') echo 'bg-purple-100 text-purple-700';
    ?>
    ">
        <?= htmlspecialchars($solicitud['estado_servicio']) ?>
    </span>
</div>

<!-- INFO -->
<div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

<div>
    <p class="text-sm text-gray-500">Cliente</p>
    <p class="font-semibold text-lg">
        <?= htmlspecialchars($solicitud['nombre']) ?>
        <?= htmlspecialchars($solicitud['apellido']) ?>
    </p>
</div>

<div>
    <p class="text-sm text-gray-500">Celular</p>
    <p class="font-medium">
        <?= htmlspecialchars($solicitud['celular']) ?>
    </p>
</div>

<div>
    <p class="text-sm text-gray-500">Correo</p>
    <p class="font-medium">
        <?= htmlspecialchars($solicitud['correo']) ?>
    </p>
</div>

<div>
    <p class="text-sm text-gray-500">Zona</p>
    <p class="font-medium">
        <?= htmlspecialchars($solicitud['zona']) ?>
    </p>
</div>

<div class="md:col-span-2">
    <p class="text-sm text-gray-500">Dirección</p>
    <p class="font-medium">
        <?= htmlspecialchars($solicitud['direccion_servicio']) ?>
    </p>
</div>

</div>

<!-- DESCRIPCIÓN -->
<div class="px-6 pb-6">

<div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-5">
    <h3 class="font-semibold text-blue-700 mb-2">
        🧾 Problema reportado
    </h3>

    <p class="text-gray-700 leading-relaxed">
        <?= nl2br(htmlspecialchars($solicitud['descripcion_problema'])) ?>
    </p>
</div>

</div>

<!-- MAPA -->
<?php if(!empty($solicitud['latitud']) && !empty($solicitud['longitud'])): ?>

<div class="px-6 pb-6">
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex justify-between items-center">

        <div>
            <h3 class="font-bold text-green-700">
                📍 Ubicación del cliente
            </h3>
            <p class="text-sm text-gray-600">
                Ubicación exacta registrada
            </p>
        </div>

        <a target="_blank"
           href="https://www.google.com/maps?q=<?= $solicitud['latitud'] ?>,<?= $solicitud['longitud'] ?>"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
           Ver mapa
        </a>

    </div>
</div>

<?php endif; ?>

<!-- ACCIONES -->
<div class="p-6 border-t flex flex-wrap gap-3 justify-between items-center">

<div class="flex gap-2">

<?php if($solicitud['estado_servicio']=='PENDIENTE'): ?>

<a href="<?= BASE_URL ?>profesional/aceptarSolicitud/<?= $solicitud['id_solicitud'] ?>"
   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
    Aceptar
</a>

<a href="<?= BASE_URL ?>profesional/rechazarSolicitud/<?= $solicitud['id_solicitud'] ?>"
   class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm">
    Rechazar
</a>

<?php endif; ?>

</div>

<a href="<?= BASE_URL ?>chat/ver/<?= $solicitud['id_solicitud'] ?>"
   class="bg-gray-800 hover:bg-black text-white px-4 py-2 rounded-lg text-sm">
    💬 Ir al chat
</a>

</div>

</div>

</main>

<!-- FOOTER -->
<footer class="bg-white shadow-inner p-4 text-center text-sm text-gray-500">
    © <?= date('Y') ?> Tu Plataforma | Servicios profesionales 🚀
</footer>

</body>
</html>