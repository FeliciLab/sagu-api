<?php

class AuthTest extends TestCase
{
    public function testAuthSemParametroUsuario()
    {
        $this->post('/auth', [
            'senha' => env('USER_TEST_PASSWORD')
        ]);

        $this->seeStatusCode(401);
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

        $this->seeStatusCode(401);
        $this->seeJsonEquals([
            'login' => 'false',
            'message' => 'Login Inválido',
        ]);
    }

    public function testAuthSemParametro()
    {
        $this->post('/auth', []);

        $this->seeStatusCode(401);
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

        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'login',
            'access_token'
        ]);
    }
}