<?php

namespace App\DAO;

use App\Model\CategoriaProfissional;
use Illuminate\Support\Facades\DB;

class CategoriaProfissionalDAO
{

    /**
     * @param $id
     * @return CategoriaProfissional
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.nucleoprofissional WHERE nucleoprofissionalid = :nucleoprofissionalid', ['nucleoprofissionalid' => $id]);

        $categoriaProfissional = new CategoriaProfissional();

        if (count($select)) {
            $select = $select[0];

            $categoriaProfissional->setId($select->nucleoprofissionalid);
            $categoriaProfissional->setDescricao($select->descricao);
            $categoriaProfissional->setAbreviatura($select->abreviatura);
        }

        return $categoriaProfissional;
    }
}