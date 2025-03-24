<?php

namespace Database\Seeders;

use App\Models\tblPY1;
use App\Support\Constants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class tblPY1Seeder extends Seeder {
    public function run(): void {
        tblPY1::create([
            'usuario'     => 'admin',
            'correo'      => 'admin@example.com',
            'password'    => Hash::make('admin'),
            'nombre'      => 'Admin',
            'apellido'    => 'Root',
            'telefono'    => '8095551234',
            'cedula'      => '00112345678',
            'tipo_sangre' => Constants::TIPOS_SANGRE[0],
            'rol'         => Constants::ROL_ADMIN,
            'sexo'        => Constants::SEXOS[0],
        ]);

        tblPY1::factory()->count(5)->create([
            'rol'      => Constants::ROL_USER,
            'password' => Hash::make('Password123'),
        ]);
    }
}
