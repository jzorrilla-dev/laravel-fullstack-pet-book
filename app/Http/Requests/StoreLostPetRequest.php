<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreLostPetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pet_name' => ['nullable', 'string', 'max:255'],
            'last_seen' => ['nullable', 'string', 'max:255'],
            'lost_date' => ['nullable', 'date'],
            'pet_species' => ['required', 'string', 'max:255'],
            'pet_photo' => ['nullable', 'image', 'max:2048'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'pet_species.required' => 'La especie es obligatoria.',
        ];
    }
}
