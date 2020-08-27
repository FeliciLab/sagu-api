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

    public function buscarTurmasSupervisor($supervisorId)
    {
        return DB::table('res.turma')
                ->distinct()
                ->select(
                    'res.turma.turmaid as turmaid',
                    'res.turma.codigoturma as codigoturma',
                    'res.turma.descricao as descricao',
                    'res.turma.datainicio as datainicio',
                    'res.turma.datafim as datafim',
                    'res.turma.quantidadeperiodo as quantidadeperiodo',
                    'res.turma.vagas as vagas'
                )
                ->join('res.ofertadeunidadetematica', 'res.ofertadeunidadetematica.turmaid', 'res.turma.turmaid')
                ->join(
                    'res.ofertadeunidadetematicasupervisoresinstituicoes',
                    'res.ofertadeunidadetematicasupervisoresinstituicoes.ofertadeunidadetematicaid',
                    'res.ofertadeunidadetematica.ofertadeunidadetematicaid'
                )
            ->join(
                'res.supervisores',
                'res.supervisores.supervisorid',
                'res.ofertadeunidadetematicasupervisoresinstituicoes.supervisorid'
            )
                ->where('res.supervisores.supervisorid', '=', $supervisorId)
                ->get()
                ->toArray();
    }
}