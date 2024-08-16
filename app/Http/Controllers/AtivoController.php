<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ativo;

/**
 * @OA\Schema(
 *     schema="Ativo",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="nome",
 *         type="string",
 *         example="Ativo Example"
 *     ),
 *     @OA\Property(
 *         property="descricao",
 *         type="string",
 *         example="Description of the ativo"
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


class AtivoController extends Controller
{
     /**
     * @OA\Get(
     *     path="/api/ativos",
     *     summary="Listar todos os ativos",
     *     tags={"Ativos"},
     *     @OA\Response(
     *         response=200,
     *         description="Operação bem-sucedida",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Ativo"))
     *     ),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=403, description="Proibido"),
     *     @OA\Response(response=404, description="Não encontrado"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index()
    {
        return response()->json(Ativo::all(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/ativos",
     *     summary="Criar um novo ativo",
     *     tags={"Ativos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome"},
     *             @OA\Property(property="nome", type="string", example="Ativo A"),
     *             @OA\Property(property="descricao", type="string", example="Descrição do Ativo A")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ativo criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Ativo")
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
     * @OA\Get(
     *     path="/api/ativos/{id}",
     *     summary="Exibir detalhes de um ativo",
     *     tags={"Ativos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID do ativo"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operação bem-sucedida",
     *         @OA\JsonContent(ref="#/components/schemas/Ativo")
     *     ),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=403, description="Proibido"),
     *     @OA\Response(response=404, description="Não encontrado"),
     *     security={{"bearerAuth":{}}}
     * )
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
     * @OA\Put(
     *     path="/api/ativos/{id}",
     *     summary="Atualizar um ativo existente",
     *     tags={"Ativos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID do ativo"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nome", type="string", example="Ativo Atualizado"),
     *             @OA\Property(property="descricao", type="string", example="Descrição atualizada do ativo")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ativo atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Ativo")
     *     ),
     *     @OA\Response(response=400, description="Requisição inválida"),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=403, description="Proibido"),
     *     @OA\Response(response=404, description="Não encontrado"),
     *     @OA\Response(response=422, description="Erro de validação"),
     *     security={{"bearerAuth":{}}}
     * )
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
     * @OA\Delete(
     *     path="/api/ativos/{id}",
     *     summary="Excluir um ativo existente",
     *     tags={"Ativos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID do ativo"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ativo excluído com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Ativo deleted successfully")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=403, description="Proibido"),
     *     @OA\Response(response=404, description="Não encontrado"),
     *     security={{"bearerAuth":{}}}
     * )
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
