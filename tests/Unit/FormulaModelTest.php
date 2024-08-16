<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Formula;
use App\Models\Ativo;
use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Testes para o modelo Formula.
 *
 * Este conjunto de testes avalia as funcionalidades e comportamentos do modelo 'Formula', incluindo a criação de
 * registros e a verificação das relações entre 'Formulas' e outras entidades, como 'Clientes' e 'Ativos'. Os testes
 * garantem que o modelo esteja corretamente configurado e que as relações e comportamentos esperados sejam mantidos.
 *
 * Comando para executar: php artisan test --filter=FormulaModelTest
 */

class FormulaModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testar a criação de uma nova fórmula.
     *
     * Comando: php artisan test --filter=testFormulaCreation
     */
    public function testFormulaCreation()
    {
        // Preparar: Criar uma nova fórmula com dados específicos e associá-la a um cliente
        $formula = Formula::factory()->create([
            'nome' => 'Sample Formula',
            'descricao' => 'This is a sample formula.',
            'cliente_id' => Cliente::factory()->create()->id,
        ]);

        // Verificar: Checar se a fórmula foi corretamente inserida no banco de dados
        $this->assertDatabaseHas('formulas', [
            'nome' => 'Sample Formula',
            'descricao' => 'This is a sample formula.',
        ]);
    }

    /**
     * Testar o relacionamento entre Formula e Cliente.
     *
     * Comando: php artisan test --filter=testFormulaBelongsToCliente
     */
    public function testFormulaBelongsToCliente()
    {
        // Preparar: Criar um cliente e uma fórmula associada a este cliente
        $cliente = Cliente::factory()->create();
        $formula = Formula::factory()->create(['cliente_id' => $cliente->id]);

        // Verificar: Checar se a fórmula pertence ao cliente criado
        $this->assertTrue($formula->cliente->is($cliente));
    }

    /**
     * Testar o relacionamento entre Formula e Ativo.
     *
     * Comando: php artisan test --filter=testFormulaBelongsToManyAtivos
     */
    public function testFormulaBelongsToManyAtivos()
    {
        // Preparar: Criar uma fórmula e dois ativos
        $formula = Formula::factory()->create();

        $ativo1 = Ativo::factory()->create();
        $ativo2 = Ativo::factory()->create();

        // Associar os ativos à fórmula
        $formula->ativos()->attach([$ativo1->id, $ativo2->id]);

        // Verificar: Checar se a fórmula tem exatamente dois ativos associados
        $this->assertCount(2, $formula->ativos);
        // Verificar: Checar se os ativos criados estão associados à fórmula
        $this->assertTrue($formula->ativos->contains($ativo1));
        $this->assertTrue($formula->ativos->contains($ativo2));
    }

}
