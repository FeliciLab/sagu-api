<?php

/**
 * TODO buscar um modo de autenticação que não seja hardcode
 */
class OfertaModuloSupervisorTest extends TestCase
{
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
                'Authorization' => 'Bearer ' . env('AUTH_TOKEN_TEST')
            ]
        )
            ->seeStatusCode(400)
            ->seeJsonEquals(
                [
                    'error' => true,
                    'status' => 400,
                    'message' => 'Atributo {page} não é um número inteiro'
                ]
            );
    }

    public function testBuscaOfertaModulosPaginaNaoNumero()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/2/ofertas/iodfjaiod',
            [
                'Authorization' => 'Bearer ' . env('AUTH_TOKEN_TEST')
            ]
        )
            ->seeStatusCode(400)
            ->seeJsonEquals(
                [
                    'error' => true,
                    'status' => 400,
                    'message' => 'Atributo {page} não é um número inteiro'
                ]
            );
    }

    public function testBuscaOfertaModulosSupervisor()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/2/ofertas',
            [
                'Authorization' => 'Bearer ' . env('AUTH_TOKEN_TEST')
            ]
        )
            ->seeStatusCode(200)
            ->seeJsonStructure(
                [
                    'ofertasModulos'
                ]
            );
    }

    public function testBuscaOfertaModulosSupervisorTurmaNaoVinculada()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/1231/ofertas',
            [
                'Authorization' => 'Bearer ' . env('AUTH_TOKEN_TEST')
            ]
        )
            ->seeStatusCode(200)
            ->seeJsonEquals(
                [
                    'ofertasModulos' => []
                ]
            );
    }
}