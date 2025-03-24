<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class tblPY1 extends Authenticatable {
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $table = 'tbl_p_y1';

    protected $fillable = [
        'usuario',
        'correo',
        'password',
        'nombre',
        'apellido',
        'cedula',
        'telefono',
        'tipo_sangre',
        'sexo',
        'rol',
    ];
}
