<?php

namespace App\Http\Requests;

use App\Support\Constants;
use App\Traits\HasEnumValidationMessages;
use App\Traits\HasPasswordValidationMessages;
use Illuminate\Validation\Rule;

class RegisterRequest extends BaseFormRequest {
    use HasPasswordValidationMessages, HasEnumValidationMessages;

    public function rules(): array {
        return [
            'usuario'  => 'required|string|unique:tbl_p_y1,usuario|max:50',
            'correo'   => 'required|email|unique:tbl_p_y1,correo',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
            'nombre'      => 'required|string|max:100',
            'apellido'    => 'required|string|max:100',
            'telefono'    => 'required|string|max:20',
            'cedula'      => 'required|string|max:25',
            'tipo_sangre' => ['required', Rule::in(Constants::TIPOS_SANGRE)],
            'sexo'        => ['required', Rule::in(Constants::SEXOS)],
        ];
    }

    public function messages(): array {
        return array_merge(
            parent::messages(),
            $this->passwordValidationMessages(),
            $this->enumValidationMessages()
        );
    }

    public function validated($key = null, $default = null) {
        return collect(parent::validated())
            ->except('rol') // Just in case someone tries to sneak it in...
            ->toArray();
    }
}
