<?php


namespace App\Model\ResidenciaMultiprofissional;


use App\Model\BaseModel\BaseModelSagu;

class OfertaUnidadeTematica extends BaseModelSagu
{
    protected $table = 'ofertaunidadetematica';
    protected $schema = 'aps';
    protected $mapFieldModel = [
        'ofertaunidadetematicaid' => 'id',
        'unidadetematicaid' => 'unidadetematica',
        'turmaid' => 'turmaId',
        'encerradopor' => 'encerradoPor',
        'acompanhamentoencontro' => 'acompanhamentoEncontro'
    ];
    protected $camposComposicao = [
        'turma' => [],
        'unidadeTematica' => []
    ];

    public $id;
    public $unidadeTematicaId;
    public $turmaId;
    public $inicio;
    public $fim;
    public $encerramento;
    public $encerradoPor;
    public $acompanhamentoEncontro;
    public $observacao;

    public $turma;
    public $unidadeTematica;

    /**
     * @param mixed $turma
     */
    public function setTurma($turma)
    {
        $this->setModeloComposto(Turma::class, 'turma', $turma);
    }

    /**
     * @param mixed $unidadeTematica
     */
    public function setUnidadeTematica($unidadeTematica)
    {
        $this->setModeloComposto(UnidadeTematica::class, 'unidadeTematica', $unidadeTematica);
        $this->unidadeTematica = $unidadeTematica;
    }


}