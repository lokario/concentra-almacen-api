<?php
namespace App\Traits;

trait HasPasswordValidationMessages {
    public function passwordValidationMessages(): array {
        return [
            'password.required'   => 'La contraseña es obligatoria.',
            'password.min'        => 'La contraseña debe tener al menos :min caracteres.',
            'password.confirmed'  => 'Las contraseñas no coinciden.',
            'password.regex'      => 'La contraseña debe contener al menos una letra minúscula, una mayúscula y un número.',
        ];
    }
}
