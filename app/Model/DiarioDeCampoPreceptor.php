<?php

namespace App\Model;

class DiarioDeCampoPreceptor
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

    /**
     * @var $ofertaDeRodizio OfertaDeRodizio
     */
    public $ofertaDeRodizio;

    /**
     * @var $preceptor Preceptor
     */
    public $preceptor;

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
}