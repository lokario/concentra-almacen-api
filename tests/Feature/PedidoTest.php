<?php

namespace Tests\Feature;

use App\Models\tblArticulo;
use App\Models\tblColocacion;
use App\Models\tblFactura;
use App\Models\tblPedido;
use App\Models\tblPY1;
use App\Support\Constants;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PedidoTest extends TestCase {
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void {
        parent::setUp();
        $this->user = tblPY1::factory()->create(['rol' => Constants::ROL_ADMIN]);
        Sanctum::actingAs($this->user);
    }

    public function testCreatesPedidoAndUpdatesStock(): void {
        $colocacion = tblColocacion::factory()->create();
        $articulo   = $colocacion->articulo;
        $factura    = tblFactura::factory()->create();

        $data = [
            'factura_id'    => $factura->id,
            'colocacion_id' => $colocacion->id,
            'cantidad'      => 3,
        ];

        $response = $this->postJson('/api/pedidos', $data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('tbl_articulo', [
            'id'    => $colocacion->id,
            'stock' => $articulo->stock - 3,
        ]);
    }

    public function testMergesPedidoOnSameFacturaAndColocacion(): void {
        $colocacion = tblColocacion::factory()->create();
        $factura    = tblFactura::factory()->create();

        $this->postJson('/api/pedidos', [
            'factura_id'    => $factura->id,
            'colocacion_id' => $colocacion->id,
            'cantidad'      => 2,
        ]);

        $this->postJson('/api/pedidos', [
            'factura_id'    => $factura->id,
            'colocacion_id' => $colocacion->id,
            'cantidad'      => 3,
        ]);

        $this->assertDatabaseHas('tbl_pedido', [
            'factura_id'    => $factura->id,
            'colocacion_id' => $colocacion->id,
            'cantidad'      => 5,
        ]);
    }

    public function testFailsToCreatePedidoWithInvalidData(): void {
        $response = $this->postJson('/api/pedidos', []);
        $response->assertStatus(422)->assertJsonValidationErrors(['factura_id', 'colocacion_id', 'cantidad']);
    }

    public function testDeletesPedidoAndRestoresStock(): void {
        $colocacion = tblColocacion::factory()->create();
        $articulo   = $colocacion->articulo;
        $factura    = tblFactura::factory()->create();

        $createResponse = $this->postJson('/api/pedidos', [
            'factura_id'    => $factura->id,
            'colocacion_id' => $colocacion->id,
            'cantidad'      => 2,
        ]);

        $pedidoId = $createResponse->json('id');

        $this->assertDatabaseHas('tbl_articulo', [
            'id'    => $articulo->id,
            'stock' => $articulo->stock - 2,
        ]);

        $this->deleteJson("/api/pedidos/{$pedidoId}");

        $this->assertDatabaseHas('tbl_articulo', [
            'id'    => $articulo->id,
            'stock' => $articulo->stock,
        ]);
    }

    public function testListsPedidosWithPagination(): void {
        tblPedido::factory()->count(5)->create();

        $response = $this->getJson('/api/pedidos');
        $response->assertStatus(200)->assertJsonStructure(['data', 'total', 'per_page', 'current_page', 'last_page']);
    }

    public function testCannotCreatePedidoIfNoStock(): void {
        $articulo   = tblArticulo::factory()->create(['stock' => 0]);
        $colocacion = tblColocacion::factory()->create(['articulo_id' => $articulo->id]);

        $data = [
            'factura_id'    => tblFactura::factory()->create()->id,
            'colocacion_id' => $colocacion->id,
            'cantidad'      => 1,
        ];

        $this->postJson('/api/pedidos', $data)->assertStatus(400)
            ->assertJson(['message' => 'No hay suficiente stock para este artículo.']);
    }

    public function testCannotIncreasePedidoIfNoStock(): void {
        $articulo   = tblArticulo::factory()->create(['stock' => 2]);
        $colocacion = tblColocacion::factory()->create(['articulo_id' => $articulo->id]);

        $pedido = tblPedido::factory()->create([
            'colocacion_id' => $colocacion->id,
            'cantidad'      => 2,
        ]);

        $update = [
            'factura_id'    => $pedido->factura_id,
            'colocacion_id' => $colocacion->id,
            'cantidad'      => 5, // trying to increase more than available
        ];

        $this->putJson("/api/pedidos/{$pedido->id}", $update)->assertStatus(400)
            ->assertJson(['message' => 'No hay suficiente stock para aumentar la cantidad.']);
    }

    public function testCannotChangeColocacionIfNewArticuloHasNoStock(): void {
        $articulo1 = tblArticulo::factory()->create(['stock' => 10]);
        $articulo2 = tblArticulo::factory()->create(['stock' => 0]);

        $colocacion1 = tblColocacion::factory()->create(['articulo_id' => $articulo1->id]);
        $colocacion2 = tblColocacion::factory()->create(['articulo_id' => $articulo2->id]);

        $pedido = tblPedido::factory()->create([
            'colocacion_id' => $colocacion1->id,
            'cantidad'      => 1,
        ]);

        $update = [
            'factura_id'    => $pedido->factura_id,
            'colocacion_id' => $colocacion2->id,
            'cantidad'      => 1,
        ];

        $this->putJson("/api/pedidos/{$pedido->id}", $update)->assertStatus(400)
            ->assertJson(['message' => 'No hay suficiente stock en el nuevo artículo.']);
    }
}
