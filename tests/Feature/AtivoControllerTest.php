<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Ativo;
use App\Models\User;

/**
 * Testes para o AtivoController.
 *
 * Este conjunto de testes verifica as funcionalidades principais do controller responsável por gerenciar os recursos
 * de 'Ativos', incluindo a criação, leitura, atualização e deleção de registros de ativos, assim como as relações entre
 * 'Ativos' e outras entidades, como 'Formulas'.
 *
 * Comando para executar: php artisan test --filter=AtivoControllerTest
 */
class AtivoControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testar a listagem de todos os ativos.
     *
     * Comando: php artisan test --filter=it_can_list_all_ativos
     */
    /** @test */
    public function it_can_list_all_ativos()
    {
        //Criando o token
        $user = User::factory()->create();
        $token = $user->createToken('Token Teste')->plainTextToken;

        // Preparar: Criar alguns ativos
        Ativo::factory()->count(3)->create();


        // Executar: Enviar uma requisição GET para o endpoint da API
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson(route('ativos.index'));

        // Verificar: Checar se a resposta é bem-sucedida e se contém o número correto de ativos
        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    /**
     * Testar a criação de um novo ativo.
     *
     * Comando: php artisan test --filter=it_can_create_an_ativo
     */
    /** @test php artisan test --filter=it_can_create_an_ativo */
    public function it_can_create_an_ativo()
    {
        //Criando o token
        $user = User::factory()->create();
        $token = $user->createToken('Token Teste')->plainTextToken;

        // Preparar: Definir os dados para um novo ativo
        $data = [
            'nome' => 'Vitamina C',
            'descricao' => 'Antioxidante',
        ];

        // Executar: Enviar uma requisição POST para o endpoint da API
       $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson(route('ativos.store'), $data);

        // Verificar: Checar se a resposta é bem-sucedida e se o ativo foi criado
        $response->assertStatus(201);
        $this->assertDatabaseHas('ativos', $data);
    }

    /**
     * Testar a visualização de um ativo.
     *
     * Comando: php artisan test --filter=it_can_show_an_ativo
     */
    /** @test */
    public function it_can_show_an_ativo()
    {
        //Criando o token
        $user = User::factory()->create();
        $token = $user->createToken('Token Teste')->plainTextToken;

        // Preparar: Criar um ativo
        $ativo = Ativo::factory()->create();

        // Executar: Enviar uma requisição GET para o endpoint da API
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson(route('ativos.show', $ativo->id));

        // Verificar: Checar se a resposta é bem-sucedida e se contém o ativo
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $ativo->id,
            'nome' => $ativo->nome,
            'descricao' => $ativo->descricao,
        ]);
    }

    /**
     * Testar a atualização de um ativo.
     *
     * Comando: php artisan test --filter=it_can_update_an_ativo
     */
    /** @test */
    public function it_can_update_an_ativo()
    {
        //Criando o token
        $user = User::factory()->create();
        $token = $user->createToken('Token Teste')->plainTextToken;

        // Preparar: Criar um ativo
        $ativo = Ativo::factory()->create();

        // Preparar dados atualizados
        $updatedData = [
            'nome' => 'Vitamina C Alterada',
            'descricao' => 'Antioxidante Alterado',
        ];

        // Executar: Enviar uma requisição PUT para o endpoint da API
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->putJson(route('ativos.update', $ativo->id), $updatedData);

        // Verificar: Checar se a resposta é bem-sucedida e se o ativo foi atualizado
        $response->assertStatus(200);
        $this->assertDatabaseHas('ativos', $updatedData);
    }

    /**
     * Testar a exclusão de um ativo.
     *
     * Comando: php artisan test --filter=it_can_delete_an_ativo
     */
    /** @test */
    public function it_can_delete_an_ativo()
    {
        //Criando o token
        $user = User::factory()->create();
        $token = $user->createToken('Token Teste')->plainTextToken;

        // Preparar: Criar um ativo
        $ativo = Ativo::factory()->create();

        // Executar: Enviar uma requisição DELETE para o endpoint da API
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->deleteJson(route('ativos.destroy', $ativo->id));

        // Verificar: Checar se a resposta é bem-sucedida e se o ativo foi deletado
        $response->assertStatus(200);
        $this->assertDatabaseMissing('ativos', ['id' => $ativo->id]);
    }
}
