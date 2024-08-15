<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Formula;
use App\Models\Cliente;

class FormulaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Formula::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->word,
            'cliente_id' => Cliente::factory(),
        ];
    }
}
