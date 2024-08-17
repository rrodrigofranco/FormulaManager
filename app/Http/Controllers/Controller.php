<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\OpenApi(
 *   @OA\Info(
 *      version="1.0.0",
 *      title="API de Gerenciamento de Fórmulas de Manipulação",
 *      description="A API foi desenvolvida para uma farmácia de manipulação com o objetivo de gerenciar clientes, fórmulas de manipulação e os ativos utilizados nessas fórmulas.",
 *      @OA\Contact(
 *          email="francorodrigognr@yahoo.com.br"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 *   ),
 *   @OA\Components(
 *      @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         type="http",
 *         scheme="bearer",
 *         bearerFormat="JWT"
 *      )
 *   )
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
