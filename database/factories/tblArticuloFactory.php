<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class tblArticuloFactory extends Factory
{
    public function definition(): array
    {
        return [
            'codigo_barras' => $this->faker->unique()->ean13,
            'descripcion' => $this->faker->words(3, true),
            'fabricante' => $this->faker->company,
        ];
    }
}
