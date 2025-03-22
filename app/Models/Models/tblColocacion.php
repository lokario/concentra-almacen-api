<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblColocacion extends Model {
    use HasFactory;

    protected $table = 'tbl_colocacion';

    protected $fillable = ['articulo_id', 'nombre', 'precio'];

    public function articulo() {
        return $this->belongsTo(tblArticulo::class, 'articulo_id');
    }
}
