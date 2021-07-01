<?php


namespace App\Model\ResidenciaMultiprofissional;


use App\Model\BaseModel\BaseModelSagu;

class OfertaModuloTiposCargaHoraria extends BaseModelSagu
{

    protected $schema = 'res';
    protected $table = 'ofertadeunidadetematicatipos';
    
    public $id;

    public $tipo;

    public $cargahoraria;


    /**
     * Mapemento entre os cmapos da tabela e as variáveis do objeto.
     * @var string[]
     */
    protected $mapFieldModel = [
        'ofertadeunidadetematicaid' => 'id'
    ];
}