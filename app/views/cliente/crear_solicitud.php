<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Solicitar Servicio | GEO V1</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<script
src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
</script>

</head>

<body class="bg-slate-100 min-h-screen">

<!-- HEADER -->

<header class="bg-white shadow-sm border-b">

<div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">

<div>
<h1 class="text-2xl font-bold text-slate-800">
Solicitar Servicio
</h1>
<p class="text-slate-500 text-sm">
Completa los datos para enviar tu solicitud
</p>
</div>

<a href="<?= BASE_URL ?>cliente/profesionales"
class="bg-slate-800 hover:bg-slate-900 text-white px-5 py-2 rounded-xl">

<i class="fa-solid fa-arrow-left mr-2"></i>
Volver

</a>

</div>

</header>

<div class="max-w-6xl mx-auto p-6 grid lg:grid-cols-3 gap-6">

<!-- PROFESIONAL -->

<div class="bg-white rounded-2xl shadow p-6 h-fit">

<h3 class="text-lg font-bold text-slate-800 mb-4">

<i class="fa-solid fa-user-tie text-blue-600 mr-2"></i>
Profesional

</h3>

<div class="space-y-2">

<p class="font-semibold text-slate-700">
<?= htmlspecialchars($profesional['nombre']) ?>
<?= htmlspecialchars($profesional['apellido']) ?>
</p>

<p class="text-slate-500">

<i class="fa-solid fa-screwdriver-wrench mr-2 text-green-600"></i>

<?= htmlspecialchars($profesional['nombre_categoria']) ?>

</p>

</div>

</div>

<!-- FORMULARIO -->

<div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">

<form method="POST" action="<?= BASE_URL ?>solicitud/guardar">

<input type="hidden"
name="id_profesional"
value="<?= $profesional['id_profesional'] ?>">

<!-- DESCRIPCIÓN -->

<div class="mb-5">

<label class="block text-sm font-semibold text-slate-700 mb-2">
<i class="fa-solid fa-pen mr-2 text-indigo-600"></i>
Descripción del problema
</label>

<textarea
name="descripcion_problema"
rows="4"
required
class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>

</div>

<!-- DIRECCIÓN -->

<div class="mb-5">

<label class="block text-sm font-semibold text-slate-700 mb-2">
<i class="fa-solid fa-location-dot mr-2 text-red-500"></i>
Dirección
</label>

<input
type="text"
name="direccion_servicio"
required
class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

</div>

<!-- ZONA -->

<div class="mb-5">

<label class="block text-sm font-semibold text-slate-700 mb-2">
<i class="fa-solid fa-map mr-2 text-green-600"></i>
Zona
</label>

<input
type="text"
name="zona"
required
class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-500">

</div>

<!-- MAPA -->

<div class="mb-6">

<label class="block text-sm font-semibold text-slate-700 mb-3">
<i class="fa-solid fa-map-pin mr-2 text-blue-600"></i>
Ubicación exacta (haz clic en el mapa)
</label>

<div id="map" class="w-full h-80 rounded-xl border"></div>

</div>

<input type="hidden" name="latitud" id="latitud">
<input type="hidden" name="longitud" id="longitud">

<!-- BOTONES -->

<div class="flex gap-3">

<button
type="submit"
class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold transition">

<i class="fa-solid fa-paper-plane mr-2"></i>
Enviar Solicitud

</button>

<a href="<?= BASE_URL ?>cliente/profesionales"
class="flex-1 text-center bg-gray-500 hover:bg-gray-600 text-white py-3 rounded-xl">

Cancelar

</a>

</div>

</form>

</div>

</div>

<!-- SCRIPT MAPA -->

<script>

var map = L.map('map').setView(
[-16.5000, -68.1500],
13
);

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
{
attribution: '&copy; OpenStreetMap'
}
).addTo(map);

var marker = null;

function setLatLng(lat, lng) {
document.getElementById('latitud').value = lat;
document.getElementById('longitud').value = lng;
}

map.on('click', function(e) {

if (marker) {
map.removeLayer(marker);
}

marker = L.marker(e.latlng).addTo(map);

setLatLng(e.latlng.lat, e.latlng.lng);

});

</script>

</body>
</html>