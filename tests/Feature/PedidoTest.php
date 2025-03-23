<?php

namespace Tests\Feature;

use App\Models\tblPedido;
use App\Models\tblColocacion;
use App\Models\tblFactura;
use App\Models\tblPY1;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PedidoTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = tblPY1::factory()->create(['rol' => 'admin']);
        Sanctum::actingAs($this->user);
    }

    public function testCreatesPedidoAndUpdatesStock(): void
    {
        $colocacion = tblColocacion::factory()->create(['stock' => 10]);
        $factura = tblFactura::factory()->create();

        $data = [
            'factura_id' => $factura->id,
            'colocacion_id' => $colocacion->id,
            'cantidad' => 3
        ];

        $response = $this->postJson('/api/pedidos', $data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('tbl_colocacion', [
            'id' => $colocacion->id,
            'stock' => 7
        ]);
    }

    public function testMergesPedidoOnSameFacturaAndColocacion(): void
    {
        $colocacion = tblColocacion::factory()->create(['stock' => 20]);
        $factura = tblFactura::factory()->create();

        $this->postJson('/api/pedidos', [
            'factura_id' => $factura->id,
            'colocacion_id' => $colocacion->id,
            'cantidad' => 2
        ]);

        $this->postJson('/api/pedidos', [
            'factura_id' => $factura->id,
            'colocacion_id' => $colocacion->id,
            'cantidad' => 3
        ]);

        $this->assertDatabaseHas('tbl_pedido', [
            'factura_id' => $factura->id,
            'colocacion_id' => $colocacion->id,
            'cantidad' => 5
        ]);
    }

    public function testFailsToCreatePedidoWithInvalidData(): void
    {
        $response = $this->postJson('/api/pedidos', []);
        $response->assertStatus(422)->assertJsonValidationErrors(['factura_id', 'colocacion_id', 'cantidad']);
    }

    public function testDeletesPedidoAndRestoresStock(): void
    {
        $colocacion = tblColocacion::factory()->create(['stock' => 5]);
        $factura = tblFactura::factory()->create();

        $createResponse = $this->postJson('/api/pedidos', [
            'factura_id' => $factura->id,
            'colocacion_id' => $colocacion->id,
            'cantidad' => 2
        ]);

        $pedidoId = $createResponse->json('id');

        $this->deleteJson("/api/pedidos/{$pedidoId}");

        $this->assertDatabaseHas('tbl_colocacion', [
            'id' => $colocacion->id,
            'stock' => 5
        ]);
    }

    public function testListsPedidosWithPagination(): void
    {
        tblPedido::factory()->count(5)->create();

        $response = $this->getJson('/api/pedidos');
        $response->assertStatus(200)->assertJsonStructure(['data', 'total', 'per_page', 'current_page', 'last_page']);
    }
}
