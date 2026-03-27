@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center gap-3 bg-purple-100 text-purple-700 px-4 py-2 rounded-full text-sm font-medium mb-4">
            <i class="fa-solid fa-map-pin"></i> Mascotas Perdidas
        </div>
        <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Mascotas Perdidas</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">Ayuda a reunirlas con sus familias. Comparte información si las vez.</p>
    </div>

    @if($lostPets->isEmpty())
    <div class="bg-gray-50 rounded-xl p-12 text-center border-2 border-dashed border-gray-200">
        <i class="fa-solid fa-map-pin text-5xl text-gray-300 mb-4"></i>
        <p class="text-gray-600 text-xl">No hay mascotas perdidas publicadas en este momento.</p>
    </div>
    @else
    <!-- Grid de mascotas perdidas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @foreach($lostPets as $pet)
        <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
            <a href="{{ route('lostpets.show', $pet->id) }}" class="block relative">
                @if($pet->pet_photo)
                <div class="w-full h-48 overflow-hidden">
                    <img src="{{ $pet->pet_photo }}" alt="Foto de {{ $pet->pet_name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                @else
                <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                    <i class="fa-solid fa-paw text-4xl text-gray-300"></i>
                </div>
                @endif
                <div class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full animate-pulse">
                    PERDIDO
                </div>
            </a>

            <div class="p-5">
                <h2 class="text-xl font-bold text-gray-800 group-hover:text-purple-600 transition-colors mb-3">
                    {{ $pet->pet_name ?? 'Sin nombre' }}
                </h2>

                <div class="space-y-2 text-sm text-gray-500 mb-3">
                    <p>
                        <i class="fa-solid fa-paw mr-2 text-purple-400"></i>
                        <span class="font-medium">{{ ucfirst($pet->pet_species) }}</span>
                    </p>
                    <p>
                        <i class="fa-solid fa-location-dot mr-2 text-purple-400"></i>
                        {{ $pet->last_seen ?? 'Ubicación no especificada' }}
                    </p>
                    <p>
                        <i class="fa-solid fa-calendar mr-2 text-purple-400"></i>
                        Se perdió el {{ \Carbon\Carbon::parse($pet->lost_date)->format('d/m/Y') }}
                    </p>
                </div>

                <p class="text-gray-600 text-sm line-clamp-2 mb-4">
                    {{ Str::limit($pet->description, 80) }}
                </p>

                <a href="{{ route('lostpets.show', $pet->id) }}" class="block w-full text-center bg-purple-600 text-white px-4 py-2.5 rounded-lg font-medium hover:bg-purple-700 transition duration-300">
                    Ver Detalles
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Paginación -->
    <div class="flex justify-center">
        {{ $lostPets->links('pagination::tailwind') }}
    </div>
    @endif
</div>
@endsection