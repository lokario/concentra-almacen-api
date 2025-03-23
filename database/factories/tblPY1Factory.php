<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class tblPY1Factory extends Factory
{
    public function definition(): array
    {
        return [
            'username' => $this->faker->userName,
            'password' => Hash::make('password'),
            'email' => $this->faker->unique()->safeEmail,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'telefono' => $this->faker->numerify('809#######'),
            'cedula' => $this->faker->numerify('###-#######-#'),
            'tipo_sangre' => $this->faker->randomElement(['A+', 'B+', 'O-', 'AB+']),
            'rol' => 'admin',
            'sex' => $this->faker->randomElement(['M', 'F']),
        ];
    }
}
