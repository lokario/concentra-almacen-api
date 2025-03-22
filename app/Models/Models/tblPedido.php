<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblPedido extends Model {
    use HasFactory;

    protected $table = 'tbl_pedido';

    protected $fillable = ['factura_id', 'colocacion_id', 'cantidad'];

    public function factura() {
        return $this->belongsTo(tblFactura::class, 'factura_id');
    }

    public function colocacion() {
        return $this->belongsTo(tblColocacion::class, 'colocacion_id');
    }
}
