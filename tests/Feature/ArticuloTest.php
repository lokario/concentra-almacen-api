<?php

namespace Tests\Feature;

use App\Models\tblArticulo;
use App\Models\tblPY1;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ArticuloTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = tblPY1::factory()->create(['rol' => 'admin']);
        Sanctum::actingAs($this->user);
    }

    public function testCreatesArticuloSuccessfully(): void
    {
        $data = [
            'codigo_barras' => '1234567890123',
            'descripcion' => 'Artículo de prueba',
            'fabricante' => 'ConcentraTech'
        ];

        $response = $this->postJson('/api/articulos', $data);
        $response->assertStatus(201)->assertJsonFragment(['descripcion' => 'Artículo de prueba']);
    }

    public function testFailsToCreateArticuloWithInvalidData(): void
    {
        $response = $this->postJson('/api/articulos', []);
        $response->assertStatus(422)->assertJsonValidationErrors(['codigo_barras', 'descripcion', 'fabricante']);
    }

    public function testUpdatesArticuloSuccessfully(): void
    {
        $articulo = tblArticulo::factory()->create();

        $response = $this->putJson("/api/articulos/{$articulo->id}", [
            'descripcion' => 'Actualizado'
        ]);

        $response->assertStatus(200)->assertJsonFragment(['descripcion' => 'Actualizado']);
    }

    public function testDeletesArticuloSuccessfully(): void
    {
        $articulo = tblArticulo::factory()->create();

        $response = $this->deleteJson("/api/articulos/{$articulo->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('tbl_articulo', ['id' => $articulo->id]);
    }

    public function testListsArticulosWithPagination(): void
    {
        tblArticulo::factory()->count(5)->create();

        $response = $this->getJson('/api/articulos');
        $response->assertStatus(200)->assertJsonStructure(['data', 'total', 'per_page', 'current_page', 'last_page']);
    }

    public function testFiltersArticulosByFabricante(): void
    {
        tblArticulo::factory()->create(['fabricante' => 'FiltroMatch']);
        tblArticulo::factory()->create(['fabricante' => 'OtroFabricante']);

        $response = $this->getJson('/api/articulos?fabricante=FiltroMatch');
        $response->assertStatus(200)
            ->assertJsonFragment(['fabricante' => 'FiltroMatch'])
            ->assertJsonMissing(['fabricante' => 'OtroFabricante']);
    }
}