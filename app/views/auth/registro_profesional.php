<?php
$errores = $errores ?? [];
$datos = $datos ?? [];
$categorias = $categorias ?? [];

$nombre = $datos['nombre'] ?? '';
$apellido = $datos['apellido'] ?? '';
$correo = $datos['correo'] ?? '';
$celular = $datos['celular'] ?? '';
$idCategoria = $datos['id_categoria'] ?? '';
$tipoDocumentoIdentidad = $datos['tipo_documento_identidad'] ?? '';
$numeroDocumento = $datos['numero_documento'] ?? '';
$experienciaAnios = $datos['experiencia_anios'] ?? '';
$zonaTrabajo = $datos['zona_trabajo'] ?? '';
$descripcionServicio = $datos['descripcion_servicio'] ?? '';
$tipoDocumentoArchivo = $datos['tipo_documento_archivo'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro profesional | GEO V1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/validaciones.css">
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center py-10 px-4">

    <div class="w-full max-w-4xl bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-2">Registro de profesional técnico</h1>
        <p class="text-center text-gray-500 mb-6">Regístrate como electricista o técnico electrónico. Tu cuenta será revisada por administración.</p>

        <?php if (!empty($errores)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-5">
                <ul class="list-disc ml-5">
                    <?php foreach ($errores as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form 
            id="registroProfesionalForm"
            action="<?= BASE_URL ?>auth/guardarProfesional"
            method="POST"
            enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols-2 gap-5"
            novalidate
        >
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" placeholder="Ejemplo: Juan Carlos" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="nombre_error" class="error-message"></div>
                <p class="help-message">Solo letras. Máximo tres nombres.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($apellido) ?>" placeholder="Ejemplo: Mamani" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="apellido_error" class="error-message"></div>
                <p class="help-message">Ingrese un solo apellido, sin números ni espacios.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Correo electrónico</label>
                <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($correo) ?>" placeholder="Ejemplo: tecnico@gmail.com" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="correo_error" class="error-message"></div>
                <p class="help-message">Debe tener @ y dominio. Ejemplo: usuario@gmail.com.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Celular</label>
                <input type="text" id="celular" name="celular" value="<?= htmlspecialchars($celular) ?>" placeholder="Ejemplo: 76543210" maxlength="15" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="celular_error" class="error-message"></div>
                <p class="help-message">Solo números. Entre 7 y 15 dígitos.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Categoría técnica</label>
                <select id="id_categoria" name="id_categoria" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    <option value="">Seleccione una categoría</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= htmlspecialchars($categoria['id_categoria']) ?>" <?= $idCategoria == $categoria['id_categoria'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categoria['nombre_categoria']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div id="id_categoria_error" class="error-message"></div>
                <p class="help-message">Seleccione si trabaja como electricista o técnico electrónico.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Tipo de documento de identidad</label>
                <select id="tipo_documento_identidad" name="tipo_documento_identidad" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    <option value="">Seleccione CI o NIT</option>
                    <option value="CI" <?= $tipoDocumentoIdentidad === 'CI' ? 'selected' : '' ?>>CI</option>
                    <option value="NIT" <?= $tipoDocumentoIdentidad === 'NIT' ? 'selected' : '' ?>>NIT</option>
                </select>
                <div id="tipo_documento_identidad_error" class="error-message"></div>
                <p class="help-message">Elija CI si es persona natural o NIT si registra su negocio.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Número de documento</label>
                <input type="text" id="numero_documento" name="numero_documento" value="<?= htmlspecialchars($numeroDocumento) ?>" placeholder="Ejemplo CI: 12345678" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="numero_documento_error" class="error-message"></div>
                <p class="help-message">CI: 5 a 12 dígitos. NIT: 7 a 15 dígitos. Solo números.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Años de experiencia</label>
                <input type="number" id="experiencia_anios" name="experiencia_anios" value="<?= htmlspecialchars($experienciaAnios) ?>" min="0" placeholder="Ejemplo: 2" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="experiencia_anios_error" class="error-message"></div>
                <p class="help-message">Si no tiene experiencia, escriba 0.</p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-1">Zona de trabajo</label>
                <input type="text" id="zona_trabajo" name="zona_trabajo" value="<?= htmlspecialchars($zonaTrabajo) ?>" placeholder="Ejemplo: Sopocachi, Centro, Miraflores" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="zona_trabajo_error" class="error-message"></div>
                <p class="help-message">Indique las zonas donde puede atender servicios.</p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-1">Descripción del servicio</label>
                <textarea id="descripcion_servicio" name="descripcion_servicio" rows="4" placeholder="Ejemplo: Realizo instalaciones eléctricas domiciliarias, mantenimiento de tomacorrientes y revisión de tableros." class="w-full border border-gray-300 rounded-lg px-4 py-2"><?= htmlspecialchars($descripcionServicio) ?></textarea>
                <div id="descripcion_servicio_error" class="error-message"></div>
                <p class="help-message">Mínimo 30 caracteres. Explique qué servicios realiza.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Tipo de documento a subir</label>
                <select id="tipo_documento_archivo" name="tipo_documento_archivo" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    <option value="">Seleccione tipo de archivo</option>
                    <option value="CERTIFICADO_TECNICO" <?= $tipoDocumentoArchivo === 'CERTIFICADO_TECNICO' ? 'selected' : '' ?>>Certificado técnico</option>
                    <option value="REFERENCIA_LABORAL" <?= $tipoDocumentoArchivo === 'REFERENCIA_LABORAL' ? 'selected' : '' ?>>Referencia laboral</option>
                    <option value="CI_ANVERSO" <?= $tipoDocumentoArchivo === 'CI_ANVERSO' ? 'selected' : '' ?>>CI anverso</option>
                    <option value="CI_REVERSO" <?= $tipoDocumentoArchivo === 'CI_REVERSO' ? 'selected' : '' ?>>CI reverso</option>
                    <option value="NIT" <?= $tipoDocumentoArchivo === 'NIT' ? 'selected' : '' ?>>NIT</option>
                    <option value="OTRO" <?= $tipoDocumentoArchivo === 'OTRO' ? 'selected' : '' ?>>Otro</option>
                </select>
                <div id="tipo_documento_archivo_error" class="error-message"></div>
                <p class="help-message">Seleccione qué documento está subiendo.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Documento</label>
                <input type="file" id="documento_tecnico" name="documento_tecnico" accept=".pdf,.jpg,.jpeg,.png" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white">
                <div id="documento_tecnico_error" class="error-message"></div>
                <div id="documento_preview" class="preview-box"></div>
                <p class="help-message">PDF, JPG o PNG. Máximo 2 MB.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Ejemplo: Tecnico123@" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="password_error" class="error-message"></div>
                <p class="help-message">Mínimo 8 caracteres, mayúscula, minúscula, número y símbolo.</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Confirmar contraseña</label>
                <input type="password" id="confirmar_password" name="confirmar_password" placeholder="Repita la contraseña" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <div id="confirmar_password_error" class="error-message"></div>
                <p class="help-message">Debe escribir exactamente la misma contraseña.</p>
            </div>

            <div class="md:col-span-2">
                <button class="w-full bg-yellow-600 text-white py-3 rounded-lg font-semibold hover:bg-yellow-700">
                    Enviar registro profesional
                </button>
            </div>
        </form>

        <div class="mt-6 text-center text-sm">
            <a href="<?= BASE_URL ?>auth/login" class="text-blue-600 hover:underline">Ya tengo una cuenta</a>
        </div>
    </div>

    <script src="<?= BASE_URL ?>assets/js/validarProfesional.js"></script>
</body>
</html>