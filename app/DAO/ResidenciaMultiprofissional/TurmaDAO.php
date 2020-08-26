<?php

namespace App\DAO\ResidenciaMultiprofissional;

use App\Model\ResidenciaMultiprofissional\Turma;
use Illuminate\Support\Facades\DB;

class TurmaDAO
{

    /**
     * @param $id
     * @return Turma
     */
    public function get($id)
    {
        $select = DB::select('SELECT * FROM res.turma WHERE turmaid = :turmaid', ['turmaid' => $id]);

        $turma = new Turma();

        if (count($select)) {
            $select = $select[0];

            $turma->setId($select->turmaid);
            $turma->setCodigoTurma($select->codigoturma);
            $turma->setDescricao($select->descricao);
            $turma->setDataInicio($select->datainicio);
            $turma->setDataFim($select->datafim);
        }

        return $turma;
    }

    public function retornaTurmasSupervisor($supervisor)
    {
        $turmasSelect = DB::table('res.turma')
                        ->select('res.turma.*')
                        ->join('res.ofertadeunidadetematica', 'res.ofertadeunidadetematica.turmaid', 'res.turma.turmaid')
                        ->join('res.ofertadeunidadetematicasupervisoresinstituicoes', 'res.ofertadeunidadetematicasupervisoresinstituicoes.ofertadeunidadetematicaid', 'res.ofertadeunidadetematica.ofertadeunidadetematicaid')
                        ->where('res.ofertadeunidadetematicasupervisoresinstituicoes.supervisorid', '=', $supervisor->getId())
                        ->get();


        $turmas = array();
        foreach ($turmasSelect as $turmaSelect) {
            $turmas[] = $this->get($turmaSelect->turmaid);
        }

        return $turmas;
    }
}