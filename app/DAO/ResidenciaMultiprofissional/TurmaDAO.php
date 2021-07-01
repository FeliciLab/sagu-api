<?php

namespace App\DAO\ResidenciaMultiprofissional;

use App\DAO\Traits\ArrayMapToModel;
use App\DAO\Traits\PaginationQuery;
use App\DAO\Traits\RemoverCamposNulos;
use App\Model\ResidenciaMultiprofissional\Turma;
use Illuminate\Support\Facades\DB;

class TurmaDAO
{
    use ArrayMapToModel, PaginationQuery, RemoverCamposNulos;

    public $model;

    /**
     * TurmaDAO constructor.
     * @param Turma $model
     */
    public function __construct()
    {
        $this->model = new Turma();
    }


    /**
     * @param $id
     * @return Turma
     */
    public function get($id)
    {
        return new Turma(
            DB::table($this->model->getTable())
                ->where('turmaid', $id)
                ->get()
                ->first()
                ->toArray()
        );
    }

    public function buscarTurmasSupervisor($supervisorId, $page = null)
    {
        $query = DB::table('res.turma')
            ->distinct()
            ->select(
                'res.turma.turmaid as turmaid',
                'res.turma.codigoturma as codigoturma',
                'res.turma.descricao as descricao',
                'res.turma.datainicio as datainicio',
                'res.turma.datafim as datafim',
                'res.turma.quantidadeperiodo as quantidadeperiodo',
                'res.componente.descricao as componente'
            )
            ->join('res.ofertadeunidadetematica', 'res.ofertadeunidadetematica.turmaid', 'res.turma.turmaid')
            ->join('res.componente', 'res.turma.componenteid', 'res.componente.componenteid')
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
            ->limit(25);

        $this->paginate($query, $page);

        return $this->removerCamposNulosLista(
            $this->mapToModel($query->get()->toArray())
        );
    }
}
