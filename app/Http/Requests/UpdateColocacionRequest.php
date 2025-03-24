<?php

namespace App\Http\Requests;


class UpdateColocacionRequest extends BaseFormRequest {
    public function rules(): array {
        return [
            'articulo_id' => 'sometimes|exists:tbl_articulo,id',
            'lugar'       => 'sometimes|string|max:255',
        ];
    }
}
