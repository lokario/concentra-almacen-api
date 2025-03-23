<?php

namespace Tests\Feature;

use App\Models\tblFactura;
use App\Models\tblCliente;
use App\Models\tblPY1;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FacturaTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = tblPY1::factory()->create(['rol' => 'admin']);
        Sanctum::actingAs($this->user);
    }

    public function testCreatesFacturaSuccessfully(): void
    {
        $cliente = tblCliente::factory()->create();

        $data = [
            'cliente_id' => $cliente->id,
            'fecha' => now()->format('Y-m-d'),
            'total' => 450.75,
        ];

        $response = $this->postJson('/api/facturas', $data);

        $response->assertStatus(201)->assertJsonFragment(['cliente_id' => $cliente->id]);
    }

    public function testFailsToCreateFacturaWithInvalidData(): void
    {
        $response = $this->postJson('/api/facturas', []);

        $response->assertStatus(422)->assertJsonValidationErrors(['cliente_id', 'fecha', 'total']);
    }

    public function testUpdatesFacturaSuccessfully(): void
    {
        $factura = tblFactura::factory()->create();

        $response = $this->putJson("/api/facturas/{$factura->id}", [
            'total' => 999.99
        ]);

        $response->assertStatus(200)->assertJsonFragment(['total' => 999.99]);
    }

    public function testDeletesFacturaSuccessfully(): void
    {
        $factura = tblFactura::factory()->create();

        $response = $this->deleteJson("/api/facturas/{$factura->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tbl_factura', ['id' => $factura->id]);
    }

    public function testListsFacturasWithPagination(): void
    {
        tblFactura::factory()->count(5)->create();

        $response = $this->getJson('/api/facturas');

        $response->assertStatus(200)->assertJsonStructure(['data', 'total', 'per_page', 'current_page', 'last_page']);
    }

    public function testFiltersFacturasByDateRange(): void
    {
        tblFactura::factory()->create(['fecha' => now()->subDays(5)->format('Y-m-d')]);
        tblFactura::factory()->create(['fecha' => now()->subDays(1)->format('Y-m-d')]);

        $response = $this->getJson('/api/facturas?from=' . now()->subDays(3)->format('Y-m-d') . '&to=' . now()->format('Y-m-d'));

        $response->assertStatus(200)->assertJsonCount(1, 'data');
    }
}
