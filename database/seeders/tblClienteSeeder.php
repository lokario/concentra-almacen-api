<?php

namespace Database\Seeders;

use App\Models\tblCliente;
use Illuminate\Database\Seeder;

class tblClienteSeeder extends Seeder {
    public function run(): void {
        tblCliente::factory()->count(40)->create();
    }
}
