@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-4xl px-4 py-8">
    <!-- Header del perfil -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 h-32"></div>
        <div class="px-6 pb-6">
            <div class="flex flex-col sm:flex-row items-center sm:items-end -mt-16 sm:-mt-12">
                <!-- Avatar -->
                <div class="bg-white rounded-full p-2 shadow-lg mb-4 sm:mb-0">
                    <div class="w-24 h-24 sm:w-32 sm:h-32 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center text-white text-4xl sm:text-5xl font-bold">
                        {{ strtoupper(substr($user->user_name, 0, 1)) }}
                    </div>
                </div>
                
                <!-- Información básica -->
                <div class="sm:ml-6 text-center sm:text-left flex-1">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $user->user_name }}</h1>
                    <p class="text-gray-600 flex items-center justify-center sm:justify-start gap-2 mt-1">
                        <i class="fa-solid fa-location-dot text-orange-500"></i>
                        {{ $user->city }}
                    </p>
                </div>

                <!-- Botón editar (para futuro) -->
                <div class="mt-4 sm:mt-0">
                    <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition font-medium text-sm">
                        <i class="fa-solid fa-pen-to-square mr-2"></i>Editar Perfil
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Información detallada -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Información de contacto -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-address-card text-orange-500"></i>
                Información de Contacto
            </h2>
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-envelope text-orange-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Email</p>
                        <p class="text-gray-900">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-phone text-orange-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Teléfono</p>
                        <p class="text-gray-900">{{ $user->user_phone }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-map-marker-alt text-orange-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Ciudad</p>
                        <p class="text-gray-900">{{ $user->city }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-simple text-orange-500"></i>
                Actividad
            </h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-paw text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Mascotas Publicadas</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $user->pets->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between p-4 bg-purple-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-magnifying-glass text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Mascotas Perdidas Reportadas</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $user->lostPets->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-calendar-days text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Miembro desde</p>
                            <p class="text-lg font-bold text-gray-900">{{ $user->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones rápidas -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Acciones Rápidas</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('pets.create') }}" class="flex items-center gap-3 p-4 border-2 border-orange-200 hover:border-orange-400 rounded-lg transition group">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-200 transition">
                    <i class="fa-solid fa-plus text-orange-600 text-xl"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Publicar Mascota</p>
                    <p class="text-sm text-gray-600">En adopción</p>
                </div>
            </a>
            <a href="{{ route('lostpets.create') }}" class="flex items-center gap-3 p-4 border-2 border-purple-200 hover:border-purple-400 rounded-lg transition group">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition">
                    <i class="fa-solid fa-magnifying-glass-plus text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Reportar Perdida</p>
                    <p class="text-sm text-gray-600">Mascota perdida</p>
                </div>
            </a>
            <a href="{{ route('pets.index') }}" class="flex items-center gap-3 p-4 border-2 border-blue-200 hover:border-blue-400 rounded-lg transition group">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition">
                    <i class="fa-solid fa-dog text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Ver Mascotas</p>
                    <p class="text-sm text-gray-600">En adopción</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
