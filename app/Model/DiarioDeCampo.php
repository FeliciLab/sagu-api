<?php

namespace App\Model;

class DiarioDeCampo
{
    public $id;

    /**
     * @var $inicio \DateTime
     */
    public $inicio;

    /**
     * @var $fim \DateTime
     */
    public $fim;

    public $cargaHoraria;
    public $conteudoAbordado;
    public $ministrante;

    /**
     * @var $ofertaDeRodizio OfertaDeRodizio
     */
    public $ofertaDeRodizio;

    /**
     * @var $residente Residente
     */
    public $residente;

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
     * @return \DateTime
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * @param \DateTime $inicio
     */
    public function setInicio(\DateTime $inicio)
    {
        $this->inicio = $inicio->format('d/m/Y H:i');
    }

    /**
     * @return \DateTime
     */
    public function getFim()
    {
        return $this->fim;
    }

    /**
     * @param \DateTime $fim
     */
    public function setFim(\DateTime $fim)
    {
        $this->fim = $fim->format('d/m/Y H:i');
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
    public function getConteudoAbordado()
    {
        return $this->conteudoAbordado;
    }

    /**
     * @param mixed $conteudoAbordado
     */
    public function setConteudoAbordado($conteudoAbordado)
    {
        $this->conteudoAbordado = $conteudoAbordado;
    }

    /**
     * @return mixed
     */
    public function getMinistrante()
    {
        return $this->ministrante;
    }

    /**
     * @param mixed $ministrante
     */
    public function setMinistrante($ministrante)
    {
        $this->ministrante = $ministrante;
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
}