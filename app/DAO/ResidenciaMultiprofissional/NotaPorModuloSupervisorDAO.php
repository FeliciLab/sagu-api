<?php


namespace App\DAO\ResidenciaMultiprofissional;


use App\DAO\ResidenciaMultiprofissional\Abstracoes\InterfaceAvaliacaoDAO;
use App\Model\ResidenciaMultiprofissional\NotaResidente;
use Illuminate\Support\Facades\DB;

class NotaPorModuloSupervisorDAO implements InterfaceAvaliacaoDAO
{
    public $model;
    public $residenteSupervisoresDAO;

    /**
     * NotaPorModuloSupervisorDAO constructor.
     * @param $residenteSupervisoresDAO
     */
    public function __construct()
    {
        $this->model = new NotaResidente();
        $this->residenteSupervisoresDAO = new ResidenteSupervisoresDAO();
    }

    /**
     * @param $referenciesIds array<string, int> : residenteId, ofertaId
     * @param $notas
     * @return mixed
     */
    public function atualizar($referenciesIds, $notas)
    {
        return \DB::table($this->model->getTable())
            ->where('residenteid', $referenciesIds['residenteId'])
            ->where('ofertadeunidadetematicaid', $referenciesIds['ofertaId'])
            ->update($notas);
    }

    /**
     * @param $referenciesIds array<string, int> : residenteId, ofertaId
     * @param $notas
     * @param $username
     * @return mixed
     */
    public function inserir($referenciesIds, $notas, $username)
    {
        return \DB::table($this->model->getTable())
            ->insert(
                array_merge(
                    [
                        'username' => $username,
                        'residenteid' => $referenciesIds['residenteId'],
                        'ofertadeunidadetematicaid' => $referenciesIds['ofertaId']
                    ],
                    $notas
                )
            );
    }
}