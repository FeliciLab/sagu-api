<?php

namespace App\DAO;

use App\Model\FaltaDoResidenteNaOfertaDeRodizio;
use App\Model\OfertaDeRodizio;
use App\Model\Residente;
use Illuminate\Support\Facades\DB;

class FaltaDoResidenteNaOfertaDeRodizioDAO
{

    /**
     * @param $id
     * @return FaltaDoResidenteNaOfertaDeRodizio
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.faltadoresidentenaofertadeunidadetematica WHERE faltadoresidentenaofertadeunidadetematicaid = :faltadoresidentenaofertadeunidadetematicaid', ['faltadoresidentenaofertadeunidadetematicaid' => $id]);

        $faltaDoResidenteNaOfertaDeRodizio = new FaltaDoResidenteNaOfertaDeRodizio();

        if (count($select)) {
            $select = $select[0];

            $faltaDoResidenteNaOfertaDeRodizio->setId($select->faltadoresidentenaofertadeunidadetematicaid);

            $residenteDao = new ResidenteDAO();
            $residente = $residenteDao->get($select->residenteid);

            $faltaDoResidenteNaOfertaDeRodizio->setResidente($residente);

            $ofertaDeRodizioDao = new OfertaDeRodizioDAO();
            $ofertaDeRodizio = $ofertaDeRodizioDao->get($select->ofertadeunidadetematicaid);

            $faltaDoResidenteNaOfertaDeRodizio->setOfertaDeRodizio($ofertaDeRodizio);
            $faltaDoResidenteNaOfertaDeRodizio->setFalta($select->falta);
            $faltaDoResidenteNaOfertaDeRodizio->setObservacao($select->observacao);
        }

        return $faltaDoResidenteNaOfertaDeRodizio;
    }

    public function save(FaltaDoResidenteNaOfertaDeRodizio $faltaDoResidenteNaOfertaDeRodizio)
    {
        if (!$faltaDoResidenteNaOfertaDeRodizio->getId()) {
            return $this->insert($faltaDoResidenteNaOfertaDeRodizio);
        } else {
            return $this->update($faltaDoResidenteNaOfertaDeRodizio);
        }



        return $faltaDoResidenteNaOfertaDeRodizio;
    }

    public function insert(FaltaDoResidenteNaOfertaDeRodizio $faltaDoResidenteNaOfertaDeRodizio)
    {
        $result = DB::insert('insert into med.faltadoresidentenaofertadeunidadetematica  (residenteid, ofertadeunidadetematicaid, falta, observacao) values (?, ?, ?, ?)',
            [
                $faltaDoResidenteNaOfertaDeRodizio->getResidente()->getId(),
                $faltaDoResidenteNaOfertaDeRodizio->getOfertaDeRodizio()->getId(),
                $faltaDoResidenteNaOfertaDeRodizio->getFalta(),
                $faltaDoResidenteNaOfertaDeRodizio->getObservacao()

            ]);

        if ( $result )  {
            $rowId = DB::connection()->getPdo()->lastInsertId();
            return $this->get($rowId);
        }
    }

    public function update(FaltaDoResidenteNaOfertaDeRodizio $faltaDoResidenteNaOfertaDeRodizio)
    {
        DB::update('update med.faltadoresidentenaofertadeunidadetematica set falta = ?, observacao = ? where faltadoresidentenaofertadeunidadetematicaid = ?',
            [
                $faltaDoResidenteNaOfertaDeRodizio->getFalta(),
                $faltaDoResidenteNaOfertaDeRodizio->getObservacao(),
                $faltaDoResidenteNaOfertaDeRodizio->getId()
            ]);

        return $faltaDoResidenteNaOfertaDeRodizio;
    }

    public function faltasDosResidentesNaOfertaDeRodizio(OfertaDeRodizio $ofertaDeRodizio)
    {
        $select = DB::select('SELECT * FROM med.faltadoresidentenaofertadeunidadetematica 
                              WHERE ofertadeunidadetematicaid = :ofertadeunidadetematicaid 
                              ', ['ofertadeunidadetematicaid' => $ofertaDeRodizio->getId()]);

        $faltasDosResidentesNaOfertaDeRodizio = array();

        foreach ($select as $faltaResidente) {
            $faltasDosResidentesNaOfertaDeRodizio[] = $this->get($faltaResidente->faltadoresidentenaofertadeunidadetematicaid);
        }

        return $faltasDosResidentesNaOfertaDeRodizio;
    }

    public function faltaDoResidenteNaOfertaDeRodizio(Residente $residente, OfertaDeRodizio $ofertaDeRodizio)
    {
        $select = DB::select('SELECT * FROM med.faltadoresidentenaofertadeunidadetematica WHERE residenteid = :residenteid AND ofertadeunidadetematicaid = :ofertadeunidadetematicaid ', ['residenteid' => $residente->getId(), 'ofertadeunidadetematicaid' => $ofertaDeRodizio->getId()]);

        $faltaDoResidenteNaOfertaDeRodizio = new FaltaDoResidenteNaOfertaDeRodizio();
        if (count($select)) {
            $select = $select[0];
            $faltaDoResidenteNaOfertaDeRodizio = $this->get($select->faltadoresidentenaofertadeunidadetematicaid);
        }

        return $faltaDoResidenteNaOfertaDeRodizio;
    }
}