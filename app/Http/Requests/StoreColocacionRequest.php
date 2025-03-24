<?php

namespace App\Http\Requests;


class StoreColocacionRequest extends BaseFormRequest {
    public function rules(): array {
        return [
            'articulo_id' => 'required|exists:tbl_articulo,id',
            'lugar'       => 'required|string|max:255',
        ];
    }
}
