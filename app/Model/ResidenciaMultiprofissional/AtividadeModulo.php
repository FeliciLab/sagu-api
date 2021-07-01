<?php

namespace App\Model\ResidenciaMultiprofissional;

class AtividadeModulo
{
    private $table = 'res.unidadetematica';

    public $id;
    public $periodo;
    public $descricao;
    public $sumula;
    public $cargaHoraria;
    public $modulo;

    public $enfases;
    public $nucleosprofissionais;

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }
}