@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-5xl px-4 py-10">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-8 md:p-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Acerca de Petbook</h1>
            <p class="text-gray-600 leading-relaxed mb-6">
                Petbook es una plataforma construida con Laravel 10, Blade, Alpine.js y Tailwind CSS para ayudar a la comunidad
                a conectar mascotas con nuevos hogares y también a reunir mascotas perdidas con sus familias.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div class="p-6 rounded-lg bg-blue-50 border border-blue-100">
                    <div class="text-blue-600 text-2xl mb-2"><i class="fa-solid fa-paw"></i></div>
                    <h3 class="font-semibold text-gray-900 mb-1">Adopciones</h3>
                    <p class="text-sm text-gray-600">Explora mascotas en adopción y publica tus propias publicaciones fácilmente.</p>
                </div>
                <div class="p-6 rounded-lg bg-purple-50 border border-purple-100">
                    <div class="text-purple-600 text-2xl mb-2"><i class="fa-solid fa-map-pin"></i></div>
                    <h3 class="font-semibold text-gray-900 mb-1">Mascotas Perdidas</h3>
                    <p class="text-sm text-gray-600">Reporta mascotas perdidas y ayuda a la comunidad a encontrarlas.</p>
                </div>
                <div class="p-6 rounded-lg bg-emerald-50 border border-emerald-100">
                    <div class="text-emerald-600 text-2xl mb-2"><i class="fa-solid fa-shield-heart"></i></div>
                    <h3 class="font-semibold text-gray-900 mb-1">Comunidad</h3>
                    <p class="text-sm text-gray-600">Construida para colaborar y cuidar a los animales de compañía.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
