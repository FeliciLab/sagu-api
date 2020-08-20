<?php

namespace App\DAO;

use App\Model\TrabalhoDeConclusaoModalidade;
use Illuminate\Support\Facades\DB;

class TrabalhoDeConclusaoModalidadeDAO
{

    /**
     * @param $id
     * @return TrabalhoDeConclusaoModalidade
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.trabalhodeconclusaomodalidade WHERE modalidadeid = :modalidadeid', ['modalidadeid' => $id]);

        $trabalhoDeConclusaoModalidade = new TrabalhoDeConclusaoModalidade();

        if (count($select)) {
            $select = $select[0];

            $trabalhoDeConclusaoModalidade->setId($select->modalidadeid);
            $trabalhoDeConclusaoModalidade->setNome($select->nome);
        }

        return $trabalhoDeConclusaoModalidade;
    }

    public function retornaModalidades()
    {
        $select = DB::select('SELECT * FROM med.trabalhodeconclusaomodalidade');
        $modalidades = array();
        foreach ($select as $modalidade) {
            $modalidades[] = $this->get($modalidade->modalidadeid);
        }

        return $modalidades;
    }
}