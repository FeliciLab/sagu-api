<?php

namespace App\Model\ResidenciaMultiprofissional;

use App\Model\BaseModel\BaseModelSagu;

class Enfase extends BaseModelSagu
{
    protected $schema = 'res';
    protected $table = 'enfase';

    public $id;
    public $descricao;
    public $abreviatura;

    protected $mapFieldModel = [
        'enfaseid' => 'id'
    ];
}