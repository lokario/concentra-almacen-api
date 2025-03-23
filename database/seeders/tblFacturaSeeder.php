<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\tblCliente;
use App\Models\tblFactura;

class tblFacturaSeeder extends Seeder
{
    public function run(): void
    {
        tblCliente::all()->each(function ($cliente) {
            tblFactura::factory()->create([
                'cliente_id' => $cliente->id,
            ]);
        });
    }
}
