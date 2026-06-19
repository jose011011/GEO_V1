<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel Cliente | GEO V1</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 min-h-screen">

<!-- HEADER -->
<header class="bg-gradient-to-r from-green-700 to-emerald-600 text-white shadow-lg">

    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <div>
            <h1 class="text-2xl font-bold">
                GEO V1
            </h1>

            <p class="text-green-100 text-sm">
                Plataforma de servicios técnicos
            </p>
        </div>

        <a href="<?= BASE_URL ?>auth/logout"
           class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg font-semibold">
            Cerrar sesión
        </a>

    </div>

</header>

<!-- CONTENIDO -->
<main class="max-w-7xl mx-auto p-6">

    <!-- BIENVENIDA -->
    <section class="bg-white rounded-3xl shadow p-8 mb-8">

        <div class="flex flex-col md:flex-row justify-between items-center">

            <div>

                <h2 class="text-3xl font-bold text-slate-800">
                    Hola,
                    <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>
                </h2>

                <p class="text-slate-500 mt-2">
                    Solicita servicios técnicos verificados en tu zona.
                </p>

            </div>

            <div class="mt-5 md:mt-0">

                <a href="<?= BASE_URL ?>cliente/profesionales"
                   class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold">

                    Buscar ayuda ahora

                </a>

            </div>

        </div>

    </section>

    <!-- ESTADO -->
    <section class="grid md:grid-cols-3 gap-5 mb-8">

        <div class="bg-white rounded-2xl shadow p-6">

            <div class="flex justify-between">

                <div>
                    <p class="text-slate-500">
                        Estado
                    </p>

                    <h3 class="text-xl font-bold text-green-600">
                        Activo
                    </h3>
                </div>

                <span class="text-4xl">
                    ✅
                </span>

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow p-6">

            <div class="flex justify-between">

                <div>
                    <p class="text-slate-500">
                        Servicios
                    </p>

                    <h3 class="text-xl font-bold text-blue-600">
                        Disponibles
                    </h3>
                </div>

                <span class="text-4xl">
                    🔧
                </span>

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow p-6">

            <div class="flex justify-between">

                <div>
                    <p class="text-slate-500">
                        Atención
                    </p>

                    <h3 class="text-xl font-bold text-orange-500">
                        24/7
                    </h3>
                </div>

                <span class="text-4xl">
                    🚨
                </span>

            </div>

        </div>

    </section>

    <!-- ACCESOS RÁPIDOS -->
    <section class="mb-8">

        <h3 class="text-2xl font-bold text-slate-800 mb-4">
            Accesos rápidos
        </h3>

        <div class="grid md:grid-cols-3 gap-6">

            <a href="<?= BASE_URL ?>cliente/profesionales">

                <div class="bg-white rounded-2xl shadow p-6 hover:shadow-xl transition">

                    <div class="text-5xl mb-4">
                        🔍
                    </div>

                    <h3 class="font-bold text-xl text-green-700">
                        Buscar Profesionales
                    </h3>

                    <p class="text-slate-500 mt-2">
                        Encuentra técnicos verificados cerca de ti.
                    </p>

                </div>

            </a>

            <a href="<?= BASE_URL ?>cliente/misSolicitudes">

                <div class="bg-white rounded-2xl shadow p-6 hover:shadow-xl transition">

                    <div class="text-5xl mb-4">
                        📋
                    </div>

                    <h3 class="font-bold text-xl text-blue-700">
                        Mis Solicitudes
                    </h3>

                    <p class="text-slate-500 mt-2">
                        Consulta el estado de tus servicios.
                    </p>

                </div>

            </a>

            <a href="<?= BASE_URL ?>cliente/perfil">

                <div class="bg-white rounded-2xl shadow p-6 hover:shadow-xl transition">

                    <div class="text-5xl mb-4">
                        👤
                    </div>

                    <h3 class="font-bold text-xl text-purple-700">
                        Mi Perfil
                    </h3>

                    <p class="text-slate-500 mt-2">
                        Actualiza tu información personal.
                    </p>

                </div>

            </a>

        </div>

    </section>

    <!-- CATEGORÍAS -->
    <section class="bg-white rounded-3xl shadow p-8 mb-8">

        <h3 class="text-2xl font-bold text-slate-800 mb-6">
            Servicios más solicitados
        </h3>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">

            <div class="bg-slate-50 rounded-xl p-5 text-center">
                <div class="text-4xl">⚡</div>
                <p class="mt-2 font-semibold">Electricista</p>
            </div>

            <div class="bg-slate-50 rounded-xl p-5 text-center">
                <div class="text-4xl">🚰</div>
                <p class="mt-2 font-semibold">Plomero</p>
            </div>

            <div class="bg-slate-50 rounded-xl p-5 text-center">
                <div class="text-4xl">🔐</div>
                <p class="mt-2 font-semibold">Cerrajero</p>
            </div>

            <div class="bg-slate-50 rounded-xl p-5 text-center">
                <div class="text-4xl">💻</div>
                <p class="mt-2 font-semibold">Soporte PC</p>
            </div>

            <div class="bg-slate-50 rounded-xl p-5 text-center">
                <div class="text-4xl">🏠</div>
                <p class="mt-2 font-semibold">Albañilería</p>
            </div>

        </div>

    </section>

</main>

<!-- FOOTER -->
<footer class="bg-slate-900 text-white mt-10">

    <div class="max-w-7xl mx-auto px-6 py-8">

        <div class="grid md:grid-cols-3 gap-8">

            <div>

                <h3 class="font-bold text-xl">
                    GEO V1
                </h3>

                <p class="text-slate-400 mt-2">
                    Plataforma inteligente para encontrar servicios técnicos.
                </p>

            </div>

            <div>

                <h3 class="font-bold mb-3">
                    Contacto
                </h3>

                <p class="text-slate-400">
                    soporte@geov1.com
                </p>

                <p class="text-slate-400">
                    +591 70000000
                </p>

            </div>

            <div>

                <h3 class="font-bold mb-3">
                    Redes Sociales
                </h3>

                <p class="text-slate-400">Facebook</p>
                <p class="text-slate-400">WhatsApp</p>
                <p class="text-slate-400">TikTok</p>

            </div>

        </div>

    </div>

</footer>

</body>
</html>