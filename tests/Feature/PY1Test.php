<?php

namespace Tests\Feature;

use App\Models\tblPY1;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PY1Test extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = tblPY1::factory()->create(['rol' => 'admin']);
        $this->user = tblPY1::factory()->create(['rol' => 'user']);
    }

    public function testAdminCanListUsers(): void
    {
        tblPY1::factory()->count(5)->create();

        Sanctum::actingAs($this->admin);

        $response = $this->getJson('/api/usuarios');

        $response->assertStatus(200)->assertJsonStructure(['data', 'total', 'per_page', 'current_page', 'last_page']);
    }

    public function testAdminCanCreateUser(): void
    {
        Sanctum::actingAs($this->admin);

        $data = tblPY1::factory()->make()->toArray();
        $data['password'] = 'SecurePass123';

        $response = $this->postJson('/api/usuarios', $data);

        $response->assertStatus(201)->assertJsonFragment(['email' => $data['email']]);
    }

    public function testUserCannotCreateUser(): void
    {
        Sanctum::actingAs($this->user);

        $data = tblPY1::factory()->make()->toArray();
        $data['password'] = 'AnotherPass123';

        $response = $this->postJson('/api/usuarios', $data);

        $response->assertStatus(403);
    }

    public function testAdminCanDeleteUser(): void
    {
        Sanctum::actingAs($this->admin);

        $target = tblPY1::factory()->create();

        $response = $this->deleteJson("/api/usuarios/{$target->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tbl_p_y1', ['id' => $target->id]);
    }

    public function testUserCannotDeleteUser(): void
    {
        Sanctum::actingAs($this->user);

        $target = tblPY1::factory()->create();

        $response = $this->deleteJson("/api/usuarios/{$target->id}");

        $response->assertStatus(403);
    }
}
