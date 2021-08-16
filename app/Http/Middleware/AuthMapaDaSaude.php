<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class AuthMapaDaSaude
{
    public function handle($request, Closure $next)
    {
        $authorization = $request->header('Authorization');
        list($jwt) = sscanf($authorization, 'Bearer %s');

        if ($jwt) {
            try {
                if ($jwt == env('MAPA_TOKEN')) {
                    return $next($request);
                }

            } catch (\Exception $ex) {
                return response()->json(
                    [
                        'message' => 'Acesso não autorizado'
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }
        }

        return response()->json(
            [
                'message' => 'Token Inválido'
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }
}
