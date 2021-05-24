<?php

namespace Tests\ResidenciaMultiprofissional;

use TestCase;
use Symfony\Component\HttpFoundation\Response;

class AuthTest extends TestCase
{
    public function testAuthSemParametroUsuario()
    {
        $this->post('/auth', [
            'senha' => env('USER_TEST_PASSWORD')
        ]);

        $this->seeStatusCode(Response::HTTP_UNAUTHORIZED);
        $this->seeJsonEquals([
            'login' => 'false',
            'message' => 'Login Inválido',
        ]);
    }

    public function testAuthSemParametroSenha()
    {
        $this->post('/auth', [
            'usuario' => env('USER_TEST')
        ]);

        $this->seeStatusCode(Response::HTTP_UNAUTHORIZED);
        $this->seeJsonEquals([
            'login' => 'false',
            'message' => 'Login Inválido',
        ]);
    }

    public function testAuthSemParametro()
    {
        $this->post('/auth', []);

        $this->seeStatusCode(Response::HTTP_UNAUTHORIZED);
        $this->seeJsonEquals([
            'login' => 'false',
            'message' => 'Login Inválido',
        ]);
    }

    public function testAuthOK()
    {
        $this->post('/auth', [
            'usuario' => env('USER_TEST'),
            'senha' => env('USER_TEST_PASSWORD')
        ]);

        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonStructure([
            'login',
            'access_token'
        ]);
    }
}