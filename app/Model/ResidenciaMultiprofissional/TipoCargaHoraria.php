<?php


namespace App\Model\ResidenciaMultiprofissional;


use App\Model\BaseModel\BaseModelSagu;

class TipoCargaHoraria extends BaseModelSagu
{
    protected $schema = 'res';
    protected $table = 'tipodecargahorariacomplementar';
    protected $mapFieldModel = [
        'tipodecargahorariacomplementarid' => 'id'
    ];

    public $username;
    public $datetime;
    public $id;
    public $descricao;
}