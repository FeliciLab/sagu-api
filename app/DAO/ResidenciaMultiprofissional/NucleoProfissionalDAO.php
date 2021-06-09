<?php

namespace App\DAO\ResidenciaMultiprofissional;

use App\Model\ResidenciaMultiprofissional\NucleoProfissional;
use Illuminate\Support\Facades\DB;

class NucleoProfissionalDAO
{
    public function get($id)
    {
        $select = DB::select('SELECT * FROM res.nucleoprofissional WHERE nucleoprofissionalid = :nucleoprofissionalid', ['nucleoprofissionalid' => $id]);
        if (count($select)) {
            $nucleo = new NucleoProfissional();

            $select = $select[0];

            $nucleo->id = $select->nucleoprofissionalid;
            $nucleo->descricao = $select->descricao;
            $nucleo->abreviatura = $select->abreviatura;
        }
        return $nucleo;
    }

    public function getNucleos()
    {
        $select = DB::select('SELECT * FROM res.nucleoprofissional ORDER BY descricao');
        $nucleos = array();
        if (count($select)) {
            foreach ($select as $nucleo) {
                $nucleos[] = $this->get($nucleo->nucleoprofissionalid);
            }
        }

        return $nucleos;
    }
}