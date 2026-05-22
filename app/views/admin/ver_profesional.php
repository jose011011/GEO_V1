
<?php
$profesional = $profesional ?? null;
$documentos = $documentos ?? [];

if (!$profesional) {
    die('No se recibió información del profesional.');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver profesional | GEO V1</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<header class="bg-blue-700 text-white px-8 py-4 flex justify-between items-center">
    <h1 class="text-xl font-bold">Detalle del profesional</h1>
    <div class="flex gap-3">
        <a href="<?= BASE_URL ?>admin/profesionales" class="bg-gray-600 px-4 py-2 rounded-lg">Volver</a>
        <a href="<?= BASE_URL ?>auth/logout" class="bg-red-500 px-4 py-2 rounded-lg">Cerrar sesión</a>
    </div>
</header>

<main class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">

    <section class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Datos personales</h2>

        <p><strong>Nombre:</strong> <?= htmlspecialchars($profesional['nombre'] . ' ' . $profesional['apellido']) ?></p>
        <p><strong>Correo:</strong> <?= htmlspecialchars($profesional['correo']) ?></p>
        <p><strong>Celular:</strong> <?= htmlspecialchars($profesional['celular']) ?></p>
        <p><strong>Estado usuario:</strong> <?= htmlspecialchars($profesional['estado_usuario']) ?></p>

        <hr class="my-4">

        <p><strong>Categoría:</strong> <?= htmlspecialchars($profesional['nombre_categoria']) ?></p>
        <p><strong>Documento:</strong> <?= htmlspecialchars($profesional['tipo_documento_identidad']) ?> - <?= htmlspecialchars($profesional['numero_documento']) ?></p>
        <p><strong>Experiencia:</strong> <?= htmlspecialchars($profesional['experiencia_anios']) ?> años</p>
        <p><strong>Zona:</strong> <?= htmlspecialchars($profesional['zona_trabajo']) ?></p>
        <p><strong>Validación:</strong> <?= htmlspecialchars($profesional['estado_validacion']) ?></p>
        <p><strong>Disponibilidad:</strong> <?= htmlspecialchars($profesional['estado_disponibilidad']) ?></p>

        <hr class="my-4">

        <p><strong>Descripción del servicio:</strong></p>
        <p class="text-gray-600 mt-2">
            <?= nl2br(htmlspecialchars($profesional['descripcion_servicio'])) ?>
        </p>

        <div class="mt-6 flex gap-3">
            <a 
                href="<?= BASE_URL ?>admin/aprobarProfesional/<?= $profesional['id_profesional'] ?>"
                onclick="return confirm('¿Aprobar este profesional?')"
                class="bg-green-600 text-white px-4 py-2 rounded-lg"
            >
                Aprobar
            </a>

            <a 
                href="<?= BASE_URL ?>admin/rechazarProfesional/<?= $profesional['id_profesional'] ?>"
                onclick="return confirm('¿Rechazar este profesional?')"
                class="bg-red-600 text-white px-4 py-2 rounded-lg"
            >
                Rechazar
            </a>
        </div>
    </section>

    <section class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Documentos subidos</h2>

        <?php if (empty($documentos)): ?>
            <p class="text-gray-500">No hay documentos registrados.</p>
        <?php endif; ?>

        <?php foreach ($documentos as $doc): ?>
            <div class="border rounded-lg p-4 mb-4">
                <p><strong>Tipo:</strong> <?= htmlspecialchars($doc['tipo_documento_archivo']) ?></p>
                <p><strong>Estado:</strong> <?= htmlspecialchars($doc['estado_revision']) ?></p>
                <p><strong>Fecha:</strong> <?= htmlspecialchars($doc['fecha_subida']) ?></p>

                <?php
                    $archivo = $doc['archivo'];
                    $rutaArchivo = BASE_URL . 'assets/uploads/documentos/' . $archivo;
                    $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
                ?>

                <div class="mt-3">
                    <?php if (in_array($extension, ['jpg', 'jpeg', 'png'])): ?>
                        <img src="<?= $rutaArchivo ?>" alt="Documento" class="max-w-xs rounded border mb-3">
                    <?php elseif ($extension === 'pdf'): ?>
                        <iframe src="<?= $rutaArchivo ?>" class="w-full h-80 border rounded mb-3"></iframe>
                    <?php endif; ?>

                    <a 
                        href="<?= $rutaArchivo ?>"
                        target="_blank"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg inline-block"
                    >
                        Abrir documento
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

</main>

</body>
</html>