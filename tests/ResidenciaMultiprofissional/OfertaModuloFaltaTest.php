<?php

namespace Tests\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\OfertaModuloDAO;
use App\DAO\ResidenciaMultiprofissional\TurmaDAO;
use TestCase;
use Symfony\Component\HttpFoundation\Response;

class OfertaModuloFaltaTest extends TestCase
{
    private $ofertasDoSupervisor;
    private $turmasSupervisor;

    public function setUp()
    {
        parent::setUp();
        $this->authenticated();

        $turmaDAO = new TurmaDAO();
        $this->turmasSupervisor = $turmaDAO->buscarTurmasSupervisor($this->supervisor->supervisorid);
        $turmaId = $this->turmasSupervisor[0]['id'];

        $ofertaModuloTurmasDAO = new OfertaModuloDAO();
        $this->ofertasDoSupervisor = $ofertaModuloTurmasDAO->buscarOfertasModuloSupervisor($this->supervisor->supervisorid, $turmaId);
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
        $turmaId = $this->turmasSupervisor[0]['id'];
        $ofertaId = $this->ofertasDoSupervisor[0]->id;

        $this->json(
            'POST',
            "/residencia-multiprofissional/supervisores/turma/{$turmaId}/oferta/{$ofertaId}/faltas",
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
        $turmaId = $this->turmasSupervisor[0]['id'];
        $ofertaId = $this->ofertasDoSupervisor[0]->id;

        $this->json(
            'POST',
            "/residencia-multiprofissional/supervisores/turma/{$turmaId}/oferta/{$ofertaId}/faltas",
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