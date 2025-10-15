@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-8">
            <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">Apoya a PetBook con tu donación</h1>
            
            <div class="mb-8 text-center">
                <p class="text-lg mb-4">Tu generosidad nos ayuda a seguir mejorando nuestra plataforma y a ayudar a más mascotas a encontrar un hogar.</p>
                <p class="text-gray-600 mb-6">Todas las donaciones se utilizan para mantener y mejorar nuestra plataforma, así como para apoyar a refugios de animales asociados.</p>
            </div>
            
            <div class="flex justify-center mb-8">
                <a href="{{ route('donations.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105">
                    Hacer una donación ahora
                </a>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6 mt-10">
                <div class="bg-blue-50 p-6 rounded-lg text-center">
                    <div class="text-blue-500 text-4xl mb-2">🏠</div>
                    <h3 class="text-xl font-semibold mb-2">Más hogares</h3>
                    <p class="text-gray-600">Ayudamos a más mascotas a encontrar familias amorosas</p>
                </div>
                
                <div class="bg-blue-50 p-6 rounded-lg text-center">
                    <div class="text-blue-500 text-4xl mb-2">🔍</div>
                    <h3 class="text-xl font-semibold mb-2">Mascotas perdidas</h3>
                    <p class="text-gray-600">Mejoramos nuestro sistema de búsqueda de mascotas extraviadas</p>
                </div>
                
                <div class="bg-blue-50 p-6 rounded-lg text-center">
                    <div class="text-blue-500 text-4xl mb-2">💙</div>
                    <h3 class="text-xl font-semibold mb-2">Comunidad</h3>
                    <p class="text-gray-600">Fortalecemos nuestra comunidad de amantes de los animales</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection