<?php

namespace Tests\ResidenciaMultiprofissional;

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

    public function testBuscaOfertaModulosPaginaNaoNumero()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/2/oferta/41/residentes/dasdasd',
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

    public function testBuscaResidentesMatriculadosNaOfertaDeModulosSupervisor()
    {
        $this->get(
            '/residencia-multiprofissional/supervisores/turma/2/oferta/41/residentes',
            [
                'Authorization' => 'Bearer ' . $this->currentToken
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
                'Authorization' => 'Bearer ' . $this->currentToken
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
                'Authorization' => 'Bearer ' . $this->currentToken
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