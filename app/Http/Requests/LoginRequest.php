<?php

namespace App\Http\Requests;

use App\Models\tblPY1;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function authenticate(): tblPY1 {
        $user = tblPY1::where('usuario', $this->input('usuario'))->first();

        if (! $user || ! Hash::check($this->input('password'), $user->password)) {
            throw new HttpResponseException(response()->json([
            'message' => 'Credenciales incorrectas.'
        ], 422));
        }

        return $user;
    }

    public function rules(): array {
        return [
            'usuario' => 'required|string',
            'password' => 'required|string'
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'message' => 'Error en la validación de las credenciales.',
            'errors' => $validator->errors()
        ], 422));
    }
}
