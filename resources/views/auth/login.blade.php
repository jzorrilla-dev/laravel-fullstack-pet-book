@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-8">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Iniciar Sesión</h1>

        <form action="{{ route('login') }}" method="POST" x-data="loginForm()">
            @csrf

            <!-- Campo de email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    required autocomplete="email">
            </div>

            <!-- Campo de contraseña con toggle -->
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Contraseña</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" 
                        id="password" name="password" 
                        class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        required autocomplete="current-password">
                    <button type="button" 
                        @click="showPassword = !showPassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                        tabindex="-1">
                        <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                    </button>
                </div>
            </div>

            <!-- Mensaje de error genérico -->
            @error('email')
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <p class="text-sm">{{ $message }}</p>
            </div>
            @enderror

            <!-- Botón de envío -->
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition duration-300">
                Entrar
            </button>
            <!-- Enlace para restablecers la contraseña -->
            <div class="mt-4 text-center">
                <a href="{{ route('password.email') }}" class="text-blue-500 hover:text-blue-700 transition duration-300">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function loginForm() {
    return {
        showPassword: false
    }
}
</script>
@endsection