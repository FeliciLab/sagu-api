<?php

namespace App\Model;


class Frequencia
{
    /**
     * @var $encontro Encontro
     */
    public $encontro;

    /**
     * @var $residente Residente
     */
    public $residente;

    public $presenca;
    public $justificativa;

    const PRESENTE = 'P';
    const AUSENTE = 'A';
    const JUSTIFICADA = 'J';

    /**
     * @return Encontro
     */
    public function getEncontro()
    {
        return $this->encontro;
    }

    /**
     * @param Encontro $encontro
     */
    public function setEncontro(Encontro $encontro)
    {
        $this->encontro = $encontro;
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
     * @return mixed
     */
    public function getPresenca()
    {
        return $this->presenca;
    }

    /**
     * @param mixed $presenca
     */
    public function setPresenca($presenca)
    {
        $this->presenca = $presenca;
    }

    /**
     * @return mixed
     */
    public function getJustificativa()
    {
        return $this->justificativa;
    }

    /**
     * @param mixed $justificativa
     */
    public function setJustificativa($justificativa)
    {
        $this->justificativa = $justificativa;
    }
}