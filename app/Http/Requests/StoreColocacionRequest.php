<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreColocacionRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'articulo_id' => 'required|exists:tbl_articulo,id',
            'lugar'       => 'required|string|max:255',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'message' => 'Error en la validación de los datos.',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
