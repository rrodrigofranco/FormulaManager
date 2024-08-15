<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ativo;

class AtivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Ativo::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        // Create a new ativo
        $ativo = Ativo::create($validated);

        // Return the created ativo
        return response()->json($ativo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the ativo by ID
        $ativo = Ativo::find($id);

        if (!$ativo) {
            return response()->json(['message' => 'Ativo not found'], 404);
        }

        // Return the ativo
        return response()->json($ativo, 200);
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
            'nome' => 'sometimes|required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        // Find the ativo by ID
        $ativo = Ativo::find($id);

        if (!$ativo) {
            return response()->json(['message' => 'Ativo not found'], 404);
        }

        // Update the ativo
        $ativo->update($validated);

        // Return the updated ativo
        return response()->json($ativo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the ativo by ID
        $ativo = Ativo::find($id);

        if (!$ativo) {
            return response()->json(['message' => 'Ativo not found'], 404);
        }

        // Delete the ativo
        $ativo->delete();

        // Return success response
        return response()->json(['message' => 'Ativo deleted successfully'], 200);
    }
}
