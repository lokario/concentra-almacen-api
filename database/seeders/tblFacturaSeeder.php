<?php

namespace Database\Seeders;

use App\Models\tblCliente;
use App\Models\tblFactura;
use Illuminate\Database\Seeder;

class tblFacturaSeeder extends Seeder {
    public function run(): void {
        tblCliente::all()->each(function ($cliente) {
            tblFactura::factory()->create([
                'cliente_id' => $cliente->id,
            ]);
        });
    }
}
