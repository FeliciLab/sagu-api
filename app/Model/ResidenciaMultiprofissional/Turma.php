<?php

namespace App\Model\ResidenciaMultiprofissional;

use Faker\Provider\DateTime;

class Turma extends BaseModelResidenciaMultiprofissional
{
    public $id;
    public $codigoturma;
    public $descricao;
    public $datainicio;
    public $datafim;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCodigoturma($codigoturma)
    {
        $this->codigoturma = $codigoturma;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function setDatainicio($datainicio)
    {
        $data = new \DateTime($datainicio);
        $this->datainicio = $data->format('d/m/Y');
    }


    public function setDatafim($datafim)
    {
        $data = new \DateTime($datafim);
        $this->datainicio = $data->format('d/m/Y');
    }

    public function getId()
    {
        $this->id;
    }

    public function getCodigoturma()
    {
        $this->codigoturma;
    }

    public function getDescricao()
    {
        $this->descricao;
    }

    public function getDatainicio()
    {
        $this->datainicio;
    }


    public function getDatafim()
    {
        $this->datafim;
    }
}