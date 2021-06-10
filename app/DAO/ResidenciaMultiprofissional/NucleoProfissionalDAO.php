<?php

namespace App\DAO\ResidenciaMultiprofissional;

use App\Model\ResidenciaMultiprofissional\NucleoProfissional;
use Illuminate\Support\Facades\DB;

class NucleoProfissionalDAO
{
    private $model;

    public function __construct()
    {
        $this->model = new NucleoProfissional();
    }

    public function get($id)
    {
        $select = DB::select("SELECT * FROM {$this->model->getTable()} WHERE nucleoprofissionalid = :nucleoprofissionalid", ['nucleoprofissionalid' => $id]);
        if (count($select)) {
            $nucleo = new NucleoProfissional();

            $select = $select[0];

            $nucleo->id = $select->nucleoprofissionalid;
            $nucleo->descricao = $select->descricao;
            $nucleo->abreviatura = $select->abreviatura;
        }
        return $nucleo;
    }

    public function getNucleos()
    {
        $select = DB::select("SELECT * FROM {$this->model->getTable()} ORDER BY descricao");
        $nucleos = array();
        if (count($select)) {
            foreach ($select as $nucleo) {
                $nucleos[] = $this->get($nucleo->nucleoprofissionalid);
            }
        }

        return $nucleos;
    }
}