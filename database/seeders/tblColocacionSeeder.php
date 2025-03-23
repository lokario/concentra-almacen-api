<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\tblArticulo;
use App\Models\tblColocacion;

class tblColocacionSeeder extends Seeder
{
    public function run(): void
    {
        $articulos = tblArticulo::all();

        foreach ($articulos as $articulo) {
            tblColocacion::factory()->count(2)->create([
                'articulo_id' => $articulo->id,
            ]);
        }
    }
}
