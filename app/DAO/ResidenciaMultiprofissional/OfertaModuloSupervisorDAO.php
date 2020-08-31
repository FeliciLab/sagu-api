<?php


namespace App\DAO\ResidenciaMultiprofissional;


use Illuminate\Support\Facades\DB;

class OfertaModuloSupervisorDAO
{
    public function buscarOfertasModuloSupervisor($supervisorId, $turmaId, $page = null)
    {
        $query = DB::table('res.ofertadeunidadetematica')
            ->distinct()
            ->select(
                'res.ofertadeunidadetematica.ofertadeunidadetematicaid as ofertadeunidadetematicaid',
                'res.ofertadeunidadetematica.inicio as inicio',
                'res.ofertadeunidadetematica.fim as fim',
                'res.ofertadeunidadetematica.encerramento as encerramento',
                'res.ofertadeunidadetematica.nome as nome',
                'res.ofertadeunidadetematica.semestre as semestre',
                DB::raw("
                    CASE WHEN semestre IN (1, 2) THEN 'Primeiro Ano' 
                        WHEN semestre in (3, 4) THEN 'Segundo Ano' 
                        WHEN semestre in (5, 6) THEN 'Terceiro Ano' 
                        ELSE 'Terceiro Ano' 
                        END AS semestre_descricao
                "),
                'res.ofertadeunidadetematica.cargahoraria as cargahoraria',
                'res.ofertadeunidadetematica.unidadetematicaid as unidadetematicaid',
                'res.turma.descricao as turma_descricao',
                'res.turma.codigoturma as turma_codigoturma',
                'res.modulo.nome as modulo_nome',
                'res.modulo.moduloid as modulo_moduloid'
            )
            ->join('res.turma', 'res.ofertadeunidadetematica.turmaid', 'res.turma.turmaid')
            ->join('res.unidadetematica', 'res.unidadetematica.unidadetematicaid', 'res.ofertadeunidadetematica.unidadetematicaid')
            ->join('res.modulo', 'res.modulo.moduloid', 'res.unidadetematica.moduloid')
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
            ->where('res.supervisores.supervisorid', $supervisorId)
            ->where('res.turma.turmaid', $turmaId)
            ->limit(25);

        if ($page) {
            $query->offset(25 * ($page - 1));
        }

        return $query->get()->toArray();
    }
}