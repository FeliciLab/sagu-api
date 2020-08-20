<?php

namespace App\Model;


class Penalidade
{
    public $id;

    /**
     * @var $tipo PenalidadeTipo
     */
    public $tipo;

    /**
     * @var $data \DateTime
     */
    public $data;

    /**
     * @var $hora \DateTime
     */
    public $hora;
    public $observacao;

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
     * @return PenalidadeTipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param PenalidadeTipo $tipo
     */
    public function setTipo(PenalidadeTipo $tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param \DateTime $data
     */
    public function setData(\DateTime $data)
    {
        $this->data = $data->format('d/m/Y');
    }

    /**
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * @param \DateTime $hora
     */
    public function setHora(\DateTime $hora)
    {
        $this->hora = $hora->format('H:i');
    }

    /**
     * @return mixed
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * @param mixed $observacao
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
    }
}