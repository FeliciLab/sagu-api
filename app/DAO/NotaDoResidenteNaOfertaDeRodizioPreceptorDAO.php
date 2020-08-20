<?php

namespace App\DAO;

use App\Model\Atividade;
use App\Model\NotaDoResidenteNaOfertaDeRodizioPreceptor;
use App\Model\OfertaDeRodizio;
use App\Model\Preceptor;
use Illuminate\Support\Facades\DB;

class NotaDoResidenteNaOfertaDeRodizioPreceptorDAO
{

    /**
     * @param $id
     * @return NotaDoResidenteNaOfertaDeRodizioPreceptor
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.notadoresidentenaofertadeunidadetematicapreceptor WHERE notadoresidentenaofertadeunidadetematicapreceptorid = :notadoresidentenaofertadeunidadetematicapreceptorid', ['notadoresidentenaofertadeunidadetematicapreceptorid' => $id]);

        $nota = new NotaDoResidenteNaOfertaDeRodizioPreceptor();

        if (count($select)) {
            $select = $select[0];

            $nota->setId($select->notadoresidentenaofertadeunidadetematicapreceptorid);

            $preceptorDao = new PreceptorDAO();
            $preceptor = $preceptorDao->get($select->preceptorid);
            $nota->setPreceptor($preceptor);

            $residenteDao = new ResidenteDAO();
            $residente = $residenteDao->get($select->residenteid);
            $nota->setResidente($residente);

            $ofertaDeRodizioDao = new OfertaDeRodizioDAO();
            $ofertaDeRodizio = $ofertaDeRodizioDao->get($select->ofertadeunidadetematicaid);
            $nota->setOfertaDeRodizio($ofertaDeRodizio);

            $nota->setNota($select->nota);
        }

        return $nota;
    }

    public function retornaNotaPorPreceptorOfertaDeRodizioEResidente(NotaDoResidenteNaOfertaDeRodizioPreceptor $nota)
    {
        $select = DB::select('SELECT * FROM med.notadoresidentenaofertadeunidadetematicapreceptor 
                              WHERE preceptorid = :preceptorid AND residenteid = :residenteid AND ofertadeunidadetematicaid = :ofertadeunidadetematicaid 
                              ', ['preceptorid' => $nota->getPreceptor()->getId(), 'residenteid' => $nota->getResidente()->getId(), 'ofertadeunidadetematicaid' => $nota->getOfertaDeRodizio()->getId()]);

        $notaDoResidenteNaOfertaDeRodizioPreceptor = new NotaDoResidenteNaOfertaDeRodizioPreceptor();

        if (count($select)) {
            $select = $select[0];
            $notaDoResidenteNaOfertaDeRodizioPreceptor = $this->get($select->notadoresidentenaofertadeunidadetematicapreceptorid);
        }
        return $notaDoResidenteNaOfertaDeRodizioPreceptor;
    }

    public function insert(NotaDoResidenteNaOfertaDeRodizioPreceptor $nota)
    {
        $result = DB::insert('insert into med.notadoresidentenaofertadeunidadetematicapreceptor  (preceptorid, residenteid, ofertadeunidadetematicaid, nota) values (?, ?, ?, ?)',
            [
                $nota->getPreceptor()->getId(),
                $nota->getResidente()->getId(),
                $nota->getOfertaDeRodizio()->getId(),
                $nota->getNota()
            ]);

        if ( $result )  {
            $rowId = DB::connection()->getPdo()->lastInsertId();
            return $this->get($rowId);
        }
    }

    public function update(NotaDoResidenteNaOfertaDeRodizioPreceptor $nota)
    {
        DB::update('update med.notadoresidentenaofertadeunidadetematicapreceptor set nota = ? where notadoresidentenaofertadeunidadetematicapreceptorid = ?',
            [
                $nota->getNota(),
                $nota->getId()
            ]);

        return $nota;
    }

    public function notasDosResidentesNaOfertaDeRodizioPorPreceptor(Preceptor $preceptor, OfertaDeRodizio $ofertaDeRodizio)
    {
        $select = DB::select('SELECT * FROM med.notadoresidentenaofertadeunidadetematicapreceptor 
                              WHERE preceptorid = :preceptorid AND ofertadeunidadetematicaid = :ofertadeunidadetematicaid 
                              ', ['preceptorid' => $preceptor->getId(), 'ofertadeunidadetematicaid' => $ofertaDeRodizio->getId()]);

        $notasDosResidentesNaOfertaDeRodizioPorPreceptor = array();

        foreach ($select as $notaResidente) {
            $notasDosResidentesNaOfertaDeRodizioPorPreceptor[] = $this->get($notaResidente->notadoresidentenaofertadeunidadetematicapreceptorid);
        }

        return $notasDosResidentesNaOfertaDeRodizioPorPreceptor;
    }
}