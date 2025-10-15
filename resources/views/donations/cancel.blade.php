@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-8 text-center">
            <div class="text-yellow-500 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Donación cancelada</h1>
            
            <p class="text-gray-600 mb-6">Has cancelado el proceso de donación. Si tuviste algún problema, por favor inténtalo de nuevo más tarde.</p>
            
            <div class="mt-8 flex justify-center space-x-4">
                <a href="{{ route('donations.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                    Intentar de nuevo
                </a>
                <a href="{{ route('home') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg transition duration-300">
                    Volver al inicio
                </a>
            </div>
        </div>
    </div>
</div>
@endsection