@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8 flex-auto space-between-y-4 max-w-lg">
    <div>
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Editar mascota perdida</h1>
        <!-- Formulario para editar una mascota perdida existente -->
        <form action="{{ route('lostpets.update', $lostPet->id)
    }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Campo: Nombre de la mascota -->
            <div class="mb-4">
                <label for="pet_name" class="block text-gray-700 font-semibold mb-2">Nombre de la Mascota</label>
                <input type="text" id="pet_name" name="pet_name" value="{{ old('pet_name', $lostPet->pet_name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Campo: Especie -->
            <div class="mb-4">
                <label for="pet_species" class="block text-gray-700 font-semibold mb-2">Especie</label>
                <select id="pet_species" name="pet_species" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Selecciona una especie</option>
                    <option value="perro" {{ old('pet_species', $lostPet->pet_species) == 'perro' ? 'selected' : '' }}>Perro</option>
                    <option value="gato" {{ old('pet_species', $lostPet->pet_species) == 'gato' ? 'selected' : '' }}>Gato</option>
                    <option value="conejo" {{ old('pet_species', $lostPet->pet_species) == 'conejo' ? 'selected' : '' }}>Conejo</option>
                    <option value="pajaro" {{ old('pet_species', $lostPet->pet_species) == 'pajaro' ? 'selected' : '' }}>Pájaro</option>
                    <option value="otro" {{ old('pet_species', $lostPet->pet_species) == 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>

            <!-- Campo: Ubicación donde se perdió -->
            <div class="mb-4">
                <label for="last_seen" class="block text-gray-700 font-semibold mb-2">Ubicación donde se perdió</label>
                <input type="text" id="last_seen" name="last_seen" value="{{ old('last_seen', $lostPet->last_seen) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>

            </div>
            <!-- Campo: Descripción -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Descripción</label>
                <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('description', $lostPet->description) }}</textarea>
            </div>
            <!-- Campo: Fecha en que se perdió -->
            <div class="mb-4">
                <label for="lost_date" class="block text-gray-700 font-semibold mb-2">Fecha en que se perdió</label>
                <input type="date" id="lost_date" name="lost_date" value="{{ old('lost_date', $lostPet->lost_date) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <!-- Campo: Foto de la mascota -->
            <div class="mb-6">
                <label for="pet_photo" class="block text-gray-700 font-semibold mb-2">Foto de la Mascota (opcional)</label>
                <input type="file" id="pet_photo" name="pet_photo" class="w-full text-gray-700 py-2">
                @if($lostPet->pet_photo)
                <p class="text-sm text-gray-500 mt-2">Foto actual:</p>
                <img src="{{ $lostPet->pet_photo }}" alt="Foto de {{ $lostPet->pet_name }}" class="w-32 h-32 object-cover mt-2 rounded-lg border border-gray-300">
                @endif
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300 font-semibold">
                    Actualizar Mascota Perdida
                </button>
                <a href="{{ url()->previous() }}" class="text-blue-500 hover:text-blue-700 transition duration-300">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Volver
                </a>
            </div>
        </form>
    </div>
</div>
@endsection