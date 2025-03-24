<?php

namespace App\Http\Requests;


class UpdateClienteRequest extends BaseFormRequest {
    public function rules(): array {
        return [
            'nombre'   => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'telefono' => 'sometimes|string|max:20',
            'tipo'     => 'sometimes|in:regular,preferente',
        ];
    }
}
