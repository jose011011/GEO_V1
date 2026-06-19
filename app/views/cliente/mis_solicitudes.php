<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mis Solicitudes | GEO V1</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}

.animate-fadeIn {
    animation: fadeIn 0.2s ease;
}
</style>
</head>

<body class="bg-slate-100 min-h-screen">

<!-- HEADER -->

<header class="bg-white shadow-sm border-b">

<div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

<div>

<h1 class="text-3xl font-bold text-slate-800">
Mis Solicitudes
</h1>

<p class="text-slate-500">
Consulta el estado de tus servicios técnicos.
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

<?php if(empty($solicitudes)): ?>

<div class="bg-white rounded-2xl shadow p-12 text-center">

<div class="text-6xl text-slate-300 mb-4">
<i class="fa-solid fa-file-circle-xmark"></i>
</div>

<h2 class="text-2xl font-bold text-slate-700 mb-2">
No tienes solicitudes registradas
</h2>

<p class="text-slate-500 mb-6">
Cuando solicites un servicio aparecerá aquí.
</p>

<a href="<?= BASE_URL ?>cliente/profesionales"
class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">

Buscar Profesionales

</a>

</div>

<?php else: ?>

<div class="grid gap-5">

<?php foreach($solicitudes as $s): ?>

<div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition p-6">

<div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-5">

<!-- DATOS -->

<div>

<h3 class="text-xl font-bold text-slate-800">

<i class="fa-solid fa-user-tie text-blue-600 mr-2"></i>

<?= $s['nombre'] ?>
<?= $s['apellido'] ?>

</h3>

<p class="text-slate-500 mt-1">

<i class="fa-solid fa-screwdriver-wrench mr-2"></i>

<?= $s['nombre_categoria'] ?>

</p>

<p class="text-sm text-slate-400 mt-2">

<i class="fa-regular fa-calendar mr-2"></i>

<?= $s['fecha_solicitud'] ?>

</p>

</div>

<!-- ESTADO -->

<div>

<?php
$color = "bg-gray-500";

if($s['estado_servicio']=="PENDIENTE"){
    $color="bg-yellow-500";
}

if($s['estado_servicio']=="ACEPTADA"){
    $color="bg-blue-500";
}

if($s['estado_servicio']=="EN_PROCESO"){
    $color="bg-indigo-600";
}

if($s['estado_servicio']=="FINALIZADA"){
    $color="bg-green-600";
}
?>

<span class="<?= $color ?> text-white px-4 py-2 rounded-full font-semibold">

<?= $s['estado_servicio'] ?>

</span>

</div>

<!-- ACCIONES -->

<div class="flex flex-wrap gap-2">

<?php if($s['estado_servicio']=='PENDIENTE'): ?>

<span
class="bg-gray-200 text-gray-700 px-4 py-2 rounded-xl">

<i class="fa-solid fa-clock mr-2"></i>

Esperando aceptación

</span>

<?php endif; ?>


<?php if(
$s['estado_servicio']=='ACEPTADA' ||
$s['estado_servicio']=='EN_PROCESO' ||
$s['estado_servicio']=='FINALIZADA'
): ?>

<a
href="<?= BASE_URL ?>chat/ver/<?= $s['id_solicitud'] ?>"
class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl">

<i class="fa-solid fa-comments mr-2"></i>

Chat

</a>

<?php endif; ?>


<?php if($s['estado_servicio']=='FINALIZADA'): ?>

<button 
onclick="abrirModal(<?= $s['id_solicitud'] ?>)"
class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-xl">

Calificar

</button>

<?php endif; ?>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

<?php endif; ?>

<?php if(isset($_GET['success']) && $_GET['success'] == '1'): ?>

<div class="max-w-7xl mx-auto px-6 mb-4">
    <div class="bg-green-600 text-white rounded-xl p-3 shadow">
        ✅ Calificación enviada con éxito.
    </div>
</div>

<?php endif; ?>

</div>
<input type="hidden" name="id_solicitud" id="id_solicitud">


<!-- OVERLAY -->
<div id="modalCalificar" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <!-- MODAL -->
    <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-xl animate-fadeIn">

        <h2 class="text-xl font-bold text-center mb-4">
            Califica tu experiencia
        </h2>

        <p class="text-gray-500 text-center mb-6 text-sm">
            Tu opinión ayuda a mejorar el servicio
        </p>

        <form method="POST" action="<?= BASE_URL ?>cliente/guardarCalificacion">

            <input type="hidden" name="id_solicitud" id="id_solicitud">
            <input type="hidden" name="puntuacion" id="puntuacion">



            <!-- ESTRELLAS -->
            <div class="flex justify-center mb-6 space-x-2 text-3xl cursor-pointer">

                <span class="star" data-value="1">☆</span>
                <span class="star" data-value="2">☆</span>
                <span class="star" data-value="3">☆</span>
                <span class="star" data-value="4">☆</span>
                <span class="star" data-value="5">☆</span>

            </div>

            <!-- COMENTARIO -->
            <textarea
                name="comentario"
                rows="3"
                placeholder="Opcional: escribe un comentario..."
                class="w-full border rounded-lg p-3 text-sm focus:ring-2 focus:ring-green-500 outline-none mb-4 resize-none">
            </textarea>

            <!-- BOTONES -->
            <div class="flex gap-3">

                <button type="button"
                    onclick="cerrarModal()"
                    class="w-1/2 border border-gray-300 py-2 rounded-lg hover:bg-gray-100 transition">
                    Cancelar
                </button>

                <button
                    class="w-1/2 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                    Enviar
                </button>

            </div>

        </form>

    </div>

</div>
<script>
function abrirModal(id) {
    document.getElementById("modalCalificar").style.display = "flex";
    document.getElementById("id_solicitud").value = id;
}
</script>
<script>
let estrellas = document.querySelectorAll(".star");
let input = document.getElementById("puntuacion");

estrellas.forEach((estrella, index) => {
    estrella.addEventListener("click", () => {

        let valor = estrella.getAttribute("data-value");
        input.value = valor;

        estrellas.forEach((e, i) => {
            e.textContent = i < valor ? "⭐" : "☆";
        });

    });
});

function cerrarModal() {
    document.getElementById("modalCalificar").style.display = "none";
}
</script>

</body>
</html>