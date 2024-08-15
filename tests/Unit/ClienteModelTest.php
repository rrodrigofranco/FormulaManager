<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
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

    public function testClienteCreation()
    {
        $cliente = Cliente::create([
            'nome' => 'John Doe',
            'email' => 'john.doe@example.com',
            // Add other attributes if necessary
        ]);

        $this->assertDatabaseHas('clientes', [
            'nome' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);
    }

    public function testClienteValidation()
    {
        $response = $this->postJson('/clientes', [
            'nome' => '', // Invalid input
            'email' => 'not-an-email', // Invalid input
        ]);

        $response->assertStatus(422); // Unprocessable Entity
        $response->assertJsonValidationErrors(['nome', 'email']);
    }

    public function testClienteHasFormulas()
    {
        $cliente = Cliente::factory()->create();
        $formula = Formula::factory()->create(['cliente_id' => $cliente->id]);

        $this->assertTrue($cliente->formulas->contains($formula));
    }
}
