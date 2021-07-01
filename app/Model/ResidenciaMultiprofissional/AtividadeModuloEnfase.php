<?php

namespace App\Model\ResidenciaMultiprofissional;

class AtividadeModuloEnfase
{
    private $table = 'res.enfasedaunidadetematica';

    public $atividademoduloid;
    public $enfaseid;

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }
}