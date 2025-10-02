@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-8">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Publicar una Mascota</h1>

        <!-- Formulario para subir una nueva mascota -->
        <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Campo: Nombre de la mascota -->
            <div class="mb-4">
                <label for="pet_name" class="block text-gray-700 font-semibold mb-2">Nombre de la Mascota</label>
                <input type="text" id="pet_name" name="pet_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Campo: Especie -->
            <div class="mb-4">
                <label for="pet_species" class="block text-gray-700 font-semibold mb-2">Especie</label>
                <select id="pet_species" name="pet_species" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Selecciona una especie</option>
                    <option value="perro">Perro</option>
                    <option value="gato">Gato</option>
                    <option value="conejo">Conejo</option>
                    <option value="pajaro">Pájaro</option>
                    <option value="otro">Otro</option>
                </select>
            </div>

            <!-- Campo: Estado de salud -->
            <div class="mb-4">
                <label for="health_condition" class="block text-gray-700 font-semibold mb-2">Estado de salud</label>
                <input type="text" id="health_condition" name="health_condition" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Campo: Ubicación -->
            <div class="mb-4">
                <label for="location" class="block text-gray-700 font-semibold mb-2">Ubicación</label>
                <input type="text" id="location" name="location" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Campo: Descripción -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Descripción</label>
                <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
            </div>

            <!-- Campo: Foto de la mascota -->
            <div class="mb-6">
                <label for="pet_photo" class="block text-gray-700 font-semibold mb-2">Foto de la Mascota</label>
                <input type="file" id="pet_photo" name="pet_photo" class="w-full text-gray-700 py-2" required>
            </div>
            <!-- campo: Castrado-->
            <div class="mb-4">
                <label for="castrated" class="block text-gray-700 font-semibold mb-2">¿Está castrado?</label>
                <select id="castrated" name="castrated" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Selecciona una opción</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition duration-300">
                Publicar
            </button>
        </form>
    </div>
</div>
@endsection