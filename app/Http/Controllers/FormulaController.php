<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formula;

/**
 * @OA\Schema(
 *     schema="Formula",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="nome",
 *         type="string",
 *         example="Formula Example"
 *     ),
 *     @OA\Property(
 *         property="descricao",
 *         type="string",
 *         example="Description of the formula"
 *     ),
 *     @OA\Property(
 *         property="cliente_id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2024-08-14T10:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         example="2024-08-14T10:00:00Z"
 *     )
 * )
 */

class FormulaController extends Controller
{
     /**
     * @OA\Get(
     *     path="/api/formulas",
     *     summary="Obter lista de fórmulas",
     *     tags={"Fórmulas"},
     *     @OA\Response(
     *         response=200,
     *         description="Operação bem-sucedida",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Formula"))
     *     ),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=403, description="Proibido"),
     *     @OA\Response(response=404, description="Não encontrado"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function index()
    {
        // Retrieve all formulas
        return response()->json(Formula::all(), 200);
    }

     /**
     * @OA\Post(
     *     path="/api/formulas",
     *     summary="Criar uma nova fórmula",
     *     tags={"Fórmulas"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome", "descricao", "cliente_id"},
     *             @OA\Property(property="nome", type="string", example="Fórmula A"),
     *             @OA\Property(property="descricao", type="string", example="Descrição da Fórmula A"),
     *             @OA\Property(property="cliente_id", type="integer", example=1),
     *             @OA\Property(property="ativos", type="array", @OA\Items(type="integer"), example={1, 2})
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Fórmula criada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Formula")
     *     ),
     *     @OA\Response(response=400, description="Requisição inválida"),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=403, description="Proibido"),
     *     @OA\Response(response=422, description="Erro de validação"),
     *     security={{"bearerAuth":{}}}
     * )
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
     * @OA\Get(
     *     path="/api/formulas/{id}",
     *     summary="Exibir detalhes de uma fórmula",
     *     tags={"Fórmulas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID da fórmula"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operação bem-sucedida",
     *         @OA\JsonContent(ref="#/components/schemas/Formula")
     *     ),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=403, description="Proibido"),
     *     @OA\Response(response=404, description="Não encontrado"),
     *     security={{"bearerAuth":{}}}
     * )
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
     * @OA\Put(
     *     path="/api/formulas/{id}",
     *     summary="Atualizar uma fórmula existente",
     *     tags={"Fórmulas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID da fórmula"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nome", type="string", example="Fórmula Atualizada"),
     *             @OA\Property(property="descricao", type="string", example="Descrição atualizada da fórmula"),
     *             @OA\Property(property="cliente_id", type="integer", example=1),
     *             @OA\Property(property="ativos", type="array", @OA\Items(type="integer"), example={1, 3})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fórmula atualizada com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Formula")
     *     ),
     *     @OA\Response(response=400, description="Requisição inválida"),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=403, description="Proibido"),
     *     @OA\Response(response=404, description="Não encontrado"),
     *     security={{"bearerAuth":{}}}
     * )
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
     * @OA\Delete(
     *     path="/api/formulas/{id}",
     *     summary="Excluir uma fórmula existente",
     *     tags={"Fórmulas"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID da fórmula"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Fórmula excluída com sucesso"
     *     ),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=403, description="Proibido"),
     *     @OA\Response(response=404, description="Não encontrado"),
     *     security={{"bearerAuth":{}}}
     * )
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
