<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class tblPY1 extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

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
        'rol'
    ];
}
