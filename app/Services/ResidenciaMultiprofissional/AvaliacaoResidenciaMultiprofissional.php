<?php


namespace App\Services\ResidenciaMultiprofissional;


use App\DAO\ResidenciaMultiprofissional\Abstracoes\InterfaceAvaliacaoDAO;
use App\DAO\ResidenciaMultiprofissional\SupervisorDAO;

class AvaliacaoResidenciaMultiprofissional
{
    /**
     * @var SupervisorDAO
     */
    public $supervisorDAO;

    /**
     * @var ResidenteService
     */
    public $residenteService;

    /**
     * @var InterfaceAvaliacaoDAO
     */
    public $modelDAO;

    /**
     * AvaliacaoResidenciaMultiprofissional constructor.
     * @param InterfaceAvaliacaoDAO $modelDAO
     */
    public function __construct(InterfaceAvaliacaoDAO $modelDAO)
    {
        $this->modelDAO = $modelDAO;

        $this->residenteService = new ResidenteService();
        $this->supervisorDAO = new SupervisorDAO();
    }


    public function upsertAvaliacao($supervisorId, $turmaId, $ofertaId, $residenteId, $avaliacao)
    {
        if (!$this->residenteService->existeResidenteNoModuloDoSupervisor(
            $supervisorId,
            $turmaId,
            $ofertaId,
            $residenteId
        )) {
            return [
                'error' => true,
                'status' => 404,
                'message' => 'Nâo foi possível encontrar residente com os dados enviados.'
            ];
        }

        if (!$this->modelDAO->atualizar($residenteId, $ofertaId, $avaliacao)) {
            $supervisor = $this->supervisorDAO->buscar($supervisorId);
            $this->modelDAO->inserir(
                $residenteId,
                $ofertaId,
                $avaliacao,
                $supervisor->username
            );
        }

        return [
            'status' => 200
        ];
    }

}