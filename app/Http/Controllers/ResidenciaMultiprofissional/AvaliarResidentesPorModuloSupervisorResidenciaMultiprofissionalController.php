<?php


namespace App\Http\Controllers\ResidenciaMultiprofissional;

use App\DAO\ResidenciaMultiprofissional\ResidenteSupervisoresDAO;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\PaginationValidateRequest;
use App\Http\Controllers\ResidenciaMultiprofissional\Traits\ValidarFaltasRequest;
use App\Services\ResidenciaMultiprofissional\FaltasResidenteSupervisorService;
use Illuminate\Http\Request;

use function response;

class AvaliarResidentesPorModuloSupervisorResidenciaMultiprofissionalController extends Controller
{
    use ValidarFaltasRequest, PaginationValidateRequest;

    public function falta(
        Request $request,
        FaltasResidenteSupervisorService $faltasResidenteSupervisorService,
        $turma,
        $oferta,
        $residenteId,
        $faltas
    )
    {
        if ($this->invalidNumberParameter($faltas)) {
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
}