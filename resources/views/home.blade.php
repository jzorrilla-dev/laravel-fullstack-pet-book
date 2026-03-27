@extends('layouts.app')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-purple-600 via-purple-500 to-blue-600 text-white overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-32 h-32 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-48 h-48 bg-white rounded-full blur-3xl"></div>
        </div>
        
        <div class="container mx-auto px-4 py-16 relative z-10">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-4 tracking-tight">
                    ¡Encuentra a tu nuevo mejor amigo!
                </h1>
                <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto">
                    Conectamos mascotas con hogares amorosos. Explora nuestra comunidad o ayuda a reunirlas con sus familias.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col md:flex-row justify-center gap-6 max-w-4xl mx-auto">
                <a href="{{ route('pets.create') }}" 
                    class="group bg-white text-purple-700 px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center justify-center gap-3">
                    <i class="fa-solid fa-paw text-2xl group-hover:rotate-12 transition-transform"></i>
                    <div class="text-left">
                        <span class="block text-lg">Publicar Mascota</span>
                        <span class="block text-sm text-purple-600/70">Dale un hogar</span>
                    </div>
                </a>

                <a href="{{ route('lostpets.create') }}" 
                    class="group bg-purple-800/50 text-white px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 border border-white/20 flex items-center justify-center gap-3">
                    <i class="fa-solid fa-magnifying-glass text-2xl group-hover:rotate-12 transition-transform"></i>
                    <div class="text-left">
                        <span class="block text-lg">Reportar Perdida</span>
                        <span class="block text-sm text-white/70">Ayudanos a encontrarla</span>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#f9fafb"/>
            </svg>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <!-- Mascotas en Adopción -->
        <section class="mb-16">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-600 text-white p-3 rounded-xl">
                        <i class="fa-solid fa-dog text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Mascotas en Adopción</h2>
                        <p class="text-gray-500 text-sm">Encuentra tu compañero perfecto</p>
                    </div>
                </div>
                <a href="{{ route('pets.index') }}" class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-2 transition">
                    Ver todas <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            @if($pets->isEmpty())
            <div class="bg-gray-50 rounded-xl p-12 text-center border-2 border-dashed border-gray-200">
                <i class="fa-solid fa-paw text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-600 text-lg">¡Vaya! No hay mascotas disponibles para adopción en este momento.</p>
                <a href="{{ route('pets.create') }}" class="inline-block mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    ¡Sé el primero en publicar!
                </a>
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($pets as $pet)
                <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                    <a href="{{ route('pets.show', $pet) }}" class="block relative">
                        @if($pet->pet_photo)
                        <div class="w-full h-48 overflow-hidden">
                            <img src="{{ $pet->pet_photo }}" alt="Foto de {{ $pet->pet_name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                            <i class="fa-solid fa-paw text-4xl text-gray-300"></i>
                        </div>
                        @endif
                        <div class="absolute top-3 right-3 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                            {{ ucfirst($pet->pet_species) }}
                        </div>
                    </a>

                    <div class="p-5">
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="text-xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $pet->pet_name }}</h3>
                            @if($pet->castrated)
                            <span class="text-green-600 text-sm" title="Castrado">
                                <i class="fa-solid fa-check-circle"></i>
                            </span>
                            @endif
                        </div>
                        
                        <p class="text-gray-500 text-sm mb-3">
                            <i class="fa-solid fa-location-dot mr-1"></i> {{ $pet->location }}
                        </p>
                        
                        <p class="text-gray-600 text-sm line-clamp-2 mb-4">
                            {{ Str::limit($pet->description, 80) }}
                        </p>

                        <a href="{{ route('pets.show', $pet) }}" class="block w-full text-center bg-blue-600 text-white py-2.5 rounded-lg font-medium hover:bg-blue-700 transition duration-300">
                            Ver Detalles
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </section>

        <!-- Mascotas Perdidas -->
        <section>
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <div class="bg-purple-600 text-white p-3 rounded-xl">
                        <i class="fa-solid fa-map-pin text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Mascotas Perdidas</h2>
                        <p class="text-gray-500 text-sm">Ayuda a reunirlas con sus familias</p>
                    </div>
                </div>
                <a href="{{ route('lostpets.index') }}" class="text-purple-600 hover:text-purple-700 font-medium flex items-center gap-2 transition">
                    Ver todas <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            @if($lostPets->isEmpty())
            <div class="bg-gray-50 rounded-xl p-12 text-center border-2 border-dashed border-gray-200">
                <i class="fa-solid fa-map-pin text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-600 text-lg">No hay mascotas perdidas publicadas en este momento.</p>
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($lostPets as $pet)
                <div class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                    <a href="{{ route('lostpets.show', $pet->id) }}" class="block relative">
                        @if($pet->pet_photo)
                        <div class="w-full h-48 overflow-hidden">
                            <img src="{{ $pet->pet_photo }}" alt="Foto de {{ $pet->pet_name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                            <i class="fa-solid fa-paw text-4xl text-gray-300"></i>
                        </div>
                        @endif
                        <div class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full animate-pulse">
                            PERDIDO
                        </div>
                    </a>

                    <div class="p-5">
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-purple-600 transition-colors mb-2">
                            {{ $pet->pet_name ?? 'Sin nombre' }}
                        </h3>
                        
                        <div class="space-y-1 text-sm text-gray-500 mb-3">
                            <p>
                                <i class="fa-solid fa-location-dot mr-1"></i> {{ $pet->last_seen ?? 'Ubicación no especificada' }}
                            </p>
                            <p>
                                <i class="fa-solid fa-calendar mr-1"></i> Se perdió el {{ \Carbon\Carbon::parse($pet->lost_date)->format('d/m/Y') }}
                            </p>
                        </div>
                        
                        <p class="text-gray-600 text-sm line-clamp-2 mb-4">
                            {{ Str::limit($pet->description, 80) }}
                        </p>

                        <a href="{{ route('lostpets.show', $pet->id) }}" class="block w-full text-center bg-purple-600 text-white py-2.5 rounded-lg font-medium hover:bg-purple-700 transition duration-300">
                            Ver Detalles
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </section>
    </div>
</div>
@endsection