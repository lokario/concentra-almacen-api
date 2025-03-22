<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePedidoRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'factura_id' => 'sometimes|exists:tbl_factura,id',
            'colocacion_id' => 'sometimes|exists:tbl_colocacion,id',
            'cantidad' => 'sometimes|integer|min:1'
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'message' => 'Error en la validación de los datos.',
            'errors' => $validator->errors()
        ], 422));
    }
}