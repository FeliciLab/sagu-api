<?php


namespace App\Services\ResidenciaMultiprofissional;


use App\DAO\ResidenciaMultiprofissional\NotaPorModuloSupervisorDAO;

class NotasResidenteSupervisorService
{
    /**
     * @var AvaliacaoResidenciaMultiprofissional
     */
    public $avaliacaoResidenciaMultiprofissional;

    /**
     * NotasResidenteSupervisorService constructor.
     * @param AvaliacaoResidenciaMultiprofissional $avaliacaoResidenciaMultiprofissional
     */
    public function __construct()
    {
        $this->avaliacaoResidenciaMultiprofissional = new AvaliacaoResidenciaMultiprofissional(
            new NotaPorModuloSupervisorDAO()
        );
    }

    /**
     * @param int $supervisorId
     * @param int $turmaId
     * @param int $ofertaId
     * @param int $residenteId
     * @param int $nota
     * @return array|int[]
     */
    public function upsertNotas($supervisorId, $turmaId, $ofertaId, $residenteId, $notas)
    {
        return $this->avaliacaoResidenciaMultiprofissional
            ->upsertAvaliacao(
                $supervisorId,
                $turmaId,
                $ofertaId,
                $residenteId,
                $notas
            );
    }
}