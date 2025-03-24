<?php

namespace App\Http\Requests;

use App\Traits\HasRelationalValidationMessages;

class UpdatePedidoRequest extends BaseFormRequest {
    use HasRelationalValidationMessages;
    
    public function rules(): array {
        return [
            'factura_id'    => 'sometimes|exists:tbl_factura,id',
            'colocacion_id' => 'sometimes|exists:tbl_colocacion,id',
            'cantidad'      => 'sometimes|integer|min:1',
        ];
    }

    public function messages(): array {
        return array_merge(
            parent::messages(),
            $this->relationalValidationMessages(),
        );
    }
}
