@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-8">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Iniciar Sesión</h1>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <!-- Campo de email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Campo de contraseña -->
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Contraseña</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition duration-300">
                Entrar
            </button>
            <!-- Enlace para restablecer la contraseña -->
            <div class="mt-4 text-center">
                <a href="{{ route('password.request') }}" class="text-blue-500 hover:text-blue-700 transition duration-300">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>
        </form>
    </div>
</div>
@endsection