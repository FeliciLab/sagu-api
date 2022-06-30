<?php
namespace Tests\Basico;

use TestCase;
use Symfony\Component\HttpFoundation\Response;

class PersonTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    private function data()
    {
        $rand = rand(90000, 99999);

        return [
            'nome' => 'Nome da pessoa - ' . $rand,
            'email' => 'mail.' . $rand . '@mail.com',
            'endereco' => [
                'cep' => '600' . $rand,
                'logradouro' => 'Logradouro ' . $rand,
                'numero' => '000' . $rand,
                'complemento' => 'Complemento ' . $rand,
                'bairro'=> 'Bair ' . $rand,
                'cidade'=> 'Fortaleza' . $rand
            ],
            'sexo' => 'M',
            'cpf' => '123.' . rand(100, 999) . '.'.rand(100, 999) . '-00',
            'rg' => '1234567'.rand(1000, 9999),
            'dataNascimento' => '2000-01-01',
            'celular' => '859999'.$rand,
            'telefoneResidencial' => '859999'.$rand,
            'estadoCivil' => 'N'
        ];
    }

    public function testCadastroPersonOK()
    {
        $data = $this->data();
        $result = $this->post(
            '/person',
            $data,
            [
                'x-api-key' => env('API_KEY_PUBLIC')
            ]
        );

        $result->seeStatusCode(Response::HTTP_OK);
        $result->seeJson(
            [
                'name' => $data['nome'],
                'email' => $data['email'],
                'cpf' => $data['cpf'],
                'rg' => $data['rg'],
                'celular' => $data['celular'],
                'telefoneResidencial' => $data['telefoneResidencial'],
                'sexo' => $data['sexo'],
                'dataNascimento' => $data['dataNascimento'],
                'cep' => $data['endereco']['cep'],
                'logradouro' => $data['endereco']['logradouro'],
                'numero' => $data['endereco']['numero'],
                'complemento' => $data['endereco']['complemento'],
                'bairro' => $data['endereco']['bairro'],
                'estadoCivil' => $data['estadoCivil']
            ]
        );
    }


    public function testCadastroPersonComCpfExistente()
    {
        $data = $this->data();

        $this->post(
            '/person',
            $data,
            [
                'x-api-key' => env('API_KEY_PUBLIC')
            ]
        );

        $novoData = $this->data();

        $data['email'] = $novoData['email'];
        $data['rg'] = $novoData['rg'];
        $this->post(
            '/person',
            $data,
            [
                'x-api-key' => env('API_KEY_PUBLIC')
            ]
        )
        ->seeStatusCode(Response::HTTP_BAD_REQUEST)
        ->seeJsonEquals([
            'error' => [
                'O campo cpf já está sendo utilizado.'
            ]
        ]);
    }

    public function testCadastroPersonComEmailExistente()
    {
        $data = $this->data();

        $this->post(
            '/person',
            $data,
            [
                'x-api-key' => env('API_KEY_PUBLIC')
            ]
        );

        $novoData = $this->data();

        $data['cpf'] = $novoData['cpf'];
        $data['rg'] = $novoData['rg'];
        $this->post(
            '/person',
            $data,
            [
                'x-api-key' => env('API_KEY_PUBLIC')
            ]
        )
        ->seeStatusCode(Response::HTTP_BAD_REQUEST)
        ->seeJsonEquals([
            'error' => [
                'O campo email já está sendo utilizado.'
            ]
        ]);
    }

    public function testCadastroPersonComRGExistente()
    {
        $data = $this->data();
        $this->post(
            '/person',
            $data,
            [
                'x-api-key' => env('API_KEY_PUBLIC')
            ]
        );

       
        $novoData = $this->data();

        $data['email'] = $novoData['email'];
        $data['cpf'] = $novoData['cpf'];
        $result = $this->post(
            '/person',
            $data,
            [
                'x-api-key' => env('API_KEY_PUBLIC')
            ]
        )
        ->seeStatusCode(Response::HTTP_BAD_REQUEST)
        ->seeJsonEquals([
            'error' => [
                'O campo rg já está sendo utilizado.'
            ]
        ]);
    }

    public function testCadastroPersonSemDados()
    {
        $this->post(
            '/person',
            [],
            [
                'x-api-key' => env('API_KEY_PUBLIC')
            ]
        )
        ->seeStatusCode(Response::HTTP_BAD_REQUEST)
        ->seeJsonEquals([
            'error' => [
                'O campo nome é obrigatório.',
                'O campo email é obrigatório.',
                'O campo cpf é obrigatório.',
                'O campo rg é obrigatório.'
            ]
        ]);
    }
  
}