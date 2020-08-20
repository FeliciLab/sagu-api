<?php

namespace App\DAO;

use App\Model\Periodo;
use Illuminate\Support\Facades\DB;

class PeriodoDAO
{

    /**
     * @param $id
     * @return Periodo
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.periodo WHERE periodo = :periodo', ['periodo' => $id]);

        $periodo = new Periodo();

        if (count($select)) {
            $select = $select[0];

            $periodo->setId($select->periodoid);
            $periodo->setPeriodo($select->periodo);
            $periodo->setDescricao($select->descricao);
            $periodo->setAnosDeDuracao($select->anosdeduracao);
        }

        return $periodo;
    }

    public function getPorId($id)
    {
        $select = DB::select('SELECT * FROM med.periodo WHERE periodoid = :periodoid', ['periodoid' => $id]);

        $periodo = new Periodo();

        if (count($select)) {
            $select = $select[0];

            $periodo->setId($select->periodoid);
            $periodo->setPeriodo($select->periodo);
            $periodo->setDescricao($select->descricao);
            $periodo->setAnosDeDuracao($select->anosdeduracao);
        }

        return $periodo;
    }
}