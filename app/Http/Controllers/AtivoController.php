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

    // Listar Ativos
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

     // Cadastrar Ativo
    public function store(Request $request)
    {
        // Validar a requisição
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        // Criar um novo ativo
        $ativo = Ativo::create($validated);

        // Retornar o Ativo criado no formato json
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

     //Mostrar o Ativo
    public function show($id)
    {
        // Encontrar o Ativo pelo ID
        $ativo = Ativo::find($id);

        if (!$ativo) {
            return response()->json(['message' => 'Ativo não encontrado!'], 404);
        }

        // Retorna o Ativo em formato json
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

     //Atualizar o Ativo
    public function update(Request $request, $id)
    {
         // Validar a requisição
         $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        // Encontrar o Ativo pelo ID
        $ativo = Ativo::find($id);

        if (!$ativo) {
            return response()->json(['message' => 'Ativo não encontrado!'], 404);
        }

        // Atualizar o Ativo
        $ativo->update($validated);

        // Retornar o Ativo em formato Json
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
     *             @OA\Property(property="message", type="string", example="Ativo excluído com sucesso")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=403, description="Proibido"),
     *     @OA\Response(response=404, description="Não encontrado"),
     *     security={{"bearerAuth":{}}}
     * )
     */

     //Excluir o Ativo
    public function destroy($id)
    {
        // Encontrar o ativo pelo ID
        $ativo = Ativo::find($id);

        if (!$ativo) {
            return response()->json(['message' => 'Ativo not found'], 404);
        }

        // Excluir o ATivo
        $ativo->delete();

        // Retornar o Ativo com mensagem de sucesso
        return response()->json(['message' => 'Ativo excluído com sucesso'], 200);
    }
}
