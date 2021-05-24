<?php

class AuthTest extends TestCase
{
    public function testAuthSemParametroUsuario()
    {
        $this->post('/auth', array(
            'senha' => env('USER_TEST_PASSWORD')
        ));

        $this->seeStatusCode(401);
        $this->seeJsonEquals([
            'login' => 'false',
            'message' => 'Login Inválido',
        ]);
    }
}