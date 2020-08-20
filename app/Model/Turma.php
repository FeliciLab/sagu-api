<?php

namespace App\Model;

use Faker\Provider\DateTime;

class Turma
{
    public $id;
    public $codigoTurma;

    /**
     * @var $especialidade Especialidade
     */
    public $especialidade;

    /**
     * @var $categoriaProfissional CategoriaProfissional
     */
    public $categoriaProfissional;

    public $descricao;

    public $dataInicio;

    public $dataFim;

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
    public function getCodigoTurma()
    {
        return $this->codigoTurma;
    }

    /**
     * @param mixed $codigoTurma
     */
    public function setCodigoTurma($codigoTurma)
    {
        $this->codigoTurma = $codigoTurma;
    }

    /**
     * @return Especialidade
     */
    public function getEspecialidade()
    {
        return $this->especialidade;
    }

    /**
     * @param Especialidade $especialidade
     */
    public function setEspecialidade(Especialidade $especialidade)
    {
        $this->especialidade = $especialidade;
    }

    /**
     * @return CategoriaProfissional
     */
    public function getCategoriaProfissional()
    {
        return $this->categoriaProfissional;
    }

    /**
     * @param CategoriaProfissional $categoriaProfissional
     */
    public function setCategoriaProfissional(CategoriaProfissional $categoriaProfissional)
    {
        $this->categoriaProfissional = $categoriaProfissional;
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
    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    /**
     * @param mixed $dataInicio
     */
    public function setDataInicio($dataInicio)
    {
        $data = new \DateTime($dataInicio);
        $this->dataInicio = $data->format('d/m/Y');
    }

    /**
     * @return mixed
     */
    public function getDataFim()
    {
        return $this->dataFim;
    }

    /**
     * @param mixed $dataFim
     */
    public function setDataFim($dataFim)
    {
        $data = new \DateTime($dataFim);
        $this->dataFim = $data->format('d/m/Y');
    }
}