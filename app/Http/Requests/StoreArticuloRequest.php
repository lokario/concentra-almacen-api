<?php

namespace App\Http\Requests;


class StoreArticuloRequest extends BaseFormRequest {
    public function rules(): array {
        return [
            'codigo_barras' => 'required|string|max:100|unique:tbl_articulo,codigo_barras',
            'descripcion'   => 'required|string|max:255',
            'fabricante'    => 'required|string|max:100',
            'precio'        => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
        ];
    }
}
