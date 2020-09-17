<?php


namespace App\Services\ResidenciaMultiprofissional;


use App\DAO\ResidenciaMultiprofissional\FaltasResidentePorModuloDAO;
use App\DAO\ResidenciaMultiprofissional\ResidenteSupervisoresDAO;
use App\DAO\ResidenciaMultiprofissional\SupervisorDAO;
use App\DAO\Traits\RemoverCamposNulos;
use App\Model\Residente;

class FaltasResidenteSupervisorService
{
    use RemoverCamposNulos;

    /**
     * @var ResidenteSupervisoresDAO
     */
    public $residenteSupervisorDAO;

    /**
     * @var FaltasResidentePorModuloDAO
     */
    public $faltasResidentePorModuloDAO;

    /**
     * FaltasResidenteSupervisorService constructor.
     */
    public function __construct()
    {
        $this->residenteSupervisorDAO = new ResidenteSupervisoresDAO();
        $this->faltasResidentePorModuloDAO = new FaltasResidentePorModuloDAO();
        $this->supervisorDAO = new SupervisorDAO();
    }

    public function upsertFaltas($supervisorId, $turmaId, $ofertaId, $residenteId, $faltas)
    {
        $residente = new Residente(
            $this->residenteSupervisorDAO->buscarResidente($supervisorId, $turmaId, $ofertaId, $residenteId)
        );

        if (!$residente) {
            return [
                'status' => 404
            ];
        }

        if (!$this->faltasResidentePorModuloDAO->atualizar($residenteId, $ofertaId, $faltas)) {
            $supervisor = $this->supervisorDAO->buscar($supervisorId);
            $this->faltasResidentePorModuloDAO->inserir(
                $residenteId,
                $ofertaId,
                $faltas,
                $supervisor->username
            );
        }

        return [
            'status' => 200
        ];
    }
}