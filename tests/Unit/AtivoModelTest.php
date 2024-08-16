<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Ativo;
class AtivoModelTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function testAtivoCreation()
    {
        $ativo = Ativo::create([
            'nome' => 'Vitamina C',
            'descricao' => 'Antioxidante',
        ]);

        $this->assertDatabaseHas('ativos', [
            'nome' => 'Vitamina C',
            'descricao' => 'Antioxidante',
        ]);
    }

    public function testAtivoRelationshipWithFormulas()
    {
        $ativo = Ativo::factory()->create();
        $formula = \App\Models\Formula::factory()->create();
        $formula->ativos()->attach($ativo);

        $this->assertTrue($formula->ativos->contains($ativo));
    }
}
