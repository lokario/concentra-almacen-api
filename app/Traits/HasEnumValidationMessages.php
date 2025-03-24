<?php
namespace App\Traits;

use App\Support\Constants;

trait HasEnumValidationMessages {
    public function enumValidationMessages(): array {
        return [
            'sexo.in'        => 'El sexo debe ser uno de los siguientes: ' . implode(', ', Constants::SEXOS) . '.',
            'tipo_sangre.in' => 'El tipo de sangre debe ser uno de los siguientes: ' . implode(', ', Constants::TIPOS_SANGRE) . '.',
            'rol.in'         => 'El rol debe ser uno de los siguientes: ' . implode(', ', Constants::ROLES) . '.',
            'estado.in'      => 'El estado debe ser uno de los siguientes: ' . implode(', ', Constants::ESTADOS_FACTURA) . '.',
        ];
    }
}