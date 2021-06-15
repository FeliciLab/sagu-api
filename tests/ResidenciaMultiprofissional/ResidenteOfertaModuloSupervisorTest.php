<?php

namespace Tests\ResidenciaMultiprofissional;

use Symfony\Component\HttpFoundation\Response;
use TestCase;

class ResidenteOfertaModuloSupervisorTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->authenticated();
    }

    public function testUsuarioNaoAutorizado()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/14/oferta/422/residentes',
            []
        )
            ->seeStatusCode(Response::HTTP_UNAUTHORIZED);
    }

    public function testBuscaOfertaModulosPaginaNumeroFloat()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/14/oferta/422/residentes/1.1231',
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

    public function testBuscaOfertaModulosPaginaNaoNumero()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/14/oferta/422/residentes/dasdasd',
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

    public function testBuscaResidentesMatriculadosNaOfertaDeModulosSupervisor()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/14/oferta/422/residentes',
            [
                'Authorization' => 'Bearer ' . $this->currentToken
            ]
        )
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJsonStructure(
                [
                    'residentes' => [
                        [
                            'id',
                            'inicio',
                            'fimPrevisto',
                            'person' => [
                                'id',
                                'name'
                            ],
                            'enfase' => [
                                'id',
                                'descricao'
                            ],
                            'nucleoProfissional' => [
                                'id',
                                'descricao'
                            ],
                            'turma' => [
                                'descricao'
                            ],
                            'instituicaoFormadoraPerson' => [
                                'name'
                            ],
                            'instituicaoExecutoraPerson' => [
                                'name'
                            ],
                            'faltas' => [
                                [
                                    'id',
                                    'residenteId',
                                    'ofertaId',
                                    'tipo',
                                    'falta',
                                    'observacao'
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
            '/residencia-multiprofissional/supervisores/turma/1231212/oferta/41/residentes',
            [
                'Authorization' => 'Bearer ' . $this->currentToken
            ]
        )
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJsonEquals(
                [
                    'residentes' => []
                ]
            );
    }

    public function testBuscaOfertaModulosSupervisorOfertaNaoVinculada()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/2/oferta/12318/residentes',
            [
                'Authorization' => 'Bearer ' . $this->currentToken
            ]
        )
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJsonEquals(
                [
                    'residentes' => []
                ]
            );
    }
}