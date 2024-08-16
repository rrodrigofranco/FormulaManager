<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

/**
 * @OA\Schema(
 *     schema="Cliente",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="nome",
 *         type="string",
 *         example="João da Silva"
 *     ),
 *     @OA\Property(
 *         property="cpf",
 *         type="string",
 *         example="123.456.789-00"
 *     ),
 *     @OA\Property(
 *         property="telefone",
 *         type="string",
 *         example="123456789"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         example="cliente@example.com"
 *     ),
 *     @OA\Property(
 *         property="endereco",
 *         type="string",
 *         example="Rua Exemplo, 123"
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


class ClienteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/clientes",
     *     summary="Obter lista de clientes",
     *     tags={"Clientes"},
     *     @OA\Response(
     *         response=200,
     *         description="Operação bem-sucedida",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Cliente"))
     *     ),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=403, description="Proibido"),
     *     @OA\Response(response=404, description="Não encontrado"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index()
    {
        // Retrieve all clients
        return response()->json(Cliente::all(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/clientes",
     *     summary="Criar um novo cliente",
     *     tags={"Clientes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome", "cpf"},
     *             @OA\Property(property="nome", type="string", example="João da Silva"),
     *             @OA\Property(property="cpf", type="string", example="123.456.789-00"),
     *             @OA\Property(property="telefone", type="string", example="123456789"),
     *             @OA\Property(property="email", type="string", example="cliente@example.com"),
     *             @OA\Property(property="endereco", type="string", example="Rua Exemplo, 123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cliente criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     ),
     *     @OA\Response(response=400, description="Requisição mal formada"),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=403, description="Proibido"),
     *     @OA\Response(response=422, description="Erro de validação dos dados"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:clientes',
            'telefone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255|unique:clientes',
        ]);

        // Create a new client
        $cliente = Cliente::create($validated);

        // Return the created client
        return response()->json($cliente, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/clientes/{id}",
     *     summary="Obter um cliente específico",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID do cliente"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente encontrado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     ),
     *     @OA\Response(response=404, description="Cliente não encontrado"),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=403, description="Proibido"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function show($id)
    {
        // Find the client by ID
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado!'], 404);
        }

        // Return the client
        return response()->json($cliente, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/clientes/{id}",
     *     summary="Atualizar um cliente específico",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID do cliente"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nome", type="string", example="Maria Oliveira"),
     *             @OA\Property(property="cpf", type="string", example="987.654.321-00"),
     *             @OA\Property(property="telefone", type="string", example="987654321"),
     *             @OA\Property(property="email", type="string", example="maria.oliveira@example.com"),
     *             @OA\Property(property="endereco", type="string", example="Rua Nova, 456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Cliente")
     *     ),
     *     @OA\Response(response=404, description="Cliente não encontrado"),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=403, description="Proibido"),
     *     @OA\Response(response=422, description="Dados inválidos"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'cpf' => 'sometimes|required|string|max:14|unique:clientes,cpf,' . $id,
            'telefone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255|unique:clientes,email,' . $id,
        ]);

        // Find the client by ID
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado!'], 404);
        }

        // Update the client
        $cliente->update($validated);

        // Return the updated client
        return response()->json($cliente, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/clientes/{id}",
     *     summary="Excluir um cliente específico",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID do cliente"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente excluído com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente excluído com sucesso.")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Cliente não encontrado"),
     *     @OA\Response(response=401, description="Não autorizado"),
     *     @OA\Response(response=403, description="Proibido"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function destroy($id)
    {
        // Find the client by ID
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente não encontrado!'], 404);
        }

        // Delete the client
        $cliente->delete();

        // Return success response
        return response()->json(['message' => 'Cliente excluído com sucesso!'], 200);
    }
}
