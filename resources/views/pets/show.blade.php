@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="md:flex">
            <div class="md:flex-shrink-0">
                <img class="h-64 w-full object-cover md:w-64" src="{{ $pet->pet_photo ? $pet->pet_photo : 'https://via.placeholder.com/600x400.png?text=Sin+foto' }}" alt="Foto de {{ $pet->pet_name }}">
            </div>
            <div class="p-8 flex-1">
                <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">Mascota para Adopción</div>
                <h1 class="block mt-1 text-4xl leading-tight font-extrabold text-gray-900">{{ $pet->pet_name }}</h1>
                <p class="mt-2 text-gray-600">{{ $pet->description }}</p>

                <div class="mt-4 grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-500">Especie</p>
                        <p class="mt-1 text-gray-900">{{ ucfirst($pet->pet_species) }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-gray-500">Ubicación</p>
                        <p class="mt-1 text-gray-900">{{ $pet->location }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500">número de contacto</p>
                        <p class="mt-1 text-gray-900">{{ $pet->user->user_phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500">Publicado por:</p>
                        <p class="mt-1 text-gray-900">{{ $pet->user->user_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500">¿Está castrado?</p>
                        @if ($pet->castrated === true)
                        <p class="mt-1 text-gray-900">castrado</p>
                        @else
                        <p class="mt-1 text-gray-900">no castrado</p>
                        @endif
                    </div>
                </div>

                <!-- Botones de Acción para el Dueño -->
                @if(Auth::check() && Auth::user()->user_id === $pet->user_id)
                <div class="mt-6 flex gap-4">
                    <a href="{{ route('pets.edit', $pet->pet_id) }}" class="flex-1 text-center bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 transition duration-300 font-semibold">
                        <i class="fa-solid fa-pen mr-2"></i> Editar
                    </a>
                    <form action="{{ route('pets.destroy', $pet->pet_id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition duration-300 font-semibold" onclick="return confirm('¿Estás seguro de que quieres eliminar esta mascota?');">
                            <i class="fa-solid fa-trash-can mr-2"></i> Eliminar
                        </button>
                    </form>
                </div>
                @endif

                <div class="mt-8">
                    <a href="{{ url()->previous() }}" class="text-blue-500 hover:text-blue-700 transition duration-300">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection