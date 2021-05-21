<?php


namespace App\Services\ResidenciaMultiprofissional;


use App\DAO\ResidenciaMultiprofissional\ResidenteDAO;
use App\Model\Residente;

class ResidenteService
{
    private $residenteSupervisorDAO;

    /**
     * ResidenteService constructor.
     * @param $residenteSupervisorDAO
     */
    public function __construct()
    {
        $this->residenteSupervisorDAO = new ResidenteDAO();
    }


    public function existeResidenteNoModuloDoSupervisor($supervisorId, $turmaId, $ofertaId, $residenteId)
    {
        return new Residente(
            $this->residenteSupervisorDAO->buscarResidenteNaOfertaTurma(
                $supervisorId,
                $turmaId,
                $ofertaId,
                $residenteId
            )
        );
    }

}