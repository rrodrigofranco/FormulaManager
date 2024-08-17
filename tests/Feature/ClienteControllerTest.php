<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Cliente;
use App\Models\User;
/**
 * Testes para o ClienteController.
 *
 * Este conjunto de testes abrange as funcionalidades essenciais do controller responsável pela gestão dos recursos
 * de 'Clientes'. Os testes verificam a criação, leitura, atualização e deleção de registros de clientes, bem como as
 * relações entre 'Clientes' e outras entidades, como 'Formulas'.
 *
 * Comando para executar: php artisan test --filter=ClienteControllerTest
 */
class ClienteControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testar a listagem de todos os clientes.
     *
     * Comando: php artisan test --filter=it_can_list_all_clients
     */
    /** @test */
    public function it_can_list_all_clients()
    {
        //Criando o token
        $user = User::factory()->create();
        $token = $user->createToken('Token Teste')->plainTextToken;

        // Preparar: Criar alguns clientes
        $clients = Cliente::factory()->count(3)->create();

        // Executar: Enviar uma requisição GET para o endpoint da API
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get(route('clientes.index'));

        // Verificar: Checar se a resposta é bem-sucedida e contém os clientes
        $response->assertStatus(200);
        $response->assertJson($clients->toArray());
    }

    /**
     * Testar a listagem de um cliente especifico.
     *
     * Comando: php artisan test --filter=it_can_show_a_specific_client
     */
    /** @test */
    public function it_can_show_a_specific_client()
    {
        //Criando o token
        $user = User::factory()->create();
        $token = $user->createToken('Token Teste')->plainTextToken;

        // Preparar: Criar um cliente
        $client = Cliente::factory()->create();

        // Executar: Enviar uma requisição GET para o endpoint da API
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get(route('clientes.show', $client->id));

        // Verificar: Checar se a resposta é bem-sucedida e contém o cliente
        $response->assertStatus(200);
        $response->assertJson($client->toArray());
    }

    /**
     * Testar a criação de um novo cliente.
     *
     * Comando: php artisan test --filter=it_can_create_a_new_client
     */
    /** @test */
    public function it_can_create_a_new_client()
    {
        //Criando o token
        $user = User::factory()->create();
        $token = $user->createToken('Token Teste')->plainTextToken;

        // Preparar: Preparar os dados para o novo cliente
        $data = [
            'nome' => 'Jane Doe',
            'cpf' => '987.654.321-00',
            'telefone' => '(22) 98765-4321',
            'email' => 'janedoe@example.com'
        ];

        // Executar: Enviar uma requisição POST para o endpoint da API
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post(route('clientes.store'), $data);

        // Verificar: Checar se a resposta é bem-sucedida e se o cliente foi criado
        $response->assertStatus(201);
        $this->assertDatabaseHas('clientes', $data);
    }

    /**
     * Testar a atualização de um cliente.
     *
     * Comando: php artisan test --filter=it_can_update_a_client
     */
    /** @test */
    public function it_can_update_a_client()
    {
        //Criando o token
        $user = User::factory()->create();
        $token = $user->createToken('Token Teste')->plainTextToken;

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
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->put(route('clientes.update', $client->id), $data);

        // Verificar: Checar se a resposta é bem-sucedida e se o cliente foi atualizado
        $response->assertStatus(200);
        $this->assertDatabaseHas('clientes', $data);
    }

    /**
     * Testar a exclusão de um cliente.
     *
     * Comando: php artisan test --filter=it_can_delete_a_client
     */
    /** @test */
    public function it_can_delete_a_client()
    {
        //Criando o token
        $user = User::factory()->create();
        $token = $user->createToken('Token Teste')->plainTextToken;

        // Preparar: Criar um cliente
        $client = Cliente::factory()->create();

        // Executar: Enviar uma requisição DELETE para o endpoint da API
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->delete(route('clientes.destroy', $client->id));

        // Verificar: Checar se a resposta é bem-sucedida e se o cliente foi deletado
        $response->assertStatus(200);
        $this->assertDatabaseMissing('clientes', ['id' => $client->id]);
    }
}
