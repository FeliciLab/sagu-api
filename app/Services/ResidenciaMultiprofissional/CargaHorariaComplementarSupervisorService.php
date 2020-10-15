<?php


namespace App\Services\ResidenciaMultiprofissional;


use App\DAO\ResidenciaMultiprofissional\CargaHorariaComplementarSupervisorDAO;

class CargaHorariaComplementarSupervisorService
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
            new CargaHorariaComplementarSupervisorDAO()
        );
    }

    public function upsertCargaHoraria(
        $supervisorId,
        $turma,
        $oferta,
        $residenteId,
        $tipoCargaHorariaId,
        $cargaHorariaComplementar
    ) {
        $this->avaliacaoResidenciaMultiprofissional->upsertAvaliacao(
            [
                'supervisorId' => $supervisorId,
                'turmaId' => $turma,
                'ofertaId' => $oferta,
                'residenteId' => $residenteId,
                'tipoCargaHorariaId' => $tipoCargaHorariaId
            ],
            $cargaHorariaComplementar
        );

        return [
            'message' => 'Salvo com sucesso',
            'status' => 200,
        ];
    }
}
