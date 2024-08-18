<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * Testes para o AuthController.
 *
 * Este conjunto de testes verifica as funcionalidades principais do controller responsável por gerenciar os recursos
 * de 'Auth', incluindo o registro e autenticação de usuários.
 *
 * Comando para executar: php artisan test --filter=AuthControllerTest
 */

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa o registro de um novo usuário com dados válidos.
     *
     * Comando: php artisan test --filter=it_can_register_user_with_valid_data
     */
     /** @test */
    public function it_can_register_user_with_valid_data()
    {
        // Dados válidos para registro
        $data = [
            'name' => 'Rodrigo Ribeiro',
            'email' => 'rodrigo@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        // Executar a requisição POST para registrar o usuário
        $response = $this->postJson('/api/v1/auth', $data);

        // Verificar se o status da resposta é 201 (Criado)
        $response->assertStatus(201);

        // Verificar se a resposta contém o usuário e o token
        $response->assertJsonStructure([
            'user' => [
                'id',
                'name',
                'email',
                'created_at',
                'updated_at',
            ],
            'token'
        ]);

        // Verificar se o usuário foi realmente criado no banco de dados
        $this->assertDatabaseHas('users', [
            'name' => 'Rodrigo Ribeiro',
            'email' => 'rodrigo@example.com',
        ]);
    }

    /**
     * Testa o registro de um novo usuário com dados inválidos.
     *
     * Comando: php artisan test --filter=it_can_register_user_with_invalid_data
     */
     /** @test */
    public function it_can_register_user_with_invalid_data()
    {
        // Dados inválidos para registro
        $data = [
            'name' => 'Rodrigo Ribeiro',
            'email' => 'rodrigo@example.com',
            'password' => 'short',
            'password_confirmation' => 'password123',
        ];

        // Executar a requisição POST para registrar o usuário
        $response = $this->postJson('/api/v1/auth', $data);

        // Verificar se o status da resposta é 422 (Erro de validação)
        $response->assertStatus(422);
    }
}
