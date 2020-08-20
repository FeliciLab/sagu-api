<?php

namespace App\Model;

class TrabalhoDeConclusao
{
    public $id;
    public $titulo;
    public $tema;

    /**
     * @var $orientador Person
     */
    public $orientador;
    public $apto;
    public $nota;

    /**
     * @var $residente Residente
     */
    public $residente;

    /**
     * @var $modalidade TrabalhoDeConclusaoModalidade
     */
    public $modalidade;

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
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param mixed $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * @return mixed
     */
    public function getTema()
    {
        return $this->tema;
    }

    /**
     * @param mixed $tema
     */
    public function setTema($tema)
    {
        $this->tema = $tema;
    }

    /**
     * @return TrabalhoDeConclusaoModalidade
     */
    public function getModalidade()
    {
        return $this->modalidade;
    }

    /**
     * @param TrabalhoDeConclusaoModalidade $modalidade
     */
    public function setModalidade(TrabalhoDeConclusaoModalidade $modalidade)
    {
        $this->modalidade = $modalidade;
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
     * @return Person
     */
    public function getOrientador()
    {
        return $this->orientador;
    }

    /**
     * @param Person $orientador
     */
    public function setOrientador($orientador)
    {
        $this->orientador = $orientador;
    }

    /**
     * @return mixed
     */
    public function getApto()
    {
        return $this->apto;
    }

    public function getSituacao($apto)
    {
        if (!is_null($apto)) {
            if ($apto) {
                return 'APTO';
            } else {
                return 'INAPTO';
            }
        }

        return null;
    }

    /**
     * @param mixed $apto
     */
    public function setApto($apto)
    {
        $this->apto = $apto;
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