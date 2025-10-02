@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">¡Encuentra a tu nuevo mejor amigo!</h1>
        <p class="text-lg text-gray-600">Explora las mascotas disponibles para adopción o ayuda a encontrar una mascota perdida.</p>
    </div>

    <!-- Sección de botones de acción -->
    <div class="flex flex-col md:flex-row justify-center gap-6 mb-12">
        <!-- Botón para Publicar Mascota en Adopción -->
        <a href="{{ route('pets.create') }}" class="flex-1 max-w-sm bg-blue-600 text-white rounded-xl shadow-md p-6 flex items-center justify-center transform hover:scale-105 transition duration-300">
            <div class="text-center">
                <i class="fa-solid fa-paw text-4xl mb-2"></i>
                <span class="text-lg font-semibold block">Publicar Mascota</span>
                <span class="text-sm font-light block opacity-80">Ofrece un hogar a una mascota</span>
            </div>
        </a>

        <!-- Botón para Reportar Mascota Perdida -->
        <a href="{{ route('lostpets.create') }}" class="flex-1 max-w-sm bg-purple-600 text-white rounded-xl shadow-md p-6 flex items-center justify-center transform hover:scale-105 transition duration-300">
            <div class="text-center">
                <i class="fa-solid fa-magnifying-glass-plus text-4xl mb-2"></i>
                <span class="text-lg font-semibold block">Reportar Mascota Perdida</span>
                <span class="text-sm font-light block opacity-80">Ayuda a reunirlas con sus dueños</span>
            </div>
        </a>
    </div>

    <!-- Sección de mascotas disponibles (mini-galería) -->
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-8">Mascotas en Adopción</h2>

    @if($pets->isEmpty())
    <div class="text-center text-gray-600">
        <p>¡Vaya! No hay mascotas disponibles para adopción en este momento. Sé el primero en publicar una.</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($pets as $pet)
        <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition duration-300">
            <a href="{{ route('pets.show', $pet) }}">
                @if($pet->pet_photo)
                <div class="w-full h-48 overflow-hidden">
                    <img src="{{ $pet->pet_photo }}" alt="Foto de {{ $pet->pet_name }}" class="w-full h-full object-cover">
                </div>
                @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500 text-sm">Sin foto</span>
                </div>
                @endif
            </a>

            <div class="p-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-1">{{ $pet->pet_name }}</h2>
                <p class="text-gray-600 text-sm">
                    <span class="font-bold">Especie:</span> {{ ucfirst($pet->pet_species) }}
                </p>
                <p class="text-gray-600 text-sm mb-4">
                    <span class="font-bold">Ubicación:</span> {{ $pet->location }}
                </p>

                <a href="{{ route('pets.show', $pet) }}" class="inline-block w-full text-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    Ver Detalles
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection