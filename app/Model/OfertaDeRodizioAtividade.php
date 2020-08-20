<?php

namespace App\Model;


class OfertaDeRodizioAtividade
{
    /**
     * @var $atividade Atividade
     */
    public $atividade;

    public $cargaHoraria;

    /**
     * @return Atividade
     */
    public function getAtividade()
    {
        return $this->atividade;
    }

    /**
     * @param Atividade $atividade
     */
    public function setAtividade(Atividade $atividade)
    {
        $this->atividade = $atividade;
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
}