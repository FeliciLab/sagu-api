<?php

namespace App\Http\JWT;

use Firebase\JWT\JWT;

class JWTWrapper
{
    const KEY = 'Espce_@dmin'; // chave

    /**
     * Geracao de um novo token jwt
     */
    public static function encode(array $options)
    {
        $issuedAt = time();
        //$expire = $issuedAt + $options['expiration_sec']; // tempo de expiracao do token

        $tokenParam = [
            'iat'  => $issuedAt,            // timestamp de geracao do token
            'iss'  => $options['iss'],      // dominio, pode ser usado para descartar tokens de outros dominios
            'data' => $options['userdata'], // Dados do usuario logado
        ];

        return JWT::encode($tokenParam, self::KEY);
    }

    /**
     * Decodifica token jwt
     */
    public static function decode($jwt)
    {
        return JWT::decode($jwt, self::KEY, ['HS256']);
    }
}