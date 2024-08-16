<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cliente;
use App\Models\Formula;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClienteModelTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_cliente()
    {
        $cliente = Cliente::create([
            'nome' => 'John Doe',
            'cpf' => '123.456.789-10',
            'telefone' => '1234567890',
            'email' => 'johndoe@example.com',
            'endereco' => '123 Main St'
        ]);

        $this->assertDatabaseHas('clientes', [
            'nome' => 'John Doe',
            'cpf' => '123.456.789-10',
            'telefone' => '1234567890',
            'email' => 'johndoe@example.com',
            'endereco' => '123 Main St'
        ]);

        $this->assertInstanceOf(Cliente::class, $cliente);
    }

    /** @test */
    public function a_cliente_can_have_multiple_formulas()
    {
        $cliente = Cliente::factory()->create();

        $formula1 = Formula::factory()->create(['cliente_id' => $cliente->id]);
        $formula2 = Formula::factory()->create(['cliente_id' => $cliente->id]);

        $this->assertCount(2, $cliente->formulas);
        $this->assertTrue($cliente->formulas->contains($formula1));
        $this->assertTrue($cliente->formulas->contains($formula2));
    }

}
