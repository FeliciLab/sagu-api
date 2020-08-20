<?php

namespace App\Model;

class NotaDoResidenteNaOfertaDeRodizioPreceptor
{
    public $id;

    /**
     * @var $preceptor Preceptor
     */
    public $preceptor;

    /**
     * @var $residente Residente
     */
    public $residente;


    /**
     * @var $ofertaDeRodizio OfertaDeRodizio
     */
    public $ofertaDeRodizio;

    public $nota;

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
     * @return Preceptor
     */
    public function getPreceptor()
    {
        return $this->preceptor;
    }

    /**
     * @param Preceptor $preceptor
     */
    public function setPreceptor(Preceptor $preceptor)
    {
        $this->preceptor = $preceptor;
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


}