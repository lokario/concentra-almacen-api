<?php

namespace Database\Factories;

use App\Models\tblCliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class tblFacturaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cliente_id' => tblCliente::factory(),
            'fecha' => $this->faker->date(),
            'total' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
