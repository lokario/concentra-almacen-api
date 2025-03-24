<?php

namespace Tests\Feature;

use App\Models\tblCliente;
use App\Models\tblPY1;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = tblPY1::factory()->create();
    }

    private function authHeaders(): array
    {
        $token = $this->user->createToken('test')->plainTextToken;

        return ['Authorization' => 'Bearer ' . $token];
    }

    public function testCreatesClienteSuccessfully(): void
    {
        $data = [
            'nombre' => 'Juan',
            'apellido' => 'Diaz',
            'telefono' => '8091234567',
            'tipo' => 'regular',
        ];

        $response = $this->postJson('/api/clientes', $data, $this->authHeaders());

        $response->assertStatus(201)->assertJsonFragment(['nombre' => 'Juan', 'apellido' => 'Diaz']);
    }

    public function testFailsToCreateClienteWithInvalidData(): void
    {
        $response = $this->postJson('/api/clientes', [], $this->authHeaders());

        $response->assertStatus(422)->assertJsonValidationErrors(['nombre', 'telefono', 'tipo']);
    }

    public function testListsClientesWithPagination(): void
    {
        tblCliente::factory()->count(10)->create();

        $response = $this->getJson('/api/clientes', $this->authHeaders());

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'total',
                'per_page',
                'current_page',
                'last_page',
            ]);
    }

    public function testReturns404ForInvalidClienteId(): void
    {
        $response = $this->getJson('/api/clientes/999', $this->authHeaders());

        $response->assertStatus(404);
    }

    public function testUpdatesClienteSuccessfully(): void
    {
        $cliente = tblCliente::factory()->create();

        $data = ['nombre' => 'Nuevo Nombre'];

        $response = $this->putJson("/api/clientes/{$cliente->id}", $data, $this->authHeaders());

        $response->assertStatus(200)->assertJsonFragment(['nombre' => 'Nuevo Nombre']);
    }

    public function testDeletesClienteSuccessfully(): void
    {
        $cliente = tblCliente::factory()->create();

        $response = $this->deleteJson("/api/clientes/{$cliente->id}", [], $this->authHeaders());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tbl_cliente', ['id' => $cliente->id]);
    }

    public function testFiltersClientesByTipo(): void
    {
        tblCliente::factory()->create(['tipo' => 'regular']);
        tblCliente::factory()->create(['tipo' => 'preferente']);

        $response = $this->getJson('/api/clientes?tipo=regular', $this->authHeaders());

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['tipo' => 'regular']);
    }

    public function testRejectsInvalidTipo(): void
    {
        $data = tblCliente::factory()->make([
            'tipo' => 'vip'
        ])->toArray();

        $this->actingAs($this->user)->postJson('/api/clientes', $data)->assertStatus(422)->assertJsonValidationErrors(['tipo']);
    }
}