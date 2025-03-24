<?php

namespace App\Http\Requests;

use App\Support\Constants;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'nombre' => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'correo' => 'sometimes|email',
            'password' => 'sometimes|string|min:6',
            'telefono' => 'sometimes|string|max:20',
            'cedula' => 'sometimes|string|max:25',
            'tipo_sangre' => ['required', Rule::in(Constants::TIPOS_SANGRE)],
            'rol' => ['sometimes', Rule::in(Constants::ROLES)]
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'message' => 'Error en la validación de los datos.',
            'errors' => $validator->errors()
        ], 422));
    }
}
