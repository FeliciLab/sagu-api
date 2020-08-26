<?php

namespace App\Model\ResidenciaMultiprofissional;

use Faker\Provider\DateTime;

class Turma
{
    public $id;
    public $codigoTurma;
    public $descricao;
    public $dataInicio;
    public $dataFim;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setCodigoTurma($codigoTurma)
    {
        $this->codigoTurma = $codigoTurma;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function setDataInicio($dataInicio)
    {
        $data = new \DateTime($dataInicio);
        $this->dataInicio = $data->format('d/m/Y');
    }


    public function setDataFim($dataFim)
    {
        $data = new \DateTime($dataFim);
        $this->dataInicio = $data->format('d/m/Y');
    }

    public function getId()
    {
        $this->id;
    }

    public function getCodigoTurma()
    {
        $this->codigoTurma;
    }

    public function getDescricao()
    {
        $this->descricao;
    }

    public function getDataInicio()
    {
        $this->dataInicio;
    }


    public function getDataFim()
    {
        $this->dataFim;
    }
}