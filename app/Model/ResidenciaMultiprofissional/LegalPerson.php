<?php


namespace App\Model\ResidenciaMultiprofissional;


use App\Model\BaseModel\BaseModelSagu;

class LegalPerson extends BaseModelSagu
{
    protected $schema = 'public';
    protected $table = 'baslegalperson';

    public $name;
    public $cnpj;
    public $ispublic;
}