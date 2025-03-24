<?php

namespace Database\Seeders;

use App\Models\tblColocacion;
use App\Models\tblFactura;
use App\Models\tblPedido;
use Illuminate\Database\Seeder;

class tblPedidoSeeder extends Seeder {
    public function run(): void {
        $colocaciones = tblColocacion::all();

        tblFactura::all()->each(function ($factura) use ($colocaciones) {
            tblPedido::factory()->count(2)->create([
                'factura_id'    => $factura->id,
                'colocacion_id' => $colocaciones->random()->id,
            ]);
        });
    }
}
