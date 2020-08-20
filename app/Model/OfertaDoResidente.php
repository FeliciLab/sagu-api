<?php
namespace App\Model;


class OfertaDoResidente
{
    public $id;

    /**
     * @var $residente Residente
     */
    public $residente;


    /**
     * @var $ofertaDeRodizio OfertaDeRodizio
     */
    public $ofertaDeRodizio;

    public $nota;

    public $frequencia;


    /**
     * @var $autoavaliacao Autoavaliacao
     */
    public $autoavaliacao;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param Residente $residente
     */
    public function setResidente(Residente $residente)
    {
        $this->residente = $residente;
    }

    /**
     * @param OfertaDeRodizio $ofertaDeRodizio
     */
    public function setOfertaDeRodizio(OfertaDeRodizio $ofertaDeRodizio)
    {
        $this->ofertaDeRodizio = $ofertaDeRodizio;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Residente
     */
    public function getResidente()
    {
        return $this->residente;
    }

    /**
     * @return OfertaDeRodizio
     */
    public function getOfertaDeRodizio()
    {
        return $this->ofertaDeRodizio;
    }

    public function getNota()
    {
        return $this->nota;
    }

    public function setNota($nota)
    {
        $this->nota = $nota;
    }

    /**
     * @return mixed
     */
    public function getFrequencia()
    {
        return $this->frequencia;
    }

    /**
     * @param mixed $frequencia
     */
    public function setFrequencia($frequencia)
    {
        $this->frequencia = $frequencia;
    }

    /**
     * @return Autoavaliacao
     */
    public function getAutoavaliacao()
    {
        return $this->autoavaliacao;
    }

    /**
     * @param Autoavaliacao $autoavaliacao
     */
    public function setAutoavaliacao(Autoavaliacao $autoavaliacao)
    {
        $this->autoavaliacao = $autoavaliacao;
    }
}