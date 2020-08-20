<?php

namespace App\Model;

class OfertaDeRodizio
{
    public $id;

    /**
     * @var $rodizio Rodizio
     */
    public $rodizio;

    public $inicio;

    /**
     * @var $inicioObject \DateTime
     */
    public $inicioObject;

    public $fim;

    /**
     * @var $fimObject \DateTime
     */
    public $fimObject;

    /**
     * @var $turma Turma
     */
    public $turma;

    public $atividades = [];

    /**
     * @var $encerramento \DateTime
     */
    public $encerramento;

    public $acompanhamentoEncontro;

    const ACOMPANHAMENTO_ENCONTRO_SIMPLES = 'S';
    const ACOMPANHAMENTO_ENCONTRO_DETALHADO = 'D';

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param Rodizio $rodizio
     */
    public function setRodizio(Rodizio $rodizio)
    {
        $this->rodizio = $rodizio;
    }

    /**
     * @param Turma $turma
     */
    public function setTurma(Turma $turma)
    {
        $this->turma = $turma;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Rodizio
     */
    public function getRodizio()
    {
        return $this->rodizio;
    }

    /**
     * @param mixed $inicio
     */
    public function setInicio($inicio)
    {
        $data = new \DateTime($inicio);
        $this->inicioObject = $data;
        $this->inicio = $data->format('d/m/Y');
    }

    /**
     * @param mixed $fim
     */
    public function setFim($fim)
    {
        $data = new \DateTime($fim);
        $this->fimObject = $data;
        $this->fim = $data->format('d/m/Y');
    }

    /**
     * @return mixed
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * @return mixed
     */
    public function getFim()
    {
        return $this->fim;
    }

    /**
     * @return Turma
     */
    public function getTurma()
    {
        return $this->turma;
    }

    /**
     * @return array
     */
    public function getAtividades()
    {
        return $this->atividades;
    }

    /**
     * @param array $atividades
     */
    public function setAtividades($atividades)
    {
        $this->atividades = $atividades;
    }

    /**
     * @return \DateTime
     */
    public function getInicioObject()
    {
        return $this->inicioObject;
    }

    /**
     * @return \DateTime
     */
    public function getFimObject()
    {
        return $this->fimObject;
    }


    public function getEncerramento()
    {
        return $this->encerramento;
    }

    public function setEncerramento($encerramento)
    {
        if ($encerramento != null) {
            $data = new \DateTime($encerramento);
            $this->encerramento = $data->format('d/m/Y');
        } else {
            $this->encerramento = null;
        }
    }

    /**
     * @return mixed
     */
    public function getAcompanhamentoEncontro()
    {
        return $this->acompanhamentoEncontro;
    }

    /**
     * @param mixed $acompanhamentoEncontro
     */
    public function setAcompanhamentoEncontro($acompanhamentoEncontro)
    {
        $this->acompanhamentoEncontro = $acompanhamentoEncontro;
    }
}