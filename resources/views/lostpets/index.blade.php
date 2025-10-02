@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Mascotas Perdidas</h1>

    @if($lostPets->isEmpty())
    <p class="text-center text-gray-600">No hay mascotas perdidas publicadas en este momento.</p>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($lostPets as $pet)
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="w-full h-48 overflow-hidden">
                <img class="w-full h-full object-cover"
                    src="{{ $pet->pet_photo ? $pet->pet_photo : 'https://via.placeholder.com/400x300.png?text=Sin+foto' }}"
                    alt="Foto de {{ $pet->pet_name }}">
            </div>
            <div class="p-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $pet->pet_name }}</h2>
                <p class="text-gray-600 mb-1"><span class="font-semibold">Especie:</span> {{ ucfirst($pet->pet_species) }}</p>
                <p class="text-gray-600 mb-1"><span class="font-semibold">Ubicación:</span> {{ $pet->location }}</p>
                <p class="text-gray-600 mb-4">{{ Str::limit($pet->description, 100) }}</p>
                <a href="{{ route('lostpets.show', $pet->id) }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">Ver Detalles</a>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection