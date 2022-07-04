<?php
namespace Tests\Basico;

use TestCase;
use Symfony\Component\HttpFoundation\Response;

use Faker\Factory;
use Faker\Generator;

class PersonTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    private function data()
    {
        $fakerBrasil = new Generator();
        $fakerBrasil->addProvider(new \Faker\Provider\pt_BR\Person($fakerBrasil));
        $faker = Factory::create();

        $rand = rand(90000, 99999);

        return [
            'nome' => $fakerBrasil->name,
            'email' => $faker->email,
            'endereco' => [
                'cep' => '600' . $rand,
                'logradouro' => 'Logradouro ' . $rand,
                'numero' => '000' . $rand,
                'complemento' => 'Complemento ' . $rand,
                'bairro'=> 'Bair ' . $rand,
                'cidade'=> 'Fortaleza' . $rand
            ],
            'sexo' => 'M',
            'cpf' => $fakerBrasil->cpf,
            'rg' => $fakerBrasil->rg,
            'dataNascimento' => '2000-01-01',
            'celular' => $faker->phoneNumber,
            'telefoneResidencial' => $faker->phoneNumber,
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

    public function testCadastroCpfInvalido()
    {
        $data = $this->data();
        
        $data['cpf'] = '000.000.000-00';
        $result = $this->post(
            '/person',
            $data,
            [
                'x-api-key' => env('API_KEY_PUBLIC')
            ]
        );

        $result->seeStatusCode(Response::HTTP_BAD_REQUEST);
        $result->seeJson(
            [
                'error' => [
                    'O campo cpf não é um CPF válido'
                ]
            ]
        );
    }
    
  
}