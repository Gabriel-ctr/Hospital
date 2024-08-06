<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Sistema de Gestión Hospitalaria</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

        <style>
            /* Estilos personalizados adicionales */
            .hero-bg {
                background-image: url('https://www.hospitalbackgroundimage.com'); /* Añade la URL de una imagen de fondo relevante para el hospital */
                background-size: cover;
                background-position: center;
            }
        </style>
    </head>
    <body class="font-sans antialiased dark:bg-gray-900 dark:text-white">

        <!-- Sección Hero -->
        <div class="hero-bg min-h-screen flex items-center justify-center py-20">
            <div class="bg-white bg-opacity-80 rounded-lg p-10 shadow-lg">
                <h1 class="text-4xl font-bold text-blue-900">Bienvenido al Sistema de Gestión Hospitalaria</h1>
                <p class="mt-4 text-lg text-gray-700">Gestione los registros de pacientes, citas y la información médica de manera eficiente.</p>

                @if (Route::has('login'))
                    <div class="mt-8">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Iniciar sesión</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Registrarse</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>

        <!-- Sección de Características -->
        <div class="bg-gray-100 py-20">
            <div class="container mx-auto px-6 lg:px-8">
                <h2 class="text-3xl font-semibold text-center text-blue-900 mb-12">Nuestras Características</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-blue-900">Gestión de Pacientes</h3>
                        <p class="mt-4 text-gray-700">Gestione fácilmente los registros de pacientes y sus historiales médicos.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-blue-900">Programación de Citas</h3>
                        <p class="mt-4 text-gray-700">Programe y administre citas con facilidad.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-semibold text-blue-900">Información Médica</h3>
                        <p class="mt-4 text-gray-700">Mantenga registros detallados de la información médica de los pacientes.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-blue-900 text-white py-6">
            <div class="container mx-auto text-center">
                <p>&copy; 2024 Sistema de Gestión Hospitalaria. Todos los derechos reservados.</p>
            </div>
        </footer>

    </body>
</html>
