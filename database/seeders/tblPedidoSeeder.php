<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\tblFactura;
use App\Models\tblPedido;
use App\Models\tblColocacion;

class tblPedidoSeeder extends Seeder
{
    public function run(): void
    {
        $colocaciones = tblColocacion::all();

        tblFactura::all()->each(function ($factura) use ($colocaciones) {
            tblPedido::factory()->count(2)->create([
                'factura_id' => $factura->id,
                'colocacion_id' => $colocaciones->random()->id,
            ]);
        });
    }
}
