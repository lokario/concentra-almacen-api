<?php

namespace App\Http\Requests;


class StoreClienteRequest extends BaseFormRequest {
    public function rules(): array {
        return [
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'tipo'     => 'required|in:regular,preferente',
        ];
    }
}
