<?php
namespace Tests\ResidenciaMultiprofissional;

use TestCase;
use Symfony\Component\HttpFoundation\Response;

class EnfaseTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->authenticated();
    }


    public function testConsultaEnfasesSemAuth()
    {
        $this->get(
            '/residencia-multiprofissional/enfases',
            []
        )
            ->seeStatusCode(Response::HTTP_UNAUTHORIZED);
    }

    public function testConsultaEnfaseOK()
    {
        $this->get(
            '/residencia-multiprofissional/enfases',
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