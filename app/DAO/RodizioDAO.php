<?php

namespace App\DAO;

use App\Model\Rodizio;
use Illuminate\Support\Facades\DB;

class RodizioDAO
{

    /**
     * @param $id
     * @return Rodizio
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM med.unidadetematica WHERE unidadetematicaid = :unidadetematicaid', ['unidadetematicaid' => $id]);

        $rodizio = new Rodizio();

        if (count($select)) {
            $select = $select[0];

            $rodizio->setId($select->unidadetematicaid);

            $periodo = new PeriodoDAO();
            $rodizio->setPeriodo($periodo->get($select->periodo));

            $rodizio->setDescricao($select->descricao);
            $rodizio->setCargaHoraria($select->cargahoraria);

            $tipo = new RodizioTipoDAO();
            $rodizio->setTipo($tipo->get($select->tipo));

            $rodizio->setFrequenciaMinima($select->frequenciaminima);

            $rodizio->setNotaMaxima($select->notamaxima);
            $rodizio->setNotaMinimaParaAprovacao($select->notaminimaparaaprovacao);


        }

        return $rodizio;
    }
}