@extends('layouts.app')
@section('content')
<div class="container mx-auto max-w-lg px-4 py-8">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Publicar Mascota Perdida</h1>

    <form action="{{ route('lostpets.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="pet_name">Nombre de la Mascota</label>
            <input type="text" name="pet_name" id="pet_name" value="{{ old('pet_name') }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('pet_name') border-red-500 @enderror">
            @error('pet_name')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="pet_species">Especie</label>
            <select name="pet_species" id="pet_species"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('pet_species') border-red-500 @enderror">
                <option value="" disabled selected>Selecciona una especie</option>
                <option value="perro" {{ old('pet_species') == 'perro' ? 'selected' : '' }}>Perro</option>
                <option value="gato" {{ old('pet_species') == 'gato' ? 'selected' : '' }}>Gato</option>
                <option value="otro" {{ old('pet_species') == 'otro' ? 'selected' : '' }}>Otro</option>
            </select>
            @error('pet_species')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="last_seen">Ubicación donde se perdió</label>
            <input type="text" name="last_seen" id="last_seen" value="{{ old('last_seen') }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('last_seen') border-red-500 @enderror">
            @error('last_seen')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Descripción</label>
            <textarea name="description" id="description" rows="4"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="lost_date">Fecha en que se perdió</label>
            <input type="date" name="lost_date" id="lost_date" value="{{ old('lost_date') }}"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('lost_date') border-red-500 @enderror">
            @error('lost_date')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="pet_photo">Foto de la Mascota (opcional)</label>
            <input type="file" name="pet_photo" id="pet_photo" accept="image/*"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('pet_photo') border-red-500 @enderror">
            @error('pet_photo')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:shadow-outline transition duration-300">
                Publicar Mascota Perdida
            </button>
            <a href="{{ route('lostpets.index') }}"
                class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection