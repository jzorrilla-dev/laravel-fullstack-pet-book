@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-8 text-center">
            <div class="text-green-500 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            
            <h1 class="text-2xl font-bold text-gray-800 mb-4">¡Gracias por tu donación!</h1>
            
            <p class="text-gray-600 mb-6">Tu generosidad nos ayuda a seguir mejorando nuestra plataforma y a ayudar a más mascotas a encontrar un hogar.</p>
            
            <div class="mt-8">
                <a href="{{ route('home') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                    Volver al inicio
                </a>
            </div>
        </div>
    </div>
</div>
@endsection