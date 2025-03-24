<?php

namespace App\Http\Requests;


class StoreFacturaRequest extends BaseFormRequest {
    public function rules(): array {
        return [
            'cliente_id' => 'required|exists:tbl_cliente,id',
            'fecha'      => 'required|date',
        ];
    }
}
