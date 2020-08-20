<?php

namespace App\DAO;

use App\Model\Atividade;
use Illuminate\Support\Facades\DB;

class AtividadeDAO
{

    /**
     * @param $id
     * @return Atividade
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.tema WHERE temaid = :temaid', ['temaid' => $id]);

        $atividade = new Atividade();

        if (count($select)) {
            $select = $select[0];

            $atividade->setId($select->temaid);
            $atividade->setDescricao($select->descricao);
        }

        return $atividade;
    }
}