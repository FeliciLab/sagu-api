<?php

use App\Http\JWT\JWTWrapper;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    protected $currentToken;
    protected $supervisor;


    public function authenticated()
    {
        parent::setUp();

        $user = [
            'usuario' => env('USER_TEST'),
            'senha' => env('USER_TEST_PASSWORD')
        ];

        $response = $this->json('POST', '/auth', $user);
        $data = $response->response->getData();

        if ($data->login) {
            $this->currentToken = $data->access_token;
            $jwtDecode = JWTWrapper::decode($data->access_token);
            $this->supervisor = $jwtDecode->data;

        }
    }

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
