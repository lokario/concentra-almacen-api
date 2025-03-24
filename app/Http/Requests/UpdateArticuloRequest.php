<?php

namespace App\Http\Requests;


class UpdateArticuloRequest extends BaseFormRequest {
    public function rules(): array {
        return [
            'codigo_barras' => 'sometimes|string|max:100',
            'descripcion'   => 'sometimes|string|max:255',
            'fabricante'    => 'sometimes|string|max:100',
            'precio'        => 'sometimes|numeric|min:0',
            'stock'         => 'sometimes|integer|min:0',
        ];
    }
}
