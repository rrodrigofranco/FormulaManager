<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Formula;
use App\Models\Ativo;
use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormulaModelTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    use RefreshDatabase;

    /**
     * Test formula creation.
     *
     * @return void
     */
    public function testFormulaCreation()
    {
        $formula = Formula::factory()->create([
            'nome' => 'Sample Formula',
            'descricao' => 'This is a sample formula.',
            'cliente_id' => Cliente::factory()->create()->id,
        ]);

        $this->assertDatabaseHas('formulas', [
            'nome' => 'Sample Formula',
            'descricao' => 'This is a sample formula.',
        ]);
    }

    /**
     * Test the relationship between Formula and Cliente.
     *
     * @return void
     */
    public function testFormulaBelongsToCliente()
    {
        $cliente = Cliente::factory()->create();
        $formula = Formula::factory()->create(['cliente_id' => $cliente->id]);

        $this->assertTrue($formula->cliente->is($cliente));
    }

    /**
     * Test the relationship between Formula and Ativo.
     *
     * @return void
     */
    public function testFormulaBelongsToManyAtivos()
    {
        $formula = Formula::factory()->create();

        $ativo1 = Ativo::factory()->create();
        $ativo2 = Ativo::factory()->create();

        $formula->ativos()->attach([$ativo1->id, $ativo2->id]);

        $this->assertCount(2, $formula->ativos);
        $this->assertTrue($formula->ativos->contains($ativo1));
        $this->assertTrue($formula->ativos->contains($ativo2));
    }
}
