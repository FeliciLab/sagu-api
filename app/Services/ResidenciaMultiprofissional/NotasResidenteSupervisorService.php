<?php


namespace App\Services\ResidenciaMultiprofissional;


use App\DAO\ResidenciaMultiprofissional\NotaPorModuloSupervisorDAO;
use App\Model\ResidenciaMultiprofissional\NotaResidente;

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
                [
                    'supervisorId' => $supervisorId,
                    'turmaId' => $turmaId,
                    'ofertaId' => $ofertaId,
                    'residenteId' => $residenteId,
                ],
                $notas
            );
    }

    public function notasIncoerentes($notaPratica, $notaTeorica, $notaFinal)
    {
        return $this->calcNotaFinal($notaPratica, $notaTeorica) != $notaFinal;
    }

    public function calcNotaFinal($notaPratica, $notaTeorica)
    {
        return round(
            (
                ($notaPratica * NotaResidente::PESO_NOTA_PRATICA) + ($notaTeorica * NotaResidente::PESO_NOTA_TEORICA)
            ) / (NotaResidente::PESO_NOTA_PRATICA + NotaResidente::PESO_NOTA_TEORICA),
            2
        );
    }

    public function limitesDasNotasValido($notaPratica, $notaTeorica, $notaFinal)
    {
        return $this->validarRangeDeNota($notaPratica) &&
            $this->validarRangeDeNota($notaTeorica) &&
            $this->validarRangeDeNota($notaFinal);
    }

    private function validarRangeDeNota($nota)
    {
        return 0 <= $nota && $nota <= 10;
    }
}