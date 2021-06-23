<?php

namespace App\Model\ResidenciaMultiprofissional;

use App\Model\BaseModel\BaseModelSagu;

class CargaHorariaComplementar extends BaseModelSagu
{
    protected $schema = 'res';
    protected $table = 'cargahorariacomplementar';

    public $id;
    public $tipoCargaHorariaComplementar;
    public $residente;
    public $oferta;
    public $cargaHoraria;
    public $justificativa;
    public $tipoCargaHoraria;
}