@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Sección de la imagen -->
                <div class="w-full md:w-1/2">
                    @if($lostPet->pet_photo)
                    <div class="w-full h-96 bg-gray-200 rounded-lg overflow-hidden flex items-center justify-center shadow-md">
                        <img src="{{ $lostPet->pet_photo }}" alt="Foto de {{ $lostPet->pet_name }}" class="object-contain w-full h-full">
                    </div>
                    @else
                    <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center shadow-md">
                        <span class="text-gray-500 font-semibold text-lg">Sin foto disponible</span>
                    </div>
                    @endif
                </div>

                <!-- Sección de detalles -->
                <div class="w-full md:w-1/2">
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-4">{{ $lostPet->pet_name }}</h1>
                    <div class="space-y-4 text-gray-700">
                        <p><strong>Especie:</strong> {{ $lostPet->pet_species }}</p>
                        <p><strong>Última ubicación vista:</strong> {{ $lostPet->last_seen }}</p>
                        <p><strong>Descripción:</strong> {{ $lostPet->description }}</p>
                    </div>

                    <!-- Información de contacto -->
                    @if($lostPet->user)
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Información de Contacto</h2>
                        <div class="space-y-2 text-gray-700">
                            <p><strong>Nombre:</strong> {{ $lostPet->user->user_name }}</p>
                            <p><strong>Teléfono:</strong> {{ $lostPet->user->user_phone }}</p>
                        </div>
                    </div>
                    @endif
                    <!-- botones de acción para el dueño -->
                    @if(Auth::check() && Auth::user()->user_id === $lostPet->user_id)
                    <div class="mt-8 flex  flex-col gap-4">
                        <a href="{{ route('lostpets.edit', $lostPet->id) }}" class="flex-1 text-center bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 transition duration-300 font-semibold">
                            <i class="fa-solid fa-pen mr-2"></i> Editar
                        </a>
                        <form action="{{ route('lostpets.destroy', $lostPet->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition duration-300 font-semibold" onclick="return confirm('¿Estás seguro de que quieres eliminar este reporte?');">
                                <i class="fa-solid fa-trash-can mr-2"></i> Eliminar
                            </button>
                            @endif
                        </form>
                        <!-- Botón para volver a la lista -->

                        <div class="mt-8">
                            <a href="{{ route('lostpets.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300">
                                Volver a la Lista
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection