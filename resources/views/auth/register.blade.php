@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-8">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Crear Cuenta</h1>

        <!-- Formulario de registro -->
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <!-- Campo de Nombre de Usuario -->
            <div class="mb-4">
                <label for="user_name" class="block text-gray-700 font-semibold mb-2">Nombre de Usuario</label>
                <input type="text" id="user_name" name="user_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Campo de Teléfono -->
            <div class="mb-4">
                <label for="user_phone" class="block text-gray-700 font-semibold mb-2">Teléfono</label>
                <input type="text" id="user_phone" name="user_phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Campo de Ciudad -->
            <div class="mb-4">
                <label for="city" class="block text-gray-700 font-semibold mb-2">Ciudad</label>
                <input type="text" id="city" name="city" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Campo de Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Campo de Contraseña -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Contraseña</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Campo de Confirmación de Contraseña -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">Confirmar Contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition duration-300">
                Registrarse
            </button>
        </form>
    </div>
</div>
@endsection