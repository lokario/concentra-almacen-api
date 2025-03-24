<?php

namespace App\Http\Requests;

use App\Traits\HasRelationalValidationMessages;

class StorePedidoRequest extends BaseFormRequest {
    use HasRelationalValidationMessages;
    
    public function rules(): array {
        return [
            'factura_id'    => 'required|exists:tbl_factura,id',
            'colocacion_id' => 'required|exists:tbl_colocacion,id',
            'cantidad'      => 'required|integer|min:1',
        ];
    }

    public function messages(): array {
        return array_merge(
            parent::messages(),
            $this->relationalValidationMessages(),
        );
    }
}
