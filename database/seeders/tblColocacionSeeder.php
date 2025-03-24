<?php

namespace Database\Seeders;

use App\Models\tblArticulo;
use App\Models\tblColocacion;
use Illuminate\Database\Seeder;

class tblColocacionSeeder extends Seeder {
    public function run(): void {
        $articulos = tblArticulo::all();

        foreach ($articulos as $articulo) {
            tblColocacion::factory()->count(2)->create([
                'articulo_id' => $articulo->id,
            ]);
        }
    }
}
