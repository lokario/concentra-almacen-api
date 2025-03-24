<?php

namespace App\Http\Requests;


class UpdatePedidoRequest extends BaseFormRequest {
    public function rules(): array {
        return [
            'factura_id'    => 'sometimes|exists:tbl_factura,id',
            'colocacion_id' => 'sometimes|exists:tbl_colocacion,id',
            'cantidad'      => 'sometimes|integer|min:1',
        ];
    }
}
