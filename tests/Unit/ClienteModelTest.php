<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cliente;
use App\Models\Formula;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Testes para o modelo Cliente.
 *
 * Este conjunto de testes avalia as funcionalidades e comportamentos do modelo 'Cliente', incluindo a criação de
 * registros e a verificação das relações entre 'Clientes' e outras entidades, como 'Formulas'. Os testes garantem
 * que o modelo esteja corretamente configurado e que as relações sejam gerenciadas conforme o esperado.
 *
 * Comando para executar: php artisan test --filter=ClienteModelTest
 */

class ClienteModelTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Testar a criação de um novo cliente.
     *
     * Comando: php artisan test --filter=it_can_create_a_cliente
     */
    /** @test */
    public function it_can_create_a_cliente()
    {
        // Preparar: Criar um novo cliente com dados específicos
        $cliente = Cliente::create([
            'nome' => 'John Doe',
            'cpf' => '123.456.789-10',
            'telefone' => '1234567890',
            'email' => 'johndoe@example.com',
            'endereco' => '123 Main St'
        ]);

        // Verificar: Checar se o cliente foi corretamente inserido no banco de dados
        $this->assertDatabaseHas('clientes', [
            'nome' => 'John Doe',
            'cpf' => '123.456.789-10',
            'telefone' => '1234567890',
            'email' => 'johndoe@example.com',
            'endereco' => '123 Main St'
        ]);

        // Verificar: Checar se a instância criada é da classe Cliente
        $this->assertInstanceOf(Cliente::class, $cliente);
    }

    /**
     * Testar o relacionamento entre Cliente e Formula.
     *
     * Comando: php artisan test --filter=testFormulaBelongsToCliente
     */
    /** @test */
    public function a_cliente_can_have_multiple_formulas()
    {
        // Preparar: Criar um cliente e duas fórmulas associadas a este cliente
        $cliente = Cliente::factory()->create();

        $formula1 = Formula::factory()->create(['cliente_id' => $cliente->id]);
        $formula2 = Formula::factory()->create(['cliente_id' => $cliente->id]);

        // Verificar: Checar se o cliente tem exatamente duas fórmulas associadas
        $this->assertCount(2, $cliente->formulas);
        // Verificar: Checar se as fórmulas criadas estão associadas ao cliente
        $this->assertTrue($cliente->formulas->contains($formula1));
        $this->assertTrue($cliente->formulas->contains($formula2));
    }


}
