<?php


namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\ParameterValidateRequest;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\ValidarFaltasRequest;
use App\Model\ResidenciaMultiprofissional\NotaResidente;
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
    )
    {
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

    public function notaPorTipo(
        Request $request,
        NotasResidenteSupervisorService $notasResidenteSupervisorService,
        $turma,
        $oferta,
        $residenteId,
        $tipo,
        $notas
    )
    {
        if ($this->invalidNumberParameter($notas)) {
            return $this->responseNumberParameterError();
        }

        if (!in_array($tipo, NotaResidente::TIPO_NOTAS)) {
            return response()->json(
                [
                    'status' => '400',
                    'message' => 'O tipo da nota é um valor inválido.'
                ],
                400
            );
        }

        $result = $notasResidenteSupervisorService->upsertNotas(
            $request->get('usuario')->supervisorid,
            (int)$turma,
            (int)$oferta,
            (int)$residenteId,
            [$tipo => (float)$notas]
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
        $notaFinal
    )
    {
        if ($this->invalidNumberParameter($notaPratica)) {
            return $this->responseNumberParameterError('nota pratica');
        }
        if ($this->invalidNumberParameter($notaTeorica)) {
            return $this->responseNumberParameterError('nota teorica');
        }
        if ($this->invalidNumberParameter($notaFinal)) {
            return $this->responseNumberParameterError('nota final');
        }

        $result = $notasResidenteSupervisorService->upsertNotas(
            $request->get('usuario')->supervisorid,
            (int)$turma,
            (int)$oferta,
            (int)$residenteId,
            [
                'nota' => round((float)$notaFinal, 2),
                'notateorica' => round((float)$notaTeorica, 2),
                'notapratica' => round((float)$notaPratica, 2),
            ]
        );

        return response()->json(
            $result,
            $result['status']
        );
    }
}