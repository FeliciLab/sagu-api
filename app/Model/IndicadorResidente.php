<?php

namespace App\Model;

class IndicadorResidente
{
    public $id;

    /**
     * @var $indicador Indicador
     */
    public $indicador;

    /**
     * @var $residente Residente
     */
    public $residente;

    public $periodoInicio;
    public $periodoFim;

    public $periodoInicioFormatado;
    public $periodoFimFormatado;

    public $quantidade;

    /**
     * @var $preceptor Preceptor
     */
    public $preceptor;

    public $justificativa;

    const SITUACAO_AGUARDANDO_AVALIACAO = '0';
    const SITUACAO_AVALIACAO_VALIDA = '1';
    const SITUACAO_AVALIACAO_INVALIDA = '2';
    public $situacao;

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
     * @return Indicador
     */
    public function getIndicador()
    {
        return $this->indicador;
    }

    /**
     * @param Indicador $indicador
     */
    public function setIndicador(Indicador $indicador)
    {
        $this->indicador = $indicador;
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
    public function getPeriodoInicio()
    {
        return $this->periodoInicio;
    }

    /**
     * @param mixed $periodoInicio
     */
    public function setPeriodoInicio($periodoInicio)
    {
        $this->periodoInicio = $periodoInicio;
    }

    /**
     * @return mixed
     */
    public function getPeriodoFim()
    {
        return $this->periodoFim;
    }

    /**
     * @param mixed $periodoFim
     */
    public function setPeriodoFim($periodoFim)
    {
        $this->periodoFim = $periodoFim;
    }

    /**
     * @return mixed
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * @param mixed $quantidade
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
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

    /**
     * @return mixed
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * @param mixed $situacao
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
    }

    /**
     * @return mixed
     */
    public function getPeriodoInicioFormatado()
    {
        return $this->periodoInicioFormatado;
    }

    /**
     * @param mixed $periodoInicioFormatado
     */
    public function setPeriodoInicioFormatado($periodoInicioFormatado)
    {
        $this->periodoInicioFormatado = $periodoInicioFormatado;
    }

    /**
     * @return mixed
     */
    public function getPeriodoFimFormatado()
    {
        return $this->periodoFimFormatado;
    }

    /**
     * @param mixed $periodoFimFormatado
     */
    public function setPeriodoFimFormatado($periodoFimFormatado)
    {
        $this->periodoFimFormatado = $periodoFimFormatado;
    }
}