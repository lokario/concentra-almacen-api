<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblCliente extends Model
{
    use HasFactory;

    protected $table = 'tbl_cliente';

    protected $fillable = ['nombre', 'telefono', 'tipo'];

    public function facturas() {
        return $this->hasMany(tblFactura::class, 'cliente_id');
    }
}
