<?php
namespace Tests\EnsinoPesquisaExtensao;

use TestCase;
use Symfony\Component\HttpFoundation\Response;

class OfertaCursoTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testOfertasDeCursosAtivos()
    {
        $result = $this->get(
            '/ensino-pesquisa-extensao/ofertas',
            [
                'x-api-key' => env('API_KEY_PUBLIC')
            ]
        );

        $result->seeStatusCode(Response::HTTP_OK);
        $result->seeJsonStructure(
            [[
               'id',
               'descricao',
               'situacao'
            ]]
        );
    }
}