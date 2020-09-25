<?php


namespace App\Model\ResidenciaMultiprofissional;


use App\Model\BaseModel\BaseModelSagu;

class NotaResidente extends BaseModelSagu
{
    const TIPO_NOTAS = ['final', 'pratica', 'teorica'];
    const PESO_NOTA_PRATICA = 7;
    const PESO_NOTA_TEORICA = 3;

    protected $table = 'notadoresidentenaofertadeunidadetematica';
    protected $schema = 'aps';
    protected $mapFieldModel = [
        'notadoresidentenaofertadeunidadetematicaid' => 'id',
        'residenteid' => 'residenteId',
        'ofertaunidadetematicaid' => 'ofertaUnidadeTematicaId',
        'notapratica' => 'notaPratica',
        'notateorica' => 'notaTeorica'
    ];
    protected $camposComposicao = [

    ];

    public $id;
    public $residenteId;
    public $ofertaUnidadeTematicaId;
    public $nota;
    public $notaPratica;
    public $notaTeorica;

    /**
     * @var OfertaModulo
     */
    public $ofertaUnidadeTematica;
    public $residente;


}