<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'username' => 'required|string|unique:tbl_p_y1,username|max:50',
            'email' => 'required|email|unique:tbl_p_y1,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/'
            ],
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'telefono' => 'required|string|max:20',
            'cedula' => 'required|string|max:25',
            'tipo_sangre' => 'required|string|max:5',
            'sex' => 'required|in:M,F',
            'rol' => 'in:admin,user'
        ];
    }

    public function validated($key = null, $default = null) {
        return collect(parent::validated())
            ->except('rol') // Just in case someone tries to sneak it in...
            ->toArray();
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'message' => 'Error en la validación de los datos.',
            'errors' => $validator->errors()
        ], 422));
    }
}
