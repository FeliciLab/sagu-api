<?php

namespace App\DAO;

use App\Model\Autoavaliacao;
use App\Model\OfertaDeRodizio;
use App\Model\OfertaDeRodizioNota;
use App\Model\OfertaDoResidente;
use App\Model\Residente;
use Illuminate\Support\Facades\DB;

class OfertaDoResidenteDAO
{
    /**
     * @param $id
     * @return OfertaDoResidente
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.ofertadoresidente WHERE ofertadoresidenteid = :ofertadoresidenteid', ['ofertadoresidenteid' => $id]);

        $ofertaDoResidente = new OfertaDoResidente();

        if (count($select)) {
            $select = $select[0];

            $ofertaDoResidente->setId($select->ofertadoresidenteid);

            $ofertaDeRodizioDao = new OfertaDeRodizioDAO();
            $ofertaDoResidente->setOfertaDeRodizio($ofertaDeRodizioDao->get($select->ofertadeunidadetematicaid));

            $ofertaDoResidente->setNota($this->getNota($select->residenteid, $select->ofertadeunidadetematicaid));
            $ofertaDoResidente->setFrequencia($this->getFrequencia($select->residenteid, $select->ofertadeunidadetematicaid));

            $autoavaliacaoDao = new AutoavaliacaoDAO();
            $autoavaliacao = $autoavaliacaoDao->getAutoavaliacao($select->residenteid, $select->ofertadeunidadetematicaid);
            $ofertaDoResidente->setAutoavaliacao($autoavaliacao);


            $residenteDao = new ResidenteDAO();
            $residente = $residenteDao->get($select->residenteid);
            $ofertaDoResidente->setResidente($residente);
        }

        return $ofertaDoResidente;
    }

    public function retornaOfertasDeRodizioDoResidente(Residente $residente)
    {
        $select = DB::select('
            SELECT * FROM 
              med.ofertadoresidente A INNER JOIN med.ofertadeunidadetematica B
              ON A.ofertadeunidadetematicaid = b.ofertadeunidadetematicaid
            WHERE A.residenteid = :residenteid
            ORDER BY B.inicio
        ', ['residenteid' => $residente->getId()]);

        $ofertasDoResidente = array();

        foreach ($select as $selectOfertaDoResidente) {
            $ofertaDoResidente = $this->get($selectOfertaDoResidente->ofertadoresidenteid);

            if ($residente->getTurma()->getId() == $ofertaDoResidente->getOfertaDeRodizio()->getTurma()->getId()) {
                $ofertasDoResidente[] = $ofertaDoResidente;
            }

        }

        return $ofertasDoResidente;
    }

    public function retornaUltimasOfertasDeRodizioDoResidente(Residente $residente, \DateTime $dataAtual)
    {
        $select = DB::select('
            SELECT * FROM 
              med.ofertadoresidente A INNER JOIN med.ofertadeunidadetematica B
              ON A.ofertadeunidadetematicaid = b.ofertadeunidadetematicaid
            WHERE A.residenteid = :residenteid AND 
                B.fim <= :fim
            ORDER BY B.inicio DESC
            LIMIT 4
        ', [
                'residenteid' => $residente->getId(),
                'fim'         => $dataAtual->format('Y-m-d')
        ]);

        $ofertasDoResidente = array();

        foreach (array_reverse($select) as $selectOfertaDoResidente) {
            $ofertaDoResidente = $this->get($selectOfertaDoResidente->ofertadoresidenteid);

            if ($residente->getTurma()->getId() == $ofertaDoResidente->getOfertaDeRodizio()->getTurma()->getId()) {
                $ofertasDoResidente[] = $ofertaDoResidente;
            }

        }

        return $ofertasDoResidente;
    }

    public function retornaAtualOfertaDeRodizioDoResidente(Residente $residente, \DateTime $dataAtual)
    {
        $select = DB::select('
            SELECT * FROM 
              med.ofertadoresidente A INNER JOIN med.ofertadeunidadetematica B
              ON A.ofertadeunidadetematicaid = b.ofertadeunidadetematicaid
            WHERE A.residenteid = :residenteid AND 
                B.inicio <= :dataAtualInicio AND B.fim >= :dataAtualFim
            ORDER BY B.inicio DESC
            LIMIT 1
        ', [
            'residenteid' => $residente->getId(),
            'dataAtualInicio'         => $dataAtual->format('Y-m-d'),
            'dataAtualFim'      => $dataAtual->format('Y-m-d')
        ]);

        $ofertasDoResidente = array();

        foreach (array_reverse($select) as $selectOfertaDoResidente) {
            $ofertaDoResidente = $this->get($selectOfertaDoResidente->ofertadoresidenteid);

            if ($residente->getTurma()->getId() == $ofertaDoResidente->getOfertaDeRodizio()->getTurma()->getId()) {
                $ofertasDoResidente[] = $ofertaDoResidente;
            }

        }

        return $ofertasDoResidente;
    }

    public function getNota($residenteId, $ofertaDeRodizioId)
    {
        $select = DB::select('
            SELECT * FROM 
            med.notadoresidentenaofertadeunidadetematica 
            WHERE ofertadeunidadetematicaid = :ofertadeunidadetematicaid 
                AND residenteid = :residenteid', ['ofertadeunidadetematicaid' => $ofertaDeRodizioId, 'residenteid' => $residenteId]);

        $nota = null;

        if (count($select)) {
            $select = $select[0];

            $nota = $select->nota;
        }

        return $nota;
    }

    public function getFrequencia($residenteId, $ofertaDeRodizioId)
    {
        $select = DB::select('
            SELECT (med.obtemcargahorariadoresidentenaoferta(:residenteid, :ofertadeunidadetematicaid )) AS freq', ['ofertadeunidadetematicaid' => $ofertaDeRodizioId, 'residenteid' => $residenteId]);

        $frequencia = 0;

        if (count($select)) {
            $select = $select[0];

            $frequencia = $select->freq;
        }

        return $frequencia;
    }

    public function retornaResidentesPorOfertaDeRodizio(OfertaDeRodizio $ofertaDeRodizio)
    {
        $select = DB::select('
            SELECT * FROM  med.ofertadoresidente A WHERE A.ofertadeunidadetematicaid = :ofertadeunidadetematicaid
        ', [
            'ofertadeunidadetematicaid' => $ofertaDeRodizio->getId()
        ]);

        $residentes = array();
        foreach ($select as $selectOfertaDoResidente) {
            $residente = new ResidenteDAO();
            $residentes[] = $residente->get($selectOfertaDoResidente->residenteid);
        }

        return $residentes;
    }


}