<?php

namespace App\Model\ResidenciaMultiprofissional;

use App\Model\BaseModel\BaseModelSagu;

class OfertaModuloNota extends BaseModelSagu
{
    protected $schema = 'res';
    protected $table = 'ofertadeunidadetematicanotas';

    public $id;
    public $residenteId;
    public $ofertaId;
    public $semestre;
    public $notaDeAtividadeDeProduto;
    public $notaDeAvaliacaoDeDesempenho;
}