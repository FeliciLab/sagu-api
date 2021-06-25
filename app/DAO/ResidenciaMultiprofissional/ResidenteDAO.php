<?php


namespace App\DAO\ResidenciaMultiprofissional;


use App\DAO\Traits\ArrayMapToModel;
use App\DAO\Traits\PaginationQuery;
use App\DAO\Traits\RemoverCamposNulos;
use App\Model\ResidenciaMultiprofissional\Residente;
use Illuminate\Support\Facades\DB;

class ResidenteDAO
{
    use ArrayMapToModel, PaginationQuery, RemoverCamposNulos;

    /**
     * @var Residente
     */
    private $model;


    private $ofertaModuloFaltaDAO;
    private $ofertaModuloNotaDAO;
    private $cargaHorariaComplementarDAO;

    public function __construct()
    {
        $this->model = new Residente();
        $this->ofertaModuloFaltaDAO = new OfertaModuloFaltaDAO();
        $this->ofertaModuloNotaDAO = new OfertaModuloNotaDAO();
        $this->cargaHorariaComplementarDAO = new CargaHorariaComplementarDAO();
    }

    public function queryBuscarResidentesOfertaModuloSupervisoresy($supervisorId, $turmaId, $ofertaId, $residenteId)
    {
        $result = DB::table($this->model->getTable())
            ->distinct()
            ->select(
                'res.residente.residenteid as residenteid',
                'res.residente.inicio as inicio',
                'res.residente.fimprevisto as fimprevisto',
                'res.enfase.enfaseid as enfase.id',
                'res.enfase.descricao as enfase.descricao',
                'res.nucleoprofissional.nucleoprofissionalid as nucleoProfissional.id',
                'res.nucleoprofissional.descricao as nucleoProfissional.descricao',
                'res.turma.descricao as turma.descricao',
                'public.baslegalperson.name as instituicaoFormadoraPerson.name',
                'baslegalpersonExecutora.name as instituicaoExecutoraPerson.name',
                'public.basphysicalperson.name as person.name',
                'public.basphysicalperson.personid as person.personid',
                'public.basphysicalperson.photoid as person.photoid'
            )
            ->join(
                'public.baslegalperson',
                'public.baslegalperson.personid',
                'res.residente.instituicaoformadora'
            )
            ->join(
                'public.baslegalperson as baslegalpersonExecutora',
                'baslegalpersonExecutora.personid',
                'res.residente.instituicaoexecutora'
            )
            ->join(
                'public.basphysicalperson',
                'public.basphysicalperson.personid',
                'res.residente.personid')
            ->join(
                'res.nucleoprofissional',
                'res.nucleoprofissional.nucleoprofissionalid',
                'res.residente.nucleoprofissionalid'
            )
            ->join(
                'res.enfase',
                'res.enfase.enfaseid',
                'res.residente.enfaseid'
            )
            ->join(
                'res.ofertadoresidente',
                'res.ofertadoresidente.residenteid',
                'res.residente.residenteid')
            ->join(
                'res.ofertadeunidadetematica',
                'res.ofertadeunidadetematica.ofertadeunidadetematicaid',
                'res.ofertadoresidente.ofertadeunidadetematicaid'
            )
            ->join(
                'res.turma',
                'res.turma.turmaid',
                'res.ofertadeunidadetematica.turmaid'
            )
            ->join(
                'res.ofertadeunidadetematicasupervisoresinstituicoes', function ($join) {
                $join->on('res.ofertadeunidadetematicasupervisoresinstituicoes.ofertadeunidadetematicaid', '=', 'res.ofertadeunidadetematica.ofertadeunidadetematicaid');
                $join->on('res.ofertadeunidadetematicasupervisoresinstituicoes.enfaseid', '=', 'res.residente.enfaseid');
            })
            ->join(
                'res.supervisores',
                'res.supervisores.supervisorid',
                'res.ofertadeunidadetematicasupervisoresinstituicoes.supervisorid'
            )
            ->join(
                'res.ofertadeunidadetematicasupervisoresinstituicoes as supervisorinstituicoes',
                'baslegalpersonExecutora.personid',
                'supervisorinstituicoes.instituicaoexecutoraid'
            )
            ->where('res.ofertadeunidadetematica.ofertadeunidadetematicaid', $ofertaId)
            ->where('res.turma.turmaid', $turmaId)
            ->where('res.supervisores.supervisorid', $supervisorId);

        if (isset($residenteId) && $residenteId >= 0) {
            $result->where('res.residente.residenteid', $residenteId);
        }

        $result->orderBy('public.basphysicalperson.name');

        return $result;
    }

    public function buscarResidentesOfertaModuloSupervisores($supervisorId, $turmaId, $ofertaId, $residenteId)
    {
        $query = $this->queryBuscarResidentesOfertaModuloSupervisoresy($supervisorId, $turmaId, $ofertaId, $residenteId);

        $residentes = $this->removerCamposNulosLista(
            $this->mapToModel($query->get()->toArray())
        );

        $residentesArray = [];
        foreach ($residentes as $residente) {
            $residente['faltas'] = $this->ofertaModuloFaltaDAO->getFaltasDoResidenteNaOferta($residente['id'], $ofertaId);
            $residente['nota'] = $this->ofertaModuloNotaDAO->getNotasDoResidenteNaOferta($residente['id'], $ofertaId);
            $residente['person']['photourl'] = isset($residente['person']['photoid']) && $residente['person']['photoid'] > 0 ? env('SAGU_URL') . "miolo20/html/index.php?module=basic&action=main:getfile&&fileId={$residente['person']['photoid']}" : null;
            $residente['cargaHorariaPendente'] = $this->ofertaModuloFaltaDAO->getCargaHorariaPendente($residente['id'], $ofertaId);
            $residente['cargahorariacomplementar'] = $this->cargaHorariaComplementarDAO->getCargaHorariaComplementarDoResidenteNaOferta($residente['id'], $ofertaId);

            $residentesArray[] = $residente;
        }
        return $residentesArray;
    }
}