<?php

namespace App\DAO;

use App\Model\Indicador;
use App\Model\Residente;
use Illuminate\Support\Facades\DB;

class IndicadorDAO
{

    /**
     * @param $id
     * @return Indicador
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.indicador WHERE indicadorid = :indicadorid', ['indicadorid' => $id]);

        $indicador = new Indicador();

        if (count($select)) {
            $select = $select[0];

            $indicador->setId($select->indicadorid);

            $especialidadeDao = new EspecialidadeDAO();
            $especialidade = $especialidadeDao->get($select->enfaseid);
            $indicador->setEspecialidade($especialidade);

            $periodoDao = new PeriodoDAO();
            $periodo = $periodoDao->getPorId($select->periodoid);
            $indicador->setPeriodo($periodo);

            $indicador->setDescricao($select->descricao);
            $indicador->setPeriodicidade($select->periodicidade);
            $indicador->setMeta($select->meta);
            $indicador->setSituacao($select->situacao);
        }

        return $indicador;
    }

    public function indicadoresPorEspecialidade($parametros)
    {
        $residente = $parametros->residente;

        $select = DB::select('SELECT * FROM med.indicador WHERE enfaseid = :enfaseid', ['enfaseid' => $residente->getEspecialidade()->getId()]);

        $indicadores = array();
        foreach ($select as $indicador) {
            $indicadores[] = $this->get($indicador->indicadorid);
        }

        return $indicadores;
    }
}