@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-4xl px-4 py-8">
    <!-- Header del perfil -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-32"></div>
        <div class="px-6 pb-6">
            <div class="flex flex-col sm:flex-row items-center sm:items-end -mt-16 sm:-mt-12">
                <!-- Avatar -->
                <div class="bg-white rounded-full p-2 shadow-lg mb-4 sm:mb-0">
                    @if($user->photo)
                        <img src="{{ $user->photo }}" alt="Foto de {{ $user->user_name }}" class="w-24 h-24 sm:w-32 sm:h-32 rounded-full object-cover">
                    @else
                        <div class="w-24 h-24 sm:w-32 sm:h-32 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white text-4xl sm:text-5xl font-bold">
                            {{ strtoupper(substr($user->user_name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                
                <!-- Información básica -->
                <div class="sm:ml-6 text-center sm:text-left flex-1">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $user->user_name }}</h1>
                    <p class="text-gray-600 flex items-center justify-center sm:justify-start gap-2 mt-1">
                        <i class="fa-solid fa-location-dot text-blue-600"></i>
                        {{ $user->city }}
                    </p>
                </div>

                <!-- Botón editar -->
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition font-medium text-sm inline-flex items-center">
                        <i class="fa-solid fa-pen-to-square mr-2"></i>Editar Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Información detallada -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Información de contacto -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-address-card text-blue-600"></i>
                Información de Contacto
            </h2>
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-envelope text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Email</p>
                        <p class="text-gray-900">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-phone text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Teléfono</p>
                        <p class="text-gray-900">{{ $user->user_phone }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-map-marker-alt text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Ciudad</p>
                        <p class="text-gray-900">{{ $user->city }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-chart-simple text-blue-600"></i>
                Actividad
            </h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-paw text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Mascotas Publicadas</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $user->pets->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between p-4 bg-purple-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-magnifying-glass text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Mascotas Perdidas Reportadas</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $user->lostPets->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-calendar-days text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Miembro desde</p>
                            <p class="text-lg font-bold text-gray-900">{{ $user->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones rápidas -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Acciones Rápidas</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('pets.create') }}" class="flex items-center gap-3 p-4 border-2 border-blue-200 hover:border-blue-400 rounded-lg transition group">
                 <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition">
                     <i class="fa-solid fa-plus text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Publicar Mascota</p>
                    <p class="text-sm text-gray-600">En adopción</p>
                </div>
            </a>
            <a href="{{ route('lostpets.create') }}" class="flex items-center gap-3 p-4 border-2 border-purple-200 hover:border-purple-400 rounded-lg transition group">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition">
                    <i class="fa-solid fa-magnifying-glass-plus text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Reportar Perdida</p>
                    <p class="text-sm text-gray-600">Mascota perdida</p>
                </div>
            </a>
            <a href="{{ route('pets.index') }}" class="flex items-center gap-3 p-4 border-2 border-blue-200 hover:border-blue-400 rounded-lg transition group">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition">
                    <i class="fa-solid fa-dog text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Ver Mascotas</p>
                    <p class="text-sm text-gray-600">En adopción</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border-2 border-red-200 p-6">
        <h2 class="text-xl font-bold text-red-600 mb-2 flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation"></i>
            Zona de Peligro
        </h2>
        <p class="text-gray-600 mb-4 text-sm">
            Una vez que elimines tu cuenta, no hay vuelta atrás. Por favor, sé consciente de que se eliminarán todos tus datos incluyendo mascotas publicadas, reportes de mascotas perdidas y publicaciones.
        </p>
        <button 
            type="button"
            @click="$dispatch('open-delete-modal')"
            class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-300 rounded-lg transition font-medium text-sm inline-flex items-center gap-2"
        >
            <i class="fa-solid fa-trash-can"></i>
            Eliminar mi cuenta
        </button>
    </div>

    <!-- Modal de confirmación de eliminación -->
    <div
        x-data="{ show: false, password: '', confirmed: false }"
        @open-delete-modal.window="show = true; password = ''; confirmed = false"
        x-show="show"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
    >
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="show = false"></div>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Eliminar cuenta de PetBook
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Para confirmar, ingresa tu contraseña y marca la casilla de confirmación.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 space-y-4">
                            <div>
                                <label for="modal-password" class="block text-sm font-medium text-gray-700">Contraseña actual</label>
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="modal-password"
                                    x-model="password"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                    required
                                >
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input 
                                        id="confirm-deletion" 
                                        name="confirm_deletion" 
                                        type="checkbox"
                                        x-model="confirmed"
                                        class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500"
                                    >
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="confirm-deletion" class="font-medium text-gray-700">
                                        Entiendo que se eliminarán todos mis datos y esta acción es irreversible
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button 
                            type="submit"
                            :disabled="!password || !confirmed"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Eliminar mi cuenta
                        </button>
                        <button 
                            type="button"
                            @click="show = false"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        >
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
