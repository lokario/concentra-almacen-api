<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\tblArticulo;

class tblArticuloSeeder extends Seeder
{
    public function run(): void
    {
        tblArticulo::factory()->count(20)->create();
    }
}
