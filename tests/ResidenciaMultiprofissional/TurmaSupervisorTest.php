<?php

namespace Tests\ResidenciaMultiprofissional;

use Symfony\Component\HttpFoundation\Response;
use TestCase;

class TurmaSupervisorTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->authenticated();
    }


    public function testUsuarioNaoAutorizadoParaTurmas()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turmas',
            []
        )
            ->seeStatusCode(Response::HTTP_UNAUTHORIZED);
    }

    public function testBuscaTurmasPaginaNumeroFloat()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turmas/1.231',
            [
                'Authorization' => 'Bearer ' . $this->currentToken
            ]
        )
        ->seeStatusCode(Response::HTTP_BAD_REQUEST)
        ->seeJsonEquals(
            [
                'error' => true,
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => 'Parâmetro { page } não é um valor número aceitável.'
            ]
        );
    }

    public function testBuscaTurmasParametroPaginaNaoNumero()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turmas/fsdfsdff',
            [
                'Authorization' => 'Bearer ' . $this->currentToken
            ]
        )
            ->seeStatusCode(Response::HTTP_BAD_REQUEST)
            ->seeJsonEquals(
                [
                    'error' => true,
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Parâmetro { page } não é um valor número aceitável.'
                ]
            );
    }

    public function testTurmasSupervisorOK()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turmas',
            [
                'Authorization' => 'Bearer ' . $this->currentToken
            ]
        )
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJsonStructure(
                [
                    'turmas' => [
                        [
                            'id',
                            'codigoTurma',
                            'descricao',
                            'dataInicio',
                            'dataFim',
                            'quantidadeperiodo',
                            'componente'
                        ]
                    ]
                ]
            );
    }
}