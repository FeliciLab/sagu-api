<?php
namespace App\Model;

class Rodizio
{
    public $id;

    /**
     * @var $periodo Periodo
     */
    public $periodo;
    public $descricao;
    public $cargaHoraria;

    /**
     * @var $tipo RodizioTipo
     */
    public $tipo;
    public $frequenciaMinima;
    public $notaMaxima;
    public $notaMinimaParaAprovacao;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param Periodo $periodo
     */
    public function setPeriodo(Periodo $periodo)
    {
        $this->periodo = $periodo;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @param mixed $cargaHoraria
     */
    public function setCargaHoraria($cargaHoraria)
    {
        $this->cargaHoraria = $cargaHoraria;
    }

    /**
     * @param RodizioTipo $tipo
     */
    public function setTipo(RodizioTipo $tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @param mixed $frequenciaMinima
     */
    public function setFrequenciaMinima($frequenciaMinima)
    {
        $this->frequenciaMinima = $frequenciaMinima;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Periodo
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @return mixed
     */
    public function getCargaHoraria()
    {
        return $this->cargaHoraria;
    }

    /**
     * @return RodizioTipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @return mixed
     */
    public function getFrequenciaMinima()
    {
        return $this->frequenciaMinima;
    }

    /**
     * @return mixed
     */
    public function getNotaMaxima()
    {
        return $this->notaMaxima;
    }

    /**
     * @param mixed $notaMaxima
     */
    public function setNotaMaxima($notaMaxima)
    {
        $this->notaMaxima = $notaMaxima;
    }

    /**
     * @return mixed
     */
    public function getNotaMinimaParaAprovacao()
    {
        return $this->notaMinimaParaAprovacao;
    }

    /**
     * @param mixed $notaMinimaParaAprovacao
     */
    public function setNotaMinimaParaAprovacao($notaMinimaParaAprovacao)
    {
        $this->notaMinimaParaAprovacao = $notaMinimaParaAprovacao;
    }



}