<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class tblPY1Factory extends Factory
{
    public function definition(): array
    {
        return [
            'usuario' => $this->faker->userName,
            'password' => Hash::make('password'),
            'correo' => $this->faker->unique()->safeEmail,
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'telefono' => $this->faker->numerify('809#######'),
            'cedula' => $this->faker->numerify('###-#######-#'),
            'tipo_sangre' => $this->faker->randomElement(['A+', 'B+', 'O-', 'AB+']),
            'rol' => 'admin',
            'sexo' => $this->faker->randomElement(['M', 'F']),
        ];
    }
}
