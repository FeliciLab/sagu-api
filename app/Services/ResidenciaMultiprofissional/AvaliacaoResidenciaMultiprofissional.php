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


    /**
     * @param $referenciesId array<string, int> - obrigatório: supervisorId, turmaId, ofertaId, residenteId
     * @param $avaliacao
     * @return array|int[]
     */
    public function upsertAvaliacao($referenciesId, $avaliacao)
    {

        if (!$this->residenteService->existeResidenteNoModuloDoSupervisor(
            $referenciesId['supervisorId'],
            $referenciesId['turmaId'],
            $referenciesId['ofertaId'],
            $referenciesId['residenteId']
        )) {
            return [
                'error' => true,
                'status' => 404,
                'message' => 'Nâo foi possível encontrar residente com os dados enviados.'
            ];
        }

        if (!$this->modelDAO->atualizar($referenciesId, $avaliacao)) {
            $supervisor = $this->supervisorDAO->buscar($referenciesId['supervisorId']);
            $this->modelDAO->inserir(
                $referenciesId,
                $avaliacao,
                $supervisor->username
            );
        }

        return [
            'status' => 200
        ];
    }

}