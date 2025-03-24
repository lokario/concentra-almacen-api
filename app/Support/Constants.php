<?php

namespace App\Support;

class Constants {
    public const ROL_USER  = 'user';
    public const ROL_ADMIN = 'admin';
    public const ROLES     = [self::ROL_ADMIN, self::ROL_USER];

    public const SEXOS        = ['M', 'F'];
    public const TIPOS_SANGRE = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

    public const FACTURA_CANCELADA  = 'cancelada';
    public const FACTURA_FINALIZADA = 'finalizada';
    public const ESTADOS_FACTURA    = [self::FACTURA_CANCELADA, self::FACTURA_FINALIZADA];
}
