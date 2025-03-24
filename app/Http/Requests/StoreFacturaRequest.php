<?php

namespace App\Http\Requests;

use App\Traits\HasRelationalValidationMessages;

class StoreFacturaRequest extends BaseFormRequest {
    use HasRelationalValidationMessages;
    
    public function rules(): array {
        return [
            'cliente_id' => 'required|exists:tbl_cliente,id',
            'fecha'      => 'required|date',
        ];
    }

    public function messages(): array {
        return array_merge(
            parent::messages(),
            $this->relationalValidationMessages(),
        );
    }
}
