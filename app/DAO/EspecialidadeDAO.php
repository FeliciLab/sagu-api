<?php

namespace App\DAO;

use App\Model\Especialidade;
use Illuminate\Support\Facades\DB;

class EspecialidadeDAO
{

    /**
     * @param $id
     * @return Especialidade
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.enfase WHERE enfaseid = :enfaseid', ['enfaseid' => $id]);

        $especialidade = new Especialidade();

        if (count($select)) {
            $select = $select[0];

            $especialidade->setId($select->enfaseid);
            $especialidade->setDescricao($select->descricao);
            $especialidade->setAbreviatura($select->abreviatura);
        }

        return $especialidade;
    }
}