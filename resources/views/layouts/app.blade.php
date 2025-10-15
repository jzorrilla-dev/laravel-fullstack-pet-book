<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Petbook') }}</title>

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('favicon-96x96.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome (Íconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-ieoQe6z5eG1jG/Q5s9eQJv1T5r9Q2C5wL9Q5P7g2l5b0P5ZJ5eL0R5I5F5A5J5S5eQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }

        /* Estilos para el scrollbar */
        body::-webkit-scrollbar {
            width: 8px;
        }

        body::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 4px;
        }

        body::-webkit-scrollbar-track {
            background: transparent;
        }
    </style>
</head>

<body class="bg-gray-100 antialiased">
    <!-- Mensaje de éxito o de error (flash messages) -->
    @if(session('success'))
    <div class="bg-green-100border-l-4 border-green-200 text-green-700 p-4 mb-4" role="alert">
        <p class="font-bold">Éxito</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="flex h-screen overflow-hidden">
        <!-- Overlay para móvil -->
        <div x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-gray-100 bg-opacity-75 z-30 lg:hidden"></div>

        <!-- Sidebar colapsable -->
        <aside
            x-show="sidebarOpen"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            @click.away="sidebarOpen = false"
            class="fixed lg:relative inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 shadow-lg flex flex-col">

            <!-- Header del sidebar -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-paw text-orange-500"></i>
                    <span>Petbook</span>
                </h2>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700 transition">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>

            <!-- Menú de navegación -->
            <nav class="flex-1 overflow-y-auto p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:text-blue-600 rounded-lg transition duration-300 group">
                            <i class="fa-solid fa-house text-gray-500 group-hover:text-blue-600 transition duration-300"></i>
                            <span class="font-medium">Inicio</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('lostpets.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:text-blue-600 rounded-lg transition duration-300 group">
                            <i class="fa-solid fa-map-pin text-gray-500 group-hover:text-blue-600 transition duration-300"></i>
                            <span class="font-medium">Mascotas Perdidas</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pets.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:text-blue-600 rounded-lg transition duration-300 group">
                            <i class="fa-solid fa-dog text-gray-500 group-hover:text-blue-600 transition duration-300"></i>
                            <span class="font-medium">Adoptar Mascota</span>
                        </a>
                    </li>

                    <li class="pt-4 mt-4 border-t border-gray-200">
                        <a href="{{ route('about') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:text-blue-600 rounded-lg transition duration-300 group">
                            <i class="fa-solid fa-circle-info text-gray-500 group-hover:text-blue-600 transition duration-300"></i>
                            <span class="font-medium">Acerca de</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contactos') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:text-blue-600 rounded-lg transition duration-300 group">
                            <i class="fa-solid fa-envelope text-gray-500 group-hover:text-blue-600 transition duration-300"></i>
                            <span class="font-medium">Contactos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('donations.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:text-blue-600 rounded-lg transition duration-300 group">
                            <i class="fa-solid fa-heart text-gray-500 group-hover:text-blue-600 transition duration-300"></i>
                            <span class="font-medium">Donar</span>
                        </a>
                    </li>

                    @auth
                    <li class="pt-4 mt-4 border-t border-gray-200">
                        <a href="{{ route('profile') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition duration-200 group">
                            <i class="fa-solid fa-user-circle text-lg group-hover:scale-110 transition-transform"></i>
                            <span class="font-medium">Mi Perfil</span>
                        </a>
                    </li>
                    <li class="pt-4 mt-4 border-t border-gray-200">
                        <a href="{{ route('pets.create') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-blue-600 rounded-lg transition duration-200 group">
                            <i class="fa-solid fa-paw text-lg group-hover:scale-110 transition-transform"></i>
                            <span class="font-medium">Publicar Mascota</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('lostpets.create') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-blue-600 rounded-lg transition duration-200 group">
                            <i class="fa-solid fa-magnifying-glass-plus text-lg group-hover:scale-110 transition-transform"></i>
                            <span class="font-medium">Reportar Perdida</span>
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition duration-200 group">
                                <i class="fa-solid fa-right-from-bracket text-lg group-hover:scale-110 transition-transform"></i>
                                <span class="font-medium">Cerrar Sesión</span>
                            </button>
                        </form>
                    </li>
                    @else
                    <li class="pt-4 mt-4 border-t border-gray-200">
                        <a href="{{ route('login') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-blue-600 rounded-lg transition duration-200 group">
                            <i class="fa-solid fa-user text-lg group-hover:scale-110 transition-transform"></i>
                            <span class="font-medium">Iniciar Sesión</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 hover:text-blue-600 rounded-lg transition duration-200 group">
                            <i class="fa-solid fa-user-plus text-lg"></i>
                            <span class="font-medium">Registrarse</span>
                        </a>
                    </li>
                    @endauth
                </ul>
            </nav>

            <!-- Footer del sidebar -->
            <div class="p-4 border-t border-gray-200">
                <p class="text-xs text-gray-500 text-center">© 2025 Petbook</p>
            </div>
        </aside>

        <!-- Contenedor Principal -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Navbar -->
            <nav class="bg-white shadow-md z-20">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Botón hamburguesa + Logo -->
                        <div class="flex items-center gap-3">
                            <button @click="sidebarOpen = !sidebarOpen"
                                aria-label="Abrir menú"
                                class="focus:outline-none bg-white p-2 transition border border-gray-200 rounded-md">
                                <span class="block w-6 space-y-1.5" aria-hidden="true">
                                    <span class="block h-0.5 w-full bg-black"></span>
                                    <span class="block h-0.5 w-full bg-black"></span>
                                    <span class="block h-0.5 w-full bg-black"></span>
                                </span>
                            </button>
                            <a class="text-xl font-bold text-gray-800 lg:text-2xl" href="{{ url('/') }}">
                                {{ config('app.name', 'Pet Book') }}
                            </a>
                        </div>

                        <!-- Acciones del navbar (desktop) -->
                        <div class="hidden md:flex items-center gap-2">
                            <a href="{{ route('about') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md transition duration-300 font-medium">
                                Acerca de
                            </a>
                            <a href="{{ route('contactos') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md transition duration-300 font-medium">
                                Contactos
                            </a>
                            <a href="{{ route('pets.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md transition duration-300 font-medium">
                                <i class="fa-solid fa-dog mr-2"></i>Ver Mascotas
                            </a>
                            <a href="{{ route('posts.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md transition duration-300 font-medium">
                                <i class="fa-solid fa-pen mr-2"></i>Blog
                            </a>
                            <a href="{{ route('donations.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md transition duration-300 font-medium">
                                <i class="fa-solid fa-heart mr-2"></i>Donar
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Contenido principal -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="min-h-full p-4 sm:p-6 lg:p-8">
                    @yield('content')
                </div>

                <!-- Footer -->
                <footer class="bg-white border-t border-gray-200 mt-auto">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-7 py-7">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Columna 1: Sobre Petbook -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                    <i class="fa-solid fa-paw text-orange-500"></i>
                                    Petbook
                                </h3>
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    Plataforma dedicada a conectar mascotas con hogares amorosos y ayudar a reunir mascotas perdidas con sus familias.
                                </p>
                            </div>

                            <!-- Columna 2: Enlaces rápidos -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Enlaces Rápidos</h3>
                                <ul class="space-y-2 text-sm">
                                    <li>
                                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 transition">
                                            <i class="fa-solid fa-chevron-right text-xs mr-1"></i>Inicio
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('pets.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                                            <i class="fa-solid fa-chevron-right text-xs mr-1"></i>Mascotas en Adopción
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('lostpets.index') }}" class="text-gray-600 hover:text-blue-600 transition">
                                            <i class="fa-solid fa-chevron-right text-xs mr-1"></i>Mascotas Perdidas
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('about') }}" class="text-gray-600 hover:text-blue-600 transition">
                                            <i class="fa-solid fa-chevron-right text-xs mr-1"></i>Acerca de
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Columna 3: Contacto -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Contacto</h3>
                                <ul class="space-y-3 text-sm">
                                    <li class="flex items-start gap-2 text-gray-600">
                                        <i class="fa-solid fa-envelope text-blue-600 mt-1"></i>
                                        <a href="mailto:{{ config('mail.from.address') }}" class="hover:text-blue-600 transition">
                                            {{ config('mail.from.address') }}
                                        </a>
                                    </li>
                                    <li class="flex items-start gap-2 text-gray-600">
                                        <i class="fa-solid fa-phone text-blue-600 mt-1"></i>
                                        <span>{{ env('APP_CONTACT_PHONE', '+54 ...') }}</span>
                                    </li>
                                    <li>
                                        <a href="{{ route('contactos') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                            <i class="fa-solid fa-paper-plane mr-1"></i>Contáctanos
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Separador y copyright -->
                        <div class="border-t border-gray-200 mt-8 pt-6 text-center">
                            <p class="text-sm text-gray-500">
                                © {{ date('Y') }} Petbook. Hecho <i class="fa-solid fa-heart text-red-500"></i> para los amantes de las mascotas.
                            </p>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>
</body>

</html>