<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblPY1 extends Model {
    use HasFactory;

    protected $table = 'tbl_p_y1';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'telefono',
        'cedula',
        'tipo_sangre',
        'rol'
    ];
}
