<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class tblClienteFactory extends Factory {
    public function definition(): array {
        return [
            'nombre'   => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'telefono' => $this->faker->numerify('809#######'),
            'tipo'     => $this->faker->randomElement(['regular', 'preferente']),
        ];
    }
}
