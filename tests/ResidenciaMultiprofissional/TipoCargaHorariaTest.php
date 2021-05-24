<?php
namespace Tests\ResidenciaMultiprofissional;

use TestCase;

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
            ->seeStatusCode(401);
    }

    public function testConsultaTipoDeCargaHorariaOK()
    {
        $this->get(
            '/residencia-multiprofissional/carga-horaria/tipos',
            [
                'Authorization' => 'Bearer ' . $this->currentToken
            ]
        )
            ->seeStatusCode(200)
            ->seeJsonStructure([
                [
                    'id',
                    'descricao'
                ]
            ]);
    }
}