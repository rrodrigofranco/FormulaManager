<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Formula;
use App\Models\Ativo;
use App\Models\Cliente;

class FormulaControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    /** @test php artisan test --filter=it_can_list_all_formulas */
    public function it_can_list_all_formulas()
    {
        Formula::factory()->count(5)->create();

        $response = $this->getJson(route('formulas.index'));

        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }

    /** @test php artisan test --filter=it_can_create_a_formula */
    public function it_can_create_a_formula()
    {
        $cliente = Cliente::factory()->create();
        $ativos = Ativo::factory()->count(3)->create();

        $data = [
            'cliente_id' => $cliente->id,
            'nome' => 'Formula X',
            'ativos' => $ativos->pluck('id')->toArray(),
        ];

        $response = $this->postJson(route('formulas.store'), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('formulas', ['nome' => 'Formula X']);
        $this->assertDatabaseHas('ativo_formula', ['formula_id' => 1, 'ativo_id' => $ativos[0]->id]);
    }

    /** @test php artisan test --filter=it_can_show_a_formula */
    public function it_can_show_a_formula()
    {
        $formula = Formula::factory()->create();

        $response = $this->getJson(route('formulas.show', $formula->id));

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $formula->id,
            'nome' => $formula->nome,
        ]);
    }

    /** @test php artisan test --filter=it_can_update_a_formula */
    public function it_can_update_a_formula()
    {
        $formula = Formula::factory()->create();
        $newName = 'Updated Formula Name';

        $response = $this->putJson(route('formulas.update', $formula->id), [
            'nome' => $newName,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('formulas', ['id' => $formula->id, 'nome' => $newName]);
    }

    /** @test php artisan test --filter=it_can_delete_a_formula */
    public function it_can_delete_a_formula()
    {
        $formula = Formula::factory()->create();

        $response = $this->deleteJson(route('formulas.destroy', $formula->id));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('formulas', ['id' => $formula->id]);
    }
}
