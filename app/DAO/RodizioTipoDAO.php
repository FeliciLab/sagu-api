<?php

namespace App\DAO;

use App\Model\RodizioTipo;
use Illuminate\Support\Facades\DB;

class RodizioTipoDAO
{

    /**
     * @param $id
     * @return RodizioTipo
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.tipodeunidadetematica WHERE tipodeunidadetematicaid = :tipodeunidadetematicaid', ['tipodeunidadetematicaid' => $id]);

        $rodizioTipo = new RodizioTipo();

        if (count($select)) {
            $select = $select[0];

            $rodizioTipo->setId($select->tipodeunidadetematicaid);
            $rodizioTipo->setDescricao($select->descricao);
        }

        return $rodizioTipo;
    }
}