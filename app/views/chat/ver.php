<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Chat | GEO V1</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body class="bg-slate-100 h-screen flex flex-col">

<!-- HEADER -->

<div class="bg-white shadow px-6 py-4 flex justify-between items-center">

<div>
<h1 class="text-lg font-bold text-slate-800">
Chat del Servicio
</h1>
<p class="text-sm text-slate-500">
Comunicación con el profesional
</p>
</div>

<a href="<?= BASE_URL ?>profesional/solicitudes"
class="bg-slate-800 text-white px-4 py-2 rounded-lg hover:bg-slate-700">


<i class="fa-solid fa-arrow-left"></i>

</a>

</div>

<!-- CHAT -->

<div id="chat-box"
class="flex-1 overflow-y-auto p-6 space-y-4">

<?php $i = 0; ?>

<?php $mensajes = $mensajes ?? []; foreach($mensajes as $m): ?>

<?php 
$esCliente = ($i % 2 == 0); // alterna visualmente
$i++;
?>

<div class="flex <?= $esCliente ? 'justify-end' : 'justify-start' ?>">

<div class="max-w-md px-4 py-3 rounded-2xl shadow

<?= $esCliente 
? 'bg-green-500 text-white rounded-br-none' 
: 'bg-white text-slate-800 rounded-bl-none border'
?>">

<div class="text-sm font-semibold mb-1">
<?= htmlspecialchars($m['nombre']) ?>
<?= htmlspecialchars($m['apellido']) ?>
</div>

<div class="text-sm leading-relaxed">
<?= nl2br(htmlspecialchars($m['mensaje'])) ?>
</div>

</div>

</div>

<?php endforeach; ?>
</div>

<!-- INPUT -->

<form method="POST"
action="<?= BASE_URL ?>chat/enviar"
class="bg-white border-t p-4 flex items-center gap-3">

<input type="hidden"
name="id_solicitud"
value="<?= $idSolicitud ?>">

<textarea
name="mensaje"
required
placeholder="Escribe un mensaje..."
class="flex-1 border rounded-xl px-4 py-2 resize-none focus:outline-none focus:ring-2 focus:ring-green-500"
rows="1"></textarea>

<button
class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl flex items-center gap-2">

<i class="fa-solid fa-paper-plane"></i>
Enviar

</button>

</form>

<!-- AUTO SCROLL -->

<script>
const chatBox = document.getElementById('chat-box');
chatBox.scrollTop = chatBox.scrollHeight;

setInterval(function(){
    location.reload();
},5000);
</script>

</body>
</html>