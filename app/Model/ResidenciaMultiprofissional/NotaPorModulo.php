<?php


namespace App\Model\ResidenciaMultiprofissional;


use App\Model\BaseModel\BaseModelSagu;
use App\Model\Residente;

class NotaPorModulo extends BaseModelSagu
{
    public $id;
    public $residenteId;
    public $moduloId;
    public $semestre;
    public $notaAssiduidade;
    public $notaAtividadeProduto;
    public $notaAvaliacaoDesempenho;

    /**
     * @var Residente
     */
    public $residente;

    /**
     * @var Modulo
     */
    public $modulo;

    protected $mapFieldModel = [
        'notapormoduloid' => 'id',
        'residenteid' => 'residenteId',
        'moduloid' => 'moduloId',
        'notadeassiduidade' => 'notaAssiduidade',
        'notadeatividadedeproduto' => 'notaAtividadeProduto',
        'notadeavaliacaodedesempenho' => 'notaAvaliacaoDesempenho'
    ];

    protected $camposComposicao = [
        'residente' => [],
        'modulo' => []
    ];

    public function setResidente($residente)
    {
        $this->setModeloComposto(Residente::class, 'residente', $residente);
    }
}