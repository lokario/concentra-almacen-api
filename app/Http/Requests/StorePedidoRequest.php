<?php

namespace App\Http\Requests;


class StorePedidoRequest extends BaseFormRequest {
    public function rules(): array {
        return [
            'factura_id'    => 'required|exists:tbl_factura,id',
            'colocacion_id' => 'required|exists:tbl_colocacion,id',
            'cantidad'      => 'required|integer|min:1',
        ];
    }
}
