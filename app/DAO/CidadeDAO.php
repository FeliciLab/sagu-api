<?php

namespace App\DAO;

use App\Model\Cidade;
use Illuminate\Support\Facades\DB;

class CidadeDAO
{

    /**
     * @param $id
     * @return Cidade
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM bascity WHERE cityid = :cityid', ['cityid' => $id]);

        $cidade = new Cidade();

        if (count($select)) {
            $select = $select[0];

            $cidade->setId($select->cityid);
            $cidade->setNome($select->name);


            $estadoDao = new EstadoDAO();
            $cidade->setEstado($estadoDao->get($select->stateid));

        }

        return $cidade;
    }

    public function getPorEstado($estadoId)
    {
        $select = DB::select('SELECT * FROM bascity WHERE stateid = :stateid ORDER BY name', ['stateid' => $estadoId]);

        $cidades = array();

        if (count($select)) {
            foreach ($select as $cidade) {
                $cidades[] = $this->get($cidade->cityid);
            }
        }

        return $cidades;
    }
}