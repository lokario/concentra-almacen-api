<?php

namespace Database\Seeders;

use App\Models\tblArticulo;
use Illuminate\Database\Seeder;

class tblArticuloSeeder extends Seeder {
    public function run(): void {
        tblArticulo::factory()->count(20)->create();
    }
}
