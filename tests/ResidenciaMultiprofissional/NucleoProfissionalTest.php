<?php
namespace Tests\ResidenciaMultiprofissional;

use TestCase;
use Symfony\Component\HttpFoundation\Response;

class NucleoProfissionalTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->authenticated();
    }


    public function testConsultaNucleosProfissionaisSemAuth()
    {
        $this->get(
            '/residencia-multiprofissional/nucleos-profissionais',
            []
        )
            ->seeStatusCode(Response::HTTP_UNAUTHORIZED);
    }

    public function testConsultaNucleosProfissionaisOK()
    {
        $this->get(
            '/residencia-multiprofissional/nucleos-profissionais',
            [
                'Authorization' => 'Bearer ' . $this->currentToken
            ]
        )
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJsonStructure([
                [
                    'id',
                    'descricao',
                    'abreviatura'
                ]
            ]);
    }
}