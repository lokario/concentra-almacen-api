<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\tblCliente;

class tblClienteSeeder extends Seeder
{
    public function run(): void
    {
        tblCliente::factory()->count(40)->create();
    }
}
