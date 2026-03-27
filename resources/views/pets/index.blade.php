@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center gap-3 bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-medium mb-4">
            <i class="fa-solid fa-dog"></i> En Adopción
        </div>
        <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Todas las Mascotas en Adopción</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Explora la lista completa de mascotas que buscan un hogar lleno de amor.</p>
    </div>

    @if($pets->isEmpty())
    <div class="bg-gray-50 rounded-xl p-12 text-center border-2 border-dashed border-gray-200">
        <i class="fa-solid fa-paw text-5xl text-gray-300 mb-4"></i>
        <p class="text-gray-600 text-xl mb-4">No se han publicado mascotas para adopción aún.</p>
        <a href="{{ route('pets.create') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
            ¡Sé el primero en publicar una!
        </a>
    </div>
    @else
    <!-- Grid de mascotas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-10">
        @foreach ($pets as $pet)
        <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
            <a href="{{ route('pets.show', $pet) }}" class="block relative">
                @if($pet->pet_photo)
                <div class="w-full h-48 overflow-hidden">
                    <img src="{{ $pet->pet_photo }}" alt="Foto de {{ $pet->pet_name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                @else
                <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                    <i class="fa-solid fa-paw text-4xl text-gray-300"></i>
                </div>
                @endif
                <div class="absolute top-3 right-3 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                    {{ ucfirst($pet->pet_species) }}
                </div>
            </a>

            <div class="p-5">
                <div class="flex items-start justify-between mb-2">
                    <h2 class="text-xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $pet->pet_name }}</h2>
                    @if($pet->castrated)
                    <span class="text-green-600 text-sm" title="Castrado">
                        <i class="fa-solid fa-check-circle"></i>
                    </span>
                    @endif
                </div>
                <p class="text-gray-500 text-sm mb-3">
                    <i class="fa-solid fa-location-dot mr-1"></i> {{ $pet->location }}
                </p>
                <p class="text-gray-600 text-sm line-clamp-2 mb-4">
                    {{ Str::limit($pet->description, 80) }}
                </p>

                <a href="{{ route('pets.show', $pet) }}" class="block w-full text-center bg-blue-600 text-white px-4 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition duration-300">
                    Ver Detalles
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Paginación -->
    <div class="flex justify-center">
        {{ $pets->links('pagination::tailwind') }}
    </div>
    @endif
</div>
@endsection