<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblArticulo extends Model {
    use HasFactory;

    protected $table = 'tbl_articulo';

    protected $fillable = ['codigo_barras', 'descripcion', 'fabricante'];

    public function colocaciones() {
        return $this->hasMany(tblColocacion::class, 'articulo_id');
    }
}
