<?php

namespace Tests\Feature;

use App\Models\tblArticulo;
use App\Models\tblPY1;
use App\Support\Constants;
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
        $this->user = tblPY1::factory()->create(['rol' => Constants::ROL_ADMIN]);
        Sanctum::actingAs($this->user);
    }

    public function testCreatesArticuloSuccessfully(): void
    {
        $data = [
            'codigo_barras' => '1234567890123',
            'descripcion' => 'iPhone 16',
            'fabricante' => 'Apple',
            'precio' => 1200,
            'stock' => 1000
        ];

        $response = $this->postJson('/api/articulos', $data);
        $response->assertStatus(201)->assertJsonFragment(['descripcion' => 'iPhone 16']);
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

    public function testCannotCreateDuplicateCodigoBarras(): void
    {
        $codigo = '5449000000996';

        tblArticulo::factory()->create(['codigo_barras' => $codigo]);

        $data = tblArticulo::factory()->make([
            'codigo_barras' => $codigo,
        ])->toArray();

        $this->postJson('/api/articulos', $data)->assertStatus(422)->assertJsonValidationErrors(['codigo_barras']);
    }

    public function testCannotCreateArticuloWithNegativeValues(): void
    {
        $data = tblArticulo::factory()->make([
            'precio' => -50,
            'stock' => -10,
        ])->toArray();

        $this->postJson('/api/articulos', $data)->assertStatus(422)->assertJsonValidationErrors(['precio', 'stock']);
    }

    public function testCannotUpdateArticuloWithInvalidData(): void
    {
        $articulo = tblArticulo::factory()->create();

        $data = [
            'precio' => 'invalid',
            'stock' => null,
        ];

        $this->putJson("/api/articulos/{$articulo->id}", $data)->assertStatus(422)->assertJsonValidationErrors(['precio', 'stock']);
    }
}