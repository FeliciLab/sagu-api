<?php

namespace App\Model;

class Indicador
{
    public $id;

    /**
     * @var $especialidade Especialidade
     */
    public $especialidade;


    /**
     * @var $periodo Periodo
     */
    public $periodo;

    public $descricao;

    const PERIODICIDADE_SEMANA = 'S';

    public $periodicidade;

    public $meta;

    public $situacao;

    const SITUACAO_ATIVADO = 'A';
    const SITUACAO_DESATIVADO = 'D';

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
     * @return Especialidade
     */
    public function getEspecialidade()
    {
        return $this->especialidade;
    }

    /**
     * @param Especialidade $especialidade
     */
    public function setEspecialidade(Especialidade $especialidade)
    {
        $this->especialidade = $especialidade;
    }

    /**
     * @return Periodo
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * @param Periodo $periodo
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return mixed
     */
    public function getPeriodicidade()
    {
        return $this->periodicidade;
    }

    /**
     * @param mixed $periodicidade
     */
    public function setPeriodicidade($periodicidade)
    {
        $this->periodicidade = $periodicidade;
    }

    /**
     * @return mixed
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param mixed $meta
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;
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



}