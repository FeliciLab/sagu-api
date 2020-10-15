<?php


namespace App\Services\ResidenciaMultiprofissional;


use App\DAO\ResidenciaMultiprofissional\FaltasResidentePorModuloDAO;

class FaltasResidenteSupervisorService
{
    /**
     * @var AvaliacaoResidenciaMultiprofissional
     */
    public $avaliacaoResidenciaMultiprofissional;

    /**
     * FaltasResidenteSupervisorService constructor.
     */
    public function __construct()
    {
        $this->avaliacaoResidenciaMultiprofissional = new AvaliacaoResidenciaMultiprofissional(
            new FaltasResidentePorModuloDAO()
        );
    }

    /**
     * @param $supervisorId
     * @param $turmaId
     * @param $ofertaId
     * @param $residenteId
     * @param $faltas
     * @return array|int[]
     */
    public function upsertFaltas($supervisorId, $turmaId, $ofertaId, $residenteId, $faltas)
    {
        return $this->avaliacaoResidenciaMultiprofissional
            ->upsertAvaliacao(
                [
                    'supervisorId' => $supervisorId,
                    'turmaId' => $turmaId,
                    'ofertaId' => $ofertaId,
                    'residenteId' => $residenteId,
                ],
                $faltas
            );
    }
}
