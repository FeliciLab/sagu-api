<?php

namespace Tests\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\OfertaModuloDAO;
use App\DAO\ResidenciaMultiprofissional\TurmaDAO;
use TestCase;
use Symfony\Component\HttpFoundation\Response;

class OfertaModuloNotaTest extends TestCase
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


    public function testLancamentoDeNotasNaoAutorizado()
    {
        $this->post(
            '/residencia-multiprofissional/supervisores/turma/13/oferta/314/notas',
            []
        )
            ->seeStatusCode(Response::HTTP_UNAUTHORIZED);
    }

    public function testLancamentoDeNotasParametrosNumeroFloat()
    {
        $this->post(
            '/residencia-multiprofissional/supervisores/turma/13.18/oferta/3.14/notas',
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

    public function testLancamentoDeNotasSemDadosDeNotas()
    {
        $this->post(
            '/residencia-multiprofissional/supervisores/turma/13/oferta/314/notas',
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
                    'mensagem' => 'Notas é obrigatório'
                ]
            );
    }


    public function testLancamentoDeNotasOK()
    {
        $turmaId = $this->turmasSupervisor[0]['id'];
        $ofertaId = $this->ofertasDoSupervisor[0]->id;

        $this->json(
            'POST',
            "/residencia-multiprofissional/supervisores/turma/{$turmaId}/oferta/{$ofertaId}/notas",
            [
                'notas' => [
                    [
                        'residenteid' => 845,
                        'notadeatividadedeproduto' => 9,
                        'notadeavaliacaodedesempenho' => 9
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
                    'notas' => [
                        [
                            'id',
                            'residenteId',
                            'ofertaId',
                            'semestre',
                            'notaDeAtividadeDeProduto',
                            'notaDeAvaliacaoDeDesempenho',
                        ]
                    ]
                ]
            );
    }

    public function testLancamentoDeNotasMenorQueZero()
    {
        $turmaId = $this->turmasSupervisor[0]['id'];
        $ofertaId = $this->ofertasDoSupervisor[0]->id;

        $this->json(
            'POST',
            "/residencia-multiprofissional/supervisores/turma/{$turmaId}/oferta/{$ofertaId}/notas",
            [
                'notas' => [
                    [
                        'residenteid' => 845,
                        'notadeatividadedeproduto' => -5,
                        'notadeavaliacaodedesempenho' => -6
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
                    'mensagem' => 'Nota não pode ser menor que 0 e maior que 10'
                ]
            );
    }

    public function testLancamentoDeNotasMaiorQueZero()
    {
        $turmaId = $this->turmasSupervisor[0]['id'];
        $ofertaId = $this->ofertasDoSupervisor[0]->id;

        $this->json(
            'POST',
            "/residencia-multiprofissional/supervisores/turma/{$turmaId}/oferta/{$ofertaId}/notas",
            [
                'notas' => [
                    [
                        'residenteid' => 845,
                        'notadeatividadedeproduto' => 15,
                        'notadeavaliacaodedesempenho' => 20
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
                    'mensagem' => 'Nota não pode ser menor que 0 e maior que 10'
                ]
            );
    }
}