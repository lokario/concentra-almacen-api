<?php

namespace Database\Factories;

use App\Models\tblArticulo;
use Illuminate\Database\Eloquent\Factories\Factory;

class tblColocacionFactory extends Factory {
    public function definition(): array {
        return [
            'articulo_id' => tblArticulo::factory(),
            'lugar'       => 'Estante ' . strtoupper($this->faker->randomLetter),
        ];
    }
}
