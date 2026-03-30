<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdatePetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pet_name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'pet_species' => ['required', 'string', 'max:255'],
            'castrated' => ['required', 'boolean'],
            'pet_photo' => ['nullable', 'image', 'max:2048'],
            'description' => ['nullable', 'string'],
            'health_condition' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'pet_name.required' => 'El nombre de la mascota es obligatorio.',
            'location.required' => 'La ubicación es obligatoria.',
            'pet_species.required' => 'La especie es obligatoria.',
            'castrated.required' => 'Debes indicar si está castrado.',
        ];
    }
}
