<?php

namespace Tests\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\TurmaDAO;
use TestCase;
use Symfony\Component\HttpFoundation\Response;

class OfertaModuloTest extends TestCase
{
    private $turmasSupervisor;

    public function setUp()
    {
        parent::setUp();
        $this->authenticated();

        $turmaDAO = new TurmaDAO();
        $this->turmasSupervisor = $turmaDAO->buscarTurmasSupervisor($this->supervisor->supervisorid);
    }


    public function testUsuarioNaoAutorizado()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/2/ofertas',
            []
        )
            ->seeStatusCode(Response::HTTP_UNAUTHORIZED);
    }

    public function testBuscaOfertaModulosPaginaNumeroFloat()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/2/ofertas/1.231',
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
            '/residencia-multiprofissional/supervisores/turma/2/ofertas/iodfjaiod',
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

    public function testBuscaOfertaModulosSupervisor()
    {
        $turmaId = $this->turmasSupervisor[0]['id'];
        $this->get(
            "/residencia-multiprofissional/supervisores/turma/{$turmaId}/ofertas",
            [
                'Authorization' => 'Bearer ' . $this->currentToken
            ]
        )
            ->seeStatusCode(Response::HTTP_OK)
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
                            ],
                            'atividadeModulo' => [
                                'id',
                                'periodo',
                                'descricao',
                                'sumula',
                                'cargaHoraria',
                                'modulo',
                                'enfases' => [
                                    [
                                        'id',
                                        'descricao',
                                        'abreviatura'
                                    ]
                                ],
                                'nucleosprofissionais' => [
                                    [
                                        'id',
                                        'descricao',
                                        'abreviatura'
                                    ]
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
        ->seeStatusCode(Response::HTTP_OK)
        ->seeJsonStructure([
            'ofertasModulos'
        ]);
    }
}