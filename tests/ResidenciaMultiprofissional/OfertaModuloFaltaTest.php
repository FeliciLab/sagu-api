<?php

namespace Tests\ResidenciaMultiprofissional;

use TestCase;
use Symfony\Component\HttpFoundation\Response;

class OfertaModuloFaltaTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->authenticated();
    }


    public function testLancamentoDeFaltaNaoAutorizado()
    {
        $this->post(
            '/residencia-multiprofissional/supervisores/turma/13/oferta/314/faltas',
            []
        )
            ->seeStatusCode(Response::HTTP_UNAUTHORIZED);
    }

    public function testLancamentoDeFaltaParametrosNumeroFloat()
    {
        $this->post(
            '/residencia-multiprofissional/supervisores/turma/13.18/oferta/3.14/faltas',
            [],
            [
                'Authorization' => 'Bearer ' . $this->currentToken,
                'Content-Type' => 'application/json'
            ]
        )
            ->seeStatusCode(Response::HTTP_BAD_REQUEST)
            ->seeJsonEquals(
                [
                    'error' => true,
                    'status' => Response::HTTP_BAD_REQUEST,
                    'message' => 'Parâmetro { turma } não é um valor número aceitável.'
                ]
            );
    }

    public function testLancamentoDeFaltaSemDadosDeFalta()
    {
        $this->post(
            '/residencia-multiprofissional/supervisores/turma/13/oferta/314/faltas',
            [],
            [
                'Authorization' => 'Bearer ' . $this->currentToken,
                'Content-Type' => 'application/json'
            ]
        )
            ->seeStatusCode(Response::HTTP_BAD_REQUEST)
            ->seeJsonEquals(
                [
                    'sucesso' => false,
                    'mensagem' => 'Não foi possível realizar o lançamento de faltas'
                ]
            );
    }


    public function testLancamentoDeFaltaOK()
    {
        $this->json(
            'POST',
            '/residencia-multiprofissional/supervisores/turma/13/oferta/314/faltas',
            [
                'faltas' => [
                    [
                        'residenteid' => 845,
                        'falta' => 10,
                        'tipo' => 'P',
                        'observacao' => 'teste',
                    ]
                ]
            ],
            [
                'Authorization' => 'Bearer ' . $this->currentToken,
                'Content-Type' => 'application/json'
            ]
        )
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJsonStructure(
                [
                    'sucesso',
                    'faltas' => [
                        [
                            'id',
                            'residenteId',
                            'ofertaId',
                            'tipo',
                            'falta',
                            'observacao',
                        ]
                    ]
                ]
            );
    }

    public function testLancamentoDeFaltaCamposInvalidos()
    {
        $this->json(
            'POST',
            '/residencia-multiprofissional/supervisores/turma/13/oferta/314/faltas',
            [
                'faltas' => [
                    [
                        'campo1' => 845,
                        'campo2' => 10,
                        'campo3' => 'P',
                        'campo4' => 'teste',
                    ]
                ]
            ],
            [
                'Authorization' => 'Bearer ' . $this->currentToken,
                'Content-Type' => 'application/json'
            ]
        )
            ->seeStatusCode(Response::HTTP_BAD_REQUEST)
            ->seeJsonEquals(
                [
                    'sucesso' => false,
                    'mensagem' => 'Não foi possível realizar o lançamento de faltas'
                ]
            );
    }
}