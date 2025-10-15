@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl px-4 py-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-user-pen text-blue-600"></i>
            Editar Perfil
        </h1>

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
                <p class="font-semibold mb-2">Por favor corrige los siguientes errores:</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="user_name" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" id="user_name" name="user_name" value="{{ old('user_name', $user->user_name) }}" required
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-600 focus:ring-blue-600" />
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-600 focus:ring-blue-600" />
            </div>

            <div>
                <label for="user_phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                <input type="text" id="user_phone" name="user_phone" value="{{ old('user_phone', $user->user_phone) }}" required
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-600 focus:ring-blue-600" />
            </div>

            <div>
                <label for="city" class="block text-sm font-medium text-gray-700">Ciudad</label>
                <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}" required
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-600 focus:ring-blue-600" />
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea id="description" name="description" rows="4"
                    class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-600 focus:ring-blue-600"
                    placeholder="Cuenta algo sobre ti...">{{ old('description', $user->description) }}</textarea>
            </div>

            <div class="pt-2">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Cambiar contraseña (opcional)</h2>
                <p class="text-sm text-gray-600 mb-4">Completa estos campos solo si deseas actualizar tu contraseña.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Nueva contraseña</label>
                        <input type="password" id="password" name="password"
                            class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-600 focus:ring-blue-600" />
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-600 focus:ring-blue-600" />
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('profile') }}" class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50">Cancelar</a>
                <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 shadow-sm">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection
