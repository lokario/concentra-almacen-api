<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblFactura extends Model {
    use HasFactory;

    protected $table = 'tbl_factura';

    protected $fillable = ['cliente_id', 'fecha', 'estado'];

    public function cliente() {
        return $this->belongsTo(tblCliente::class, 'cliente_id');
    }

    public function pedidos() {
        return $this->hasMany(tblPedido::class, 'factura_id');
    }

    public function getTotalAttribute(): float {
        return $this->pedidos->sum(function ($pedido) {
            $precio = $pedido->colocacion->articulo->precio ?? 0;
            return $pedido->cantidad * $precio;
        });
    }
}
