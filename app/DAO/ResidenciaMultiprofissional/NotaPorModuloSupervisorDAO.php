<?php


namespace App\DAO\ResidenciaMultiprofissional;


use App\DAO\ResidenciaMultiprofissional\Abstracoes\InterfaceAvaliacaoDAO;
use App\Model\ResidenciaMultiprofissional\NotaResidente;
use Illuminate\Support\Facades\DB;

class NotaPorModuloSupervisorDAO implements InterfaceAvaliacaoDAO
{
    public $model;
    public $ResidenteDAO;

    /**
     * NotaPorModuloSupervisorDAO constructor.
     * @param $ResidenteDAO
     */
    public function __construct()
    {
        $this->model = new NotaResidente();
        $this->ResidenteDAO = new ResidenteDAO();
    }

    public function atualizar($residenteId, $ofertaId, $notas)
    {
        return \DB::table($this->model->getTable())
            ->where('residenteid', $residenteId)
            ->where('ofertadeunidadetematicaid', $ofertaId)
            ->update($notas);
    }

    public function inserir($residenteId, $ofertaId, $notas, $username)
    {
        return \DB::table($this->model->getTable())
            ->insert(
                array_merge(
                    [
                        'username' => $username,
                        'residenteid' => $residenteId,
                        'ofertadeunidadetematicaid' => $ofertaId
                    ],
                    $notas
                )
            );
    }
}