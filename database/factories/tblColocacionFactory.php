<?php

namespace Database\Factories;

use App\Models\tblArticulo;
use Illuminate\Database\Eloquent\Factories\Factory;

class tblColocacionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'articulo_id' => tblArticulo::factory(),
            'nombre' => $this->faker->word,
            'precio' => $this->faker->randomFloat(2, 5, 100),
            'stock' => $this->faker->numberBetween(1, 20),
        ];
    }
}
