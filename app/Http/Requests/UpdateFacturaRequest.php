<?php

namespace App\Http\Requests;

use App\Support\Constants;
use App\Traits\HasEnumValidationMessages;
use App\Traits\HasRelationalValidationMessages;
use Illuminate\Validation\Rule;

class UpdateFacturaRequest extends BaseFormRequest {
    use HasEnumValidationMessages, HasRelationalValidationMessages;

    public function rules(): array {
        return [
            'estado' => ['required', Rule::in(Constants::ESTADOS_FACTURA)],
        ];
    }

    public function messages(): array {
        return array_merge(
            parent::messages(),
            $this->enumValidationMessages(),
            $this->relationalValidationMessages(),
        );
    }
}
