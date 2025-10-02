@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-8">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Editar Mascota</h1>

        <!-- Formulario para editar una mascota existente -->
        <form action="{{ route('pets.update', $pet->pet_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Campo: Nombre de la mascota -->
            <div class="mb-4">
                <label for="pet_name" class="block text-gray-700 font-semibold mb-2">Nombre de la Mascota</label>
                <input type="text" id="pet_name" name="pet_name" value="{{ old('pet_name', $pet->pet_name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Campo: Especie -->
            <div class="mb-4">
                <label for="pet_species" class="block text-gray-700 font-semibold mb-2">Especie</label>
                <select id="pet_species" name="pet_species" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Selecciona una especie</option>
                    <option value="perro" {{ old('pet_species', $pet->pet_species) == 'perro' ? 'selected' : '' }}>Perro</option>
                    <option value="gato" {{ old('pet_species', $pet->pet_species) == 'gato' ? 'selected' : '' }}>Gato</option>
                    <option value="conejo" {{ old('pet_species', $pet->pet_species) == 'conejo' ? 'selected' : '' }}>Conejo</option>
                    <option value="pajaro" {{ old('pet_species', $pet->pet_species) == 'pajaro' ? 'selected' : '' }}>Pájaro</option>
                    <option value="otro" {{ old('pet_species', $pet->pet_species) == 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
            <!-- Campo: Estado de salud -->
            <div class="mb-4">
                <label for="health_condition" class="block text-gray-700 font-semibold mb-2">Estado de salud</label>
                <input type="text" id="health_condition" name="health_condition" value="{{ old('health_condition', $pet->health_condition) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <!-- Campo: Ubicación -->
            <div class="mb-4">
                <label for="location" class="block text-gray-700 font-semibold mb-2">Ubicación</label>
                <input type="text" id="location" name="location" value="{{ old('location', $pet->location) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <!-- Campo: Descripción -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Descripción</label>
                <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('description', $pet->description) }}</textarea>
            </div>
            <!-- Campo: Foto de la mascota -->
            <div class="mb-6">
                <label for="pet_photo" class="block text-gray-700 font-semibold mb-2">Foto de la Mascota</label>
                <input type="file" id="pet_photo" name="pet_photo" class="w-full text-gray-700 py-2">
                @if($pet->pet_photo)
                <p class="text-sm text-gray-500 mt-2">Foto actual:</p>
                <img src="{{ $pet->pet_photo }}" alt="Foto de {{ $pet->pet_name }}" class="w-32 h-32 object-cover mt-2 rounded-lg border border-gray-300">
                @endif
            </div>
            <!-- campo: Castrado-->
            <div class="mb-4">
                <label for="castrated" class="block text-gray-700 font-semibold mb-2">¿Está castrado?</label>
                <select id="castrated" name="castrated" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Selecciona una opción</option>
                    <option value="1" {{ old('castrated', $pet->castrated) == '1' ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ old('castrated', $pet->castrated) == '0' ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="mb-4">
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition duration-300">
                    Guardar Cambios
                </button>
            </div>
        </form>
        <div class="text-center">
            <a href="{{ route('pets.show', $pet->pet_id) }}" class="text-blue-500 hover:text-blue-700 transition duration-300">
                <i class="fa-solid fa-arrow-left mr-2"></i> Volver a Detalles
            </a>
        </div>
    </div>
</div>
@endsection