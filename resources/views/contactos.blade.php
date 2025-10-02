@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl px-4 py-10">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-8 md:p-10">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">Contactos</h1>
            <p class="text-gray-600 mb-8">Puedes contactarme a través de los siguientes medios:</p>

            <div class="space-y-4">
                <a href="mailto:{{ config('mail.from.address') }}" class="flex items-center gap-3 p-4 rounded-lg border border-blue-100 bg-blue-50 hover:bg-blue-100 transition">
                    <span class="text-blue-600 text-xl"><i class="fa-solid fa-envelope"></i></span>
                    <div>
                        <div class="font-semibold text-gray-900">Correo</div>
                        <div class="text-gray-700">{{ config('mail.from.address') }}</div>
                    </div>
                </a>

                <a href="tel:{{ env('APP_CONTACT_PHONE', '') }}" class="flex items-center gap-3 p-4 rounded-lg border border-emerald-100 bg-emerald-50 hover:bg-emerald-100 transition">
                    <span class="text-emerald-600 text-xl"><i class="fa-solid fa-phone"></i></span>
                    <div>
                        <div class="font-semibold text-gray-900">Teléfono</div>
                        <div class="text-gray-700">{{ env('APP_CONTACT_PHONE', 'Agrega APP_CONTACT_PHONE en tu .env') }}</div>
                    </div>
                </a>
            </div>

            <div class="mt-8 text-sm text-gray-500">
                Consejo: puedes configurar tu número en el archivo .env como <code class="bg-gray-100 px-1 rounded">APP_CONTACT_PHONE=+54...</code>
            </div>
        </div>
    </div>
</div>
@endsection
