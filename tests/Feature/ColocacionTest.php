<?php

namespace Tests\Feature;

use App\Models\tblColocacion;
use App\Models\tblPY1;
use App\Models\tblArticulo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ColocacionTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = tblPY1::factory()->create(['rol' => 'admin']);
        Sanctum::actingAs($this->user);
    }

    public function testCreatesColocacionSuccessfully(): void
    {
        $data = [
            'articulo_id' => tblArticulo::factory()->create()->id,
            'lugar' => 'Estante A',
        ];

        $response = $this->postJson('/api/colocaciones', $data);

        $response->assertStatus(201)->assertJsonFragment(['lugar' => 'Estante A']);
    }

    public function testFailsToCreateColocacionWithInvalidData(): void
    {
        $response = $this->postJson('/api/colocaciones', []);

        $response->assertStatus(422)->assertJsonValidationErrors(['articulo_id', 'lugar']);
    }

    public function testUpdatesColocacionSuccessfully(): void
    {
        $colocacion = tblColocacion::factory()->create();

        $response = $this->putJson("/api/colocaciones/{$colocacion->id}", [
            'lugar' => 'Estante X'
        ]);

        $response->assertStatus(200)->assertJsonFragment(['lugar' => 'Estante X']);
    }

    public function testDeletesColocacionSuccessfully(): void
    {
        $colocacion = tblColocacion::factory()->create();

        $response = $this->deleteJson("/api/colocaciones/{$colocacion->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tbl_colocacion', ['id' => $colocacion->id]);
    }

    public function testListsColocacionesWithPagination(): void
    {
        tblColocacion::factory()->count(10)->create();

        $response = $this->getJson('/api/colocaciones');

        $response->assertStatus(200)->assertJsonStructure(['data', 'total', 'per_page', 'current_page', 'last_page']);
    }
}