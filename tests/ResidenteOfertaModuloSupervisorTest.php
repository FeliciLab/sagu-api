<?php

/**
 * TODO buscar um modo de autenticação que não seja hardcode
 */
class ResidenteOfertaModuloSupervisorTest extends TestCase
{
    public function testUsuarioNaoAutorizado()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/2/oferta/41/residentes',
            []
        )
            ->seeStatusCode(401);
    }

    public function testBuscaOfertaModulosPaginaNumeroFloat()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/2/oferta/41/residentes/1.1231',
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
            '/residencia-multiprofissional/supervisores/turma/2/oferta/41/residentes/dasdasd',
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
            '/residencia-multiprofissional/supervisores/turma/2/oferta/41/residentes',
            [
                'Authorization' => 'Bearer ' . env('AUTH_TOKEN_TEST')
            ]
        )
            ->seeStatusCode(200)
            ->seeJsonStructure(
                [
                    'residentes'
                ]
            );
    }

    public function testBuscaOfertaModulosSupervisorTurmaNaoVinculada()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/1231212/oferta/41/residentes',
            [
                'Authorization' => 'Bearer ' . env('AUTH_TOKEN_TEST')
            ]
        )
            ->seeStatusCode(200)
            ->seeJsonEquals(
                [
                    'residentes' => []
                ]
            );
    }

    public function testBuscaOfertaModulosSupervisorOrfertaNaoVinculada()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/2/oferta/12318/residentes',
            [
                'Authorization' => 'Bearer ' . env('AUTH_TOKEN_TEST')
            ]
        )
            ->seeStatusCode(200)
            ->seeJsonEquals(
                [
                    'residentes' => []
                ]
            );
    }
}