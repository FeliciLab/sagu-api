<?php

namespace App\Model\ResidenciaMultiprofissional;

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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param Person $person
     */
    public function setPerson(Person $person)
    {
        $this->person = $person;
    }
}