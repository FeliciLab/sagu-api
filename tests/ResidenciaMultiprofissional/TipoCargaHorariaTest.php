<?php
namespace Tests\ResidenciaMultiprofissional;

use TestCase;
use Symfony\Component\HttpFoundation\Response;

class TipoCargaHorariaTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->authenticated();
    }


    public function testConsultaTipoDeCargaHorariaSemAuth()
    {
        $this->get(
            '/residencia-multiprofissional/carga-horaria/tipos',
            []
        )
            ->seeStatusCode(Response::HTTP_UNAUTHORIZED);
    }

    public function testConsultaTipoDeCargaHorariaOK()
    {
        $this->get(
            '/residencia-multiprofissional/carga-horaria/tipos',
            [
                'Authorization' => 'Bearer ' . $this->currentToken
            ]
        )
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJsonStructure([
                [
                    'id',
                    'descricao',
                    'frequenciaminima'
                ]
            ]);
    }
}