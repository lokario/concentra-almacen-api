<?php

namespace App\Http\Requests;

use App\Support\Constants;
use App\Traits\HasEnumValidationMessages;
use App\Traits\HasPasswordValidationMessages;
use Illuminate\Validation\Rule;

class StoreUsuarioRequest extends BaseFormRequest {
    use HasPasswordValidationMessages, HasEnumValidationMessages;

    public function rules(): array {
        return [
            'usuario'  => 'required|string|unique:tbl_p_y1,usuario|max:50',
            'correo'   => 'required|email|unique:tbl_p_y1,correo',
            'password' => [
                'required',
                'string',
                'min:8',
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
            'rol'         => [Rule::in(Constants::ROLES)],
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
