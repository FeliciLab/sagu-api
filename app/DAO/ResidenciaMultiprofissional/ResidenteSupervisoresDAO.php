<?php


namespace App\DAO\ResidenciaMultiprofissional;


use App\DAO\Traits\ArrayMapToModel;
use App\DAO\Traits\PaginationQuery;
use App\DAO\Traits\RemoverCamposNulos;
use App\Model\Residente;
use Illuminate\Support\Facades\DB;

class ResidenteSupervisoresDAO
{
    use ArrayMapToModel, PaginationQuery, RemoverCamposNulos;

    /**
     * @var Residente
     */
    public $model;

    /**
     * ResidenteSupervisorDAO constructor.
     * @param Residente $model
     */
    public function __construct()
    {
        $this->model = new Residente();
    }

    public function buscarResidentesOfertaModuloSupervisores($supervisorId, $turmaId, $ofertaId, $page = null)
    {
        $query = DB::table($this->model->getTable())
            ->select(
                'res.residente.residenteid as residenteid',
                'res.residente.inicio as inicio',
                'res.residente.fimprevisto as fimprevisto',
                'res.enfase.descricao as enfase.descricao',
                'res.nucleoprofissional.descricao as nucleoprofissional.descricao',
                'res.turma.descricao as turma.descricao',
                'public.baslegalperson.name as instituicaoFormadoraPerson.name',
                'public.basphysicalperson.name as person.name',
                'public.basphysicalperson.personid as person.personid'
            )
            ->join('public.baslegalperson', 'public.baslegalperson.personid', 'res.residente.instituicaoformadora')
            ->join('public.basphysicalperson', 'public.basphysicalperson.personid', 'res.residente.personid')
            ->join('res.nucleoprofissional', 'res.nucleoprofissional.nucleoprofissionalid', 'res.residente.nucleoprofissionalid')
            ->join('res.enfase', 'res.enfase.enfaseid', 'res.residente.enfaseid')
            ->join('res.ofertadoresidente', 'res.ofertadoresidente.residenteid', 'res.residente.residenteid')
            ->join(
                'res.ofertadeunidadetematica',
                'res.ofertadeunidadetematica.ofertadeunidadetematicaid',
                'res.ofertadoresidente.ofertadeunidadetematicaid'
            )
            ->join('res.turma', 'res.turma.turmaid', 'res.ofertadeunidadetematica.turmaid')
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
            ->where('res.ofertadeunidadetematica.ofertadeunidadetematicaid', $ofertaId)
            ->where('res.turma.turmaid', $turmaId)
            ->where('res.supervisores.supervisorid', $supervisorId)
            ->limit(25);

        $this->paginate($query, $page);
        return $this->removerCamposNulosLista(
            $this->mapToModel($query->get()->toArray())
        );
    }
}