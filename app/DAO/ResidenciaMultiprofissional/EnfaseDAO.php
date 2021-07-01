<?php

namespace App\DAO\ResidenciaMultiprofissional;

use App\Model\ResidenciaMultiprofissional\Enfase;
use Illuminate\Support\Facades\DB;

class EnfaseDAO
{
    private $model;

    public function __construct()
    {
        $this->model = new Enfase();
    }

    public function get($id)
    {
        $select = DB::select("SELECT * FROM {$this->model->getTable()} WHERE enfaseid = :enfaseid", ['enfaseid' => $id]);
        if (count($select)) {
            $enfase = new Enfase();

            $select = $select[0];

            $enfase->id = $select->enfaseid;
            $enfase->descricao = $select->descricao;
            $enfase->abreviatura = $select->abreviatura;
        }
        return $enfase;
    }

    public function getEnfases()
    {
        $select = DB::select("SELECT * FROM {$this->model->getTable()} ORDER BY descricao");
        $enfases = array();
        if (count($select)) {
            foreach ($select as $enfase) {
                $enfases[] = $this->get($enfase->enfaseid);
            }
        }

        return $enfases;
    }
}