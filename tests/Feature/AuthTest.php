<?php

namespace Tests\Feature;

use App\Models\tblPY1;
use App\Support\Constants;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase {
    use RefreshDatabase;

    public function testRegistersUserSuccessfully(): void {
        $data = [
            'usuario'               => 'testUser',
            'correo'                => 'test@example.com',
            'password'              => 'StrongPass123',
            'password_confirmation' => 'StrongPass123',
            'nombre'                => 'Test',
            'apellido'              => 'User',
            'telefono'              => '8091234567',
            'cedula'                => '00112345678',
            'tipo_sangre'           => Constants::TIPOS_SANGRE[0],
            'sexo'                  => Constants::SEXOS[0],
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'user',
            ]);

        $this->assertDatabaseHas('tbl_p_y1', ['correo' => 'test@example.com']);
    }

    public function testLoginWithValidCredentials(): void {
        tblPY1::factory()->create([
            'usuario'  => 'validuser',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'usuario'  => 'validuser',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['access_token', 'token_type', 'user']);
    }

    public function testLoginFailsWithInvalidCredentials(): void {
        tblPY1::factory()->create([
            'usuario'  => 'baduser',
            'password' => Hash::make('correctpass'),
        ]);

        $response = $this->postJson('/api/login', [
            'usuario'  => 'baduser',
            'password' => 'wrongpass',
        ]);

        $response->assertStatus(422)->assertJson(['message' => 'Credenciales incorrectas.']);
    }

    public function testLogoutSuccessfully(): void {
        $user = tblPY1::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/logout');

        $response->assertStatus(200)->assertJson(['message' => 'Sesión cerrada']);
    }

    public function testRejectsDuplicateEmailAndUsername(): void {
        tblPY1::factory()->create([
            'correo'  => 'test2@example.com',
            'usuario' => 'test2',
        ]);

        $data = tblPY1::factory()->make([
            'correo'                => 'test2@example.com',
            'usuario'               => 'test2',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ])->toArray();

        $this->postJson('/api/register', $data)->assertStatus(422)->assertJsonValidationErrors(['correo', 'usuario']);
    }

    public function testRequiresPasswordConfirmation(): void {
        $data = tblPY1::factory()->make([
            'password'              => 'password',
            'password_confirmation' => null,
        ])->toArray();

        $this->postJson('/api/register', $data)->assertStatus(422)->assertJsonValidationErrors(['password']);
    }

    public function testAssignsUserRoleByDefault(): void {
        $data = tblPY1::factory()->make([
            'rol'                   => Constants::ROL_ADMIN,
            'password'              => 'Password123',
            'password_confirmation' => 'Password123',
        ])->toArray();

        $this->postJson('/api/register', $data)->assertStatus(201)->assertJsonMissing(['rol '=> Constants::ROL_ADMIN]);
    }
}
