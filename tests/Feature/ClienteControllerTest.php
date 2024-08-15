<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Cliente;

class ClienteControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test php artisan test --filter=it_can_list_all_clients */
    public function it_can_list_all_clients()
    {
        // Arrange: Create some clients
        $clients = Cliente::factory()->count(3)->create();

        // Act: Send a GET request to the API endpoint
        $response = $this->get('/api/clientes');

        // Assert: Check if the response is successful and contains the clients
        $response->assertStatus(200);
        $response->assertJson($clients->toArray());
    }

    /** @test php artisan test --filter=it_can_show_a_specific_client */
    public function it_can_show_a_specific_client()
    {
        // Arrange: Create a client
        $client = Cliente::factory()->create();

        // Act: Send a GET request to the API endpoint
        $response = $this->get("/api/clientes/{$client->id}");

        // Assert: Check if the response is successful and contains the client
        $response->assertStatus(200);
        $response->assertJson($client->toArray());
    }

    /** @test php artisan test --filter=it_can_create_a_new_client */
    public function it_can_create_a_new_client()
    {
        // Arrange: Prepare the data for the new client
        $data = [
            'nome' => 'Jane Doe',
            'cpf' => '987.654.321-00',
            'telefone' => '(22) 98765-4321',
            'email' => 'janedoe@example.com'
        ];

        // Act: Send a POST request to the API endpoint
        $response = $this->post('/api/clientes', $data);

        // Assert: Check if the response is successful and the client was created
        $response->assertStatus(201);
        $this->assertDatabaseHas('clientes', $data);
    }

    /** @test  php artisan test --filter=it_can_update_a_client */
    public function it_can_update_a_client()
    {
        // Arrange: Create a client
        $client = Cliente::factory()->create();

        // Prepare updated data
        $data = [
            'nome' => 'Jane Doe Updated',
            'cpf' => '987.654.321-00',
            'telefone' => '(22) 98765-4321',
            'email' => 'janeupdated@example.com'
        ];

        // Act: Send a PUT request to the API endpoint
        $response = $this->put("/api/clientes/{$client->id}", $data);

        // Assert: Check if the response is successful and the client was updated
        $response->assertStatus(200);
        $this->assertDatabaseHas('clientes', $data);
    }

    /** @test php artisan test --filter=it_can_delete_a_client */
    public function it_can_delete_a_client()
    {
        // Arrange: Create a client
        $client = Cliente::factory()->create();

        // Act: Send a DELETE request to the API endpoint
        $response = $this->delete("/api/clientes/{$client->id}");

        // Assert: Check if the response is successful and the client was deleted
        $response->assertStatus(200);
        $this->assertDatabaseMissing('clientes', ['id' => $client->id]);
    }
}
