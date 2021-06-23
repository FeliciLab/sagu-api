<?php

namespace App\Model\ResidenciaMultiprofissional;

use App\Model\BaseModel\BaseModelSagu;

class CargaHorariaComplementarTipo extends BaseModelSagu
{
    protected $schema = 'res';
    protected $table = 'tipodecargahorariacomplementar';

    public $id;
    public $descricao;
}