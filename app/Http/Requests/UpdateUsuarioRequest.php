<?php

namespace App\Http\Requests;

use App\Support\Constants;
use App\Traits\HasEnumValidationMessages;
use App\Traits\HasPasswordValidationMessages;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends BaseFormRequest {
    use HasPasswordValidationMessages, HasEnumValidationMessages;

    public function rules(): array {
        return [
            'nombre'      => 'sometimes|string|max:255',
            'apellido'    => 'sometimes|string|max:255',
            'correo'      => 'sometimes|email',
            'password'    => 'sometimes|string|min:6',
            'telefono'    => 'sometimes|string|max:20',
            'cedula'      => 'sometimes|string|max:25',
            'tipo_sangre' => ['sometimes', Rule::in(Constants::TIPOS_SANGRE)],
            'rol'         => ['sometimes', Rule::in(Constants::ROLES)],
        ];
    }

    public function messages(): array {
        return array_merge(
            parent::messages(),
            $this->passwordValidationMessages(),
            $this->enumValidationMessages()
        );
    }
}
