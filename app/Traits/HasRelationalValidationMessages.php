<?php

namespace App\Traits;


trait HasRelationalValidationMessages {
    public function relationalValidationMessages(): array {
        return [
            'factura_id.exists'      => 'La factura seleccionada no existe.',
            'articulo_id.exists'     => 'El artículo seleccionado no existe.',
            'cliente_id.exists'      => 'El cliente seleccionado no existe.',
            'colocacion_id.exists'   => 'La colocación seleccionada no existe.',
        ];
    }
}