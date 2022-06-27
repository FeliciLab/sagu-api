<?php

namespace App\Http\Middleware;

use Closure;
use  App\Http\JWT\JWTWrapper;
use Illuminate\Http\Response;

class ApiKeyPublicAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $apiKey = $request->header('x-api-key');

        if ($apiKey) {
            try {
                if ($apiKey == env('API_KEY_PUBLIC')) {
                    return $next($request);
                }  
            } catch (\Exception $ex) {
                return response()->json(
                    [
                        'message' => 'Chave pública não autorizada'
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }
        }

        return response()->json(
            [
                'message' => 'Chave pública não autorizada'
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }
}
