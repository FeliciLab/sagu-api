<?php

namespace App\Model;


class Periodo
{
    public $id;
    public $periodo;
    public $descricao;
    public $anosDeDuracao;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $periodo
     */
    public function setPeriodo($periodo)
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
     * @param mixed $anosDeDuracao
     */
    public function setAnosDeDuracao($anosDeDuracao)
    {
        $this->anosDeDuracao = $anosDeDuracao;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
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
    public function getAnosDeDuracao()
    {
        return $this->anosDeDuracao;
    }

}