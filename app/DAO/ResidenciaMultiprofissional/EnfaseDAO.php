<?php

namespace App\DAO\ResidenciaMultiprofissional;

use App\Model\ResidenciaMultiprofissional\Enfase;
use Illuminate\Support\Facades\DB;

class EnfaseDAO
{
    public function get($id)
    {
        $select = DB::select('SELECT * FROM res.enfase WHERE enfaseid = :enfaseid', ['enfaseid' => $id]);
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
        $select = DB::select('SELECT * FROM res.enfase ORDER BY descricao');
        $enfases = array();
        if (count($select)) {
            foreach ($select as $enfase) {
                $enfases[] = $this->get($enfase->enfaseid);
            }
        }

        return $enfases;
    }
}