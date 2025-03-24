<?php

namespace Database\Factories;

use App\Models\tblColocacion;
use App\Models\tblFactura;
use Illuminate\Database\Eloquent\Factories\Factory;

class tblPedidoFactory extends Factory {
    public function definition(): array {
        return [
            'factura_id'    => tblFactura::factory(),
            'colocacion_id' => tblColocacion::factory(),
            'cantidad'      => $this->faker->numberBetween(1, 5),
        ];
    }
}
