<?php

namespace App\Model\ResidenciaMultiprofissional;

use App\Model\BaseModel\BaseModelSagu;

class OfertaModuloFalta extends BaseModelSagu
{
    protected $schema = 'res';
    protected $table = 'ofertadeunidadetematicafaltadoresidente';

    public $id;
    public $residenteId;
    public $ofertaId;
    public $tipo;
    public $falta;
    public $observacao;
}