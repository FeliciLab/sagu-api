<?php

class OfertaModuloTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->authenticated();
    }


    public function testUsuarioNaoAutorizado()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/2/ofertas',
            []
        )
            ->seeStatusCode(401);
    }

    public function testBuscaOfertaModulosPaginaNumeroFloat()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/2/ofertas/1.231',
            [
                'Authorization' => 'Bearer ' . $this->currentToken
            ]
        )
            ->seeStatusCode(400)
            ->seeJsonEquals(
                [
                    'error' => true,
                    'status' => 400,
                    'message' => 'Atributo { page } não é um valor número aceitável.'
                ]
            );
    }

    public function testBuscaOfertaModulosPaginaNaoNumero()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/2/ofertas/iodfjaiod',
            [
                'Authorization' => 'Bearer ' . $this->currentToken
            ]
        )
            ->seeStatusCode(400)
            ->seeJsonEquals(
                [
                    'error' => true,
                    'status' => 400,
                    'message' => 'Atributo { page } não é um valor número aceitável.'
                ]
            );
    }

    public function testBuscaOfertaModulosSupervisor()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/13/ofertas',
            [
                'Authorization' => 'Bearer ' . $this->currentToken
            ]
        )
            ->seeStatusCode(200)
            ->seeJsonStructure(
                [
                    'ofertasModulos' => [
                        [
                            'id',
                            'dataInicio',
                            'dataFim',
                            'encerramento',
                            'nome',
                            'semestre',
                            'semestre_descricao',
                            'turma' => [
                                'id',
                                'codigoTurma',
                                'descricao',
                                'dataInicio',
                                'dataFim',
                            ],
                            'modulo' => [
                                'nome',
                                'id'
                            ],
                            'cargahoraria',
                            'unidadetematicaid',
                            'tipoCargaHoraria' => [
                                [
                                    'tipo',
                                    'cargahoraria'
                                ]
                            ]
                        ]
                    ]
                ]
            );
    }

    public function testBuscaOfertaModulosSupervisorTurmaNaoVinculada()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/1231/ofertas',
            [
                'Authorization' => 'Bearer ' . $this->currentToken
            ]
        )
        ->seeStatusCode(200)
        ->seeJsonStructure([
            'ofertasModulos'
        ]);
    }
}