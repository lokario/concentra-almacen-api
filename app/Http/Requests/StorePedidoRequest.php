<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePedidoRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'factura_id'    => 'required|exists:tbl_factura,id',
            'colocacion_id' => 'required|exists:tbl_colocacion,id',
            'cantidad'      => 'required|integer|min:1',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'message' => 'Error en la validación de los datos.',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
