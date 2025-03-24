<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


abstract class BaseFormRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function messages(): array {
        return [
            'required'  => 'El campo :attribute es obligatorio.',
            'max'       => 'El campo :attribute no puede exceder los :max caracteres.',
            'min'       => 'El campo :attribute debe tener al menos :min caracteres.',
            'unique'    => 'Este valor ya está registrado.',
            'email'     => 'El campo :attribute debe ser un correo electrónico válido.',
            'confirmed' => 'Las contraseñas no coinciden.',
            'in'        => 'El campo :attribute no tiene un valor válido.',
            'regex'     => 'El formato del campo :attribute no es válido.',
        ];
    }

    public function attributes(): array {
        return [
            'usuario'               => 'nombre de usuario',
            'password'              => 'contraseña',
            'telefono'              => 'teléfono',
            'cedula'                => 'cédula',
            'tipo_sangre'           => 'tipo de sangre',
            'articulo_id'           => 'artículo',
            'cliente_id'            => 'cliente',
            'colocacion_id'         => 'colocación',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'message' => 'Error en la validación de los datos.',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
