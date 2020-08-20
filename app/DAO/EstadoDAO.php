<?php

namespace App\DAO;

use App\Model\Estado;
use Illuminate\Support\Facades\DB;

class EstadoDAO
{

    /**
     * @param $id
     * @return Estado
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM basstate WHERE stateid = :stateid', ['stateid' => $id]);

        $estado = new Estado();

        if (count($select)) {
            $select = $select[0];

            $estado->setId($select->stateid);
            $estado->setNome($select->name);
        }

        return $estado;
    }

    public function getEstados()
    {
        $select = DB::select('SELECT * FROM basstate ORDER BY name');

        $estados = array();

        if (count($select)) {
            foreach ($select as $estado) {
                $estados[] = $this->get($estado->stateid);
            }
        }

        return $estados;
    }
}