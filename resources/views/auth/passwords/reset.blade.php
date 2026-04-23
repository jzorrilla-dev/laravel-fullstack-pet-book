@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-xl overflow-hidden p-8">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Establecer Nueva Contraseña</h1>

        <div x-data="resetPassword()" x-init="init()" class="">

            <!-- Loading state -->
            <div x-show="loading" class="text-center py-8">
                <i class="fa-solid fa-circle-notch fa-spin text-3xl text-blue-600"></i>
                <p class="mt-2 text-gray-600">Verificando token...</p>
            </div>

            <!-- Error state -->
            <div x-show="error && !loading" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <p class="font-bold">Error</p>
                <p x-text="error"></p>
            </div>

            <!-- Success state - Password form -->
            <form x-show="!loading && !error" method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- Token oculto -->
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email info (solo lectura, obtenido del servidor) -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-semibold mb-2">
                        Cuenta a restablecer
                    </label>
                    <div class="flex items-center gap-2 px-4 py-2 bg-gray-100 rounded-lg">
                        <i class="fa-solid fa-envelope text-gray-500"></i>
                        <span class="text-gray-800 font-medium" x-text="userEmail"></span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Este es el correo electrónico associated a tu cuenta</p>
                </div>

                <!-- Validación de errores de sesión -->
                @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
                @endif

                @error('token')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <p class="text-sm">{{ $message }}</p>
                </div>
                @enderror

                <!-- Nueva contraseña -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">
                        Nueva Contraseña
                    </label>
                    <div class="relative">
                        <input id="password" :type="showPassword ? 'text' : 'password'" 
                            class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" 
                            name="password" required autocomplete="new-password"
                            placeholder="Mínimo 8 caracteres">
                        <button type="button" 
                            @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                            tabindex="-1">
                            <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                        </button>
                    </div>

                    @error('password')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar contraseña -->
                <div class="mb-4">
                    <label for="password-confirm" class="block text-gray-700 text-sm font-semibold mb-2">
                        Confirmar Nueva Contraseña
                    </label>
                    <div class="relative">
                        <input id="password-confirm" :type="showPassword ? 'text' : 'password'" 
                            class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Repite la contraseña">
                        <button type="button" 
                            @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                            tabindex="-1">
                            <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Botón de envío -->
                <div class="flex items-center justify-end mt-6">
                    <button type="submit" 
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="loading">
                        Restablecer Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function resetPassword() {
    return {
        token: '{{ $token }}',
        loading: true,
        error: null,
        showPassword: false,
        userEmail: '',
        userName: '',

        async init() {
            try {
                const response = await fetch('{{ route("password.validate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        token: this.token
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.error || 'Token inválido o expirado');
                }

                this.userEmail = data.email;
                this.userName = data.user_name;
            } catch (err) {
                this.error = err.message;
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>

@endsection