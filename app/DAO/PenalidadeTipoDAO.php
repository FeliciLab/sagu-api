<?php

namespace App\DAO;

use App\Model\PenalidadeTipo;
use Illuminate\Support\Facades\DB;

class PenalidadeTipoDAO
{

    /**
     * @param $id
     * @return PenalidadeTipo
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.tipodepenalidade WHERE tipopenalidadeid = :tipopenalidadeid', ['tipopenalidadeid' => $id]);

        $penalidadeTipo = new PenalidadeTipo();

        if (count($select)) {
            $select = $select[0];

            $penalidadeTipo->setId($select->tipopenalidadeid);
            $penalidadeTipo->setDescricao($select->descricao);
        }

        return $penalidadeTipo;
    }
}