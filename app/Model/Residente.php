<?php

namespace App\Model;

class Residente
{
    public $id;

    /**
     * @var $person Person
     */
    public $person;

    /**
     * @var $especialidade Especialidade
     */
    public $especialidade;

    /**
     * @var $categoriaProfissional CategoriaProfissional
     */
    public $categoriaProfissional;

    public $inicio;

    public $fimPrevisto;

    /**
     * @var $turma Turma
     */
    public $turma;

    public $ofertasDeRodizio;

    /**
     * @var $trabalhoDeConclusao TrabalhoDeConclusao
     */
    public $trabalhoDeConclusao;

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
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * @param mixed $inicio
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;
    }

    /**
     * @return mixed
     */
    public function getFimPrevisto()
    {
        return $this->fimPrevisto;
    }

    /**
     * @param mixed $fimPrevisto
     */
    public function setFimPrevisto($fimPrevisto)
    {
        $this->fimPrevisto = $fimPrevisto;
    }

    /**
     * @return Turma
     */
    public function getTurma()
    {
        return $this->turma;
    }

    /**
     * @param Turma $turma
     */
    public function setTurma(Turma $turma)
    {
        $this->turma = $turma;
    }

    /**
     * @return mixed
     */
    public function getOfertasDeRodizio()
    {
        return $this->ofertasDeRodizio;
    }

    /**
     * @param mixed $ofertasDeRodizio
     */
    public function setOfertasDeRodizio($ofertasDeRodizio)
    {
        $this->ofertasDeRodizio = $ofertasDeRodizio;
    }

    /**
     * @return TrabalhoDeConclusao
     */
    public function getTrabalhoDeConclusao()
    {
        return $this->trabalhoDeConclusao;
    }

    /**
     * @param TrabalhoDeConclusao $trabalhoDeConclusao
     */
    public function setTrabalhoDeConclusao($trabalhoDeConclusao)
    {
        $this->trabalhoDeConclusao = $trabalhoDeConclusao;
    }
}