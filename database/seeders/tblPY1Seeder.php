<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\tblPY1;
use Illuminate\Support\Facades\Hash;

class tblPY1Seeder extends Seeder
{
    public function run(): void
    {
        tblPY1::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
            'first_name' => 'Admin',
            'last_name' => 'Root',
            'telefono' => '8095551234',
            'cedula' => '00112345678',
            'tipo_sangre' => 'O+',
            'rol' => 'admin',
            'sex' => 'M',
        ]);

        tblPY1::factory()->count(5)->create([
            'rol' => 'user',
            'password' => Hash::make('Password123'),
        ]);
    }
}
