<?php


namespace App\Model\ResidenciaMultiprofissional;

use App\Model\BaseModel\BaseModelSagu;

/**
 * Class UnidadeTematica
 * Aka: Modulo|Módulo
 * @package App\Model\ResidenciaMultiprofissional
 */
class UnidadeTematica extends BaseModelSagu
{
    protected $schema = 'aps';
    protected $table = 'unidadetematica';
    protected $mapFieldModel = [
        'unidadetematicaid' => 'id',
        'cargahoraria' => 'cargaHoraria',
        'frequenciaminima' => 'frequenciaMinima',
        'notamaxima' => 'notaMaxima',
        'notaminimaparaaprovacao' => 'notaMinimaAprovacao',
        'justificativanota' => 'justificativaNota'
    ];

    public $id;
    public $periodo;
    public $descricao;
    public $sumula;
    public $cargahoraria;
    public $frequenciaMinima;
    public $tipo;
    public $notaMaxima;
    public $notaMinimaAprovacao;
    public $justificativaNota;
}