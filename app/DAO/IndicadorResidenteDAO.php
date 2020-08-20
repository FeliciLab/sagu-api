<?php

namespace App\DAO;

use App\Model\IndicadorResidente;
use App\Model\Preceptor;
use Illuminate\Support\Facades\DB;

class IndicadorResidenteDAO
{

    /**
     * @param $id
     * @return IndicadorResidente
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.residenteindicador WHERE residenteindicadorid = :residenteindicadorid', ['residenteindicadorid' => $id]);

        $indicadorResidente = new IndicadorResidente();

        if (count($select)) {
            $select = $select[0];

            $indicadorResidente->setId($select->residenteindicadorid);
            $indicadorResidente->setPeriodoInicio($select->periodoinicio);
            $indicadorResidente->setPeriodoFim($select->periodofim);


            $inicio = new \DateTime($select->periodoinicio);
            $fim = new \DateTime($select->periodofim);

            $indicadorResidente->setPeriodoInicioFormatado($inicio->format('d/m/Y'));
            $indicadorResidente->setPeriodoFimFormatado($fim->format('d/m/Y'));
            $indicadorResidente->setQuantidade($select->quantidade);
            $indicadorResidente->setJustificativa($select->justificativa);
            $indicadorResidente->setSituacao($select->situacao);

            $indicadorDao = new IndicadorDAO();
            $indicadorResidente->setIndicador($indicadorDao->get($select->indicadorid));

            $preceptorDao = new PreceptorDAO();
            $indicadorResidente->setPreceptor($preceptorDao->get($select->preceptorid));
        }

        return $indicadorResidente;
    }

    public function retornaIndicadorDoResidentePorSemana(IndicadorResidente $indicadorResidente)
    {

        $select = DB::select('SELECT * FROM med.residenteindicador 
                              WHERE residenteid = :residenteid AND periodoinicio = :periodoinicio AND periodofim =:periodofim AND indicadorid = :indicadorid',
            ['residenteid' => $indicadorResidente->getResidente()->getId(), 'periodoinicio' => $indicadorResidente->getPeriodoInicio(), 'periodofim' => $indicadorResidente->getPeriodoFim(), 'indicadorid' => $indicadorResidente->getIndicador()->getId()]);

        $indicadorResidente = new IndicadorResidente();

        if (count($select)) {
            $select = $select[0];
            $indicadorResidente = $this->get($select->residenteindicadorid);
        }

        return $indicadorResidente;
    }


    public function retornaIndicadoresDoResidentePorSemana($parametros)
    {

        $select = DB::select('SELECT * FROM med.residenteindicador 
                              WHERE residenteid = :residenteid AND periodoinicio = :periodoinicio AND periodofim =:periodofim', ['residenteid' => $parametros->residente->getId(), 'periodoinicio' => $parametros->inicio, 'periodofim' => $parametros->fim]);

        $indicadoresResidente = array();
        foreach ($select as $indicadorResidente) {
            $indicadoresResidente[] = $this->get($indicadorResidente->residenteindicadorid);
        }

        return $indicadoresResidente;
    }

    public function insert(IndicadorResidente $indicadorResidente)
    {
        $result = DB::insert('insert into med.residenteindicador  (residenteid, periodoinicio, periodofim, quantidade, situacao, indicadorid) values (?, ?, ?, ?, ?, ?)',
            [
                $indicadorResidente->getResidente()->getId(),
                $indicadorResidente->getPeriodoInicio(),
                $indicadorResidente->getPeriodoFim(),
                $indicadorResidente->getQuantidade(),
                $indicadorResidente->getSituacao(),
                $indicadorResidente->getIndicador()->getId()

            ]);

        if ( $result )  {
            $rowId = DB::connection()->getPdo()->lastInsertId();
            return $this->get($rowId);
        }
    }

    public function update(IndicadorResidente $indicadorResidente)
    {
        DB::update('update med.residenteindicador set quantidade = ?, situacao = ? where residenteindicadorid = ?',
            [
                $indicadorResidente->getQuantidade(),
                $indicadorResidente->getSituacao(),
                $indicadorResidente->getId()
            ]);

        return $indicadorResidente;
    }

    public function updateJustificativa(IndicadorResidente $indicadorResidente)
    {
        DB::update('update med.residenteindicador set situacao = ?, justificativa = ?, preceptorid = ? where residenteindicadorid = ?',
            [
                $indicadorResidente->getSituacao(),
                $indicadorResidente->getJustificativa(),
                $indicadorResidente->getPreceptor()->getId(),
                $indicadorResidente->getId()
            ]);

        return $indicadorResidente;
    }

    public function retornaIndicadoresRespondidosDoResidentePorPeriodoDaOfertaDeRodizio($parametros)
    {
        $select = DB::select('SELECT * FROM med.residenteindicador 
                              WHERE residenteid = :residenteid AND periodoinicio >= :periodoinicio AND periodofim  <= :periodofim ORDER BY periodoinicio',
                                ['residenteid' => $parametros->residente->getId(), 'periodoinicio' => $parametros->inicio, 'periodofim' => $parametros->fim]);

        $indicadoresResidente = array();
        foreach ($select as $indicadorResidente) {
            $indicadoresResidente[] = $this->get($indicadorResidente->residenteindicadorid);
        }

        return $indicadoresResidente;
    }
}