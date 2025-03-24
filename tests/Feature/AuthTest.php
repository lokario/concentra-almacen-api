<?php

namespace Tests\Feature;

use App\Models\tblPY1;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;


class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistersUserSuccessfully(): void
    {
        $data = [
            'usuario' => 'testUser',
            'correo' => 'test@example.com',
            'password' => 'StrongPass123',
            'password_confirmation' => 'StrongPass123',
            'nombre' => 'Test',
            'apellido' => 'User',
            'telefono' => '8091234567',
            'cedula' => '00112345678',
            'tipo_sangre' => 'O+',
            'sexo' => 'M'
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'user'
            ]);

        $this->assertDatabaseHas('tbl_p_y1', ['correo' => 'test@example.com']);
    }

    public function testLoginWithValidCredentials(): void
    {
        tblPY1::factory()->create([
            'usuario' => 'validuser',
            'password' => Hash::make('password123')
        ]);

        $response = $this->postJson('/api/login', [
            'usuario' => 'validuser',
            'password' => 'password123'
        ]);

        $response->assertStatus(200)->assertJsonStructure(['access_token', 'token_type', 'user']);
    }

    public function testLoginFailsWithInvalidCredentials(): void
    {
        tblPY1::factory()->create([
            'usuario' => 'baduser',
            'password' => Hash::make('correctpass')
        ]);

        $response = $this->postJson('/api/login', [
            'usuario' => 'baduser',
            'password' => 'wrongpass'
        ]);

        $response->assertStatus(422)->assertJson(['message' => 'Credenciales incorrectas.']);
    }

    public function testLogoutSuccessfully(): void
    {
        $user = tblPY1::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/logout');

        $response->assertStatus(200)->assertJson(['message' => 'Sesión cerrada']);
    }
}
