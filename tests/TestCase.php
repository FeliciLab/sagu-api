<?php

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    protected $currentToken;

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
