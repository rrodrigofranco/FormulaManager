<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Nome de Teste"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         example="email@teste.com"
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

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/auth",
     *     summary="Registrar um novo usuário",
     *     tags={"Autenticação"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome", "email", "senha", "senha_confirmacao"},
     *             @OA\Property(property="name", type="string", example="Nome Teste"),
     *             @OA\Property(property="email", type="string", example="teste@exemplo.com"),
     *             @OA\Property(property="password", type="string", example="senha123"),
     *             @OA\Property(property="password_confirmation", type="string", example="senha123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuário registrado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", ref="#/components/schemas/User"),
     *             @OA\Property(property="token", type="string", example="seu_token_aqui")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Erro de validação"),
     *     @OA\Tag(
     *         name="Autenticação",
     *         description="Endpoints relacionados à autenticação de usuários"
     *     )
     * )
     */
    public function register(Request $request)
    {
        // Validar a requisição
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Retornar erros de validação se houver
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Criar um novo usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Gerar um token de autenticação válido por 7 dias
        $token = $user->createToken('Token Pessoal', ['*'], Carbon::now()->addDays(7))->plainTextToken;

        // Retornar o usuário e o token
        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }
}
