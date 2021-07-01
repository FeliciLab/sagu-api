<?php

namespace App\Model\ResidenciaMultiprofissional;

use App\Model\BaseModel\BaseModelSagu;
use App\Model\Person;

class Supervisor extends BaseModelSagu
{
    public $id;

    /**
     * @var $person Person
     */
    public $person;

    protected $mapFieldModel = [
        'supervisorid' => 'id'
    ];

    protected $camposComposicao = [
        'person' => []
    ];

    /**
     * @param array
     */
    public function setPerson($dados)
    {
        $this->setModeloComposto(Person::class, 'person', $dados);
    }

    public function getPerson()
    {
        return $this->person;
    }

    public function getId()
    {
        return $this->id;
    }
}