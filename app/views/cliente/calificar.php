<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Calificar Servicio</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen flex items-center justify-center">

<div class="w-full max-w-xl">

<div class="bg-white rounded-2xl shadow-lg p-8">

<h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
⭐ Calificar Servicio
</h1>

<form method="POST" action="<?= BASE_URL ?>cliente/guardarCalificacion">

<input type="hidden" name="id_solicitud" value="<?= $id_solicitud ?>">

<!-- PUNTUACIÓN -->
<div class="mb-6">
<label class="block text-gray-700 font-semibold mb-2">
Puntuación
</label>

<select
name="puntuacion"
class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none transition"
required>

<option value="">Seleccione una puntuación</option>
<option value="1">⭐ 1 - Muy malo</option>
<option value="2">⭐⭐ 2 - Malo</option>
<option value="3">⭐⭐⭐ 3 - Regular</option>
<option value="4">⭐⭐⭐⭐ 4 - Bueno</option>
<option value="5">⭐⭐⭐⭐⭐ 5 - Excelente</option>

</select>
</div>

<!-- COMENTARIO -->
<div class="mb-6">
<label class="block text-gray-700 font-semibold mb-2">
Comentario
</label>

<textarea
name="comentario"
rows="5"
placeholder="Cuéntanos tu experiencia..."
class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none transition resize-none"></textarea>

</div>

<!-- BOTÓN -->
<button
class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition shadow-md hover:shadow-lg">

Guardar Calificación

</button>

</form>

</div>

</div>

</body>
</html>