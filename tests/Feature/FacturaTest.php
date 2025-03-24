<?php

namespace Tests\Feature;

use App\Models\tblCliente;
use App\Models\tblFactura;
use App\Models\tblPY1;
use App\Support\Constants;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FacturaTest extends TestCase {
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void {
        parent::setUp();
        $this->user = tblPY1::factory()->create(['rol' => Constants::ROL_ADMIN]);
        Sanctum::actingAs($this->user);
    }

    public function testCreatesFacturaSuccessfully(): void {
        $cliente = tblCliente::factory()->create();

        $data = [
            'cliente_id' => $cliente->id,
            'fecha'      => now()->format('Y-m-d'),
            'total'      => 450.75,
        ];

        $response = $this->postJson('/api/facturas', $data);

        $response->assertStatus(201)->assertJsonFragment(['cliente_id' => $cliente->id]);
    }

    public function testFailsToCreateFacturaWithInvalidData(): void {
        $response = $this->postJson('/api/facturas', []);

        $response->assertStatus(422)->assertJsonValidationErrors(['cliente_id', 'fecha']);
    }

    // public function testUpdatesFacturaSuccessfully(): void
    // {
    //     $factura = tblFactura::factory()->create();

    //     $response = $this->putJson("/api/facturas/{$factura->id}", [
    //         'total' => 999.99
    //     ]);

    //     $response->assertStatus(200)->assertJsonFragment(['total' => 999.99]);
    // }

    public function testDeletesFacturaSuccessfully(): void {
        $factura = tblFactura::factory()->create();

        $response = $this->deleteJson("/api/facturas/{$factura->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tbl_factura', ['id' => $factura->id]);
    }

    public function testListsFacturasWithPagination(): void {
        tblFactura::factory()->count(5)->create();

        $response = $this->getJson('/api/facturas');

        $response->assertStatus(200)->assertJsonStructure(['data', 'total', 'per_page', 'current_page', 'last_page']);
    }

    public function testFiltersFacturasByDateRange(): void {
        tblFactura::factory()->create(['fecha' => now()->subDays(5)->format('Y-m-d')]);
        tblFactura::factory()->create(['fecha' => now()->subDays(1)->format('Y-m-d')]);

        $response = $this->getJson('/api/facturas?from=' . now()->subDays(3)->format('Y-m-d') . '&to=' . now()->format('Y-m-d'));

        $response->assertStatus(200)->assertJsonCount(1, 'data');
    }

    public function testRejectsInvalidClienteId(): void {
        $data = [
            'cliente_id' => 9999,
            'fecha'      => now()->toDateString(),
        ];

        $this->postJson('/api/facturas', $data)->assertStatus(422)->assertJsonValidationErrors(['cliente_id']);
    }

    public function testRejectsInvalidFechaFormat(): void {
        $cliente = tblCliente::factory()->create();

        $data = [
            'cliente_id' => $cliente->id,
            'fecha'      => 'hello-world',
        ];

        $this->postJson('/api/facturas', $data)->assertStatus(422)->assertJsonValidationErrors(['fecha']);
    }

    public function testDefaultsEstadoToFinalizada(): void {
        $cliente = tblCliente::factory()->create();

        $data = [
            'cliente_id' => $cliente->id,
            'fecha'      => now()->toDateString(),
        ];

        $this->postJson('/api/facturas', $data)->assertStatus(201)
            ->assertJsonFragment(['estado' => Constants::FACTURA_FINALIZADA]);
    }

    public function testRejectsInvalidEstado(): void {
        $factura = tblFactura::factory()->create();

        $data = [
            'cliente_id' => $factura->cliente_id,
            'estado'     => 'invalid-status',
        ];

        $this->putJson("/api/facturas/{$factura->id}", $data)->assertStatus(422)
            ->assertJsonValidationErrors(['estado']);
    }

    public function testIgnoresFechaUpdate(): void {
        $factura = tblFactura::factory()->create([
            'fecha' => now()->toDateString(),
        ]);

        $updatedFecha = now()->addDays(5)->toDateString();

        $data = [
            'cliente_id' => $factura->cliente_id,
            'estado'     => Constants::FACTURA_FINALIZADA,
            'fecha'      => $updatedFecha,
        ];

        $this->putJson("/api/facturas/{$factura->id}", $data)->assertStatus(200);
        $this->assertNotEquals($updatedFecha, $factura->fresh()->fecha);
    }
}
