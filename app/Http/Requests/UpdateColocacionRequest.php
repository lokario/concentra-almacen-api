<?php

namespace App\Http\Requests;

use App\Traits\HasRelationalValidationMessages;

class UpdateColocacionRequest extends BaseFormRequest {
    use HasRelationalValidationMessages;
    
    public function rules(): array {
        return [
            'articulo_id' => 'sometimes|exists:tbl_articulo,id',
            'lugar'       => 'sometimes|string|max:255',
        ];
    }

    public function messages(): array {
        return array_merge(
            parent::messages(),
            $this->relationalValidationMessages(),
        );
    }
}
