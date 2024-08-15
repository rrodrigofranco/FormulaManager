<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Ativo;

class AtivoControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    /** @test php artisan test --filter=it_can_list_all_ativos */
    public function it_can_list_all_ativos()
    {
        // Arrange
        Ativo::factory()->count(3)->create();

        // Act
        $response = $this->getJson('/api/ativos');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    /** @test php artisan test --filter=it_can_create_an_ativo */
    public function it_can_create_an_ativo()
    {
        // Arrange
        $data = [
            'nome' => 'Vitamina C',
            'descricao' => 'Antioxidante',
        ];

        // Act
        $response = $this->postJson('/api/ativos', $data);

        // Assert
        $response->assertStatus(201);
        $this->assertDatabaseHas('ativos', $data);
    }

    /** @test php artisan test --filter=it_can_show_an_ativo */
    public function it_can_show_an_ativo()
    {
        // Arrange
        $ativo = Ativo::factory()->create();

        // Act
        $response = $this->getJson("/api/ativos/{$ativo->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $ativo->id,
            'nome' => $ativo->nome,
            'descricao' => $ativo->descricao,
        ]);
    }

    /** @test php artisan test --filter=it_can_update_an_ativo */
    public function it_can_update_an_ativo()
    {
        // Arrange
        $ativo = Ativo::factory()->create();

        $updatedData = [
            'nome' => 'Vitamina C Alterada',
            'descricao' => 'Antioxidante Alterado',
        ];

        // Act
        $response = $this->putJson("/api/ativos/{$ativo->id}", $updatedData);

        // Assert
        $response->assertStatus(200);
        $this->assertDatabaseHas('ativos', $updatedData);
    }

    /** @test php artisan test --filter=it_can_delete_an_ativo */
    public function it_can_delete_an_ativo()
    {
        // Arrange
        $ativo = Ativo::factory()->create();

        // Act
        $response = $this->deleteJson("/api/ativos/{$ativo->id}");

        // Assert
        $response->assertStatus(200);
        $this->assertDatabaseMissing('ativos', ['id' => $ativo->id]);
    }
}
