<?php

namespace App\Model\ResidenciaMultiprofissional;

use App\Model\BaseModel\BaseModelSagu;

class NucleoProfissional extends BaseModelSagu
{
    protected $schema = 'res';
    protected $table = 'nucleoprofissional';

    public $id;
    public $descricao;
    public $abreviatura;

    protected $mapFieldModel = [
        'nucleoprofissionalid' => 'id'
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
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return mixed
     */
    public function getAbreviatura()
    {
        return $this->abreviatura;
    }

    /**
     * @param mixed $abreviatura
     */
    public function setAbreviatura($abreviatura)
    {
        $this->abreviatura = $abreviatura;
    }
}