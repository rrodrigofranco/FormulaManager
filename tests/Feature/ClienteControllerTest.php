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
        // Preparar: Criar alguns clientes
        $clients = Cliente::factory()->count(3)->create();

        // Executar: Enviar uma requisição GET para o endpoint da API
        $response = $this->get('/api/clientes');

        // Verificar: Checar se a resposta é bem-sucedida e contém os clientes
        $response->assertStatus(200);
        $response->assertJson($clients->toArray());
    }

    /** @test php artisan test --filter=it_can_show_a_specific_client */
    public function it_can_show_a_specific_client()
    {
        // Preparar: Criar um cliente
        $client = Cliente::factory()->create();

        // Executar: Enviar uma requisição GET para o endpoint da API
        $response = $this->get("/api/clientes/{$client->id}");

        // Verificar: Checar se a resposta é bem-sucedida e contém o cliente
        $response->assertStatus(200);
        $response->assertJson($client->toArray());
    }

    /** @test php artisan test --filter=it_can_create_a_new_client */
    public function it_can_create_a_new_client()
    {
        // Preparar: Preparar os dados para o novo cliente
        $data = [
            'nome' => 'Jane Doe',
            'cpf' => '987.654.321-00',
            'telefone' => '(22) 98765-4321',
            'email' => 'janedoe@example.com'
        ];

        // Executar: Enviar uma requisição POST para o endpoint da API
        $response = $this->post('/api/clientes', $data);

        // Verificar: Checar se a resposta é bem-sucedida e se o cliente foi criado
        $response->assertStatus(201);
        $this->assertDatabaseHas('clientes', $data);
    }

    /** @test  php artisan test --filter=it_can_update_a_client */
    public function it_can_update_a_client()
    {
        // Preparar: Criar um cliente
        $client = Cliente::factory()->create();

        // Preparar dados atualizados
        $data = [
            'nome' => 'Jane Doe Updated',
            'cpf' => '987.654.321-00',
            'telefone' => '(22) 98765-4321',
            'email' => 'janeupdated@example.com'
        ];

        // Executar: Enviar uma requisição PUT para o endpoint da API
        $response = $this->put("/api/clientes/{$client->id}", $data);

        // Verificar: Checar se a resposta é bem-sucedida e se o cliente foi atualizado
        $response->assertStatus(200);
        $this->assertDatabaseHas('clientes', $data);
    }

    /** @test php artisan test --filter=it_can_delete_a_client */
    public function it_can_delete_a_client()
    {
        // Preparar: Criar um cliente
        $client = Cliente::factory()->create();

        // Executar: Enviar uma requisição DELETE para o endpoint da API
        $response = $this->delete("/api/clientes/{$client->id}");

        // Verificar: Checar se a resposta é bem-sucedida e se o cliente foi deletado
        $response->assertStatus(200);
        $this->assertDatabaseMissing('clientes', ['id' => $client->id]);
    }
}
