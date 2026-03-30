<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class DestroyAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => ['required', 'string'],
            'confirm_deletion' => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Debes ingresar tu contraseña para confirmar.',
            'confirm_deletion.accepted' => 'Debes aceptar que esta acción es irreversible.',
        ];
    }
}
