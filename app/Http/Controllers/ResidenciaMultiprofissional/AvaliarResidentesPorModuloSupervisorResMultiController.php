<?php


namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\ParameterValidateRequest;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\ValidarFaltasRequest;
use App\Services\ResidenciaMultiprofissional\CargaHorariaComplementarSupervisorService;
use App\Services\ResidenciaMultiprofissional\FaltasResidenteSupervisorService;
use App\Services\ResidenciaMultiprofissional\NotasResidenteSupervisorService;
use Illuminate\Http\Request;

use function response;

class AvaliarResidentesPorModuloSupervisorResMultiController extends Controller
{
    use ValidarFaltasRequest, ParameterValidateRequest;

    public function falta(
        Request $request,
        FaltasResidenteSupervisorService $faltasResidenteSupervisorService,
        $turma,
        $oferta,
        $residenteId,
        $faltas
    ) {
        if ($this->invalidIntegerParameter($faltas)) {
            return $this->responseNumberParameterError();
        }

        $result = $faltasResidenteSupervisorService->upsertFaltas(
            $request->get('usuario')->supervisorid,
            (int)$turma,
            (int)$oferta,
            (int)$residenteId,
            (int)$faltas
        );

        return response()->json(
            $result,
            $result['status']
        );
    }

    public function notas(
        Request $request,
        NotasResidenteSupervisorService $notasResidenteSupervisorService,
        $turma,
        $oferta,
        $residenteId,
        $notaPratica,
        $notaTeorica,
        $notaFinal = null
    ) {
        if ($this->invalidNumberParameter($notaPratica)) {
            return $this->responseNumberParameterError('nota pratica');
        }

        if ($this->invalidNumberParameter($notaTeorica)) {
            return $this->responseNumberParameterError('nota teorica');
        }

        if ($notaFinal != null && $this->invalidNumberParameter($notaFinal)) {
            return $this->responseNumberParameterError('nota final');
        }

        if ($notaFinal != null && $notasResidenteSupervisorService->notasIncoerentes(
            round((float)$notaPratica, 2),
            round((float)$notaTeorica, 2),
            round((float)$notaFinal, 2)
        )) {
            return response()->json(
                [
                    'status' => 400,
                    'message' => 'As notas enviadas não condizem com o cálculo da nota final. Valor inválido.'
                ],
                400
            );
        }

        if (!$notasResidenteSupervisorService->limitesDasNotasValido($notaPratica, $notaTeorica, $notaFinal)) {
            return response()->json(
                [
                    'status' => 400,
                    'message' => 'Algum parâmetro de nota está fora dos limites. A nota deve estar entre 0 e 10'
                ],
                400
            );
        }

        $result = $notasResidenteSupervisorService->upsertNotas(
            $request->get('usuario')->supervisorid,
            (int)$turma,
            (int)$oferta,
            (int)$residenteId,
            [
                'nota' => $notaFinal === null ? $notasResidenteSupervisorService->calcNotaFinal(
                    $notaPratica,
                    $notaTeorica
                ) : round((float)$notaFinal, 2),
                'notateorica' => round((float)$notaTeorica, 2),
                'notapratica' => round((float)$notaPratica, 2),
            ]
        );

        return response()->json(
            $result,
            $result['status']
        );
    }

    public function cargaHoraria(
        Request $request,
        CargaHorariaComplementarSupervisorService $cargaHorariaComplementarSupervisorService,
        $turma,
        $oferta,
        $residenteId,
        $tipoCargaHorariaId,
        $cargaHorariaComplementar
    ) {
        if ($this->invalidNumberParameter($cargaHorariaComplementar)) {
            return $this->responseNumberParameterError('carga horária');
        }

        $result = $cargaHorariaComplementarSupervisorService->upsertCargaHoraria(
            $request->get('usuario')->supervisorid,
            $turma,
            $oferta,
            $residenteId,
            $tipoCargaHorariaId,
            $cargaHorariaComplementar
        );

        return response()->json(
            $result,
            $result['status']
        );
    }
}
