<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void {
        $this->call([
            tblClienteSeeder::class,
            tblArticuloSeeder::class,
            tblColocacionSeeder::class,
            tblPY1Seeder::class,
            tblFacturaSeeder::class,
            tblPedidoSeeder::class,
        ]);
    }
}
