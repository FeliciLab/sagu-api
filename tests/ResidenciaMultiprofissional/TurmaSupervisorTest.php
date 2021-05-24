<?php

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
            ->seeStatusCode(401);
    }

    public function testBuscaTurmasPaginaNumeroFloat()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turmas/1.231',
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

    public function testBuscaTurmasParametroPaginaNaoNumero()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turmas/fsdfsdff',
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

    public function testTurmasSupervisorOK()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turmas',
            [
                'Authorization' => 'Bearer ' . $this->currentToken
            ]
        )
            ->seeStatusCode(200)
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