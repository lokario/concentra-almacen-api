<?php

namespace App\Http\Requests;

use App\Support\Constants;
use Illuminate\Validation\Rule;

class UpdateFacturaRequest extends BaseFormRequest {
    public function rules(): array {
        return [
            'estado' => ['required', Rule::in(Constants::ESTADOS_FACTURA)],
        ];
    }
}
