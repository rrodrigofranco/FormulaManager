<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formula;

class FormulaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve all formulas
        return response()->json(Formula::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'ativos' => 'required|array',
            'ativos.*' => 'exists:ativos,id',
        ]);

        // Create a new formula
        $formula = Formula::create([
            'cliente_id' => $validated['cliente_id'],
            'nome' => $validated['nome'],
            'descricao' => $validated['descricao'],
        ]);

        // Associate ativos with the formula
        $formula->ativos()->attach($validated['ativos']);

        // Return the created formula
        return response()->json($formula->load('ativos'), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the formula by ID
        $formula = Formula::with('ativos')->find($id);

        if (!$formula) {
            return response()->json(['message' => 'Formula not found'], 404);
        }

        // Return the formula with associated ativos
        return response()->json($formula, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'cliente_id' => 'sometimes|required|exists:clientes,id',
            'nome' => 'sometimes|required|string|max:255',
            'descricao' => 'nullable|string',
            'ativos' => 'sometimes|required|array',
            'ativos.*' => 'exists:ativos,id',
        ]);

        // Find the formula by ID
        $formula = Formula::find($id);

        if (!$formula) {
            return response()->json(['message' => 'Formula not found'], 404);
        }

        // Update the formula
        $formula->update($validated);

        // If ativos are provided, update the association
        if (isset($validated['ativos'])) {
            $formula->ativos()->sync($validated['ativos']);
        }

        // Return the updated formula with associated ativos
        return response()->json($formula->load('ativos'), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // Find the formula by ID
         $formula = Formula::find($id);

         if (!$formula) {
             return response()->json(['message' => 'Formula not found'], 404);
         }

         // Detach all associated ativos
         $formula->ativos()->detach();

         // Delete the formula
         $formula->delete();

         // Return success response
         return response()->json(['message' => 'Formula deleted successfully'], 200);
    }
}
