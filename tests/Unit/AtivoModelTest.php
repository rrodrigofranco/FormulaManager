<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Ativo;

/**
 * Testes para o modelo Ativo.
 *
 * Este conjunto de testes verifica as funcionalidades e comportamentos do modelo 'Ativo', incluindo a criação de
 * registros e as relações entre 'Ativos' e outras entidades, como 'Formulas'. Os testes garantem que o modelo
 * esteja corretamente configurado e que os relacionamentos sejam mantidos conforme o esperado.
 *
 * Comando para executar: php artisan test --filter=AtivoModelTest
 */

class AtivoModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testar a criação de um novo ativo.
     *
     * @return void
     */
    /** @test */
    public function testAtivoCreation()
    {
        // Preparar: Criar um novo ativo com nome e descrição específicos
        $ativo = Ativo::create([
            'nome' => 'Vitamina C',
            'descricao' => 'Antioxidante',
        ]);

        // Verificar: Checar se o ativo foi corretamente inserido no banco de dados
        $this->assertDatabaseHas('ativos', [
            'nome' => 'Vitamina C',
            'descricao' => 'Antioxidante',
        ]);
    }
    /**
     * Testar o relacionamento entre Ativo e Formula.
     *
     * Comando: php artisan test --filter=testAtivoRelationshipWithFormulas
     */
    /** @test */
    public function testAtivoRelationshipWithFormulas()
    {
        // Preparar: Criar um ativo e uma fórmula, e associar o ativo à fórmula
        $ativo = Ativo::factory()->create();
        $formula = \App\Models\Formula::factory()->create();
        $formula->ativos()->attach($ativo);

        // Verificar: Checar se a relação entre a fórmula e o ativo foi corretamente estabelecida
        $this->assertTrue($formula->ativos->contains($ativo));
    }
}
