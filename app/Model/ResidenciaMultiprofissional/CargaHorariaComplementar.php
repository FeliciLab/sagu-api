<?php

namespace App\Model\ResidenciaMultiprofissional;

use App\Model\BaseModel\BaseModelSagu;
use App\Model\ResidenciaMultiprofissional\TipoCargaHoraria;

class CargaHorariaComplementar extends BaseModelSagu
{
    protected $table = 'cargahorariacomplementar';
    protected $schema = 'res';
    protected $mapFieldModel = [
        'cargahorariacomplementar' => 'id',
        'tipocargahorariaid' => 'tipoCargaHorariaId',
        'cargahoraria' => 'cargaHoraria'
    ];

    protected $camposComposicao = [
        'tipoCargaHoraria' => []
    ];

    public $username;
    public $id;
    public $tipoCargaHorariaId;
    public $cargaHoraria;

    public $tipoCargaHoraria;

    public function setTipoCargaHoraria($tipo)
    {
        $this->setModeloComposto(TipoCargaHoraria::class, 'tipoCargaHoraria', $tipo);
    }
}
