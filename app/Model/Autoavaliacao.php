<?php

namespace App\Model;

class Autoavaliacao
{
    public $id;
    public $nota;
    public $avaliacao;

    /**
     * @var $residente Residente
     */
    public $residente;

    /**
     * @var $ofertaDeRodizio OfertaDeRodizio
     */
    public $ofertaDeRodizio;

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
    public function getNota()
    {
        return $this->nota;
    }

    /**
     * @param mixed $nota
     */
    public function setNota($nota)
    {
        $this->nota = $nota;
    }

    /**
     * @return mixed
     */
    public function getAvaliacao()
    {
        return $this->avaliacao;
    }

    /**
     * @param mixed $avaliacao
     */
    public function setAvaliacao($avaliacao)
    {
        $this->avaliacao = $avaliacao;
    }

    /**
     * @return Residente
     */
    public function getResidente()
    {
        return $this->residente;
    }

    /**
     * @param Residente $residente
     */
    public function setResidente(Residente $residente)
    {
        $this->residente = $residente;
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
}