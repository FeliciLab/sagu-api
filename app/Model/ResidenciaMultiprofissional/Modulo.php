<?php


namespace App\Model\ResidenciaMultiprofissional;


class Modulo extends BaseModelSagu
{
    /**
     * @var string
     */
    public $nome;

    /**
     * @var integer
     */
    public $id;

    protected $mapFieldModel = [
        'moduloid' => 'id'
    ];
}