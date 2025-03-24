<?php

namespace App\Http\Requests;

use App\Traits\HasRelationalValidationMessages;

class StoreColocacionRequest extends BaseFormRequest {
    use HasRelationalValidationMessages;

    public function rules(): array {
        return [
            'articulo_id' => 'required|exists:tbl_articulo,id',
            'lugar'       => 'required|string|max:255',
        ];
    }

    public function messages(): array {
        return array_merge(
            parent::messages(),
            $this->relationalValidationMessages(),
        );
    }
}
