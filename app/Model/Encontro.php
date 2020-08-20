<?php

namespace App\Model;

class Encontro
{
    public $id;

    /**
     * @var $atividade Atividade
     */
    public $atividade;

    /**
     * @var $ofertaDeRodizio OfertaDeRodizio
     */
    public $ofertaDeRodizio;

    /**
     * @var $inicio \DateTime
     */
    public $inicio;

    /**
     * @var $fim \DateTime
     */
    public $fim;

    public $cargaHoraria;
    public $conteudoMinistrado;

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
     * @return Atividade
     */
    public function getAtividade()
    {
        return $this->atividade;
    }

    /**
     * @param Atividade $atividade
     */
    public function setAtividade(Atividade $atividade)
    {
        $this->atividade = $atividade;
    }

    /**
     * @return OfertaDeRodizio
     */
    public function getOfertaDeRodizio()
    {
        return $this->ofertaDeRodizio;
    }

    /**
     * @param OfertaDeRodizio $ofertaDeRodizio
     */
    public function setOfertaDeRodizio(OfertaDeRodizio $ofertaDeRodizio)
    {
        $this->ofertaDeRodizio = $ofertaDeRodizio;
    }

    public function getInicio()
    {
        return $this->inicio;
    }

    public function setInicio($inicio)
    {
        $this->inicio = $inicio;
    }


    public function getFim()
    {
        return $this->fim;
    }


    public function setFim($fim)
    {
        $this->fim = $fim;
    }

    /**
     * @return mixed
     */
    public function getCargaHoraria()
    {
        return $this->cargaHoraria;
    }

    /**
     * @param mixed $cargaHoraria
     */
    public function setCargaHoraria($cargaHoraria)
    {
        $this->cargaHoraria = $cargaHoraria;
    }

    /**
     * @return mixed
     */
    public function getConteudoMinistrado()
    {
        return $this->conteudoMinistrado;
    }

    /**
     * @param mixed $conteudoMinistrado
     */
    public function setConteudoMinistrado($conteudoMinistrado)
    {
        $this->conteudoMinistrado = $conteudoMinistrado;
    }
}