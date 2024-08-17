<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Formula;
use App\Models\Ativo;
use App\Models\Cliente;
use App\Models\User;

/**
 * Testes para o FormulaController.
 *
 * Este conjunto de testes abrange as funcionalidades essenciais do controller responsável pela gestão dos recursos
 * de 'Formulas'. Os testes verificam a criação, leitura, atualização e deleção de registros de fórmulas, bem como as
 * relações entre 'Formulas' e outras entidades, como 'Clientes' e 'Ativos'.
 *
 * Comando para executar: php artisan test --filter=FormulaControllerTest
 */

class FormulaControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testar a listagem de fórmulas.
     *
     * Comando: php artisan test --filter=it_can_list_all_formulas
     */
     /** @test */
     public function it_can_list_all_formulas()
     {
        //Criando o token
        $user = User::factory()->create();
        $token = $user->createToken('Token Teste')->plainTextToken;

         // Preparar: Criar 5 fórmulas
         Formula::factory()->count(5)->create();

         // Executar: Enviar uma requisição GET para o endpoint da API de listagem de fórmulas
         $response = $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson(route('formulas.index'));

         // Verificar: Checar se a resposta é bem-sucedida e se contém as 5 fórmulas
         $response->assertStatus(200);
         $response->assertJsonCount(5);
     }

     /**
     * Testar a criação de uma nova fórmula.
     *
     * Comando: php artisan test --filter=it_can_create_a_formula
     */
     /** @test */
     public function it_can_create_a_formula()
     {
        //Criando o token
        $user = User::factory()->create();
        $token = $user->createToken('Token Teste')->plainTextToken;

         // Preparar: Criar um cliente e 3 ativos
         $cliente = Cliente::factory()->create();
         $ativos = Ativo::factory()->count(3)->create();

         // Preparar: Dados para criar uma nova fórmula associada ao cliente e aos ativos
         $data = [
             'cliente_id' => $cliente->id,
             'nome' => 'Formula X',
             'descricao' => 'Teste Formula',
             'ativos' => $ativos->pluck('id')->toArray(),
         ];

         // Executar: Enviar uma requisição POST para o endpoint da API de criação de fórmulas
         $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson(route('formulas.store'), $data);

         $formula_id = $response->json('id');

         // Verificar: Checar se a resposta é bem-sucedida e se a fórmula foi criada com os dados corretos
         $response->assertStatus(201);
         $this->assertDatabaseHas('formulas', ['nome' => 'Formula X']);
         $this->assertDatabaseHas('formula_ativo', ['formula_id' => $formula_id, 'ativo_id' => $ativos[0]->id]);
     }

     /**
     * Testar a visualização de uma fórmula.
     *
     * Comando: php artisan test --filter=it_can_show_a_formula
     */
     /** @test php artisan test --filter=it_can_show_a_formula */
     public function it_can_show_a_formula()
     {
        //Criando o token
        $user = User::factory()->create();
        $token = $user->createToken('Token Teste')->plainTextToken;

         // Preparar: Criar uma fórmula
         $formula = Formula::factory()->create();

         // Executar: Enviar uma requisição GET para o endpoint da API de exibição de fórmula
         $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson(route('formulas.show', $formula->id));

         // Verificar: Checar se a resposta é bem-sucedida e se contém os dados da fórmula criada
         $response->assertStatus(200);
         $response->assertJson([
             'id' => $formula->id,
             'nome' => $formula->nome,
         ]);
     }

     /**
     * Testar a atualização de uma fórmula.
     *
     * Comando: php artisan test --filter=it_can_update_a_formula
     */
     /** @test */
     public function it_can_update_a_formula()
     {
        //Criando o token
        $user = User::factory()->create();
        $token = $user->createToken('Token Teste')->plainTextToken;

         // Preparar: Criar uma fórmula existente
         $formula = Formula::factory()->create();
         $newName = 'Updated Formula Name';

         // Executar: Enviar uma requisição PUT para o endpoint da API de atualização de fórmula
         $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->putJson(route('formulas.update', $formula->id), [
             'nome' => $newName,
         ]);

         // Verificar: Checar se a resposta é bem-sucedida e se a fórmula foi atualizada com o novo nome
         $response->assertStatus(200);
         $this->assertDatabaseHas('formulas', ['id' => $formula->id, 'nome' => $newName]);
     }

     /**
     * Testar a exclusão de uma fórmula.
     *
     * Comando: php artisan test --filter=it_can_delete_a_formula
     */
     /** @test */
     public function it_can_delete_a_formula()
     {
        //Criando o token
        $user = User::factory()->create();
        $token = $user->createToken('Token Teste')->plainTextToken;

         // Preparar: Criar uma fórmula existente
         $formula = Formula::factory()->create();

         // Executar: Enviar uma requisição DELETE para o endpoint da API de exclusão de fórmula
         $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->deleteJson(route('formulas.destroy', $formula->id));

         // Verificar: Checar se a resposta é bem-sucedida e se a fórmula foi deletada do banco de dados
         $response->assertStatus(200);
         $this->assertDatabaseMissing('formulas', ['id' => $formula->id]);
     }
}
