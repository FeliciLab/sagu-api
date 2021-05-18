<?php

namespace App\Model\ResidenciaMultiprofissional;

use App\Model\BaseModel\BaseModelSagu;

class Turma extends BaseModelSagu
{
    public $id;
    public $codigoTurma;
    public $descricao;
    public $dataInicio;
    public $dataFim;

    protected $mapFieldModel = [
        'turmaid' => 'id',
        'codigoturma' => 'codigoTurma',
        'datainicio' => 'dataInicio',
        'datafim' => 'dataFim'
    ];

    public function setDataInicio($dataInicio)
    {
        $data = new \DateTime($dataInicio);
        $this->dataInicio = $data->format('d/m/Y');
    }


    public function setDataFim($dataFim)
    {
        $data = new \DateTime($dataFim);
        $this->dataFim = $data->format('d/m/Y');
    }
}