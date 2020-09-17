<?php

namespace App\Http\Middleware;

use Closure;
use  App\Http\JWT\JWTWrapper;
use Illuminate\Http\Response;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $authorization = $request->header('Authorization');
        list($jwt) = sscanf($authorization, 'Bearer %s');

        if ($jwt) {
            try {
                $jwt = JWTWrapper::decode($jwt);
                $request->request->add(['usuario' => $jwt->data]);
                return $next($request);
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
