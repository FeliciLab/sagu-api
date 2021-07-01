<?php


namespace App\Model\ResidenciaMultiprofissional;


use App\Model\BaseModel\BaseModelSagu;

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