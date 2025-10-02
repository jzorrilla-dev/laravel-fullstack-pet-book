@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-xl overflow-hidden p-8">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Establecer Nueva Contraseña</h1>

        <!-- Mensaje de estado de la sesión, si existe -->
        @if (session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Campo oculto para el token de restablecimiento -->
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Campo de correo electrónico -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">
                    Correo Electrónico
                </label>
                <input id="email" type="email" class="w-full px-4 py-2 border border-black-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo de nueva contraseña -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">
                    Contraseña
                </label>
                <input id="password" type="password" class="w-full px-4 py-2 border border-black-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">

                @error('password')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Campo de confirmación de contraseña -->
            <div class="mb-4">
                <label for="password-confirm" class="block text-gray-700 text-sm font-semibold mb-2">
                    Confirmar Contraseña
                </label>
                <input id="password-confirm" type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" name="password_confirmation" required autocomplete="new-password">
            </div>

            <!-- Botón de envío -->
            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition duration-300">
                    Restablecer Contraseña
                </button>
            </div>
        </form>
    </div>

</div>
@endsection